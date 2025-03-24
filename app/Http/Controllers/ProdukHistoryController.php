<?php

namespace App\Http\Controllers;

use App\Models\ProdukHistory;
use Illuminate\Http\Request;

class ProdukHistoryController extends Controller
{
    public function index()
    {
        $histories = ProdukHistory::with('user', 'baju')->latest()->get();
        return view('history.history', compact('histories'));
    }
}
