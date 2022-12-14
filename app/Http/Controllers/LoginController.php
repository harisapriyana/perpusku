<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index(){
        return view('login.index',[
            'title' => 'Login',
            'active' => 'login'
        ]);
    }

    public function register(){
        return view('login.register', [
            'title' => 'Register',
            'active' => 'login'
        ]);
    }

    public function store(Request $request){
        // return request()->all();
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|min:5|max:255|unique:users',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255',
            'phone' => 'required|unique:users'
        ]);

        // $validateData['password'] = bcrypt($validateData['password']);
        $validateData['password'] = Hash::make($validateData['password']);

        User::create($validateData);

        // $request->session()->flash('success', 'Registration was successful! Please Login');

        return redirect('/login')->with('success', 'Registration was successful! Please Login');
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);
        
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            $user = Auth::user();

            if($user->isadmin == 1){
                Session::put('login',TRUE);
                Cart::CardTotal();
                return redirect()->intended('/dashboard');
            } elseif($user->isadmin == 0){
                Cart::CardTotal();
                return redirect()->intended('/cart');
            }
            return redirect()->intended('/login')->with('errorLogin', 'Access denied!');
        }
        return redirect('/login')->with('errorLogin', 'Login failed!');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->flush();
 
        $request->session()->invalidate();
 
        $request->session()->regenerateToken();
 
        return redirect('/');
    }
}
