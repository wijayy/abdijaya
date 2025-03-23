<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Produk') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama Produk</label>
                            <input
                                type="text"
                                name="nama"
                                id="nama"
                                autocomplete="off"
                                value="{{ old('nama') }}"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                required>
                            @error('nama')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="ukuran" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Ukuran</label>
                            <input
                                type="text"
                                name="ukuran"
                                id="ukuran"
                                autocomplete="off"
                                value="{{ old('ukuran') }}"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('ukuran')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="warna" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Warna</label>
                            <input
                                type="text"
                                name="warna"
                                id="warna"
                                autocomplete="off"
                                value="{{ old('warna') }}"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('warna')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Gambar</label>
                            <input type="file" name="image" id="image" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block bg-white w-full shadow-sm sm:text-sm border-gray-300 rounded-md" onchange="previewImage(event)">
                            @error('image')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                            <div class="mt-2">
                                <img id="image-preview" src="" alt="Preview Gambar" class="max-w-xs">
                            </div>
                        </div>
                    </div>

                    <!-- Checkbox for quantity -->
                    <div class="mt-4">
                        <input type="checkbox" id="apply_all_stock_checkbox" class="mr-2">
                        <label for="apply_all_stock_checkbox" class="text-sm font-medium text-gray-700 dark:text-gray-200">Terapkan Qty pada Semua Varian</label>
                        <input type="number" id="apply_all_stock" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md hidden">
                    </div>

                    <!-- Checkbox for price -->
                    <div class="mt-4">
                        <input type="checkbox" id="apply_all_price_checkbox" class="mr-2">
                        <label for="apply_all_price_checkbox" class="text-sm font-medium text-gray-700 dark:text-gray-200">Terapkan Harga pada Semua Varian</label>
                        <input type="number" id="apply_all_price" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md hidden">
                    </div>

                    <!-- Additional Field -->
                    <div id="additional-fields" class="grid grid-cols-1 sm:grid-cols-4 gap-4 mt-8"></div>

                    <!-- Add Button -->
                    <div class="mt-4">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Tambah Produk
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
                                <label for="size_${size}" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Size (${size})</label>
                                <input type="text" name="size_${size}" id="size_${size}" value="${size}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" readonly>
                            </div>
                            <div>
                                <label for="color_${color}" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Warna</label>
                                <input type="text" name="color_${color}" id="color_${color}" value="${color}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" readonly>
                            </div>
                            <div>
                                <label for="qty_${size}_${color}" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Qty (${size} - ${color})</label>
                                <input type="number" name="qty_${size}_${color}" id="qty_${size}_${color}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label for="harga_${size}_${color}" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Harga (${size} - ${color})</label>
                                <input type="number" name="harga_${size}_${color}" id="harga_${size}_${color}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        `;
                    }
                });
            });
        }

        document.getElementById('ukuran').addEventListener('input', updateFields);
        document.getElementById('warna').addEventListener('input', updateFields);

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

        document.getElementById('apply_all_stock_checkbox').addEventListener('change', function() {
            const stockInput = document.getElementById('apply_all_stock');
            if (this.checked) {
                stockInput.classList.remove('hidden');
            } else {
                stockInput.classList.add('hidden');
                stockInput.value = '';
                document.querySelectorAll('[id^="qty_"]').forEach(input => {
                    input.value = '';
                });
            }
        });

        document.getElementById('apply_all_stock').addEventListener('input', function() {
            const stock = this.value;
            document.querySelectorAll('[id^="qty_"]').forEach(input => {
                input.value = stock;
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