<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index(Request $r)
    {
        $query = Booking::with(['vehicle','user'])->orderBy('id','desc');
        if ($r->has('status')) {
            $statusInput = $r->status;
            $map = ['new' => 0, 'confirmed' => 1, 'canceled' => 2];
            if (isset($map[$statusInput])) {
                $query->where('Status', $map[$statusInput]);
            } elseif (is_numeric($statusInput)) {
                $query->where('Status', (int)$statusInput);
            }
        }
        $bookings = $query->paginate(20);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function setStatus(Request $r, $id)
    {
        $b = Booking::find($id);
        if (!$b) {
            session()->flash('error','Booking not found');
            return redirect()->back();
        }
        $status = $r->input('status');
        $map = ['new' => 0, 'confirmed' => 1, 'canceled' => 2];
        if (isset($map[$status])) {
            $b->Status = $map[$status];
        } elseif (is_numeric($status)) {
            $b->Status = (int)$status;
        } else {
            // unknown - leave unchanged
        }
        $b->save();
        session()->flash('msg','Booking status updated');
        return redirect()->back();
    }

    public function show($id)
    {
        $b = Booking::with(['vehicle','user'])->find($id);
        if (!$b) {
            session()->flash('error','Booking not found');
            return redirect()->route('admin.bookings.index');
        }
        return view('admin.bookings.show', compact('b'));
    }
}
