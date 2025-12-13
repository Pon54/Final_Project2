<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('BrandName')->paginate(20);
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.form');
    }

    public function store(Request $r)
    {
        $r->validate([
            'BrandName'=>'required|string|max:255|unique:tblbrands,BrandName'
        ]);
        Brand::create($r->only('BrandName'));
        return redirect()->route('admin.brands.index')->with('msg','Brand created.');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.form', compact('brand'));
    }

    public function update(Request $r, $id)
    {
        $r->validate([
            'BrandName'=>'required|string|max:255|unique:tblbrands,BrandName,'.$id
        ]);
        $b = Brand::findOrFail($id);
        $b->update($r->only('BrandName'));
        return redirect()->route('admin.brands.index')->with('msg','Brand updated.');
    }

    public function destroy($id)
    {
        Brand::findOrFail($id)->delete();
        return redirect()->route('admin.brands.index')->with('msg','Brand deleted.');
    }
}
