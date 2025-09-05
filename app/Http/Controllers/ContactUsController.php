<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Mail\ContactUs;


class ContactUsController extends Controller
{
    public function contactUs(){
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
}
