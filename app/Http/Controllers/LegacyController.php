<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Vehicle;

class LegacyController extends Controller
{
    public function index()
    {
        // delegate to the same data as VehicleController so '/' and legacy index match
        $vehicles = Vehicle::with('brand')->orderBy('id', 'desc')->take(9)->get();

        $contact_email = null;
        $contact_phone = null;
        if (Schema::hasTable('tblcontactusinfo')) {
            try {
                $c = DB::table('tblcontactusinfo')->first();
            } catch (\Exception $e) {
                $c = null;
            }
            if ($c) {
                $contact_email = $c->EmailId ?? $c->email ?? $c->Email ?? null;
                $contact_phone = $c->ContactNumber ?? $c->ContactNo ?? $c->phone ?? $c->Phone ?? null;
            }
        }

        return view('legacy.index', compact('vehicles','contact_email','contact_phone'));
    }

    public function search(Request $request)
    {
        // Accept search via POST or GET. If no search term, show all vehicles (legacy listing).
        $search = $request->input('searchdata') ?? $request->query('searchdata');

        if ($search) {
            // basic search on vehicle title, fuel or brand name (simple query placeholder)
            $vehiclesQuery = Vehicle::where('VehiclesTitle', 'like', "%{$search}%")
                ->orWhere('FuelType', 'like', "%{$search}%")
                ->orderBy('id', 'desc');
        } else {
            // If the request is the full listing page (/car-listing) paginate results,
            // otherwise return all for the lighter legacy search behaviour.
            if ($request->is('car-listing')) {
                $vehicles = Vehicle::orderBy('id','desc')->paginate(12);
            } else {
                $vehiclesQuery = Vehicle::orderBy('id', 'desc');
            }
        }

        // If we have a query builder, resolve it to a collection or paginator depending on context
        if (!isset($vehicles) && isset($vehiclesQuery)) {
            // For non-listing routes with no search, we prefer a collection for the legacy behaviour
            if ($request->is('car-listing')) {
                $vehicles = $vehiclesQuery->paginate(12);
            } else {
                $vehicles = $vehiclesQuery->get();
            }
        }

        $recent = Vehicle::orderBy('id', 'desc')->take(4)->get();
        $count = is_countable($vehicles) ? count($vehicles) : 0;
        return view('legacy.search', compact('search', 'vehicles', 'recent', 'count'));
    }

    public function vehicle($id)
    {
        $vehicle = Vehicle::find($id);
        $similar = $vehicle ? Vehicle::where('VehiclesBrand', $vehicle->VehiclesBrand)->take(4)->get() : [];
        return view('legacy.vehicle', compact('id', 'vehicle', 'similar'));
    }

    public function contact()
    {
        // contact form: placeholder. The view will post back to this route in future.
        $contact_info = null;
        return view('legacy.contact', compact('contact_info'));
    }
}
