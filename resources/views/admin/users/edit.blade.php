@extends('layouts.admin')
@section('title', 'Dashboard ADMIN')

@section('content')
<div class="row py-3">
  <div class="container">
    <h3>Dashboard Rekanan</h3>
  </div>
</div>


<div class="row">
  <div class="card">
    <div class="card-body">
      <h4>Edit Rekanan</h4>
      <form action="{{ route('users.update',$user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$user->name) }}" placeholder="Name" aria-label="Name" name="name" aria-describedby="email-addon">
          @error('name')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email',$user->email) }}" placeholder="Email" aria-label="Email" aria-describedby="email-addon">
          @error('email')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <div class="form-group">
          <label for="phone">Phone</label>
          <input type="number" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone',$user->phone) }}" placeholder="Phone" aria-label="Name" aria-describedby="email-addon">
                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
        </div>
        <div class="form-group">
          <label for="alamat">Alamat</label>
          <textarea name="alamat" id="" cols="30" rows="5" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat">{{ old('alamat',$user->alamat) }}</textarea>
          @error('alamat')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>
        
      
        <div class="form-group">
          <label for="image">Image</label> <br>
          @if ($user->foto)
            <img src="{{ asset('storage/profile/'.$user->foto) }}" alt="" width="100px" height="100px"> <br>
          @endif
          <input type="file"  class="form-control @error('image') is-invalid @enderror" id="image" name="image">
          @error('image')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
      
    </div>
  </div>
</div>


 
@endsection
