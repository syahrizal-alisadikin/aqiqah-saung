@extends('layouts.admin')
@section('title', 'Dashboard ADMIN')

@section('content')
<div class="row py-3">
  <div class="container">
    <h3>Dashboard Orders</h3>
  </div>
</div>


<div class="row">
  <div class="card mb-4">
    <div class="card-body">
      <form action="#">
        <div class="row">
          <div class="col">
            <label for="">Nama</label>
            <input type="text" class="form-control" placeholder="Nama Anak" id="name">
          </div>
          <div class="col">
            <label for="">Nama Ayah</label>
            <input type="text" class="form-control" placeholder="Nama Ayah" id="nama_ayah">
          </div>
          <div class="col">
            <label for="">No PO</label>
            <input type="text" class="form-control" placeholder="No Po" id="ref">
          </div>
         
        </div>
        <div class="row">
          <div class="col">
            <label for="">Rekanan</label>
            <select name="user_id" id="user_id" class="form-select">
              <option value="">Pilih Rekanan</option>
              @foreach ($users as $user)
              <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col">
            <label for="">Status</label>
    
            <select name="status" id="status" class="form-control">
              <option value="">Pilih Status</option>
              <option value="PENDING">PENDING</option>
              <option value="POTONG">POTONG</option>
              <option value="KIRIM">KIRIM</option>
              <option value="SELESAI">SELESAI</option>
              <option value="LUNAS">LUNAS</option>
            </select>
          </div>
          <div class="col">
           <div class="form-group">
            <label for="">Tanggal</label>
            <div class="input-group">
              <input type="text" class="form-control" id="created_at" name="created_at" value="" />
              <span class="input-group-addon" style="margin-left: ; margin-top:5px">
                <i class="fa fa-calendar fa-lg" aria-hidden="true"></i> 
              </span>
          </div>
           </div>

          </div>
        </div>
        <div class="row justify-content-between">
          {{-- Button Simpan --}}
          <div class="col  ">
             

          </div>
          <div class="col pt-3 text-center">
            <button type="button" class="btn btn-primary btn-block" id="search">
              <i class="fa fa-search"></i> Cari
            </button>
            <button class="btn btn-success btn-block">
              <i class="fa fa-download me-1"></i>Download PDF
            </button>
            <button class="btn btn-warning btn block">
              <i class="fa fa-download me-1"></i>Download EXCEL
            </button>

        </div>
        </div>
      </form>
    </div>
  </div>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    var orders = $('#orders').DataTable({
       processing: true,
        serverSide:true,
        ordering:true,
        searching: false,
        ajax:{
          url: '{!! url()->current() !!}',
          data: function (izal) {
                          izal.status = $('#status').val();
                          izal.user_id = $('#user_id').val();
                          izal.nama_ayah = $('#nama_ayah').val();
                          izal.name = $('#name').val();
                          izal.ref = $('#ref').val();
                          izal.created_at = $('#created_at').val();
                        
                      },
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

    // Search
    $("#search").on('click',function (e) {
        $('#orders').DataTable().draw(true);
    });

   
  </script>

  <script>
    $(document).ready(function(){
      $('#user_id, #status').select2();

      // Date Picker
      $("#created_at").daterangepicker({
        // showDropdowns: true,
       
      });

    });
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