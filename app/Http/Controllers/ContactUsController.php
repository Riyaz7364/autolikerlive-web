<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Mail\ContactUs;


class ContactUsController extends Controller
{
    public function contactUs()
    {
        return view('contact');
    }

    public function sendMessage(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'message' => 'required',
                'g-recaptcha-response' => 'required',
            ]);

            $g_api = "https://www.google.com/recaptcha/api/siteverify";
            $response = Http::asForm()->post($g_api, [
                'secret' => "6LdMKyQrAAAAAMPXzw4hP1XbcmRWM--HErjuetXi",
                'response' => $request['g-recaptcha-response'],
            ]);

            $json = $response->json();

            if ($json['success'] == true) {
                // Send email
                Mail::to('contact@autolikerlive.com')
                    ->send(new ContactUs($request));

                // Handle AJAX vs regular request
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Message sent successfully!'
                    ]);
                } else {
                    toastr()->success('Send mail success');
                    return redirect()->back();
                }
            } else {
                // reCAPTCHA failed
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'reCAPTCHA verification failed. Please try again.'
                    ], 422);
                } else {
                    toastr()->error('reCAPTCHA verification failed. Please try again.');
                    return redirect()->back();
                }
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation failed
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            } else {
                return redirect()->back()->withErrors($e->errors())->withInput();
            }
        } catch (\Exception $e) {
            // General error
            \Log::error('Contact form error: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong. Please try again later.'
                ], 500);
            } else {
                toastr()->error('Something went wrong. Please try again later.');
                return redirect()->back();
            }
        }
    }

    public function deleteAccountForm()
    {
        return view('delete-account');
    }

    public function deleteAccountRequest(Request $request)
    {
        try {
            $request->validate([
                'facebook_username' => 'required|string|max:255',
                'reason' => 'nullable|string|max:500',
                'confirmation' => 'required|accepted',
                'g-recaptcha-response' => 'required',
            ], [
                'facebook_username.required' => 'Facebook username is required.',
                'confirmation.accepted' => 'You must confirm that you want to delete your account.',
                'g-recaptcha-response.required' => 'Please complete the reCAPTCHA verification.',
            ]);

            // Verify reCAPTCHA
            $g_api = "https://www.google.com/recaptcha/api/siteverify";
            $response = Http::asForm()->post($g_api, [
                'secret' => "6LdMKyQrAAAAAMPXzw4hP1XbcmRWM--HErjuetXi",
                'response' => $request['g-recaptcha-response'],
            ]);

            $json = $response->json();

            if ($json['success'] == true) {
                // Send email notification
                $emailData = [
                    'facebook_username' => $request->facebook_username,
                    'reason' => $request->reason ?? 'No reason provided',
                    'request_date' => now()->format('Y-m-d H:i:s'),
                    'ip_address' => $request->ip(),
                ];

                Mail::to('contact@autolikerlive.com')
                    ->send(new \App\Mail\DeleteAccountRequest($emailData));

                // Handle AJAX vs regular request
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Account deletion request sent successfully! We will process your request within 48 hours.'
                    ]);
                } else {
                    return redirect()->back()->with('success', 'Account deletion request sent successfully! We will process your request within 48 hours.');
                }
            } else {
                // reCAPTCHA failed
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'reCAPTCHA verification failed. Please try again.'
                    ], 422);
                } else {
                    return redirect()->back()->withErrors(['recaptcha' => 'reCAPTCHA verification failed. Please try again.'])->withInput();
                }
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation failed
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            } else {
                return redirect()->back()->withErrors($e->errors())->withInput();
            }
        } catch (\Exception $e) {
            // General error
            \Log::error('Delete account request error: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong. Please try again later.'
                ], 500);
            } else {
                return redirect()->back()->withErrors(['general' => 'Something went wrong. Please try again later.'])->withInput();
            }
        }
    }
}
