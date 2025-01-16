<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pemesan</th>
            <th>Total Harga</th>
            <th>Metode Pembayaran</th>
            <th>Tanggal Pesanan</th>
            <th>Detail Produk</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $index => $order)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $order->nama }}</td>
                <td>Rp. {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                <td>{{ $order->pembayaran->nama ?? '-' }}</td>
                <td>{{ $order->created_at->format('d-m-Y') }}</td>
                <td>
                    @foreach($order->orderProduk as $orderProduk)
                        - {{ $orderProduk->produk->nama }} ({{ $orderProduk->jumlah }} x Rp. {{ number_format($orderProduk->harga, 0, ',', '.') }})<br>
                    @endforeach
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
