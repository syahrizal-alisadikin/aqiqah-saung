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
    <div class="tab-pane fade  @if (!session()->has('pengeluaran')) show active @endif " id="home" role="tabpanel" aria-labelledby="home-tab">
      <div class="card">
        <div class="card-body">
          <a href="javascript:void(0)" class="btn btn-primary" onclick="ShowModalPemasukan()"><i class="fa fa-plus me-2"></i>Pemasukan</a>
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0" id="masuk"  style="width:100%; !important">
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
    <div class="tab-pane fade @if (session()->has('pengeluaran')) show active @endif" id="profile" role="tabpanel" aria-labelledby="profile-tab">
      <div class="card">
        <div class="card-body">
          <a href="javascript:void(0)" class="btn btn-danger" onclick="ShowModalPengeluaran()"><i class="fa fa-plus me-2"></i>Pengeluaran</a>
          
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



   <!-- Modal -->
   <div class="modal fade" id="pemasukanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah PENDAPATAN {{ auth()->user()->name }} </h5>
          <button type="button" class="close" onclick="exitModal()" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('keuangan.store') }}" method="post">
        <div class="modal-body">
              @csrf
              
              <div class="form-group">
                  <label for="name">NAME</label>
                  <input  type="text" required name="name"required placeholder="Masukan Nama Pendapatan" id="name" class="form-control">
              </div>
              <div class="form-group">
                <label for="name">Nominal</label>
                <input  type="text" required name="nominal"required placeholder="Masukan Nominal Pendapatan" id="nominalView" class="form-control">
            </div>
            <div class="form-group">
                <label for="name">Metode</label>
                <select name="metode" class="form-control" required id="">
                    <option value="">Pilih</option>
                    <option value="CASH">CASH</option>
                    <option value="TRANSFER">TRANSFER</option>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Tanggal</label>
                <input  type="date" required name="tanggal"required placeholder="Masukan Nominal Pendapatan" id="name" class="form-control">
            </div>
              <div class="form-group">
                  <button type="submit" class="btn btn-primary">Save</button>
                  <button type="button" class="btn btn-secondary"onclick="exitModal()">Close</button>
              </div>
        </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="pengeluaranModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah PENGELUARAN {{ auth()->user()->name }} </h5>
          <button type="button" class="close" onclick="exitModalp()" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('keuangan.pengeluaran') }}" method="post">
        <div class="modal-body">
              @csrf
              
              <div class="form-group">
                  <label for="name">NAME</label>
                  <input  type="text" required name="name"required placeholder="Masukan Nama Pengeluaran" id="name" class="form-control">
              </div>
              <div class="form-group">
                <label for="name">Nominal</label>
                <input  type="text" required name="nominal"required placeholder="Masukan Nominal Pengeluaran" id="nominalView" class="form-control">
            </div>
            <div class="form-group">
                <label for="name">Metode</label>
                <select name="metode" class="form-control" required id="">
                    <option value="">Pilih</option>
                    <option value="CASH">CASH</option>
                    <option value="TRANSFER">TRANSFER</option>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Tanggal</label>
                <input  type="date" required name="tanggal"required  class="form-control">
            </div>
              <div class="form-group">
                  <button type="submit" class="btn btn-primary">Save</button>
                  <button type="button" class="btn btn-secondary"onclick="exitModalp()">Close</button>
              </div>
        </div>
        </form>
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
<script>
function ShowModalPemasukan(){
  $("#pemasukanModal").modal('show');
}  
function ShowModalPengeluaran(){
  $("#pengeluaranModal").modal('show');
}  
function exitModalp(){
  $("#pengeluaranModal").modal('hide');
} 
function exitModal(){
  $("#pemasukanModal").modal('hide');
}  
</script>    
@endpush
