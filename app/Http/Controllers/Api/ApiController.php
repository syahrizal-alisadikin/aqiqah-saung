<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function rekanan($id)
    {
        $user = User::find($id);
        if ($user->roles == 'ADMIN') {
            $product = Product::with('rekanan')->get();
            return response()->json([
                'status' => 'success',
                'message' => 'admin',
                'data' => $product,
                'user' => $user

            ]);
        } else {
            $product = Product::whereHas('rekanan', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->with('rekanan')->get();
            return response()->json([
                'status' => 'success',
                'message' => 'rekanan',
                'data' => $product,
                'user' => $user


            ]);
        }
    }
    public function product($id)
    {
        $user = User::find(request()->user_id);
        $product = Product::with('rekanan')->find($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Product berhasil diambil',
            'data' => $product,
            'user' => $user

        ]);
    }

    public function order($id)
    {
        $product = Order::find($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Order berhasil diambil',
            'data' => $product,

        ]);
    }
}
