@extends('layouts.admin')
@section('title', 'Dashboard ADMIN')

@section('content')
<div class="row py-3">
  <div class="container">
    <h3>Dashboard Keuangan</h3>
  </div>
</div>
<div class="row mb-2">
  <div class="col-lg-4 col-md-6">
    <div class="nav-wrapper position-relative end-0">
      <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">
        <li class="nav-item">
          <a class="nav-link mb-0 px-0 py-1 active "id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" aria-selected="true"  role="tab" aria-controls="home" >
            <span class="ms-1">Pemasukan</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link mb-0 px-0 py-1  "id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false" >
            
            <span class="ms-1">Pengeluaran</span>
          </a>
        </li>
        
      </ul>
    </div>
  </div>
</div>
<div class="row">
 
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
      <div class="card">
        <div class="card-body">
          <a href="#" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Pemasukan</a>
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0" id="masuk">
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
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
      <div class="card">
        <div class="card-body">
          <a href="#" class="btn btn-danger"><i class="fa fa-plus me-2"></i>Pengeluaran</a>
          
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0" id="keluar" style="width:100%; !important">
              <thead>
                <tr>
                  <th class=" text-uppercase text-secondary opacity-7">No</th>
                  <th class="text-center text-uppercase text-secondary  opacity-7">Name</th>
                  <th class="text-center text-uppercase text-secondary  opacity-7">Nominal</th>
                  <th class="text-center text-uppercase text-secondary  opacity-7">Tanggal keluar</th>
                  <th class="text-center text-uppercase text-secondary opacity-7">Metode</th>
                </tr>
              </thead>
              
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>  
</div>



 
@endsection
@push('addon-script')
<script>
    var masuk = $('#masuk').DataTable({
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
    var keluar = $('#keluar').DataTable({
       processing: true,
  
        serverSide:true,
        ordering:true,
        ajax:{
          url: '{!! route('pengeluaran.index') !!}',
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