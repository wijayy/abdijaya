<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Tambah Produk') }}
        </h2>
    </x-slot>
    <div class="py-12" x-data="{nama:'',baju: JSON.parse('{{ json_encode($baju) }}')}">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama
                                Produk</label>
                            <input type="text" x-model="nama" name="nama" id="nama" autocomplete="off"
                                value="{{ old('nama') }}"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-secondary focus:border-secondary sm:text-sm"
                                required>
                            <div class="text-red-500" x-show="baju.includes(nama)">Nama baju sudah terdaftar, silahkan update data</div>
                            @error('nama')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="ukuran" class="block text-sm font-medium text-gray-700">Ukuran</label>
                            <input type="text" name="ukuran" id="ukuran" autocomplete="off" value="{{ old('ukuran') }}"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-secondary focus:border-secondary sm:text-sm"
                                placeholder="Masukkan semua ukuran, pisahkan dengan tanda koma.  Ex: L, XL" required>
                            @error('ukuran')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="warna" class="block text-sm font-medium text-gray-700">Warna</label>
                            <input type="text" name="warna" id="warna" autocomplete="off" value="{{ old('warna') }}"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-secondary focus:border-secondary sm:text-sm"
                                placeholder="Masukkan semua warna, pisahkan dengan tanda koma. Ex: merah, putih"
                                required>
                            @error('warna')
                            <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700">Gambar</label>
                            <input type="file" name="image" id="image"
                                class="block w-full mt-1 bg-white border-gray-300 rounded-md shadow-sm focus:ring-secondary focus:border-secondary sm:text-sm"
                                onchange="previewImage(event)">
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
                        <label for="apply_all_stock_checkbox" class="text-sm font-medium text-gray-700">Terapkan Qty
                            pada Semua Varian</label>
                        <input type="number" id="apply_all_stock"
                            class="hidden block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-secondary focus:border-secondary sm:text-sm">
                    </div>

                    <!-- Checkbox for price -->
                    <div class="mt-4">
                        <input type="checkbox" id="apply_all_price_checkbox" class="mr-2">
                        <label for="apply_all_price_checkbox" class="text-sm font-medium text-gray-700">Terapkan Harga
                            pada Semua Varian</label>
                        <input type="number" id="apply_all_price"
                            class="hidden block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-secondary focus:border-secondary sm:text-sm">
                    </div>

                    <!-- Additional Field -->
                    <div id="additional-fields" class="grid grid-cols-1 gap-4 mt-8 sm:grid-cols-4"></div>

                    <!-- Add Button -->
                    <div class="mt-4">
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#48CFCB] hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
                                <label for="size_${size}" class="block text-sm font-medium text-gray-700">Size (${size})</label>
                                <input type="text" name="size_${size}" id="size_${size}" value="${size}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-secondary focus:border-secondary sm:text-sm" readonly>
                            </div>
                            <div>
                                <label for="color_${color}" class="block text-sm font-medium text-gray-700">Warna</label>
                                <input type="text" name="color_${color}" id="color_${color}" value="${color}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-secondary focus:border-secondary sm:text-sm" readonly>
                            </div>
                            <div>
                                <label for="qty_${size}_${color}" class="block text-sm font-medium text-gray-700">Qty (${size} - ${color})</label>
                                <input type="number" name="qty_${size}_${color}" id="qty_${size}_${color}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-secondary focus:border-secondary sm:text-sm" required>
                            </div>
                            <div class="pb-6 border-b-2 border-secondary sm:border-none sm:pb-0">
                                <label for="harga_${size}_${color}" class="block text-sm font-medium text-gray-70">Harga (${size} - ${color})</label>
                                <input type="number" name="harga_${size}_${color}" id="harga_${size}_${color}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-secondary focus:border-secondary sm:text-sm" required>
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
            reader.onload = function() {
                const output = document.getElementById('image-preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-app-layout>
