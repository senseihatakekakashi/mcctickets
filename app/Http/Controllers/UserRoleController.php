<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRoleValidationRequest;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class UserRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_roles = UserRole::all();        
        return view('system.user-role.index', ['user_roles' => $user_roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('system.user-role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRoleValidationRequest $request)
    {
        $request->validated();
         
        $user_role = new UserRole();                
        $user_role->user_role = $request->input('user_role');         
        $user_role->save();
        return redirect('/user-role')->with('message', 'User Role is Successfully Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function show(UserRole $userRole)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {                    
            $user_role = UserRole::find(Crypt::decryptString($id)); 
            return view('system.user-role.edit', ['user_role' => $user_role]);
        } catch (DecryptException $e) {
            abort(403);
        } 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function update(UserRoleValidationRequest $request, $id)
    {
        $request->validated();
           
        $user_role = UserRole::find(Crypt::decryptString($id));            
        $user_role->user_role = $request->input('user_role');             
        $user_role->save();
        return redirect('/user-role')->with('message', 'User Role is Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try  {
            UserRole::find(Crypt::decryptString($id))->delete();                       
            return redirect('/user-role')->with('message', 'User Role is Successfully Deleted!');
        } catch (DecryptException $e) {
            abort(403);
        } 
    }
}
