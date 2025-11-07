<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Str;

class DiagnosticsController extends Controller
{
    public function images(Request $request)
    {
        $perPage = 20;
        $query = Vehicle::orderBy('id','desc');

        // CSV export
        if ($request->query('export') === 'csv') {
            $candidates = [
                'legacy/admin/img/vehicleimages/',
                'legacy/img/vehicleimages/',
                'legacy/admin-img/vehicleimages/',
                'legacy/img/',
                'legacy/assets/images/',
            ];

            $response = new StreamedResponse(function() use ($query, $candidates) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['id','VehiclesTitle','Vimage1','found','foundPath']);
                foreach ($query->cursor() as $v) {
                    $file = $v->Vimage1 ?? '';
                    $found = false;
                    $foundPath = '';
                    foreach ($candidates as $c) {
                        $p = public_path($c . $file);
                        if ($file && file_exists($p)) { $found = true; $foundPath = $c . $file; break; }
                    }
                    fputcsv($handle, [$v->id, $v->VehiclesTitle ?? '', $file, $found ? 'FOUND' : 'MISSING', $foundPath]);
                }
                fclose($handle);
            });

            $fname = 'vehicle-images-' . date('Ymd-His') . '.csv';
            $response->headers->set('Content-Type', 'text/csv');
            $response->headers->set('Content-Disposition', 'attachment; filename="' . $fname . '"');
            return $response;
        }

        $vehicles = $query->paginate($perPage)->withQueryString();
        $candidates = [
            'legacy/admin/img/vehicleimages/',
            'legacy/img/vehicleimages/',
            'legacy/admin-img/vehicleimages/',
            'legacy/img/',
            'legacy/assets/images/',
        ];

        return view('admin.diagnostics.images', compact('vehicles','candidates'));
    }
}
