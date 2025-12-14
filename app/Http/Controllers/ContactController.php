<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactQuery;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function contact(Request $r)
    {
        $r->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contactno' => 'nullable|string|max:20',
            'message' => 'required|string|max:1000'
        ]);
        
        ContactQuery::create([
            'name' => $r->fullname,
            'EmailId' => $r->email,
            'ContactNumber' => $r->contactno ?? null,
            'Message' => $r->message,
            'PostingDate' => now(),
        ]);
        
        return redirect('/contact-us')->with('success', 'Thank you for contacting us! We will get back to you shortly.');
    }

    public function subscribe(Request $r)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Please login first to subscribe.');
        }

        $r->validate(['subscriberemail' => 'required|email']);
        
        Subscriber::firstOrCreate(['SubscriberEmail' => $r->subscriberemail]);
        
        return redirect()->back()->with('success', 'Thank you for subscribing! You will receive exclusive deals and updates from our Car Rental Portal.');
    }
}
