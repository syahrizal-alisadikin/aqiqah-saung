<!DOCTYPE html>
<html>
<head>
	<title>Orders </title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
{{-- <style type="text/css">
    table tr td,
    table tr th{
        font-size: 9pt;
    }
</style> --}}
<body>
<div class="row">
  <div class="container-fluid">
      <div class="card p-2">
          <h4 class="text-center">Data Order </h4>
          <div class="card-body">
            <table class="table align-items-center mb-0"  style="width:100%; !important">
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
                  </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $item)
                        <tr>
                            <td>{{ $item->ref }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->nama_ayah }}</td>
                            <td>{{ $item->product->name .' ' .$item->product->type.' ' .$item->product->jenis }}</td>
                            <td>{{ moneyFormat($item->harga) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ moneyFormat($item->total_harga) }}</td>
                            <td>{{ $item->status }}</td>

                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="10">Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
              </table>
          </div>
      </div>
  </div>
</div>
	


</body>
</html>