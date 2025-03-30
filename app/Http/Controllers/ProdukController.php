<?php

namespace App\Http\Controllers;

use App\Models\Baju;
use App\Models\ProdukHistory;
use App\Models\Stok;
use Illuminate\Support\Facades\Auth;
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

        ProdukHistory::create([
            'produk_id' => $baju->id,
            'user_id' => Auth::id(),
            'message' => 'Menambahkan produk baru',
        ]);

        return redirect()->route('dashboard')->with('success', 'Produk berhasil ditambahkan');
    }

    public function show($id)
    {
        $produk = Baju::with('stoks')->findOrFail($id);
        $histories = ProdukHistory::where('produk_id', $id)->with('user')->latest()->get();

        return view('produk.produk-detail', compact('produk', 'histories'));
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
        $changes = [];

        // Cek perubahan nama, ukuran, warna
        if ($baju->nama !== $request->nama) {
            $changes[] = "Nama dari '{$baju->nama}' menjadi '{$request->nama}'";
        }
        if ($baju->ukuran !== $request->ukuran) {
            $changes[] = "Ukuran dari '{$baju->ukuran}' menjadi '{$request->ukuran}'";
        }
        if ($baju->warna !== $request->warna) {
            $changes[] = "Warna dari '{$baju->warna}' menjadi '{$request->warna}'";
        }

        // Cek perubahan gambar
        if ($request->hasFile('image')) {
            if ($baju->image) {
                Storage::disk('public')->delete($baju->image);
            }
            $path = $request->file('image')->store('produk', 'public');
            $changes[] = "Gambar diperbarui";
        } else {
            $path = $baju->image;
        }

        // Update data utama
        $baju->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'ukuran' => $request->ukuran,
            'warna' => $request->warna,
            'image' => $path,
        ]);

        // Update data stok
        $sizes = array_map('trim', explode(',', $request->ukuran));
        $colors = array_map('trim', explode(',', $request->warna));

        // Hapus stok yang tidak ada di input baru
        Stok::where('produk_id', $id)->whereNotIn('ukuran', $sizes)->delete();
        Stok::where('produk_id', $id)->whereNotIn('warna', $colors)->delete();

        foreach ($sizes as $size) {
            foreach ($colors as $color) {
                if (!$size || !$color) continue;

                $qtyKey = "qty_{$size}_{$color}";
                $hargaKey = "harga_{$size}_{$color}";

                $newQty = (int) $request->input($qtyKey, 0);
                $newHarga = (int) $request->input($hargaKey, 0);

                $stok = Stok::where('produk_id', $baju->id)
                            ->where('ukuran', $size)
                            ->where('warna', $color)
                            ->first();

                if ($stok) {
                    if ($stok->qty != $newQty) {
                        $changes[] = "Qty untuk ukuran {$size} dan warna {$color} dari '{$stok->qty}' menjadi '{$newQty}'";
                    }
                    if ($stok->harga != $newHarga) {
                        $changes[] = "Harga untuk ukuran {$size} dan warna {$color} dari '{$stok->harga}' menjadi '{$newHarga}'";
                    }

                    $stok->update([
                        'qty' => $newQty,
                        'harga' => $newHarga,
                    ]);
                } else {
                    Stok::create([
                        'produk_id' => $baju->id,
                        'ukuran' => $size,
                        'warna' => $color,
                        'qty' => $newQty,
                        'harga' => $newHarga,
                    ]);

                    $changes[] = "Stok baru ditambahkan untuk ukuran {$size} dan warna {$color} (qty: {$newQty}, harga: {$newHarga})";
                }
            }
        }

        // Simpan riwayat jika ada perubahan
        if (count($changes) > 0) {
            ProdukHistory::create([
                'produk_id' => $baju->id,
                'user_id' => Auth::id(),
                'message' => implode(', ', $changes),
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Produk berhasil diperbarui');
}


    public function destroy($id)
    {
        $baju = Baju::findOrFail($id);
        
        if ($baju->image) {
            Storage::disk('public')->delete($baju->image);
        }

        Stok::where('produk_id', $id)->delete();

        ProdukHistory::where('produk_id', $id)->delete();

        $baju->delete();

        return redirect()->route('dashboard')->with('success', 'Produk berhasil dihapus');
    }
}
