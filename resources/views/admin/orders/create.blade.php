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
      <h4>Tambah Orders</h4>
      <form action="" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Name" aria-label="Name" name="name" aria-describedby="email-addon">
          @error('name')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email" aria-label="Email" aria-describedby="email-addon">
          @error('email')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <div class="form-group">
          <label for="phone">Phone</label>
          <input type="number" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Phone" aria-label="Name" aria-describedby="email-addon">
                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
        </div>
        <div class="form-group">
          <label for="alamat">Alamat</label>
          <textarea name="alamat" id="" cols="30" rows="5" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat">{{ old('alamat') }}</textarea>
          @error('alamat')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
          @error('password')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <div class="form-group">
          <label for="password_confirmation">Password Confirmation</label>
          <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
          @error('password_confirmation')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
        
        </div>
        <div class="form-group">
          <label for="image">Image</label>
          <input type="file" class="form-control" id="image" name="image">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
      
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