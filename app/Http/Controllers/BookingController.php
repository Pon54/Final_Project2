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
        
        // Check if user already has an active booking (pending or confirmed)
        $user = \Auth::user();
        $userEmail = $user ? $user->EmailId : ($r->input('userEmail') ?? $r->input('useremail'));
        
        $existingBooking = Booking::where('userEmail', $userEmail)
            ->whereIn('Status', [0, 1]) // 0 = pending, 1 = confirmed
            ->exists();
            
        if ($existingBooking) {
            $r->session()->flash('error', 'You already have an active booking. Please complete or cancel your existing booking before making a new one.');
            return redirect('/car-listing');
        }
        
        // Improved check for overlapping bookings
        $overlap = Booking::where('VehicleId', $id)
            ->where('Status', '!=', 2) // Exclude cancelled bookings
            ->where(function($q) use ($from, $to) {
                // Check if new booking overlaps with existing bookings
                $q->whereBetween('FromDate', [$from, $to])
                  ->orWhereBetween('ToDate', [$from, $to])
                  ->orWhere(function($q2) use ($from, $to) {
                      // Check if existing booking encompasses new booking
                      $q2->where('FromDate', '<=', $from)
                         ->where('ToDate', '>=', $to);
                  });
            })->exists();
            
        if ($overlap) {
            $r->session()->flash('error', 'Car already booked for these days');
            return redirect('/car-listing');
        }

        // Get authenticated user
        $user = \Auth::user();
        $userEmail = $user ? $user->EmailId : ($r->input('userEmail') ?? $r->input('useremail'));

        $booking = Booking::create([
            'BookingNumber' => mt_rand(100000000,999999999),
            'userEmail' => $userEmail,
            'VehicleId' => $id,
            'FromDate' => $from,
            'ToDate' => $to,
            'message' => $message,
            'Status' => 0,
            'PostingDate' => now(),
        ]);

        if($booking){
            $r->session()->flash('msg','Booking successful.');
            return redirect('/my-booking');
        }
        $r->session()->flash('error','Something went wrong.');
        return redirect('/car-listing');
    }

    public function cancel(Request $r, $id)
    {
        // Get authenticated user
           $user = \Auth::user();
        
        if (!$user) {
            $r->session()->flash('error', 'Please login to cancel booking.');
            return redirect('/my-booking');
        }

        // Find the booking and verify it belongs to the user
        $booking = Booking::where('id', $id)
                         ->where('userEmail', $user->EmailId)
                         ->first();

        if (!$booking) {
            $r->session()->flash('error', 'Booking not found.');
            return redirect('/my-booking');
        }

        // Delete the booking completely
        $booking->delete();

        $r->session()->flash('msg', 'Booking cancelled successfully.');
        return redirect('/my-booking');
    }
}
