<?php

namespace App\Http\Controllers;

use App\Models\PenerimaanBarang;
use Illuminate\Http\Request;

class PenerimaanBarangController extends Controller
{
    public function index()
    {
        $penerimaanBarang = PenerimaanBarang::all();
        return view('penerimaan-barang.index', compact('penerimaanBarang'));
    }
}
