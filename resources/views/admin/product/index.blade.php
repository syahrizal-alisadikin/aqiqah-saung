@extends('layouts.admin')
@section('title', 'Dashboard ADMIN')

@section('content')
<div class="row py-3">
  <div class="container">
    <h3>Dashboard Produk</h3>
  </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-2 text-center">
      <h5>Sehat {{ $products }} Ekor</h5>
    </div>
    <div class="col-md-2 text-center">
  
      <h5>Sakit {{ $productSakit }} Ekor</h5>
    </div>
    <div class="col-md-2 text-center">
  
      <h5>Mati {{ $productMati }} Ekor</h5>
    </div>
</div>
<div class="row">

 @foreach ($productType as $item)
 @php
     $products = \App\Models\Product::whereNotNull('stock')
                    ->where('jenis',$item->jenis)
                    ->groupBy('jenis')
                    ->groupBy('type')
                    ->selectRaw('sum(stock) as sum, type ,jenis')
                    ->get();
 @endphp  
  <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-12">
            <div class="numbers">
              <p class="text-sm mb-0 text-capitalize text-center font-weight-bold">{{ $item->jenis }}</p>
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0"   style="width:100%; !important">
                  <thead>
                    <tr>
                     @foreach ($products as $product)
                    <th class=" text-uppercase text-secondary text-center opacity-7">{{ $product->type }}</th>
                 
                    @endforeach
                  </tr> 
                  </thead>
                  <tbody>
                    <tr>
                      @foreach ($products as $pro)
                      <td class="text-center">{{ $pro->sum }}</td>
                          
                      @endforeach
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        
        </div>
      </div>
    </div>
  </div>
 @endforeach
  
 
</div>
<div class="row">
  <div class="card">
    <div class="card-body">
      <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Produk</a>
      <div class="table-responsive p-0">
        <table class="table align-items-center mb-0" id="products"  style="width:100%; !important">
          <thead>
            <tr>
              <th class=" text-uppercase text-secondary opacity-7">No</th>
              <th class="text-center text-uppercase text-secondary  opacity-7">Name</th>
              <th class="text-center text-uppercase text-secondary  opacity-7">Type</th>
              <th class="text-center text-uppercase text-secondary  opacity-7">Jenis</th>
              <th class="text-center text-uppercase text-secondary opacity-7">Harga Beli</th>
              <th class="text-center text-uppercase text-secondary opacity-7">Harga Jual</th>
              <th class="text-center text-uppercase text-secondary opacity-7">Stok Sakit</th>
              <th class="text-center text-uppercase text-secondary opacity-7">Stok </th>
              <th class="text-center text-uppercase text-secondary opacity-7">Aksi </th>
            </tr>
          </thead>
          
        </table>
      </div>
    </div>
  </div>
</div>


   <!-- Modal -->
   <div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> </h5>
          <button type="button" class="close" onclick="exitModal()" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('stock.store') }}" method="post">
        <div class="modal-body">
              @csrf
              <div class="form-group">
                <label for="name">Pilih Status</label>
                <select name="status" class="form-control" required id="">
                    <option value="">Pilih</option>
                    <option value="Masuk">Masuk</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Mati">Mati</option>
                </select>
            </div>
              <div class="form-group">
                  <label for="name">Quantity</label>
                  <input  type="number" required name="quantity" placeholder="Masukan Quantity" id="name" class="form-control">
                  <input  type="hidden"  name="product_id" id="product_id">
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
@endsection
@push('addon-script')
<script>
    var orders = $('#products').DataTable({
       processing: true,
  
        serverSide:true,
        ordering:true,
        ajax:{
          url: '{!! url()->current() !!}',
        },
        columns:[
          { data: 'DT_RowIndex', name:'DT_RowIndex'},
          
          { data: 'name', name:'name'},
          { data: 'type', name:'type'},
          { data: 'jenis', name:'jenis'},
          { data: 'buy_price', name:'buy_price'},
          { data: 'sell_price', name:'sell_price'},
          { data: 'stock_sakit', name:'stock_sakit'},
          { data: 'stock', name:'stock'},
          { data: 'aksi', name:'aksi'},
          
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
              {
                  "targets": 5, // your case first column
                  "className": "text-center",
              },  
              {
                  "targets": 6, // your case first column
                  "className": "text-center",
              },  
              {
                  "targets": 7, // your case first column
                  "className": "text-center",
              },  
              {
                  "targets": 8, // your case first column
                  "className": "text-center",
              },  
          ]
    })
   
</script>
 <script>
   function ShowPlush(id)
   {
     if (id) {
       jQuery.ajax({
         url: '/api/productStock/'+id,
         type: "GET", 
         dataType: "json",
         success: function (response) {
                      $("#showModal").modal('show');
                      $("#exampleModalLabel").text(`${response.data.name} ${response.data.type} ${response.data.jenis}`);
                      $("#product_id").val(response.data.id)
                  
                        },

                    });
                }
   }
   function exitModal(){
  $("#showModal").modal('hide');
}
 </script>
@endpush