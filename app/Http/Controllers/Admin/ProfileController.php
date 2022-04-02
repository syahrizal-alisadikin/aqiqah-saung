<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user= Auth::user();
        return view('admin.profile.index',compact('user'));
    }

    public function update(Request $request)
    {
        $data = $request->all();
        
        $user = Auth::user();
        if($request->hasFile('image')){
              //upload image
        $image = $request->file('image');
        $data['foto'] = $image->hashName();
        $image->storeAs('public/profile', $image->hashName());
        }

        if($request->input('password')){
            // password conifrmation validation
            $this->validate($request, [
                'password'      => 'required|min:8',
                'password_confirmation' => 'required|min:8|same:password',

            ]);            
            $data['password'] = bcrypt($request->input('password'));
        }   
        $user->update($data);
        return redirect()->route('profile.index')->with('success','Profile updated successfully');
    }
}
