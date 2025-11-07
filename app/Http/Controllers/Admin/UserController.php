<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserLegacy;

class UserController extends Controller
{
    public function index()
    {
        $users = UserLegacy::orderBy('FullName')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = UserLegacy::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function destroy($id)
    {
        $u = UserLegacy::find($id);
        if ($u) $u->delete();
        return redirect()->route('admin.users.index')->with('status','User removed');
    }
}
