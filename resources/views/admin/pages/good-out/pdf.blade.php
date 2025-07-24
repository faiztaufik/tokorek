<!-- PDF Template -->
<h2>{{ $title }}</h2>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
            <th>Catatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($goodsOut as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->good->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->date_in }}</td>
                <td>{{ $item->note }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
