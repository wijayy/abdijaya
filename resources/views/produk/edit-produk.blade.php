<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Produk') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('produk.update', $baju->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                            <input
                                type="text"
                                name="nama"
                                id="nama"
                                autocomplete="off"
                                value="{{ old('nama', $baju->nama) }}"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                required>
                            @error('nama')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="ukuran" class="block text-sm font-medium text-gray-700">Ukuran</label>
                            <input
                                type="text"
                                name="ukuran"
                                id="ukuran"
                                autocomplete="off"
                                value="{{ old('ukuran', $baju->ukuran) }}"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('ukuran')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="warna" class="block text-sm font-medium text-gray-700">Warna</label>
                            <input
                                type="text"
                                name="warna"
                                id="warna"
                                autocomplete="off"
                                value="{{ old('warna', $baju->warna) }}"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('warna')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700">image</label>
                            <input type="file" name="image" id="image" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block bg-white w-full shadow-sm sm:text-sm border-gray-300 rounded-md" onchange="previewImage(event)">
                            @error('image')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                            <div class="mt-2">
                                <img id="image-preview" src="{{ $baju->image ? asset('storage/' . $baju->image) : '' }}" alt="Preview Gambar" class="max-w-xs">
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <input type="checkbox" id="apply_all_qty_checkbox" class="mr-2">
                        <label for="apply_all_qty_checkbox" class="text-sm font-medium text-gray-700">Terapkan Qty pada Semua Varian</label>
                        <input type="number" id="apply_all_qty" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md hidden">
                    </div>
                    <div class="mt-4">
                        <input type="checkbox" id="apply_all_price_checkbox" class="mr-2">
                        <label for="apply_all_price_checkbox" class="text-sm font-medium text-gray-700">Terapkan Harga pada Semua Varian</label>
                        <input type="number" id="apply_all_price" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md hidden">
                    </div>
                    <div id="additional-fields" class="grid grid-cols-1 sm:grid-cols-4 gap-4 mt-8">
                        @foreach($baju->stoks as $stok)
                            <div>
                                <label for="size_{{ $stok->ukuran }}" class="block text-sm font-medium text-gray-700">Size ({{ $stok->ukuran }})</label>
                                <input type="text" name="size_{{ $stok->ukuran }}" id="size_{{ $stok->ukuran }}" value="{{ $stok->ukuran }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" readonly>
                            </div>
                            <div>
                                <label for="color_{{ $stok->warna }}" class="block text-sm font-medium text-gray-700">Warna</label>
                                <input type="text" name="color_{{ $stok->warna }}" id="color_{{ $stok->warna }}" value="{{ $stok->warna }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" readonly>
                            </div>
                            <div>
                                <label for="qty_{{ $stok->ukuran }}_{{ $stok->warna }}" class="block text-sm font-medium text-gray-700">Qty ({{ $stok->ukuran }} - {{ $stok->warna }})</label>
                                <input type="number" name="qty_{{ $stok->ukuran }}_{{ $stok->warna }}" id="qty_{{ $stok->ukuran }}_{{ $stok->warna }}" value="{{ $stok->qty }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label for="harga_{{ $stok->ukuran }}_{{ $stok->warna }}" class="block text-sm font-medium text-gray-700">Harga ({{ $stok->ukuran }} - {{ $stok->warna }})</label>
                                <input type="number" name="harga_{{ $stok->ukuran }}_{{ $stok->warna }}" id="harga_{{ $stok->ukuran }}_{{ $stok->warna }}" value="{{ $stok->harga }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function updateFields() {
            const sizes = document.getElementById('ukuran').value.split(',');
            const colors = document.getElementById('warna').value.split(',');
            const container = document.getElementById('additional-fields');
            container.innerHTML = ''; // Clear previous fields

            sizes.forEach(size => {
                size = size.trim();
                colors.forEach(color => {
                    color = color.trim();
                    if (size && color) {
                        container.innerHTML += `
                            <div>
                                <label for="size_${size}" class="block text-sm font-medium text-gray-700">Size (${size})</label>
                                <input type="text" name="size_${size}" id="size_${size}" value="${size}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" readonly>
                            </div>
                            <div>
                                <label for="color_${color}" class="block text-sm font-medium text-gray-700">Warna</label>
                                <input type="text" name="color_${color}" id="color_${color}" value="${color}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" readonly>
                            </div>
                            <div>
                                <label for="qty_${size}_${color}" class="block text-sm font-medium text-gray-700">Qty (${size} - ${color})</label>
                                <input type="number" name="qty_${size}_${color}" id="qty_${size}_${color}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label for="harga_${size}_${color}" class="block text-sm font-medium text-gray-70">Harga (${size} - ${color})</label>
                                <input type="number" name="harga_${size}_${color}" id="harga_${size}_${color}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        `;
                    }
                });
            });
        }

        document.getElementById('ukuran').addEventListener('input', updateFields);
        document.getElementById('warna').addEventListener('input', updateFields);

        document.getElementById('apply_all_qty_checkbox').addEventListener('change', function() {
            const qtyInput = document.getElementById('apply_all_qty');
            if (this.checked) {
                qtyInput.classList.remove('hidden');
            } else {
                qtyInput.classList.add('hidden');
                qtyInput.value = '';
                document.querySelectorAll('[id^="qty_"]').forEach(input => {
                    input.value = '';
                });
            }
        });

        document.getElementById('apply_all_qty').addEventListener('input', function() {
            const qty = this.value;
            document.querySelectorAll('[id^="qty_"]').forEach(input => {
                input.value = qty;
            });
        });

        document.getElementById('apply_all_price_checkbox').addEventListener('change', function() {
            const priceInput = document.getElementById('apply_all_price');
            if (this.checked) {
                priceInput.classList.remove('hidden');
            } else {
                priceInput.classList.add('hidden');
                priceInput.value = '';
                document.querySelectorAll('[id^="harga_"]').forEach(input => {
                    input.value = '';
                });
            }
        });

        document.getElementById('apply_all_price').addEventListener('input', function() {
            const price = this.value;
            document.querySelectorAll('[id^="harga_"]').forEach(input => {
                input.value = price;
            });
        });

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('image-preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-app-layout>