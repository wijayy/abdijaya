<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (session('success'))
            <div class="p-4 mb-4 text-gray-700 bg-green-100 rounded">
                {{ session('success') }}
            </div>
            @endif
            <div class="relative overflow-x-auto">
                <a href="{{ route('produk.tambah') }}">
                    <button class="px-6 py-2 mb-4 overflow-hidden font-bold text-white rounded-lg bg-secondary">
                        Tambah Produk
                    </button>
                </a>
                <form class="flex items-center rounded-lg">
                    <input type="text" name="search" id="search" value="{{ request('search') }}" autocomplete="off"
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-secondary focus:border-secondary sm:text-sm"
                        placeholder="Cari produk">
                    <button class="px-6 py-2 overflow-hidden font-bold text-white rounded-lg bg-secondary">
                        Search
                    </button>
                </form>
                <table class="w-full mt-4 text-sm text-left text-gray-500 rtl:text-right">
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
                                <a href="{{ route('produk.edit', $produk->id) }}"
                                    class="text-blue-600 hover:text-blue-900">Edit</a>
                                <a href="{{ route('produk.show', $produk->id) }}"
                                    class="text-green-600 hover:text-green-900">| Detail |</a>
                                <form action="{{ route('produk.destroy', $produk->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')"
                                        class="text-red-600 hover:text-red-900">
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
