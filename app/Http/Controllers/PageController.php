<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public function show(Request $r)
    {
        $type = $r->query('type');
        $page = Page::where('type',$type)->first();
        if(!$page){
            abort(404);
        }
        return view('legacy.page', ['page' => $page]);
    }
}
