<x-filament::page>
    <form wire:submit.prevent="applyFilter">


        <div class="flex flex-col md:flex-row items-end gap-4 mb-4">
            <div class="w-full md:w-64">
                <label for="filterBy" class="block text-sm font-medium text-gray-700 mb-1">
                    Tampilkan berdasarkan
                </label>
                <select wire:model="filterBy" id="filterBy"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500">
                    <option value="month">Bulanan</option>
                    <option value="week">Mingguan</option>
                    <option value="year">Tahunan</option> 

                </select>
            </div>

            <div>
                <x-filament::button type="submit" class="mt-1 md:mt-0">
                    Tampilkan
                </x-filament::button>
            </div>

        </div>


        @if ($filterBy === 'range')
            <div>
                <label class="block font-medium text-sm text-gray-700">Dari Tanggal</label>
                <input type="date" wire:model="startDate" class="w-full rounded-lg border-gray-300" />
            </div>
            <div>
                <label class="block font-medium text-sm text-gray-700">Sampai Tanggal</label>
                <input type="date" wire:model="endDate" class="w-full rounded-lg border-gray-300" />
            </div>
        @endif
    </form>

    @forelse ($groupedReports as $periode => $laporans)

        <div class="flex items-center justify-between mb-2">
            <h2 class="font-bold text-lg">Periode: {{ $periode }} | Total: {{ $laporans->count() }} laporan</h2>
            <a href="{{ route('export.laporan.periode', urlencode($periode)) }}" target="_blank">
                <x-filament::button icon="heroicon-o-arrow-down-tray" color="success">
                    Export Laporan
                </x-filament::button>
            </a>
        </div>


        <table class="table-auto w-full border mt-2 mb-6">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">No</th>
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
                        <td class="border px-4 py-2">{{ $i + 1 }}</td>
                        <td class="border px-4 py-2">{{ $laporan->nama }}</td>
                        <td class="border px-4 py-2">{{ $laporan->masalah }}</td>
                        <td class="border px-4 py-2">{{ $laporan->deskripsi }}</td>

                        <td class="border px-4 py-2">{{ $laporan->opd }}</td>


                        <td class="border px-4 py-2">{{ $laporan->kontak }}</td>
                        <td class="border px-4 py-2">{{ $laporan->created_at }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @empty
        <p class="text-center text-gray-500">Tidak ada data.</p>
    @endforelse

</x-filament::page>
