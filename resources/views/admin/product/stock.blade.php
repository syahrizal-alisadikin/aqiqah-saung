@extends('layouts.admin')
@section('title', 'Dashboard ADMIN')

@section('content')
<div class="row py-3">
  <div class="container">
    <h3>Stock  {{ $product->name }} {{ $product->type }} {{ $product->jenis }}</h3>
  </div>
</div>


<div class="row">
  <div class="card">
    <div class="card-body">
      <a href="{{ route('products.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left me-2"></i>kembali</a>

      <div class="table-responsive p-0">
        <table class="table align-items-center mb-0" id="products"  style="width:100%; !important">
          <thead>
            <tr>
              <th class=" text-uppercase text-secondary opacity-7">No</th>
              <th class="text-center text-uppercase text-secondary  opacity-7">Name Produck</th>
              <th class="text-center text-uppercase text-secondary  opacity-7">Status</th>
              <th class="text-center text-uppercase text-secondary  opacity-7">Quantity</th>
              <th class="text-center text-uppercase text-secondary opacity-7">Tanggal</th>
          
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
        responsive: true,
        serverSide:true,
        ordering:true,
        ajax:{
          url: '{!! url()->current() !!}',
        },
        columns:[
          { data: 'DT_RowIndex', name:'DT_RowIndex'},
          
          { data: 'product.name', name:'product.name'},
          { data: 'status', name:'status'},
          { data: 'quantity', name:'quantity'},
          { data: 'tanggal', name:'buy_price'},
          
          
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
              
          ]
    })
   
</script>

@endpush