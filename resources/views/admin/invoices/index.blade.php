@extends('layouts.admin')
@section('title', 'Dashboard ADMIN')

@section('content')
<div class="row py-3">
  <div class="container">
    <h3>Dashboard Invoices Supplier</h3>
  </div>
</div>

<div class="row">
  
  <div class="card">
    <div class="card-body">
      <a href="javascript:void(0)" onclick="ShowModalInvoice()" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Invoices</a>
      <div class="table-responsive p-0">
        <table class="table align-items-center mb-0" id="orders"  style="width:100%; !important">
          <thead>
            <tr>
              <th class=" text-uppercase text-secondary opacity-7">Po</th>
              <th class="text-center text-uppercase text-secondary  opacity-7">Name Supplier</th>
              <th class="text-center text-uppercase text-secondary  opacity-7">Product</th>
              <th class="text-center text-uppercase text-secondary  opacity-7">Harga</th>
              <th class="text-center text-uppercase text-secondary  opacity-7">Quantity</th>
              <th class="text-center text-uppercase text-secondary opacity-7">Total Pemabayaran</th>
              <th class="text-center text-uppercase text-secondary opacity-7">Tanggal</th>
              
            </tr>
          </thead>

          <tbody>
            @forelse($invoices as $invoice)
            <tr>
              <td class="text-center">{{$loop->iteration}}</td>
              <td class="text-center">{{$invoice->supplier}}</td>
              
              <td class="text-center">
                @forelse ($invoice->products as $item)
                {{$item->product->name}} <br>
                @empty
                Tidak ada data
                @endforelse
              </td>
              <td class="text-center">
                @forelse ($invoice->products as $item)
                {{ moneyFormat($item->harga)}} <br>
                @empty
                Tidak ada data
                @endforelse
              </td>
              <td class="text-center">
                @forelse ($invoice->products as $item)
                {{$item->qty}} <br>
                @empty
                Tidak ada data
                @endforelse
              </td>
              
              <td class="text-center">{{moneyFormat($invoice->total)}}</td>
              <td class="text-center">{{ tanggalID($invoice->created_at)}}</td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
          </tbody>

          
        </table>
        <div style="text-align: center">
          {{ $invoices->links("vendor.pagination.bootstrap-4") }}
      </div>

      </div>
    </div>
  </div>
</div>


   <!-- Modal -->
   <div class="modal fade" id="InvoiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Invoice </h5>
          <button type="button" class="close" onclick="exitModal()" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('invoice.store') }}" method="post">
        <div class="modal-body">
              @csrf
              
              <div class="form-group">
                  <label for="name">NAME SUPPLIER</label>
                  <input  type="text" required name="supplier"required placeholder="Masukan Nama Supplier" class="form-control">
              </div>
             
              <div id="inputFormRow" class="row">

                    <div class="col-md-4 mb-3">
                        <label for="name">Product</label>
                      <select name="product_id[]" class="form-control" required id="">
                          <option value="">Pilih Product</option>
                          @forelse ($products as $item)
                              <option value="{{ $item->id }}">{{ $item->name }}</option>
                          @empty
                          <option value="">Tidak ada data</option>
                              
                          @endforelse
                         
                      </select>
                      
                    </div>
                    <div class="col-md-4">
                      <label for="name">Harga</label>

                      <input type="number" name="harga[]" required class="form-control" placeholder="Harga" id="">
                    </div>
                    <div class="col-md-4">
                      <label for="name">Quantity</label>

                      <input type="number" name="quantity[]" required class="form-control" placeholder="Quantity" id="">
                    </div>
                    <div class="container">
                      <button id="addRow" type="button" class="btn btn-info btn-sm ">Tambah</button>
                    </div>

                  
              </div>

            <div id="newRow"></div>
            <div class="form-group">
                <label for="name">Total Pembayaran</label>
                <input  type="number" required name="total"required placeholder="Masukan Nominal Pemabayaran"  class="form-control">
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
function ShowModalInvoice(){
  $("#InvoiceModal").modal('show');
}  
 
function exitModal(){
  $("#InvoiceModal").modal('hide');
} 

</script>    
<script type="text/javascript">
  // add row
  $("#addRow").click(function () {
      var html = '';
      // html += '<div id="inputFormRow">';
      // html += '<div class="input-group mb-3">';
      // html += `<select name="title[]" class="form-control" id="">
      //                     <option value="">Pilih</option>
      //                     <option value="">1</option>
      //                     <option value="">2</option>
      //                 </select>`;
      // html += '<div class="input-group-append">';
      // html += '';
      // html += '</div>';
      // html += '</div>';
      html += `<div id="inputFormRow" class="row">
                <div class="col mb-3">
                  <label for="name">Product</label>
                      <select name="product_id[]" class="form-control" id="">

                          <option value="">Pilih Product</option>
                          @forelse ($products as $item)
                              <option value="{{ $item->id }}">{{ $item->name }}</option>
                          @empty
                          <option value="">Tidak ada data</option>
                              
                          @endforelse
                      </select>
                      
                    </div>
                    <div class="col">
                      <label for="name">Harga</label>

                      <input type="number" name="harga[]" class="form-control" placeholder="harga" id="">
                    </div>
                    <div class="col">
                      <label for="name">Quantity</label>

                      <input type="number" name="quantity[]" class="form-control" placeholder="quantity" id="">
                    </div>
                    <div class="container">
                        <button id="removeRow" type="button" class="btn btn-danger">Hapus</button>
                    </div>
              </div>`;

      $('#newRow').append(html);
  });

  // remove row
  $(document).on('click', '#removeRow', function () {
      $(this).closest('#inputFormRow').remove();
  });
</script>
@endpush
