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
                'password' => 'required|min:6'
            ]);

            $user = User::create([
                'FullName' => $r->fullname,
                'EmailId' => $r->emailid,
                'ContactNo' => $r->mobileno ?? null,
                // legacy used md5; we store bcrypt but keep field name
                'Password' => bcrypt($r->password),
            ]);

            // Set both Laravel session and PHP session for compatibility
            session(['success_modal' => 'You have successfully registered']);
            $_SESSION['success_modal'] = 'You have successfully registered';
            
            \Log::info('Registration successful, session set', ['session' => session('success_modal')]);
            
            return redirect('/');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Set error in both sessions
            $errors = $e->validator->errors();
            $errorMsg = $errors->first();
            
            session(['error_modal' => $errorMsg]);
            $_SESSION['error_modal'] = $errorMsg;
            
            \Log::info('Registration failed', ['error' => $errorMsg]);
            
            return redirect('/');
        }
    }

    public function login(Request $r)
    {
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
                // Use Laravel's built-in authentication
                Auth::login($user);
                $r->session()->flash('success_modal', 'You have successfully logged in');
                return redirect('/');
            }
        }
        $r->session()->flash('error', 'Invalid credentials');
        return redirect()->back();
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
