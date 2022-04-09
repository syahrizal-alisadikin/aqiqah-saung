@extends('layouts.admin')
@section('title', 'Dashboard ADMIN')

@section('content')
<div class="row py-3">
  <div class="container">
    <h3>Dashboard Produk</h3>
  </div>
</div>


<div class="row">
  <div class="card">
    <div class="card-body">
      <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Produk</a>
      <div class="table-responsive p-0">
        <table class="table align-items-center mb-0" id="products"  style="width:100%; !important">
          <thead>
            <tr>
              <th class=" text-uppercase text-secondary opacity-7">No</th>
              <th class="text-center text-uppercase text-secondary  opacity-7">Name</th>
              <th class="text-center text-uppercase text-secondary  opacity-7">Type</th>
              <th class="text-center text-uppercase text-secondary  opacity-7">Jenis</th>
              <th class="text-center text-uppercase text-secondary opacity-7">Harga Beli</th>
              <th class="text-center text-uppercase text-secondary opacity-7">Harga Jual</th>
              <th class="text-center text-uppercase text-secondary opacity-7">Stok Sakit</th>
              <th class="text-center text-uppercase text-secondary opacity-7">Stok </th>
              <th class="text-center text-uppercase text-secondary opacity-7">Aksi </th>
            </tr>
          </thead>
          
        </table>
      </div>
    </div>
  </div>
</div>


 
@endsection
@push('addon-script')
<script>
    var orders = $('#products').DataTable({
       processing: true,
  
        serverSide:true,
        ordering:true,
        ajax:{
          url: '{!! url()->current() !!}',
        },
        columns:[
          { data: 'DT_RowIndex', name:'DT_RowIndex'},
          
          { data: 'name', name:'name'},
          { data: 'type', name:'type'},
          { data: 'jenis', name:'jenis'},
          { data: 'buy_price', name:'buy_price'},
          { data: 'sell_price', name:'sell_price'},
          { data: 'stock_sakit', name:'stock_sakit'},
          { data: 'stock', name:'stock'},
          { data: 'aksi', name:'aksi'},
          
        ],
        columnDefs: [
              {
                  "targets": 0, // your case first column
                  "className": "text-center",
              }, 
               {
                  "targets": 1, // your case first column
                  "className": "text-center",
              }, 
              {
                  "targets": 2, // your case first column
                  "className": "text-center",
              }, 
              {
                  "targets": 3, // your case first column
                  "className": "text-center",
              },
              {
                  "targets": 4, // your case first column
                  "className": "text-center",
              },   
              {
                  "targets": 5, // your case first column
                  "className": "text-center",
              },  
              {
                  "targets": 6, // your case first column
                  "className": "text-center",
              },  
              {
                  "targets": 7, // your case first column
                  "className": "text-center",
              },  
              {
                  "targets": 8, // your case first column
                  "className": "text-center",
              },  
          ]
    })
   
  </script>
    
@endpush