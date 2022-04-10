@extends('layouts.admin')
@section('title', 'Dashboard ADMIN')
@push('addon-style')
    <style>
      .select2 {
      width:100%!important;
      
      }
    </style>
@endpush
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
       @if (Auth::user()->roles == "ADMIN")
       <div class="form-group">
        <label for="name">Rekanan</label>
        <select name="user_id" class="form-control" id="rekanan">
          <option value="">Pilih Rekanan</option>
          <option value="{{ auth()->user()->id }}">{{ auth()->user()->name }}</option>
        @forelse ($users as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
        @empty
            <option value="">Belum ada data</option>
        @endforelse
        </select>
        @error('user_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
       @endif
       <div class="form-group">
        <label for="name">Produk</label>
        <select name="product_id" required class="form-control" id="product">
          <option value="">Pilih Produk</option>
          {{-- @forelse ($products as $item)
              <option value="{{ $item->id }}">{{ $item->name }}</option>
          @empty
              <option value="">Belum ada data</option>
          @endforelse --}}
          
        </select>
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
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
          <label for="name">Nama Ayah (Binti)</label>
          <input type="text" required class="form-control @error('nama_ayah') is-invalid @enderror" value="{{ old('nama_ayah') }}" placeholder="Nama Ayah" aria-label="Name" name="nama_ayah" aria-describedby="email-addon">
          @error('nama_ayah')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <div class="form-group">
          <label for="name">Nama Ibu (optional)</label>
          <input type="text"  class="form-control @error('nama_ibu') is-invalid @enderror" value="{{ old('nama_ibu') }}" placeholder="Nama Ibu" aria-label="Name" name="name" aria-describedby="email-addon">
          @error('nama_ayah')
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
          <label for="email">Harga</label>
          <input type="text" name="harga" readonly id="hargaView"  class="form-control ">
          <input type="hidden" name="harga" readonly id="hargaInput"  class="form-control ">
          @error('harga')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <div class="form-group">
          <label for="email">Quantity</label>
          <input type="number" name="quantity" required min="0" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" placeholder="Quantity" >
          @error('quantity')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <div class="form-group">
          <label for="email">Total Harga</label>
          <input type="text" name="total_harga"  class="form-control" id="totalHargaView" value="{{ old('total_harga') }}" placeholder="Total Harga" >
          <input type="hidden" name="total_harga"  class="form-control totalHarga" value="{{ old('total_harga') }}"  >
          @error('quantity')
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
  $(document).ready(function() {
    $('#rekanan ,#product').select2();
});
</script>
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
    <script>
      $(document).ready(function(){
        $("#rekanan").on("change",function(){
                const id =  $(this).val();
                console.log(id)
                if (id) {
                jQuery.ajax({
                     url: '/api/rekanan/'+id,
                    type: "GET",
                    dataType: "json",
                    success: function (response) {
                      $('select[name="product_id"]').empty();
                      $('select[name="product_id"]').append('<option value="">Pilih Produk</option>');
                       if(response.message == "admin" ){
                        $.each(response.data, function (key, value) {
                                $('select[name="product_id"]').append('<option value="' +  value.id + '">' + value.name + '</option>');
                        });
                       }else{
                        $.each(response.data, function (key, value) {
                                $('select[name="product_id"]').append('<option value="' +  value.id + '">' + value.name + '</option>');
                        });
                       }
                      console.log(response)
                  
                        },

                    });
                }
            })
        $("#product").on("change",function(){
                const id =  $(this).val()

                if (id) {
                jQuery.ajax({
                     url: '/api/product/'+id,
                    type: "GET", 
                    dataType: "json",
                    success: function (response) {
                      $('#hargaView').val("Rp "+ new Intl.NumberFormat('id-ID', {
                                maximumSignificantDigits: 5
                            }).format(response.data.rekanan.harga))
                       
                       $("#hargaInput").val(response.data.rekanan.harga)
                  
                        },

                    });
                }
            })
        $("#quantity").on("keyup",function(){
            const quantity =  $(this).val()
            const harga = $("#hargaInput").val()
            const total = quantity * harga;
            $("#totalHargaView").val("Rp "+ new Intl.NumberFormat('id-ID', {
                maximumSignificantDigits: 5
            }).format(total))
            $(".totalHarga").val(total)
        })
      })
    </script>
@endpush