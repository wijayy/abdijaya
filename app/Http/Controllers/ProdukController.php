<?php

namespace App\Http\Controllers;

use App\Models\Baju;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index() {
        return view('produk.tambah-produk');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'ukuran' => 'required|string',
            'warna' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('produk', 'public');
        }

        // Simpan data Baju
        $baju = Baju::create([
            'nama' => $request->nama,
            'ukuran' => $request->ukuran,
            'warna' => $request->warna,
            'image' => $path,
        ]);

        // Simpan data Stok
        $sizes = explode(',', $request->ukuran);
        $colors = explode(',', $request->warna);

        foreach ($sizes as $size) {
            $size = trim($size);
            foreach ($colors as $color) {
                $color = trim($color);
                if ($size && $color) {
                    Stok::create([
                        'produk_id' => $baju->id,
                        'ukuran' => $size,
                        'warna' => $color,
                        'qty' => $request->input("qty_{$size}_{$color}"),
                        'harga' => $request->input("harga_{$size}_{$color}"),
                    ]);
                }
            }
        }

        return redirect()->route('dashboard')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $baju = Baju::findOrFail($id);
        $stok = Stok::where('produk_id', $id)->get();
        
        return view('produk.edit-produk', compact('baju', 'stok'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'ukuran' => 'required|string',
            'warna' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $baju = Baju::findOrFail($id);
        
        if ($baju->image && $request->hasFile('image')) {
            Storage::disk('public')->delete($baju->image);
        }

        $path = $baju->image;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('produk', 'public');
        }

        $baju->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'ukuran' => $request->ukuran,
            'warna' => $request->warna,
            'image' => $path,
        ]);

        // Update data Stok
        $sizes = explode(',', $request->ukuran);
        $colors = explode(',', $request->warna);

        // Hapus stok lama yang tidak ada dalam input baru
        Stok::where('produk_id', $id)
            ->whereNotIn('ukuran', $sizes)
            ->delete();

        Stok::where('produk_id', $id)
            ->whereNotIn('warna', $colors)
            ->delete();

        foreach ($sizes as $size) {
            $size = trim($size);
            foreach ($colors as $color) {
                $color = trim($color);
                if ($size && $color) {
                    $stok = Stok::where('produk_id', $baju->id)
                                ->where('ukuran', $size)
                                ->where('warna', $color)
                                ->first();

                    if ($stok) {
                        $stok->update([
                            'qty' => $request->input("qty_{$size}_{$color}") ?? 0,
                            'harga' => $request->input("harga_{$size}_{$color}") ?? 0,
                        ]);
                    } else {
                        Stok::create([
                            'produk_id' => $baju->id,
                            'ukuran' => $size,
                            'warna' => $color,
                            'qty' => $request->input("qty_{$size}_{$color}") ?? 0,
                            'harga' => $request->input("harga_{$size}_{$color}") ?? 0,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('dashboard')->with('success', 'Produk berhasil diperbarui');
    }
}
