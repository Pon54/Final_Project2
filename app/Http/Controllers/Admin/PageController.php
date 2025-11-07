<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $pages = Page::orderBy('PageName')->paginate(15);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.form', ['page' => new Page()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'PageName' => 'required|string|max:255',
            'type' => 'nullable|string|max:50',
            'detail' => 'nullable|string',
        ]);
        Page::create($data);
        return redirect()->route('admin.pages.index')->with('status', 'Page created');
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.form', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        $data = $request->validate([
            'PageName' => 'required|string|max:255',
            'type' => 'nullable|string|max:50',
            'detail' => 'nullable|string',
        ]);
        $page->update($data);
        return redirect()->route('admin.pages.index')->with('status', 'Page updated');
    }

    public function destroy($id)
    {
        $page = Page::find($id);
        if ($page) $page->delete();
        return redirect()->route('admin.pages.index')->with('status', 'Page deleted');
    }
}
