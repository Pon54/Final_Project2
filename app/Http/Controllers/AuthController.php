<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserLegacy;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $r)
    {
        try {
            $r->validate([
                'fullname' => 'required',
                'emailid' => 'required|email|unique:tblusers,EmailId',
                'password' => 'required|min:6',
                'mobileno' => 'nullable|digits:10'
            ]);

            $user = User::create([
                'FullName' => $r->fullname,
                'EmailId' => $r->emailid,
                'ContactNo' => $r->mobileno ?? null,
                // legacy used md5; we store bcrypt but keep field name
                'Password' => bcrypt($r->password),
            ]);

            // Redirect to homepage with success message
            return redirect('/')->with('success', 'You have successfully registered! You can now log in.');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Get validation errors
            $errors = $e->validator->errors();
            $errorMsg = $errors->first();
            
            // Redirect back with error message
            return redirect('/')->with('error', $errorMsg);
        } catch (\Exception $e) {
            // Handle any other errors
            return redirect('/')->with('error', 'Registration failed. Please try again.');
        }
    }

    public function login(Request $r)
    {
        try {
            // First check if APP_KEY is set
            if (empty(config('app.key'))) {
                \Log::error('CRITICAL: APP_KEY is not set! Cannot encrypt cookies/sessions.');
                \Log::error('Please set APP_KEY environment variable in Render dashboard.');
                return response()->json([
                    'error' => 'Server Configuration Error',
                    'message' => 'APP_KEY is not configured. Please contact administrator.',
                    'fix' => 'Set APP_KEY in Render Environment Variables'
                ], 500);
            }

            // Log everything for debugging
            \Log::info('=== LOGIN REQUEST STARTED ===');
            \Log::info('Request method: ' . $r->method());
            \Log::info('Has email: ' . ($r->has('email') ? 'yes' : 'no'));
            \Log::info('Has password: ' . ($r->has('password') ? 'yes' : 'no'));
            \Log::info('APP_KEY is set: YES');
            
            // Validate
            $r->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
            
            \Log::info('Validation passed');
            
            // Find user
            $user = User::where('EmailId', $r->email)->first();
            
            if (!$user) {
                \Log::info('User not found: ' . $r->email);
                return redirect('/')->with('error', 'User not found.');
            }
            
            \Log::info('User found: ' . $user->EmailId);
            
            // Check password
            $ok = false;
            $stored = $user->Password;
            
            if (\Str::startsWith($stored, ['$2y$', '$2a$', '$2b$'])) {
                $ok = Hash::check($r->password, $stored);
                \Log::info('Bcrypt check: ' . ($ok ? 'pass' : 'fail'));
            } elseif (preg_match('/^[0-9a-f]{32}$/i', $stored)) {
                $ok = (md5($r->password) === $stored);
                \Log::info('MD5 check: ' . ($ok ? 'pass' : 'fail'));
                if ($ok) {
                    $user->Password = bcrypt($r->password);
                    $user->save();
                    \Log::info('Password upgraded to bcrypt');
                }
            }
            
            if (!$ok) {
                \Log::info('Password check failed');
                return redirect('/')->with('error', 'Invalid password.');
            }
            
            // Set session
            \Log::info('Setting session data...');
            $r->session()->put([
                'login' => $user->EmailId,
                'fname' => $user->FullName,
                'user_id' => $user->id
            ]);
            
            // Save immediately
            $r->session()->save();
            
            \Log::info('Session saved. Values: ' . json_encode([
                'login' => $r->session()->get('login'),
                'fname' => $r->session()->get('fname'),
                'user_id' => $r->session()->get('user_id')
            ]));
            
            \Log::info('=== LOGIN SUCCESS ===');
            
            return redirect('/')->with('success', 'Welcome back, ' . $user->FullName . '!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed: ' . json_encode($e->errors()));
            return redirect('/')->with('error', 'Please enter valid email and password.');
        } catch (\Exception $e) {
            \Log::error('=== LOGIN ERROR ===');
            \Log::error('Error: ' . $e->getMessage());
            \Log::error('File: ' . $e->getFile() . ':' . $e->getLine());
            \Log::error('Trace: ' . $e->getTraceAsString());
            
            // Check if it's encryption key error
            if (strpos($e->getMessage(), 'encryption key') !== false || strpos($e->getMessage(), 'APP_KEY') !== false) {
                return redirect('/')->with('error', 'Server configuration error: APP_KEY not set. Please contact administrator.');
            }
            
            return redirect('/')->with('error', 'Login error. Please try again or contact support.');
        }
    }

    public function forgot(Request $r)
    {
        // placeholder: implement reset flow with tokens/emails
        $r->session()->flash('error', 'Password reset not implemented yet.');
        return redirect()->back();
    }

    public function logout(Request $r)
    {
        // Clear session data
        $r->session()->flush();
        $r->session()->regenerate();
        return redirect('/')->with('success', 'Logged out successfully.');
    }
}
