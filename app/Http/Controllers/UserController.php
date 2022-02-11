<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function settings(Request $request){
        $user = $request->user();
        return view('content.user.settings', compact('user'));
    }

    public function profile(Request $request, User $user){
        $breadcrumbs = [
            ['link'=>"/",'name'=>"Home"], ['name'=> "User Profile"]
        ];
        return view('content.user.profile', compact('user', 'breadcrumbs'));
    }
}
