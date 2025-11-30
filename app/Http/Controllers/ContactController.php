<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactQuery;
use App\Models\Subscriber;

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
        
        $r->session()->flash('msg','Thank you for contacting us! We will get back to you shortly.');
        return redirect('/contact-us')->with('success', 'Your message has been sent successfully!');
    }

    public function subscribe(Request $r)
    {
        if (!auth()->check()) {
            return redirect()->back()->with('subscribe_error', 'Please login first to subscribe.');
        }
        
        $r->validate([
            'subscriberemail' => 'required|email|max:255'
        ]);
        
        $subscriber = Subscriber::firstOrCreate(['SubscriberEmail' => $r->subscriberemail]);
        
        if ($subscriber->wasRecentlyCreated) {
            return redirect()->back()->with('subscribe_success', 'Successfully subscribed! Thank you for subscribing to our car rental portal.');
        } else {
            return redirect()->back()->with('subscribe_success', 'You are already subscribed to our car rental portal.');
        }
    }
}
