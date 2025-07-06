<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\InvitationRequest;
use App\Mail\InvitationMail;
use App\Models\Invitation;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Mail;

/**
 * Class InvitationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class InvitationCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Invitation::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/invitation');
        CRUD::setEntityNameStrings('invitation', 'invitations');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('email');
        CRUD::column('invitation_code')->label('Code');
        CRUD::column('name');
        CRUD::column('phone');
        CRUD::column('status');
        CRUD::column('sent_at');
        CRUD::column('registered_at');
        CRUD::column('expires_at');
        CRUD::column('created_by');
        CRUD::column('registered_user_id');
        CRUD::column('notes')->limit(30);

        // Add custom button for sending invitation
        CRUD::addButtonFromView('line', 'send_invite', 'send_invite', 'beginning');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(InvitationRequest::class);
        CRUD::field('email');
        CRUD::addField([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Name',
        ]);
        CRUD::addField([
            'name' => 'phone',
            'type' => 'text',
            'label' => 'Phone',
        ]);
        CRUD::addField([
            'name' => 'notes',
            'type' => 'textarea',
            'label' => 'Notes',
        ]);
        // Invitation code is auto-generated
        CRUD::addField([
            'name' => 'invitation_code',
            'type' => 'hidden',
            'value' => function() {
                return \App\Models\Invitation::generateInvitationCode();
            },
        ]);
        CRUD::addField([
            'name' => 'status',
            'type' => 'hidden',
            'value' => 'pending',
        ]);
        CRUD::addField([
            'name' => 'created_by',
            'type' => 'hidden',
            'value' => backpack_user()->id,
        ]);
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

    // Custom action to send invitation email
    public function sendInvite($id)
    {
        $invitation = Invitation::findOrFail($id);
        if ($invitation->status === 'pending' || $invitation->status === 'sent') {
            // Mark as sent if not already
            if ($invitation->status === 'pending') {
                $invitation->markAsSent();
            }
            Mail::to($invitation->email)->send(new InvitationMail($invitation));
            \Alert::success('Invitation sent to ' . $invitation->email)->flash();
        } else {
            \Alert::warning('Invitation cannot be sent in its current status.')->flash();
        }
        return redirect()->back();
    }
}
