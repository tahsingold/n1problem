<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\County;
class HomeController extends Controller
{
    public function index(){
        if (true){
            $counties = County::with('city')->get();
        }
        else{
            $counties = County::all();
        }
        
        return view('home',compact('counties'));
    }
}
