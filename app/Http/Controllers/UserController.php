<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //Show register/Create form
    public function create(){

        return view('users.register');
    }


    //Create User
    public function store(Request $request){

        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', 'min:6']
        ]);
        //Hash Password
        $formFields['password'] = bcrypt($formFields['password']);

        //Create User
        $user = User::create($formFields);

        //Login
        auth()->login($user);

        return redirect('/')->with('message', 'User created and logged in successfully!');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('users.login');
      }
    public function login(){

        return view('users.login');
    }
    public function authenticate(Request $request){

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect('/')
                        ->with('message', 'You have Successfully logged in');
        }

        return redirect("login")->with('message', 'Oppes! You have entered invalid credentials');
    }
}
