<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class CostumerController extends Controller
{
    public function index(){
        return view('costumer.index', [
            'title' => 'Profile',
            'active' => 'profile',
        ]);
    }
}
