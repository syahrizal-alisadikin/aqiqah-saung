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
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="card-body">
      <h4>Edit Orders</h4>
      <form action="{{ route('orders.update',$order->id) }}" method="POST" enctype="multipart/form-data">
      @method("PUT")
        @csrf
       @if (Auth::user()->roles == "ADMIN")
       <div class="form-group">
        <label for="name">Rekanan</label>
        <select name="user_id" class="form-control" id="rekanan">
          <option value="">Pilih Rekanan</option>
          <option value="{{ auth()->user()->id }}">{{ auth()->user()->name }}</option>
        @forelse ($users as $item)
            <option value="{{ $item->id }}" {{ $item->id == $order->user_id ? "selected" : ""}}>{{ $item->name }}</option>
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
          <option value="{{ $order->product_id }}">{{ $order->product->name }} {{ $order->product->type }}  {{ $order->product->jenis }}</option>
          {{-- @forelse ($products as $item)
              <option value="{{ $item->id }}">{{ $item->name }}</option>
          @empty
              <option value="">Belum ada data</option>
          @endforelse --}}
          
        </select>
        @error('product_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" name="name" required class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$order->name) }}" placeholder="Name" aria-label="Name"  aria-describedby="email-addon">
          @error('name')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <div class="form-group">
          <label for="name">Nama Ayah (Binti)</label>
          <input type="text" required class="form-control @error('nama_ayah') is-invalid @enderror" value="{{ old('nama_ayah',$order->nama_ayah) }}" placeholder="Nama Ayah" aria-label="Name" name="nama_ayah">
          @error('nama_ayah')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <div class="form-group">
          <label for="name">Nama Ibu (optional)</label>
          <input type="text"  class="form-control @error('nama_ibu') is-invalid @enderror" value="{{ old('nama_ibu',$order->nama_ibu) }}" placeholder="Nama Ibu" aria-label="Name" name="nama_ibu" aria-describedby="email-addon">
          @error('nama_ayah')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
       
        <div class="form-group">
          <label for="phone">Phone</label>
          <input type="number" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone',$order->phone) }}" placeholder="Phone" aria-label="Name" aria-describedby="email-addon">
                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
        </div>
        <div class="form-group">
          <label for="jk">Jenis Kelamin</label>
          <select name="jk" required class="form-select" id="">
            <option value="">Pilih Jenis Kelamin</option>
            <option value="0" {{ $order->jk == 0 ? "selected" : ""}}>Perempuan</option>
            <option value="1" {{ $order->jk == 1 ? "selected" : ""}}>Laki-Laki</option>
          </select>
                @error('jk')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
        </div>
        <div class="form-group">
          <label for="email">Harga</label>
          <input type="text" name="harga" readonly id="hargaView" value="{{ moneyFormat($order->harga) }}" class="form-control ">
          <input type="hidden" name="harga" readonly id="hargaInput" value="{{ $order->harga  }}" class="form-control ">
          @error('harga')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <div class="form-group">
          <label for="email">Quantity</label>
          <input type="number" name="quantity" required min="0" id="quantity"   class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity',$order->quantity) }}" placeholder="Quantity" >
          @error('quantity')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <div class="form-group">
          <label for="email">Total Harga</label>
          <input type="text" readonly name="total_harga"  class="form-control" id="totalHargaView" value="{{ old('total_harga',moneyFormat($order->total_harga)) }}" placeholder="Total Harga" >
          <input type="hidden" name="total_harga"  class="form-control totalHarga" value="{{ old('total_harga',$order->total_harga) }}"  >
          @error('total_harga')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <div class="form-group">
          <label for="name">Tanggal Potong Hewan</label>
          <input type="date" required name="tanggal_potong" value="{{ $order->tanggal_potong }}" class="form-control" id="">
          @error('tanggal_potong')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <div class="form-group">
          <label for="name">Tanggal Acara</label>
          <input type="date"  name="tanggal_acara" value="{{ $order->tanggal_acara }}" class="form-control" id="">
          @error('tanggal_acara')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <div class="form-group">
          <label for="alamat">Alamat</label>
          <textarea name="alamat" id="" cols="30" rows="5" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat">{{ old('alamat',$order->alamat) }}</textarea>
          @error('alamat')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>
        
        <div class="form-group">
          <label for="alamat">Note</label>
          <textarea name="note" id="" cols="30" rows="5" class="form-control @error('note') is-invalid @enderror" placeholder="Masukan Note...">{{ old('note',$order->note) }}</textarea>
          @error('note')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>
        <div class="form-group">
          <label for="status">Status</label>
          <select class="form-control" name="status">
            <option value="PENDING" {{ $order->status == "PENDING" ? "selected" : "" }}>PENDING</option>
            <option value="KIRIM" {{ $order->status == "KIRIM" ? "selected" : "" }}>KIRIM</option>
            <option value="SELESAI" {{ $order->status == "SELESAI" ? "selected" : "" }}>SELESAI</option>
            <option value="LUNAS" {{ $order->status == "LUNAS" ? "selected" : "" }}>LUNAS</option>
            <option value="BATAL" {{ $order->status == "BATAL" ? "selected" : "" }}>BATAL</option>
          </select>
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
                if (id) {
                jQuery.ajax({
                     url: '/api/rekanan/'+id,
                    type: "GET",
                    dataType: "json",
                    success: function (response) {
                      $('#hargaView').val("");
                      $('select[name="product_id"]').empty();
                      $('select[name="product_id"]').append('<option value="">Pilih Produk</option>');
                        $.each(response.data, function (key, value) {
                                $('select[name="product_id"]').append('<option value="' +  value.id + '">' + value.name +' '+value.type+ ' '+ value.jenis+ '</option>');
                        });
                     
                  
                        },

                    });
                }
            })
        $("#product").on("change",function(){
                const id =  $(this).val()
                const rekanan = $('#rekanan').val();
                if (id) {
                jQuery.ajax({
                     url: '/api/product/'+id,
                    type: "GET", 
                    data: {user_id:rekanan},
                    dataType: "json",
                    success: function (response) {
                      if(response.user.roles == "USER"){
                        $('#hargaView').val("Rp "+ new Intl.NumberFormat('id-ID', {
                                  maximumSignificantDigits: 5
                              }).format(response.data.rekanan != null ? response.data.rekanan.harga : 0))
                         
                         $("#hargaInput").val(response.data.rekanan != null ? response.data.rekanan.harga : 0)

                      }else{
                        $('#hargaView').val("Rp "+ new Intl.NumberFormat('id-ID', {
                                  maximumSignificantDigits: 5
                              }).format(response.data.sell_price))
                         
                         $("#hargaInput").val(response.data.sell_price)
                      }
                  
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