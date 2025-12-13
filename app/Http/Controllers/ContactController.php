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
        
        $r->session()->flash('success_modal','Thank you for contacting us! We will get back to you shortly.');
        return redirect('/contact-us');
    }

    public function subscribe(Request $r)
    {
        if (!Auth::check()) {
            $r->session()->flash('error', 'Please login first to subscribe.');
            return redirect()->back();
        }

        $r->validate(['subscriberemail' => 'required|email']);
        
        Subscriber::firstOrCreate(['SubscriberEmail' => $r->subscriberemail]);
        
        $r->session()->flash('success_modal', 'You have subscribed in our Car Portal');
        return redirect()->back();
    }
}
