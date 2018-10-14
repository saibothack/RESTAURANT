<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Restaurant;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $users = User::search($request->get('search'))->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id');
        $restaurants = Restaurant::active(1)->pluck('name', 'id');
        return view('users.create', compact('roles', 'restaurants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateUser($request, $id);

        $password = str_random(8);

        if ($request->only('role') == 1) {
            $dataUser = $request->only('roles_id', 'email', 'name');
            $dataUser['password'] = $password;
            $user = User::create($dataUser);
        } else {
            $dataUser = $request->only('roles_id', 'restaurants_id', 'email', 'name');
            $dataUser['password'] = $password;
            $user = User::create($dataUser);
        }



        if (isset($dataUser['roles_id'])) {
            $role_r = Role::where('id', '=', $dataUser['roles_id'])->firstOrFail();
            $user->assignRole($role_r);
        }    

        return redirect()->route('users.index')
            ->with('flash_message',
             'El usuario se dio de alta.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('users'); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::pluck('name', 'id');
        $restaurants = Restaurant::active(1)->pluck('name', 'id');
        return view('users.edit', compact('user', 'roles', 'restaurants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validateUser($request, $id);

        $user = User::findOrFail($id);
    
        if ($request->only('role') == 1) {
            $dataUser = $request->only('roles_id', 'email', 'name');
            $user->fill($dataUser)->save();
        } else {
            $dataUser = $request->only('roles_id', 'restaurants_id', 'email', 'name');
            $user->fill($dataUser)->save();
        }

        if (isset($dataUser['roles_id'])) {
            $user->roles()->sync($dataUser['roles_id']);
        }        
        
        return redirect()->route('users.index')
                ->with('flash_message',
                 'El usuario se modifico correctamente.');    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $dataUser = array('status' => 0);
        $user->fill($dataUser)->save();
        return redirect()->route('users.index')
            ->with('flash_message',
             'El usuario se elimino correctamente.');
    }

    public function validateUser($request, $id) {
        $this->validate($request, [
            'roles_id'=>'required|int',
            'restaurants_id'=>'required|int',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id
        ]);
    }
}
