<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ApiController extends Controller
{
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
