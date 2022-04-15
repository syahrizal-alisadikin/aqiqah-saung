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
      <h4>Tambah Produk</h4>
      <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" required class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Name" aria-label="Name" name="name" aria-describedby="email-addon">
          @error('name')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <div class="form-group">
          <label for="email">Type</label>
          <select name="type" class="form-control" required id="">
            <option value="">Pilih Type</option>
            <option value="A" {{ old('type') == "A" ? "selected" : "" }}>A</option>
            <option value="B" {{ old('type') == "B" ? "selected" : "" }}>B</option>
            <option value="C" {{ old('type') == "C" ? "selected" : "" }}>C</option>
            <option value="D" {{ old('type') == "D" ? "selected" : "" }}>D</option>
            <option value="E" {{ old('type') == "E" ? "selected" : "" }}>E</option>
          </select>
          @error('type')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <div class="form-group">
          <label for="phone">Jenis</label>
          <select name="jenis" required class="form-control" id="">
            <option value="">Pilih Jenis</option>
            <option value="Jantan" {{ old('jenis') == "Jantan" ? "selected" : "" }}>Jantan</option>
            <option value="Betina" {{ old('jenis') == "Betina" ? "selected" : "" }}>Betina</option>
          </select>
                @error('jenis')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
        </div>
        <div class="form-group">
          <label for="alamat">Harga Beli</label>
          <input type="number" name="buy_price" min="0" value="{{ old('buy_price') }}" required class="form-control @error('buy_price') is-invalid @enderror" placeholder="Masukan Harga Beli" id="">
          @error('buy_price')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>
        <div class="form-group">
          <label for="alamat">Harga Jual</label>
          <input type="number" name="sell_price" min="0" value="{{ old('sell_price') }}" required class="form-control @error('sell_price') is-invalid @enderror" placeholder="Masukan Harga Jual" id="">
          @error('sell_price')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>
        
     
        <div class="form-group">
          <label for="image">Stok Sakit (Opsional)</label>
          <input type="number" class="form-control" min="0" name="stock_sakit" value="0" placeholder="Masukan Stok sakit">
        </div>
        <div class="form-group">
          <label for="image">Stok Mati (Opsional)</label>
          <input type="number" class="form-control" min="0" name="stock_mati" value="0" placeholder="Masukan Stok mati">
        </div>
        <div class="form-group">
          <label for="image">Stok</label>
          <input type="number" required min="0" class="form-control @error('stock') is-invalid @enderror" name="stock" value="0" placeholder=" Masukan Stok Total">
          @error('stock')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
        </div>
        <div class="form-group">
          <label for="image">Deskripsi</label>
          <textarea name="description" id="" cols="30" rows="5" class="form-control @error('description') is-invalid @enderror" placeholder="Masukan Deskripsi">{{ old('description') }}</textarea>
          @error('description')
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
