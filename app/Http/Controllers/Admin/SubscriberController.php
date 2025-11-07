<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscriber;

class SubscriberController extends Controller
{
    public function index()
    {
        $subs = Subscriber::orderBy('id','desc')->paginate(25);
        return view('admin.subscribers.index', ['subscribers' => $subs]);
    }

    public function destroy($id)
    {
        $s = Subscriber::find($id);
        if ($s) $s->delete();
        return redirect()->route('admin.subscribers.index')->with('status','Subscriber removed');
    }
}
