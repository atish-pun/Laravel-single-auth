<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class changePasswordController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //
    public function index(){
        return view('auth.passwords.changePass');

    }

    public function changePass(Request $request){ 
        $this->validate($request, [
            'oldPass' => 'required',
            'password' => 'required|confirmed',
        ]);

        $hasedPassword = Auth::user()->password;
        if(Hash::check($request->oldPass,$hasedPassword)){
            $user = User::find(Auth::id());
            $user->password = Hash::make($request->password);
            $user->save();
            Auth::logout();
            return redirect()->route('login')->with('success', "Password is changed successfully");
        }

        else{
            return redirect()->back()->with('error', "Current password is invalid");

        }

    }
}
