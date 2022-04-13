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
        <h3>AQIQAH :</h3>
        <h1>{{ $order->name }}</h1>
        <h5>{{ $order->jk == 0 ? "BINTI" : "BIN" }}</h5>
        <h1>{{ $order->nama_ayah }}</h1>
    </div>
</div>
	

<div class="row" style="margin-top:100px">
    <div class="container" style="line-height: 0.5">
        <p>{{ $order->quantity ." ". $order->product->type ." ". $order->product->jenis }} </p>
        <p>{{ $order->note }}</p>
    </div>
</div>
</body>
</html>