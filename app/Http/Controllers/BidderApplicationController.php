<?php

namespace App\Http\Controllers;

use App\Models\BidderApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BidderApplicationController extends Controller
{
    /**
     * Show the bidder application form.
     */
    public function show()
    {
        $user = Auth::user();
        
        // Check if user already has an application
        $existingApplication = BidderApplication::where('user_id', $user->id)->first();
        
        if ($existingApplication) {
            return view('bidder-application.status', compact('existingApplication'));
        }

        return view('bidder-application.form');
    }

    /**
     * Submit the bidder application.
     */
    public function submit(Request $request)
    {
        $user = Auth::user();

        // Check if user already has an application
        $existingApplication = BidderApplication::where('user_id', $user->id)->first();
        if ($existingApplication) {
            return redirect()->route('bidder.application.status')
                ->with('error', 'You already have a pending application.');
        }

        $request->validate([
            'phone' => 'required|string|max:20',
            'cnic' => 'required|string|max:15',
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'transaction_id' => 'required|string|max:100',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'phone.required' => 'Phone number is required.',
            'cnic.required' => 'CNIC is required.',
            'bank_name.required' => 'Bank name is required.',
            'account_number.required' => 'Account number is required.',
            'transaction_id.required' => 'Transaction ID is required.',
            'payment_proof.required' => 'Payment proof is required.',
            'payment_proof.mimes' => 'Payment proof must be an image (jpg, jpeg, png) or PDF.',
            'payment_proof.max' => 'Payment proof file size must be less than 2MB.',
        ]);

        try {
            // Handle file upload
            $paymentProofPath = null;
            if ($request->hasFile('payment_proof')) {
                $file = $request->file('payment_proof');
                $fileName = 'payment_proof_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $paymentProofPath = $file->storeAs('payment_proofs', $fileName, 'public');
            }

            // Create application
            $application = BidderApplication::create([
                'user_id' => $user->id,
                'phone' => $request->phone,
                'cnic' => $request->cnic,
                'deposit_amount' => config('auction.deposit_amount', 50000), // Default 50,000 PKR
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'transaction_id' => $request->transaction_id,
                'payment_proof' => $paymentProofPath,
                'status' => 'pending',
            ]);

            return redirect()->route('bidder.application.status')
                ->with('success', 'Your bidder application has been submitted successfully! We will review it within 24-48 hours.');

        } catch (\Exception $e) {
            return back()->with('error', 'There was an error submitting your application. Please try again.')
                ->withInput();
        }
    }

    /**
     * Show application status.
     */
    public function status()
    {
        $user = Auth::user();
        $application = BidderApplication::where('user_id', $user->id)->first();

        if (!$application) {
            return redirect()->route('bidder.application.show');
        }

        return view('bidder-application.status', compact('application'));
    }
}
