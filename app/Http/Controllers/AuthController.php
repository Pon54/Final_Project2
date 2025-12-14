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
            // Validate input
            $validated = $r->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
            
            \Log::info('Login attempt started', ['email' => $r->email]);
            
            // Find user
            $user = User::where('EmailId', $r->email)->first();
            
            if (!$user) {
                \Log::warning('Login failed - user not found', ['email' => $r->email]);
                return redirect('/')->with('error', 'Invalid credentials. Please try again.');
            }
            
            $stored = $user->Password;
            $input = $r->password;
            $ok = false;

            // Check password
            if (\Str::startsWith($stored, ['$2y$','$2a$','$2b$','$argon$'])) {
                $ok = Hash::check($input, $stored);
            } elseif (preg_match('/^[0-9a-f]{32}$/i', $stored)) {
                if (md5($input) === $stored) {
                    $ok = true;
                    // Upgrade to bcrypt
                    $user->Password = bcrypt($input);
                    $user->save();
                }
            }

            if (!$ok) {
                \Log::warning('Login failed - invalid password', ['email' => $r->email]);
                return redirect('/')->with('error', 'Invalid credentials. Please try again.');
            }
            
            // Set session - simple approach
            \Log::info('Setting session for user', ['user_id' => $user->id, 'email' => $user->EmailId]);
            
            $r->session()->put('login', $user->EmailId);
            $r->session()->put('fname', $user->FullName);
            $r->session()->put('user_id', $user->id);
            $r->session()->save(); // Force save
            
            \Log::info('Login successful', [
                'user_id' => $user->id,
                'session_login' => $r->session()->get('login'),
                'session_fname' => $r->session()->get('fname')
            ]);
            
            return redirect('/')->with('success', 'Welcome back, ' . $user->FullName . '! You have successfully logged in.');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Login validation error', ['errors' => $e->errors()]);
            return redirect('/')->with('error', 'Please provide valid email and password.');
        } catch (\Exception $e) {
            \Log::error('Login exception', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect('/')->with('error', 'Login error: ' . $e->getMessage());
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
