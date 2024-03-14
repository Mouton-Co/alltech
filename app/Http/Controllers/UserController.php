<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\IndexRequest;
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
    public function index(IndexRequest $request)
    {
        $users = User::select(['users.*', 'roles.name as role_name'])
            ->join('roles', 'roles.id', '=', 'users.role_id');

        if (! empty($request->get('order_by')) && $request->get('order_by') == 'role->name') {
            $users = $users->orderBy(
                'roles.name',
                $request->get('order_direction') ?? 'asc'
            );
        } else {
            $users = $users->orderBy(
                $request->get('order_by') ?? 'users.name',
                $request->get('order_direction') ?? 'asc'
            );
        }

        if (! empty($request->get('search'))) {
            $users = $users->where('users.name', 'like', '%'.$request->get('search').'%')
                ->orWhere('email', 'like', '%'.$request->get('search').'%')
                ->orWhere('roles.name', 'like', '%'.$request->get('search').'%');
        }

        return view('models.user.index')->with([
            'users' => $users->paginate(10),
            'roles' => Role::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make(
                ! empty($request->get('password')) ?
                    $request->get('password') :
                    'password'
            ),
            'role_id' => $request->get('role_id'),
        ]);

        if ($user) {
            return redirect()->route('user.index')->with([
                'success' => "$user->name successfully created",
            ]);
        }

        return redirect()->route('user.index')->with([
            'error' => 'User creation failed',
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
                'error' => 'User not found',
            ]);
        }

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->role_id = $request->get('role_id');

        if (! empty($request->get('password'))) {
            $user->password = Hash::make($request->get('password'));
        }

        $user->save();

        return redirect()->route('user.index')->with([
            'success' => "$user->name successfully created",
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
                'error' => 'User not found',
            ]);
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('user.index')->with([
            'success' => "$name has been removed",
        ]);
    }

    /**
     * Show edit user form
     */
    public function edit(string $id)
    {
        $user = User::find($id);

        if (empty($user)) {
            return redirect()->route('user.index')->with([
                'error' => 'User not found',
            ]);
        }

        return view('models.user.edit')->with([
            'user' => $user,
            'roles' => Role::all(),
        ]);
    }
}
