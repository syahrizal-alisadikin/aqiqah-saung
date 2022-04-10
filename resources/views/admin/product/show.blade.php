@extends('layouts.admin')
@section('title', 'Dashboard ADMIN')

@section('content')
<div class="row py-3">
  <div class="container">
    <h3>Harga  {{ $product->name }} {{ $product->type }} {{ $product->jenis }} Rekanan</h3>
  </div>
</div>


<div class="row">
  <div class="card">
    <div class="card-body">
      <div class="table-responsive p-0">
        <form method="POST" action="{{ route('harga-rekanan',$product->id) }}">
          @csrf
        <table class="table align-items-center mb-0" id="products"  style="width:100%; !important">
          <thead>
            <tr>
              <th class=" text-uppercase text-secondary opacity-7">No</th>
              <th class="text-center text-uppercase text-secondary  opacity-7">Nama Rekanan</th>
              <th class="text-center text-uppercase text-secondary  opacity-7">Harga</th>
            
            </tr>
          </thead>
         
          <tbody>
           
            @forelse ($users as $item)
            @php
                $rekanan = \App\Models\HargaRekanan::where('user_id',$item->id)->where('product_id',$product->id)->first();
            @endphp
            <tr class="text-center">
              <td class="w-5">{{ $loop->iteration }}</td>
              <td>{{ $item->name }}</td>
  
              <td>
                <input type="hidden" name="user_id[]" value="{{ $item->id }}" class="form-control" >
                <input type="text" name="harga[]" class="form-control" value="{{ $rekanan->harga ?? null }}" id="" placeholder="Masukan Harga rekanan"></td>
            
            </tr>
            @empty
                <tr>
                  <td >Tidak ada data</td>
                </tr>
            @endforelse
            <tr>
              <td></td>
              <td></td>
              <td><button class="btn btn-primary" type="submit">Submit</button></td>
            </tr>
          </tbody>
        </table>
      </form>
      </div>
    </div>
  </div>
</div>


 
@endsection
