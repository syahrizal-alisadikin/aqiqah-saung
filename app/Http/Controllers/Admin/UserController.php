<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = User::where('roles','USER');
             
             return Datatables::of($users->get())
                 ->addIndexColumn()
                
               
                 ->addColumn('aksi', function ($data) {
                     $edit = '<a href="'.route('users.edit',$data->id).'"  class="btn btn-primary btn-sm"> Edit </a>';
 
                     return $edit;
                 
                 })
                 ->rawColumns(['aksi'])
                 ->make(true);
         }
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validas user
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'image' => 'required|mimes:jpeg,jpg,png',
        ]);
            //upload image
        $image = $request->file('image');
        $data['foto'] = $image->hashName();
        $image->storeAs('public/profile', $image->hashName());
         
        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'alamat' => $request->alamat,
            'password' => bcrypt('password'),
            'roles' => 'USER',
            'foto' => $data['foto'],

        ]);
        activity(auth()->user()->name)->log('Menambah rekanan  ' . $user->name);

        return redirect()->route('users.index')->with('success', 'Data berhasil disimpan!!');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //update user
        $data = $request->all();
        $this->validate($request, [
            'name'      => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'alamat' => 'required',

        ]);  
        $user = User::find($id);
        
        
           
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

            return redirect()->route('users.index')->with('success', 'Data berhasil disimpan!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
