<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    public function rekanan()
    {
        return $this->belongsTo(HargaRekanan::class, 'id', 'product_id');
    }
}
