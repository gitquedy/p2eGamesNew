<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
// use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function settings(Request $request){
        $user = $request->user();
        // print json_encode($user);die();
        return view('content.user.settings', compact('user'));
    }

    public function profile(Request $request, User $user){
        $breadcrumbs = [
            ['link'=>"/",'name'=>"Home"], ['name'=> "User Profile"]
        ];
        return view('content.user.profile', compact('user', 'breadcrumbs'));
    }

    public function update(Request $request, $type)
    {   
        $user = Auth::user();
        if ($type == "account") {
            request()->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.Auth::user()->id.',id'],
                'phone_number' => ['required','unique:users,phone_number,'.Auth::user()->id.',id'],
            ]);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            if ($request->hasFile('picture')) {
                $image = $request->file('picture');

                $uploadedAvatar = $this->saveImage($image);
                $user->profile_photo_path = $uploadedAvatar;
            }
            $user->update();
        }
        else if($type == "password") {
            if (Auth::user()->hasPassword) {
                request()->validate([
                    'old_password' => ['required', new MatchOldPassword],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ]);
            }
            else {
                request()->validate([
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ]);   
            }

            $user->password = Hash::make($request->password);
            $user->update();

        }
        return back()->with('toast_success','You have successfully updated your info.');
    }




}
