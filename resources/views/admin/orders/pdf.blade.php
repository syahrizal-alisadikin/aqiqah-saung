<!DOCTYPE html>
<html>
<head>
	<title>Orders {{ $order->ref }}</title>
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
    <div class="container">
        <img src="{{ public_path('storage/profile/'. $order->user->foto) }}" style="height: 100px; width:100px"  alt="">

    </div>
    <div class="container text-center p-4">

        <h3>{{ $order->name }}</h3>
        <h4>{{ $order->jk == 0 ? "BINTI" : "BIN" }}</h4>
        <h3>{{ $order->nama_ayah }}</h3>
    </div>
</div>
	

<div class="row">
    <div class="container">
        <h5>{{ $order->quantity ." ". $order->product->type ." ". $order->product->jenis }} </h5>
        <h5>{{ $order->note }}</h5>
    </div>
</div>
</body>
</html>