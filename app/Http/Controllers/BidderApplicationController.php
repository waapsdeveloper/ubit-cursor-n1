<?php

namespace App\Http\Controllers;

use App\Models\BidderApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
            'phone' => 'required|string|regex:/^\+92\d{10}$/|max:13',
            'cnic' => 'required|string|regex:/^\d{5}-\d{7}-\d{1}$/|max:15',
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|regex:/^\d{10,16}$/|max:50',
            'transaction_id' => 'required|string|regex:/^[A-Za-z0-9]{8,20}$/|max:100',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Phone number must be in format: +923001234567',
            'cnic.required' => 'CNIC is required.',
            'cnic.regex' => 'CNIC must be in format: 12345-1234567-1',
            'bank_name.required' => 'Bank name is required.',
            'account_number.required' => 'Account number is required.',
            'account_number.regex' => 'Account number must be 10-16 digits only.',
            'transaction_id.required' => 'Transaction ID is required.',
            'transaction_id.regex' => 'Transaction ID must be 8-20 alphanumeric characters.',
            'payment_proof.required' => 'Payment proof is required.',
            'payment_proof.mimes' => 'Payment proof must be an image (jpg, jpeg, png) or PDF.',
            'payment_proof.max' => 'Payment proof file size must be less than 2MB.',
        ]);

        try {
            // Handle file upload
            $paymentProofPath = null;
            
            // Debug file upload information
            Log::info('File upload debug info', [
                'user_id' => $user->id,
                'has_file' => $request->hasFile('payment_proof'),
                'all_files' => $request->allFiles(),
                'content_type' => $request->header('Content-Type'),
                'content_length' => $request->header('Content-Length')
            ]);
            
            if ($request->hasFile('payment_proof')) {
                $file = $request->file('payment_proof');
                
                Log::info('File object retrieved', [
                    'user_id' => $user->id,
                    'file_object' => $file ? 'exists' : 'null',
                    'file_class' => $file ? get_class($file) : 'null'
                ]);
                
                // Additional file validation
                if (!$file || !$file->isValid()) {
                    Log::error('File validation failed', [
                        'user_id' => $user->id,
                        'file_exists' => $file ? 'yes' : 'no',
                        'is_valid' => $file ? $file->isValid() : 'no',
                        'error_code' => $file ? $file->getError() : 'no file',
                        'file_size' => $file ? $file->getSize() : 'no file',
                        'file_name' => $file ? $file->getClientOriginalName() : 'no file'
                    ]);
                    throw new \Exception('Invalid payment proof file. Please try again.');
                }
                
                Log::info('File validation passed', [
                    'user_id' => $user->id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_size' => $file->getSize(),
                    'file_type' => $file->getMimeType()
                ]);
                
                $fileName = 'payment_proof_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                
                // Get file information before moving
                $fileSize = $file->getSize();
                $fileType = $file->getMimeType();
                $originalName = $file->getClientOriginalName();
                
                Log::info('Preparing to move file', [
                    'user_id' => $user->id,
                    'file_name' => $fileName,
                    'original_name' => $originalName,
                    'file_size' => $fileSize,
                    'file_type' => $fileType
                ]);
                
                // Ensure the directory exists
                $directory = 'payment_proofs';
                $fullPath = storage_path('app/public/' . $directory);
                
                Log::info('Directory check', [
                    'user_id' => $user->id,
                    'full_path' => $fullPath,
                    'exists' => file_exists($fullPath)
                ]);
                
                if (!file_exists($fullPath)) {
                    $created = mkdir($fullPath, 0755, true);
                    Log::info('Directory creation', [
                        'user_id' => $user->id,
                        'path' => $fullPath,
                        'created' => $created
                    ]);
                }
                
                // Store the file using move instead of storeAs
                $destinationPath = $fullPath . '/' . $fileName;
                
                Log::info('Attempting file move', [
                    'user_id' => $user->id,
                    'source' => $file->getPathname(),
                    'destination' => $destinationPath
                ]);
                
                $moved = $file->move($fullPath, $fileName);
                
                Log::info('File move result', [
                    'user_id' => $user->id,
                    'moved' => $moved ? 'success' : 'failed',
                    'result_path' => $moved ? $moved->getPathname() : 'null'
                ]);
                
                if (!$moved) {
                    throw new \Exception('Failed to store payment proof file.');
                }
                
                $paymentProofPath = $directory . '/' . $fileName;
                
                // Log successful file upload for debugging
                Log::info('Payment proof uploaded successfully', [
                    'user_id' => $user->id,
                    'file_path' => $paymentProofPath,
                    'full_path' => $destinationPath,
                    'file_size' => $fileSize,
                    'file_type' => $fileType,
                    'file_exists' => file_exists($destinationPath)
                ]);
            } else {
                Log::error('No payment proof file found in request', [
                    'user_id' => $user->id,
                    'request_files' => $request->allFiles(),
                    'request_all' => $request->all()
                ]);
                throw new \Exception('Payment proof file is required.');
            }

            // Log before database creation
            Log::info('Creating bidder application in database', [
                'user_id' => $user->id,
                'payment_proof_path' => $paymentProofPath
            ]);

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

            Log::info('Bidder application created successfully', [
                'user_id' => $user->id,
                'application_id' => $application->id
            ]);

            return redirect()->route('bidder.application.status')
                ->with('success', 'Your bidder application has been submitted successfully! We will review it within 24-48 hours.');

        } catch (\Exception $e) {
            Log::error('Bidder application submission failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'There was an error submitting your application: ' . $e->getMessage())
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
