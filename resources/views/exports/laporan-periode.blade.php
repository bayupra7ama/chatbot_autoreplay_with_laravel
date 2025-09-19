<table>
    <thead>
        <tr>
            <th colspan="4">Periode: {{ $periode }} | Total: {{ $laporans->count() }}</th>
        </tr>
        <tr>

            <th class="border px-4 py-2">Nama</th>
            <th class="border px-4 py-2">Masalah</th>
            <th class="border px-4 py-2">Deskripsi</th>

            <th class="border px-4 py-2">OPD</th>
            <th class="border px-4 py-2">Kontak</th>
            <th class="border px-4 py-2">Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($laporans as $i => $laporan)
            <tr>
                <td class="border px-4 py-2">{{ $laporan->nama }}</td>
                <td class="border px-4 py-2">{{ $laporan->masalah }}</td>
                <td class="border px-4 py-2">{{ $laporan->deskripsi }}</td>

                <td class="border px-4 py-2">{{ $laporan->opd }}</td>


                <td class="border px-4 py-2">{{ $laporan->kontak }}</td>
                <td class="border px-4 py-2">{{ $laporan->created_at->translatedFormat('d F Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
