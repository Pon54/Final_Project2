<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function book(Request $r, $id)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Please login first to book a vehicle.');
        }

        // Check if user already has an active booking
        $existingBooking = Booking::where('userEmail', Auth::user()->EmailId)
            ->where('Status', '!=', 2) // Not cancelled
            ->exists();
        
        if ($existingBooking) {
            return redirect()->back()->with('error', 'You already have an active booking. Please complete or cancel your existing booking first.');
        }

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
            return redirect('/car-listing')->with('error', 'Invalid booking data. Please check your dates and try again.');
        }
        // naive check for overlapping bookings
        $overlap = Booking::where('VehicleId',$id)
            ->where(function($q) use($r){
                $q->whereBetween('FromDate', [$r->fromdate, $r->todate])
                  ->orWhereBetween('ToDate', [$r->fromdate, $r->todate]);
            })->exists();
        if($overlap){
            return redirect('/car-listing')->with('error', 'This car is already booked for the selected dates. Please choose different dates.');
        }

        $booking = Booking::create([
            'BookingNumber' => mt_rand(100000000,999999999),
            'userEmail' => Auth::user()->EmailId,
            'VehicleId' => $id,
            'FromDate' => $from,
            'ToDate' => $to,
            'message' => $message,
            'Status' => 0,
        ]);

        if($booking){
            return redirect('/my-booking')->with('success', 'Booking successful! Your reservation has been confirmed. You can view your booking details below.');
        }
        return redirect('/car-listing')->with('error', 'Something went wrong. Please try again.');
    }
}
