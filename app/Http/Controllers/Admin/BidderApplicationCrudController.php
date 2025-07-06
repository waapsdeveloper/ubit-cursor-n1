<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BidderApplicationRequest;
use App\Models\BidderApplication;
use App\Models\Invite;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

/**
 * Class BidderApplicationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BidderApplicationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\BidderApplication::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/bidder-application');
        CRUD::setEntityNameStrings('bidder application', 'bidder applications');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('user.name')->label('Applicant');
        CRUD::column('phone');
        CRUD::column('cnic')->label('CNIC');
        CRUD::column('deposit_amount')->type('number')->decimals(2)->prefix('PKR ');
        CRUD::column('bank_name');
        CRUD::column('transaction_id')->label('Transaction ID');
        CRUD::column('status')->type('badge')->options([
            'pending' => 'warning',
            'payment_verified' => 'info',
            'invitation_sent' => 'primary',
            'approved' => 'success',
            'rejected' => 'danger',
        ]);
        CRUD::column('created_at')->type('datetime')->label('Applied On');
        CRUD::column('payment_verified_at')->type('datetime')->label('Payment Verified');
        CRUD::column('invitation_sent_at')->type('datetime')->label('Invitation Sent');
        CRUD::column('approved_at')->type('datetime')->label('Approved On');

        // Disable default CRUD buttons since they're included in our dropdown
        CRUD::removeButton('show');
        CRUD::removeButton('update');
        CRUD::removeButton('delete');
        
        // Add actions dropdown (includes preview, edit, delete)
        CRUD::addButton('line', 'actions', 'model_function', 'actionsDropdown', 'beginning');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(BidderApplicationRequest::class);

        CRUD::field('user_id')->type('select2')->entity('user')->attribute('name');
        CRUD::field('phone');
        CRUD::field('cnic');
        CRUD::field('deposit_amount')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('bank_name');
        CRUD::field('account_number');
        CRUD::field('transaction_id');
        CRUD::field('payment_proof')->type('upload')->disk('public');
        CRUD::field('status')->type('select_from_array')->options([
            'pending' => 'Pending',
            'payment_verified' => 'Payment Verified',
            'invitation_sent' => 'Invitation Sent',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
        ]);
        CRUD::field('admin_notes')->type('textarea');
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    /**
     * Define what happens when the Show operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-show
     * @return void
     */
    protected function setupShowOperation()
    {
        CRUD::column('id');
        CRUD::column('user.name')->label('Applicant Name');
        CRUD::column('user.email')->label('Email');
        CRUD::column('phone');
        CRUD::column('cnic')->label('CNIC');
        CRUD::column('deposit_amount')->type('number')->decimals(2)->prefix('PKR ');
        CRUD::column('bank_name');
        CRUD::column('account_number')->label('Account Number');
        CRUD::column('transaction_id')->label('Transaction ID');
        CRUD::column('payment_proof')->type('image')->disk('public')->label('Payment Proof');
        CRUD::column('status')->type('badge')->options([
            'pending' => 'warning',
            'payment_verified' => 'info',
            'invitation_sent' => 'primary',
            'approved' => 'success',
            'rejected' => 'danger',
        ]);
        CRUD::column('admin_notes')->type('textarea');
        CRUD::column('created_at')->type('datetime')->label('Application Submitted');
        CRUD::column('payment_verified_at')->type('datetime')->label('Payment Verified On');
        CRUD::column('invitation_sent_at')->type('datetime')->label('Invitation Sent On');
        CRUD::column('approved_at')->type('datetime')->label('Approved On');
        CRUD::column('verifiedBy.name')->label('Verified By');
    }

    /**
     * Verify payment for a bidder application.
     */
    public function verifyPayment($id)
    {
        $application = BidderApplication::findOrFail($id);
        
        if ($application->status === 'pending') {
            // Update user role to bidder when payment is verified
            $application->user->update(['role' => 'bidder']);
            
            // Mark payment as verified
            $application->markPaymentVerified(Auth::id());
            
            \Alert::success('Payment verified successfully! User is now a bidder.')->flash();
        } else {
            \Alert::error('Application is not in pending status.')->flash();
        }
        
        return redirect()->back();
    }

    /**
     * Send invitation for a bidder application.
     */
    public function sendInvitation($id)
    {
        $application = BidderApplication::findOrFail($id);
        
        if ($application->status === 'payment_verified') {
            // Create invitation
            $invite = Invite::create([
                'email' => $application->user->email,
                'name' => $application->user->name,
                'code' => strtoupper(substr(md5(uniqid()), 0, 8)),
                'status' => 'pending',
                'sent_at' => now(),
            ]);
            
            // Mark invitation as sent
            $application->markInvitationSent();
            
            // Send email
            try {
                Mail::send('emails.bidder-invitation', [
                    'invite' => $invite,
                    'application' => $application,
                    'user' => $application->user
                ], function ($message) use ($invite) {
                    $message->to($invite->email)
                            ->subject('Bidder Invitation - Sahil e Firdaus Auctions');
                });
                
                \Alert::success('Invitation sent successfully!')->flash();
            } catch (\Exception $e) {
                \Alert::error('Error sending invitation email: ' . $e->getMessage())->flash();
            }
        } else {
            \Alert::error('Application payment must be verified first.')->flash();
        }
        
        return redirect()->back();
    }

    /**
     * Approve a bidder application.
     */
    public function approve($id)
    {
        $application = BidderApplication::findOrFail($id);
        
        if ($application->status === 'invitation_sent') {
            // Mark application as approved
            $application->markApproved();
            
            \Alert::success('Application approved successfully!')->flash();
        } else {
            \Alert::error('Application must have invitation sent first.')->flash();
        }
        
        return redirect()->back();
    }

    /**
     * Reject a bidder application.
     */
    public function reject($id)
    {
        $application = BidderApplication::findOrFail($id);
        
        if (in_array($application->status, ['pending', 'payment_verified'])) {
            // Mark application as rejected
            $application->update([
                'status' => 'rejected',
                'admin_notes' => $application->admin_notes ? $application->admin_notes . "\n\nApplication rejected on " . now()->format('M d, Y g:i A') : 'Application rejected on ' . now()->format('M d, Y g:i A')
            ]);
            
            \Alert::success('Application rejected successfully.')->flash();
        } else {
            \Alert::error('Cannot reject application in current status.')->flash();
        }
        
        return redirect()->back();
    }
}
