<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Brand;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('brand')->orderBy('id','desc')->paginate(20);
        $brands = Brand::orderBy('BrandName')->get();
        return view('admin.vehicles.index', compact('vehicles','brands'));
    }

    public function create()
    {
        $brands = Brand::orderBy('BrandName')->get();
        return view('admin.vehicles.form', compact('brands'));
    }

    public function store(Request $r)
    {
        $r->validate([
            'VehiclesTitle'=>'required|string|max:255',
            'PricePerDay'=>'required|numeric',
            'Vimage1'=>'nullable|image|max:5120'
        ]);

        // use legacy column names so admin-created records appear correctly on the public site
        $data = $r->only(['VehiclesTitle','PricePerDay','FuelType','ModelYear','SeatingCapacity','VehiclesBrand']);
        if($r->hasFile('Vimage1')){
            $file = $r->file('Vimage1');
            $name = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('legacy/admin/img/vehicleimages'), $name);
            $data['Vimage1'] = $name;
        }
    Vehicle::create($data);
        return redirect()->route('admin.vehicles.index')->with('msg','Vehicle created.');
    }

    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $brands = Brand::orderBy('BrandName')->get();
        return view('admin.vehicles.form', compact('vehicle','brands'));
    }

    public function update(Request $r, $id)
    {
        $r->validate([
            'VehiclesTitle'=>'required|string|max:255',
            'PricePerDay'=>'required|numeric',
            'Vimage1'=>'nullable|image|max:5120'
        ]);
        $vehicle = Vehicle::findOrFail($id);
    $data = $r->only(['VehiclesTitle','PricePerDay','FuelType','ModelYear','SeatingCapacity','VehiclesBrand']);
        if($r->hasFile('Vimage1')){
            $file = $r->file('Vimage1');
            $name = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('legacy/admin/img/vehicleimages'), $name);
            $data['Vimage1'] = $name;
        }
        $vehicle->update($data);
        return redirect()->route('admin.vehicles.index')->with('msg','Vehicle updated.');
    }

    public function destroy($id)
    {
        $v = Vehicle::findOrFail($id);
        $v->delete();
        return redirect()->route('admin.vehicles.index')->with('msg','Vehicle deleted.');
    }

    public function bulkDelete(Request $r)
    {
        $ids = $r->input('ids', []);
        if(empty($ids)){
            return redirect()->route('admin.vehicles.index')->with('error','No vehicles selected.');
        }
        Vehicle::whereIn('id', $ids)->delete();
        return redirect()->route('admin.vehicles.index')->with('msg','Selected vehicles deleted.');
    }

    public function exportCsv()
    {
    $columns = ['id','VehiclesTitle','VehiclesBrand','PricePerDay','FuelType','ModelYear','SeatingCapacity','Vimage1'];
        $response = new StreamedResponse(function() use ($columns) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $columns);
            Vehicle::chunk(500, function($rows) use ($handle) {
                foreach($rows as $r){
                    fputcsv($handle, [
                        $r->id,$r->VehiclesTitle,$r->VehiclesBrand,$r->PricePerDay,$r->FuelType,$r->ModelYear,$r->SeatingCapacity,$r->Vimage1
                    ]);
                }
            });
            fclose($handle);
        });
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="vehicles.csv"');
        return $response;
    }
}
