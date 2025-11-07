<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Vehicle;

$v = Vehicle::create([
    'VehiclesBrand' => null,
    'VehiclesTitle' => 'TEST VEHICLE X',
    'Vimage1' => 'test.jpg',
    'Vimage2' => null,
    'Vimage3' => null,
    'Vimage4' => null,
    'Vimage5' => null,
    'FuelType' => 'Gasoline',
    'ModelYear' => '2020',
    'SeatingCapacity' => 4,
    'VehiclesOverview' => 'Inserted by test script',
    'PricePerDay' => 100.00,
]);

echo "Inserted vehicle id: " . $v->id . "\n";
