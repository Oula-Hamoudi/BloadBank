<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Request $request)
    {
        $user = Auth::id();
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'confirm_password' => ['same:new_password'],
        ]);
        if($request['new_password'] == $request['confirm_password']){
            User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
            return redirect()->back()->withMessage('Password successfully changed!');
        }
        else{
            return redirect()
                    ->back()->withInput()
                    ->withErrors('New password and Confirm password does not match! Please try again.');
        }
        
    }
}
