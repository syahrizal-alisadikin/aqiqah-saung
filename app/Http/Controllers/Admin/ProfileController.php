<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $this->validate($request, [
            'name'      => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'alamat' => 'required',

        ]);  
        $user = Auth::user();
        
        if ($request->input('password') == "") {
            if($request->hasFile('image')){
                  //upload image
            $image = $request->file('image');
            $data['foto'] = $image->hashName();
            $image->storeAs('public/profile', $image->hashName());
                if(Storage::exists('public/profile')){
                    $image = Storage::disk('local')->delete('public/profile/'.$user->foto);
                }
            }
            $user->update([
                'name'      => $request->input('name'),
                // 'last_name' => $request->input('last_name'),
                'email'     => $request->input('email'),
                'phone'     => $request->input('phone'),
                'alamat'    => $request->input('alamat'),
                'foto'      => $data['foto'] ?? $user->foto,
            ]);
        } else {
            $this->validate($request, [
                'password'      => 'required|min:8',
                'password_confirmation' => 'required|min:8|same:password',

            ]);
            if($request->hasFile('image')){
                //upload image
          $image = $request->file('image');
          $data['foto'] = $image->hashName();
          $image->storeAs('public/profile', $image->hashName());
              if(Storage::exists('public/profile')){
                  $image = Storage::disk('local')->delete('public/profile/'.$user->foto);
              }
          }
            $user->update([
                'name'      => $request->input('name'),
                // 'last_name' => $request->input('last_name'),
                'email'     => $request->input('email'),
                'phone'     => $request->input('phone'),
                'alamat'    => $request->input('alamat'),
                'foto'      => $data['foto'] ?? $user->foto,
                'password'  => bcrypt($request->input('password')),

            ]);
        }
        return redirect()->route('profile.index')->with('success','Profile updated successfully');
    }
}
