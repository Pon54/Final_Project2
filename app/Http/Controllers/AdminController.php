<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $r)
    {
        $r->validate(['username' => 'required','password' => 'required']);
        $username = $r->username;
        $password = md5($r->password); // legacy stores md5

        $admin = DB::table('admin')->where('UserName', $username)->where('Password', $password)->first();
        if($admin){
            session(['alogin' => $username]);
            return redirect()->route('admin.dashboard');
        }
        return redirect()->back()->with('error','Invalid Details');
    }

    public function dashboard()
    {
        if(!session('alogin')){
            return redirect('/admin');
        }
        // gather some basic stats
        $vehiclesCount = \App\Models\Vehicle::count();
        $bookingsCount = \App\Models\Booking::count();
        $usersCount = \App\Models\UserLegacy::count();
        $recentBookings = \App\Models\Booking::with('vehicle')->orderBy('id','desc')->limit(10)->get();

        return view('admin.dashboard', compact('vehiclesCount','bookingsCount','usersCount','recentBookings'));
    }
}
