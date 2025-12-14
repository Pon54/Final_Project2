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
            $r->validate(['email' => 'required|email','password' => 'required']);
            $user = User::where('EmailId', $r->email)->first();
            
            if ($user) {
                $stored = $user->Password;
                $input = $r->password;
                $ok = false;

                // Debug logging
                \Log::info('Login attempt', [
                    'email' => $r->email,
                    'stored_password_length' => strlen($stored),
                    'stored_password_preview' => substr($stored, 0, 10) . '...',
                    'is_bcrypt' => \Str::startsWith($stored, ['$2y$','$2a$','$2b$']),
                    'is_md5' => preg_match('/^[0-9a-f]{32}$/i', $stored) ? 'yes' : 'no'
                ]);

                // If stored password looks like bcrypt/argon (starts with $2y$/$2a$/$2b$), use Hash::check
                if (\Str::startsWith($stored, ['$2y$','$2a$','$2b$','$argon$'])) {
                    $ok = Hash::check($input, $stored);
                    \Log::info('Bcrypt check result: ' . ($ok ? 'success' : 'failed'));
                }
                // If stored password looks like legacy md5 (32 hex chars), compare md5
                elseif (preg_match('/^[0-9a-f]{32}$/i', $stored)) {
                    $inputMd5 = md5($input);
                    \Log::info('MD5 check', ['input_md5' => $inputMd5, 'stored' => $stored]);
                    if ($inputMd5 === $stored) {
                        $ok = true;
                        // upgrade legacy md5 to bcrypt for better security
                        $user->Password = bcrypt($input);
                        $user->save();
                        \Log::info('Upgraded legacy MD5 password to bcrypt for user: ' . $user->EmailId);
                    }
                }
                else {
                    // last resort: try PHP password_verify, wrapped to avoid exceptions
                    try {
                        $ok = password_verify($input, $stored);
                    } catch (\Throwable $e) {
                        $ok = false;
                    }
                }

                if ($ok) {
                    // Use Laravel's built-in authentication (without remember token since column doesn't exist)
                    Auth::login($user);
                    
                    // Regenerate session to prevent fixation
                    $r->session()->regenerate();
                    
                    // Set session variables for legacy pages (Laravel manages the session)
                    session(['login' => $user->EmailId]);
                    session(['fname' => $user->FullName]);
                    
                    // Log for debugging
                    \Log::info('User logged in successfully', [
                        'user_id' => $user->id,
                        'email' => $user->EmailId,
                        'name' => $user->FullName,
                        'auth_check' => Auth::check(),
                        'auth_id' => Auth::id()
                    ]);
                    
                    // Redirect with success message
                    return redirect('/')->with('success', 'Welcome back, ' . $user->FullName . '! You have successfully logged in.');
                }
            }
            
            // Redirect with error message
            return redirect('/')->with('error', 'Invalid credentials. Please try again.');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Login validation error: ' . $e->getMessage());
            return redirect('/')->with('error', 'Please provide valid email and password.');
        } catch (\Exception $e) {
            \Log::error('Login error: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            return redirect('/')->with('error', 'Login failed: ' . $e->getMessage());
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
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        $r->session()->flash('msg', 'Logged out successfully.');
        return redirect('/');
    }
}
