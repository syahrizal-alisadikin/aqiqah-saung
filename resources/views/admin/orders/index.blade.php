@extends('layouts.admin')
@section('title', 'Dashboard ADMIN')

@section('content')
<div class="row py-3">
  <div class="container">
    <h3>Dashboard Orders</h3>
  </div>
</div>


<div class="row">
  <div class="card">
    <div class="card-body">
      <a href="#" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Orders</a>
      <div class="table-responsive p-0">
        <table class="table align-items-center mb-0" id="orders"  style="width:100%; !important">
          <thead>
            <tr>
              <th class=" text-uppercase text-secondary opacity-7">No</th>
              <th class="text-center text-uppercase text-secondary  opacity-7">Name</th>
              <th class="text-center text-uppercase text-secondary  opacity-7">Nominal</th>
              <th class="text-center text-uppercase text-secondary  opacity-7">Tanggal Masuk</th>
              <th class="text-center text-uppercase text-secondary opacity-7">Metode</th>
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
    var orders = $('#orders').DataTable({
       processing: true,
  
        serverSide:true,
        ordering:true,
        ajax:{
          url: '{!! url()->current() !!}',
        },
        columns:[
          { data: 'DT_RowIndex', name:'DT_RowIndex'},
          
          { data: 'name', name:'name'},
          { data: 'nominal', name:'nominal'},
          { data: 'tanggal', name:'tanggal'},
          { data: 'metode', name:'metode'},
          
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