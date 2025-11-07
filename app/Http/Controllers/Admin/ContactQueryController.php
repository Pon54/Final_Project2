<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactQueryController extends Controller
{
    public function index()
    {
        return response('Contact queries placeholder', 200);
    }
}
