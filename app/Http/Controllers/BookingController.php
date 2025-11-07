<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Vehicle;

class BookingController extends Controller
{
    public function book(Request $r, $id)
    {
        // support both legacy capitalized field names and lowercase ones
        $from = $r->input('fromdate', $r->input('FromDate'));
        $to = $r->input('todate', $r->input('ToDate'));
        $message = $r->input('message', $r->input('Message'));

        // validate
        $validator = \Illuminate\Support\Facades\Validator::make([
            'fromdate' => $from,
            'todate' => $to,
            'message' => $message,
        ], [
            'fromdate' => 'required|date',
            'todate' => 'required|date',
            'message' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            $r->session()->flash('error', 'Invalid booking data');
            return redirect('/car-listing');
        }
        // naive check for overlapping bookings
        $overlap = Booking::where('VehicleId',$id)
            ->where(function($q) use($r){
                $q->whereBetween('FromDate', [$r->fromdate, $r->todate])
                  ->orWhereBetween('ToDate', [$r->fromdate, $r->todate]);
            })->exists();
        if($overlap){
            $r->session()->flash('error','Car already booked for these days');
            return redirect('/car-listing');
        }

        $booking = Booking::create([
            'BookingNumber' => mt_rand(100000000,999999999),
            'userEmail' => session('login') ?? $r->input('userEmail') ?? $r->input('useremail') ?? null,
            'VehicleId' => $id,
            'FromDate' => $from,
            'ToDate' => $to,
            'message' => $message,
            'Status' => 0,
        ]);

        if($booking){
            $r->session()->flash('msg','Booking successful.');
            return redirect('/my-booking');
        }
        $r->session()->flash('error','Something went wrong.');
        return redirect('/car-listing');
    }
}
