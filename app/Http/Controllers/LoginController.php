<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
class LoginController extends Controller
{
    public function home(){
    	return view('/login/login');
    }

    public function validateUsers(Request $request){
    	$this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/login/postlogin');
        } 
        else 
        {
            return redirect()->back()->with('message','email and password did not exist');
        }
    }

    public function postLogin()
    {
        if(Auth::user()->position_id == 1){
            return redirect('/admin');
        }
        if(Auth::user()->position_id == 2){
            return redirect('/receptionist');
        }
        if(Auth::user()->position_id == 3){
            return redirect('/cashier');
        }
        if(Auth::user()->position_id == 4){
            return redirect('/tofficer');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }

    public function thome(){
        return view('/login/login2');
    }

    public function tvalidateUsers(Request $request){
        $user = User::all(); 
        foreach($user as $users){
            if(($users->email == $request->email) && ($users->password == $request->password))
            {
                if($users->tofficer->active == 1)
                {
                    $officer = $users->tofficer;
                    //return view('/training_officer/schedule',compact('officer'));
                    return redirect('/tofficer/'.$officer->id.'');
                }
            }
        }
    }
}
