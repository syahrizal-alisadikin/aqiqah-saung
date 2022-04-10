<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function rekanan($id)
    {
        $user = User::find($id);
        if($user->roles == 'ADMIN'){
            $product = Product::with('rekanan')->get();
            return response()->json([
                'status' => 'success',
                'message' => 'admin',
                'data' => $product,
                'user' => $user
                                                                                   
            ]);
        }else{
            $product = Product::whereHas('rekanan',function($q) use ($id){
                $q->where('user_id',$id);
            })->with('rekanan')->get();
            return response()->json([
                'status' => 'success',
                'message' => 'rekanan',
                'data' => $product,
    
            ]);
        }
    }
    public function product($id)
    {
        $product = Product::with('rekanan')->find($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Product berhasil diambil',
            'data' => $product,

        ]);
    }
}
