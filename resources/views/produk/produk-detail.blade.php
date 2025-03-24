<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-xl text-center font-bold text-gray-900 dark:text-gray-200">Informasi Produk</h3>
                <div class="mt-4 text-gray-900 dark:text-gray-200">
                    <p><strong>Nama:</strong> {{ $produk->nama }}</p>
                    <p><strong>Ukuran:</strong> {{ $produk->ukuran }}</p>
                    <p><strong>Warna:</strong> {{ $produk->warna }}</p>
                    <p><strong>Gambar:</strong></p>
                    <img src="{{ $produk->image ? asset('storage/' . $produk->image) : '' }}" alt="Gambar Produk" class="max-w-xs">
                </div>

                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mt-8">Stok</h3>
                <div class="mt-4">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Ukuran</th>
                                <th scope="col" class="px-6 py-3">Warna</th>
                                <th scope="col" class="px-6 py-3">Qty</th>
                                <th scope="col" class="px-6 py-3">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produk->stoks as $stok)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                <td class="px-6 py-4">{{ $stok->ukuran }}</td>
                                <td class="px-6 py-4">{{ $stok->warna }}</td>
                                <td class="px-6 py-4">{{ $stok->qty }}</td>
                                <td class="px-6 py-4">{{ $stok->harga }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mt-8">History Perubahan</h3>
                <div class="mt-4">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">No</th>
                                <th scope="col" class="px-6 py-3">User</th>
                                <th scope="col" class="px-6 py-3">Pesan</th>
                                <th scope="col" class="px-6 py-3">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($histories as $index => $history)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">{{ $history->user ? $history->user->name : 'Deleted User' }}</td>
                                <td class="px-6 py-4">{{ $history->message }}</td>
                                <td class="px-6 py-4">{{ $history->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>