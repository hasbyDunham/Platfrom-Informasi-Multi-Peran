<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
     {
         $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
         $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
     }

    public function index(Request $request)
    {

        $data = User::orderBy('created_at', 'asc')->paginate(5);
        confirmDelete("Delete", "Are you sure you want to delete?");

        return View('users.index', compact('data'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return View('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $users = User::create($input);
        $users->assignRole($request->input('roles'));

        toast('Users Added','success');
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(string $id)
    {
        $users = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $users->roles->pluck('name', 'name')->all();

        return view('users.update', compact('users', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            // 'roles' => 'required',
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $users = User::find($id);
        $users->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $users->assignRole($request->input('roles'));

        toast('Users Updated','success');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        User::find($id)->delete();
        
        toast('Delete Data Successfully','success');
        return redirect()->route('users.index');
    }
}
