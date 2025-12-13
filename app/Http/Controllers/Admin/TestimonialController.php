<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $testimonials = Testimonial::orderBy('id','desc')->paginate(15);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function setStatus(Request $request, $id)
    {
        $t = Testimonial::findOrFail($id);
        $t->status = $request->input('status', $t->status);
        $t->save();
        return redirect()->route('admin.testimonials.index');
    }

    public function destroy($id)
    {
        $t = Testimonial::find($id);
        if ($t) $t->delete();
        return redirect()->route('admin.testimonials.index');
    }
}
