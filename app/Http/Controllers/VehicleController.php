<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    public function index()
    {
        // Use id desc for legacy tables that don't have created_at
        $vehicles = Vehicle::with('brand')->orderBy('id', 'desc')->take(9)->get();

        // try to load contact info from legacy contact table if it exists
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

    public function show($id)
    {
        $vehicle = Vehicle::find($id);
        $similar = Vehicle::where('VehiclesBrand',$vehicle->VehiclesBrand ?? null)->take(4)->get();
        return view('legacy.vehicle', ['id' => $id, 'vehicle' => $vehicle, 'similar' => $similar]);
    }
}
