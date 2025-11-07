<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactQuery;
use App\Models\Subscriber;

class ContactController extends Controller
{
    public function contact(Request $r)
    {
        $r->validate(['fullname' => 'required','email' => 'required|email','message' => 'required']);
        ContactQuery::create([
            'name' => $r->fullname,
            'EmailId' => $r->email,
            'ContactNumber' => $r->contactno ?? null,
            'Message' => $r->message,
        ]);
        $r->session()->flash('msg','Query Sent. We will contact you shortly');
        return redirect('/contact-us');
    }

    public function subscribe(Request $r)
    {
        $r->validate(['subscriberemail' => 'required|email']);
        Subscriber::firstOrCreate(['SubscriberEmail' => $r->subscriberemail]);
        $r->session()->flash('msg','Subscribed successfully.');
        return redirect()->back();
    }
}
