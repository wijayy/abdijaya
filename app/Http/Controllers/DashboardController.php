<?php

namespace App\Http\Controllers;

use App\Models\Baju;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        if (Auth::check()) {
            return redirect('/dashboard');
        } else {
            return redirect('/login');
        }
    }

    public function dashboard() {
        $produk = Baju::latest()->filters(request(['search']))->get();
        return view('dashboard', ['produks' => $produk]);
    }
}
