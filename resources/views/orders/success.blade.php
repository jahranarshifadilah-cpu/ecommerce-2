
<!-- resources/views/orders/success.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pembayaran Berhasil</h1>
    <p>Terima kasih, pesanan Anda telah berhasil dibayar.</p>
    <a href="{{ route('orders.index') }}" class="btn btn-primary">Kembali ke Pesanan</a>
</div>
@endsection
