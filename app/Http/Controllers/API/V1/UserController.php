<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Users\UserRequest;


class UserController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*if (!Gate::allows('isAdmin')) {
            return $this->unauthorizedResponse();
        }*/
        // $this->authorize('isAdmin');
        $user = Auth::user();
        if($user->role_id == 3){
            $users = User::with('roles')->where('role_id', 2)->orderBy('id', 'asc')->paginate(10);
        }else{
            $users = User::with('roles')->orderBy('id', 'asc')->paginate(10);
        }
        

        return $this->sendResponse($users, 'Users list');
    }
    
    public function show()
    {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Users\UserRequest  $request
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserRequest $request)
    {
        //dd($request['role_id']);
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role_id' => $request['role_id'],
        ]);

        return $this->sendResponse($user, 'Creado');
    }

    /**
     * Update the resource in storage
     *
     * @param  \App\Http\Requests\Users\UserRequest  $request
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        if (!empty($request->password)) {
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        $user->update($request->all());

        return $this->sendResponse($user, 'User Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->authorize('isAdmin');

        $user = User::findOrFail($id);
        // delete the user

        $user->delete();

        return $this->sendResponse([$user], 'User has been Deleted');
    }

    public function getByRole($role_id){
        $users = User::where('role_id', $role_id)->with('roles')->latest()->paginate(10);
        return $this->sendResponse($users, 'Users list');

    }

    public function filter($search){
        $users = User::join('roles', 'users.role_id', 'roles.id')
            ->Where('users.name','LIKE',"%$search%")
            ->orWhere('users.email','LIKE',"%$search%")
            ->orWhere('roles.name','LIKE',"%$search%")
            ->with('roles')
            ->select('users.*')
            ->paginate(5);
            info($users);
        return $this->sendResponse($users, 'Users list');
    }

    public function getSeller(){
        $role_id = Role::SELLER;
        $users = User::where('role_id','=', $role_id)->get();
        return $this->sendResponse($users, 'Users list');

    }

    public function getInstalator(){
        $role_id = Role::INSTALATOR;
        $users = User::where('role_id','=', $role_id)->get();
        return $this->sendResponse($users, 'Users list');

    }
}
