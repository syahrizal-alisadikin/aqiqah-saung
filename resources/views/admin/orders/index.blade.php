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
      <a href="{{ route('orders.create') }}" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Orders</a>
      <div class="table-responsive p-0">
        <table class="table align-items-center mb-0" id="orders"  style="width:100%; !important">
          <thead>
            <tr>
              <th class=" text-uppercase text-secondary opacity-7">Po</th>
              <th class="text-center text-uppercase text-secondary  opacity-7">Name Rekanan</th>
              <th class="text-center text-uppercase text-secondary  opacity-7">Nama Anak</th>
              <th class="text-center text-uppercase text-secondary  opacity-7">Nama Ayah</th>
              <th class="text-center text-uppercase text-secondary  opacity-7">Produk</th>
              <th class="text-center text-uppercase text-secondary opacity-7">Harga</th>
              <th class="text-center text-uppercase text-secondary opacity-7">Quantity</th>
              <th class="text-center text-uppercase text-secondary opacity-7">Total Harga</th>
              <th class="text-center text-uppercase text-secondary opacity-7">Status</th>
              <th class="text-center text-uppercase text-secondary opacity-7">Aksi</th>
            </tr>
          </thead>
          
        </table>
      </div>
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
          { data: 'ref', name:'ref'},
          
          { data: 'user.name', name:'user.name'},
          { data: 'name', name:'name'},
          { data: 'nama_ayah', name:'nama_ayah'},
          { data: 'product.name', name:'product.name'},
          { data: 'harga', name:'harga'},
          { data: 'quantity', name:'quantity'},
          { data: 'total_harga', name:'total_harga'},
          { data: 'status', name:'status'},
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
              {
                  "targets": 9, // your case first column
                  "className": "text-center",
              },  
          ]
    })
   
  </script>

  <script>
    function ChangeStatus(id)
    {
      var token = $("meta[name='csrf-token']").attr("content");
      if (id) 
      {
        jQuery.ajax({
              url: '/api/order/'+id,
            type: "GET",
            dataType: "json",
            success: function (response) {
               swal({
                title: "APAKAH KAMU YAKIN ?",
                text: `INGIN ${response.data.status == "PENDING" ? "POTONG" : ""} ${response.data.status == "POTONG" ? "KIRIM" : ""} ${response.data.status == "KIRIM" ? "SELESAI" : ""} DATA INI`,
                icon: "warning",
                buttons: [
                    'TIDAK',
                    'YA'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    //ajax delete
                    jQuery.ajax({
                        url: "{{ route("orders.index") }}/"+id,
                        data:   {
                            "id": id,
                            "_token": token,
                            "status": response.data.status == "PENDING" ? "POTONG" : (response.data.status == "POTONG" ? "KIRIM" : (response.data.status == "KIRIM" ? "SELESAI" : ""))
                        },
                        type: 'DELETE',
                        success: function (response) {
                            if (response.status == "success") {
                                swal({
                                    title: 'BERHASIL!',
                                    text: 'DATA BERHASIL DISIMPAN!',
                                    icon: 'success',
                                    timer: 5000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    orders.ajax.reload();
                                });
                            }else{
                                swal({
                                    title: 'GAGAL!',
                                    text: 'DATA GAGAL DISIMPAN!',
                                    icon: 'error',
                                    timer: 5000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    orders.ajax.reload();
                                });
                            }
                        }
                    });
                } else {
                    return true;
                }
            })
          
            },

          });
        }
    }
  </script>
    
@endpush