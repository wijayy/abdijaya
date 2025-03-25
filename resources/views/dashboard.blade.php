<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 text-gray-700 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            <div class="relative overflow-x-auto">
                <a href="{{ route('produk.tambah') }}">
                    <button class="bg-secondary text-white overflow-hidden font-bold sm:rounded-lg px-6 py-2 mb-4">
                        Tambah Produk
                    </button>
                </a>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                No
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Produk
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Ukuran
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Warna
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produks as $index => $produk)
                        <tr class="bg-white border-b border-gray-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $index + 1 }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $produk->nama }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $produk->ukuran }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $produk->warna }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('produk.edit', $produk->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                <a href="{{ route('produk.show', $produk->id) }}" class="text-green-600 hover:text-green-900">| Detail |</a>
                                <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')" class="text-red-600 hover:text-red-900">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>