<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Session;

class CopyPagesController extends Controller
{
    public function yolikers()
    {
        return view('copyPages.yolikers');
    }

    public function djliker()
    {
        return view('copyPages.djliker');
    }

    public function machineliker()
    {
        return view('copyPages.machineliker');
    }

    public function rajeliker()
    {
        return view('rajeliker');
    }

    /**
     * Redirect to Facebook OAuth
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')
            ->scopes(['email', 'public_profile'])
            ->redirect();
    }

    /**
     * Handle Facebook OAuth callback
     */
    public function handleFacebookCallback(Request $request)
    {
        try {
            // Handle OAuth errors
            if ($request->has('error')) {
                $error = $request->get('error');
                $errorDescription = $request->get('error_description', 'Unknown error occurred');

                \Log::warning('Facebook OAuth Error', [
                    'error' => $error,
                    'description' => $errorDescription,
                    'ip' => $request->ip()
                ]);

                return redirect()->route('rajeliker')->with('login_error', 'Login was cancelled or failed. Please try again.');
            }

            $facebookUser = Socialite::driver('facebook')->user();

            // Validate user data
            if (!$facebookUser->getId() || !$facebookUser->getName()) {
                throw new \Exception('Invalid user data received from Facebook');
            }

            // Store user data in session
            Session::put('facebook_user', [
                'id' => $facebookUser->getId(),
                'name' => $facebookUser->getName(),
                'email' => $facebookUser->getEmail() ?? 'No email provided',
                'avatar' => $facebookUser->getAvatar(),
                'token' => $facebookUser->token,
                'logged_in_at' => now(),
                'ip_address' => $request->ip(),
            ]);

            // Log successful login
            \Log::info('Facebook Login Successful', [
                'facebook_id' => $facebookUser->getId(),
                'name' => $facebookUser->getName(),
                'ip' => $request->ip()
            ]);

            // Redirect back to Rajeliker page with success parameter
            return redirect()->route('rajeliker')->with('login_success', 'Successfully logged in with Facebook!');

        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            \Log::error('Facebook OAuth Invalid State', [
                'error' => $e->getMessage(),
                'ip' => $request->ip()
            ]);

            return redirect()->route('rajeliker')->with('login_error', 'Security validation failed. Please try logging in again.');

        } catch (\Exception $e) {
            \Log::error('Facebook OAuth Error', [
                'error' => $e->getMessage(),
                'ip' => $request->ip()
            ]);

            return redirect()->route('rajeliker')->with('login_error', 'Failed to login with Facebook. Please try again.');
        }
    }

    /**
     * Logout from Facebook session
     */
    public function facebookLogout(Request $request)
    {
        // Get user info before logout for logging
        $facebookUser = Session::get('facebook_user');

        // Clear Facebook session
        Session::forget('facebook_user');

        // Log logout
        if ($facebookUser) {
            \Log::info('Facebook Logout', [
                'facebook_id' => $facebookUser['id'],
                'name' => $facebookUser['name'],
                'ip' => $request->ip()
            ]);
        }

        return redirect()->route('rajeliker')->with('logout_success', 'You have been logged out successfully.');
    }

    /**
     * Get current Facebook user session
     */
    public function getCurrentUser()
    {
        return Session::get('facebook_user');
    }

    /**
     * Check if user is logged in via Facebook
     */
    public function isLoggedIn()
    {
        return Session::has('facebook_user');
    }

    /**
     * API endpoint to get login status (for AJAX calls)
     */
    public function getLoginStatus(Request $request)
    {
        $isLoggedIn = Session::has('facebook_user');
        $user = Session::get('facebook_user');

        if ($request->expectsJson()) {
            return response()->json([
                'logged_in' => $isLoggedIn,
                'user' => $isLoggedIn ? [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'avatar' => $user['avatar'],
                    'logged_in_at' => $user['logged_in_at']
                ] : null
            ]);
        }

        return response($isLoggedIn ? 'logged_in' : 'not_logged_in');
    }
}
