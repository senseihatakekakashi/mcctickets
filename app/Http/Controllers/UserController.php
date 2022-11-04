<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserValidationRequest;
use App\Models\User;
use App\Models\UserRole;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;


class UserController extends Controller
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
        $users = User::where('record_status', 1)->get();        
        return view('system.user.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_roles = UserRole::all();            
        return view('system.user.create', ['user_roles' => $user_roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserValidationRequest $request)
    {
        $request->validated();
        $photo_name = '';
        
        if(isset($request->photo)) {
            $photo_name = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('storage/users-photo'), $photo_name);
        }            

        $user = new User;                
        $user->name = $request->input('name');        
        $user->email = $request->input('email');
        $user->user_role = $request->input('user_role');        
        $user->password = 'Pass1234';
        $user->photo = $photo_name;
        $user->record_status = 1;        
        $user->save();
        return redirect('/system-user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {        
        try {                    
            $user = User::find(Crypt::decryptString($id)); 
            $user_roles = UserRole::all();
            return view('system.user.edit', ['user' => $user, 'user_roles' => $user_roles]);
        } catch (DecryptException $e) {
            abort(403);
        }           
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserValidationRequest $request, $id)
    {
        $request->validated();
        $photo_name = '';
        
        if(isset($request->photo)) {
            $photo_name = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('storage/users-photo'), $photo_name);
        }            
                     
        $user = User::find(Crypt::decryptString($id));   
        $user->name = $request->input('name');        
        $user->email = $request->input('email');
        $user->user_role = $request->input('user_role');                
        $user->photo = $photo_name;
        $user->record_status = 1;        
        $user->save();
        return redirect('/system-user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try  {
            User::find(Crypt::decryptString($id))->delete();                       
            return redirect('/system-user')->with('message', 'System User Record is Successfully Deleted!');
        } catch (DecryptException $e) {
            abort(403);
        }              
    }

    public function deactivate($id) {             
        try {            
            $user = User::find(Crypt::decryptString($id));   
            $user->record_status = 0;
            $user->save();
            return redirect('/system-user')->with('message', 'System User is Successfully Deactivated!');                  
        } catch (DecryptException $e) {
            abort(403);
        }  
    }

    public function resetPassword($id) {
        try {            
            $user = User::find(Crypt::decryptString($id));   
            $user->password = 'Pass1234';
            $user->save();
            return redirect('/system-user')->with('message', 'Password Reset is Successful!');
        } catch (DecryptException $e) {
            abort(403);
        }  
    }

    public function changePassword() {
        return view('system.user.change-password');
    }

    public function changePasswordStore(Request $request) {
        $request->validate([
            'current_password'      => ['required', new MatchOldPassword],
            'new_password'          => ['required'],
            'confirm_new_password'  => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password'=> $request->new_password]);
        return redirect('/change-password')->with('message', 'Password is Successfully Changed!');
    }
}
