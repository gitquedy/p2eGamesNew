<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaterkitController extends Controller
{
    // home
    public function home()
    {
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"], ['name' => "Index"]
        ];
        return view('/content/home', ['breadcrumbs' => $breadcrumbs]);
    }
}
