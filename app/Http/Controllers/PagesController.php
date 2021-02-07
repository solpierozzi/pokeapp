<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function inicio(){
        return view('inicio');
    }
    public function pokemones(){
        return view('pokemones');
    }
    public function nosotros($nombre =null){
        return view('nosotros');
    }
}
