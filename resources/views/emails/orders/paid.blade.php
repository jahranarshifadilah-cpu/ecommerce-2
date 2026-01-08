{{-- resources/views/emails/orders/paid.blade.php --}}

<x-mail::message>
# Pembayaran Dikonfirmasi

Halo **{{ $order->user->name }}**,

Kabar baik! Kami telah menerima pembayaran Anda untuk pesanan **#{{ $order->order_number }}**. Tim kami sekarang sedang menyiapkan produk Anda untuk segera dikirim.

<x-mail::panel>
**Status Pesanan:** Sedang Diproses  
**Metode Pembayaran:** {{ $order->payment_method ?? 'Transfer Bank' }}
</x-mail::panel>

### Rincian Pesanan:
<x-mail::table>
| Produk | Qty | Subtotal |
|:-------|:---:|:---------|
@foreach($order->items as $item)
| {{ $item->product_name }} | {{ $item->quantity }} | Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }} |
@endforeach
| **Total Bayar** | | **Rp {{ number_format($order->total_amount, 0, ',', '.') }}** |
</x-mail::table>

<x-mail::button :url="route('orders.show', $order)" color="success">
Pantau Status Pengiriman
</x-mail::button>

### Alamat Pengiriman:
> {{ $order->shipping_address }}

**Apa selanjutnya?**
Kami akan mengirimkan email notifikasi kembali beserta nomor resi segera setelah paket Anda diserahkan ke kurir.

Terima kasih telah berbelanja di **{{ config('app.name') }}**.

Salam hangat,<br>
Tim {{ config('app.name') }}
</x-mail::message>