@extends('layouts.admin')
@section('title', 'Dashboard ADMIN')

@section('content')
<div class="row py-3">
  <div class="container">
    <h3>Dashboard Profile</h3>
  </div>
</div>
<div class="row mb-2">
  <div class="col-lg-4 col-md-6">
    <div class="nav-wrapper position-relative end-0">
      <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">
        <li class="nav-item">
          <a class="nav-link mb-0 px-0 py-1 active "id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" aria-selected="true"  role="tab" aria-controls="home" >
            <span class="ms-1">Profile</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link mb-0 px-0 py-1  "id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false" >
            
            <span class="ms-1"> <i class="fas fa-user-edit text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Profile"></i>Edit</span>
          </a>
        </li>
        
      </ul>
    </div>
  </div>
</div>
<div class="row">
 
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
      <div class="card h-100">
        
        <div class="card-body">
          <div class="col-md-8 d-flex align-items-center">
            <h6 class="mb-0">Profile Information</h6>
          </div>
          <hr class="horizontal gray-light">
          <table class="table align-items-center mb-0"  style="width:100%; !important">
           
            <tbody>
             @if ($user->foto)
             <tr>
              <th class=" text-uppercase  opacity-7" style="width: 10%">Foto</th>
              <th class=" text-uppercase text-secondary opacity-7" style="width: 5%">:</th>
              <th class=" text-uppercase   opacity-7"><img src="{{ Storage::url('profile/'.$user->foto) }}" style="height: 100px;width:100px" alt=""></th>
              
            </tr>
             @endif
              <tr>
                <th class=" text-uppercase  opacity-7" style="width: 10%">Name</th>
                <th class=" text-uppercase text-secondary opacity-7" style="width: 5%">:</th>
                <th class=" text-uppercase   opacity-7">{{ $user->name }}</th>
                
              </tr>
              <tr>
                <th class=" text-uppercase  opacity-7" style="width: 10%">Email</th>
                <th class=" text-uppercase text-secondary opacity-7" style="width: 5%">:</th>
                <th class=" text-uppercase   opacity-7">{{ $user->email }}</th>
                
              </tr>
              <tr>
                <th class=" text-uppercase  opacity-7" style="width: 10%">Phone</th>
                <th class=" text-uppercase text-secondary opacity-7" style="width: 5%">:</th>
                <th class=" text-uppercase   opacity-7">{{ $user->phone }}</th>
                
              </tr>
              <tr>
                <th class=" text-uppercase  opacity-7" style="width: 10%">Alamat</th>
                <th class=" text-uppercase text-secondary opacity-7" style="width: 5%">:</th>
                <th class=" text-uppercase   opacity-7">{{ $user->alamat }}</th>
                
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
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
  </div>  
</div>



 
@endsection
