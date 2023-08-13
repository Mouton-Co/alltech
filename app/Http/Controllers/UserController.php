<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | RESOURCES
    |--------------------------------------------------------------------------
    */

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return view('models.user.index')->with([
            'users'  => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();

        return view('models.user.create')->with([
            'roles'  => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $user = User::create([
            'name'     => $request->get('name'),
            'email'    => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'role_id'  => $request->get('role_id'),
        ]);

        if ($user) {
            return redirect()->route('user.index')->with([
                'success' => "$user->name successfully created"
            ]);
        }

        return redirect()->route('user.index')->with([
            'error' => "User creation failed"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);

        if (empty($user)) {
            return redirect()->route('user.index')->with([
                'error' => "User not found"
            ]);
        }

        $roles = Role::all();

        return view('models.user.edit')->with([
            'user'   => $user,
            'roles'  => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $user = User::find($id);

        if (empty($user)) {
            return redirect()->route('user.index')->with([
                'error' => "User not found"
            ]);
        }

        $user->name    = $request->get('name');
        $user->email   = $request->get('email');
        $user->role_id = $request->get('role_id');

        if (!empty($request->get('password'))) {
            $user->name = $request->get('name');
        }
        
        $user->save();

        return redirect()->route('user.edit', $user->id)->with([
            'success' => "User updated"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (empty($user)) {
            return redirect()->route('user.index')->with([
                'error' => "User not found"
            ]);
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('user.index')->with([
            'success' => "$name has been removed"
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | OTHER
    |--------------------------------------------------------------------------
    */

    /**
     * Toggles the dark mode for logged in user.
     */
    public function toggleDarkMode()
    {
        $user = User::find(auth()->user()->id);
        $user->dark = !$user->dark;
        $user->save();
    }
}
