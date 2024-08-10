<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(){
        $user=auth()->user();
        return view('profile.edit',['user' => $user]);
    }


        /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate(
            [
                'name'=>'required',
                'email'=>'required|email'
            ]
        );

        $user = auth()->user();
        $user->name = $request['name'];
        $user->email = $request['email'];


        // store profile photo
        $staffPhotoPath = 'images/users/photos';
        if (!file_exists($staffPhotoPath)) {
            mkdir($staffPhotoPath, 0777, true);
        }

        if ($request->hasFile('profile')) {
            $photo = $request->file('profile');
            $photo_image_name = time() . mt_rand(1, 2000) . '.' . $photo->extension();
            $Folder = public_path($staffPhotoPath);
            $photo->move($Folder, $photo_image_name);
            $user->profile = $photo_image_name;
        }

        if($user->save())
        {
            return redirect()->route('profile')->with('success','User Profile has been updated');
        }

        return redirect()->route('profile')->with('error','something went wrong!!!');

    }



}
