<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Supplier;
use App\Models\Karat;
use App\Models\PenerimaanBarang;
use Illuminate\Support\Facades\Auth;

class PenerimaanBarangForm extends Component
{
    use WithFileUploads;

    public $image;
    public $no_penerimaan;
    public $no_surat_jalan;
    public $supplier_id;
    public $tanggal;
    public $multiple_input = [];
    public $total_berat_real;
    public $total_berat_kotor;
    public $berat_timbangan;
    public $berat_selisih;
    public $catatan;
    public $tipe_pembayaran;
    public $harga_beli;
    public $tanggal_jatuh_tempo;
    public $nama_pengirim;
    public $pic_id;

    protected $rules = [
        'image' => 'required|image|max:2048',
        'no_surat_jalan' => 'required',
        'supplier_id' => 'required',
        'tanggal' => 'required|date|before_or_equal:today',
        'multiple_input.*.parameter_karat' => 'required',
        'multiple_input.*.berat_real' => 'required|numeric|min:0.1',
        'multiple_input.*.berat_kotor' => 'required|numeric|min:0.1',
        'total_berat_real' => 'required|numeric|min:0.1',
        'total_berat_kotor' => 'required|numeric|min:0.1',
        'berat_timbangan' => 'required|numeric|min:0.1',
        'berat_selisih' => 'required|numeric',
        'tipe_pembayaran' => 'required',
        'harga_beli' => 'required_if:tipe_pembayaran,Lunas|nullable|numeric',
        'tanggal_jatuh_tempo' => 'required_if:tipe_pembayaran,Jatuh Tempo|nullable|date|after_or_equal:today',
        'nama_pengirim' => 'required',
    ];

    public function mount()
    {
        $this->no_penerimaan = 'INV-' . time();
        $this->tanggal = now()->format('Y-m-d');
        $this->multiple_input = [
            ['parameter_karat' => '', 'berat_real' => '', 'berat_kotor' => '']
        ];
        if (Auth::check()) {
            $this->pic_id = Auth::user()->id;
        } else {
            $this->pic_id = null;
        }
    }

    public function addRow()
    {
        $this->multiple_input[] = ['parameter_karat' => '', 'berat_real' => '', 'berat_kotor' => ''];
    }

    public function removeRow($index)
    {
        unset($this->multiple_input[$index]);
        $this->multiple_input = array_values($this->multiple_input);
    }

    public function updatedBeratTimbangan()
    {
        $this->berat_selisih = $this->berat_timbangan - $this->total_berat_real;
    }

    public function submit()
    {
        $this->validate();

        $imagePath = $this->image->store('images');

        PenerimaanBarang::create([
            'no_penerimaan' => $this->no_penerimaan,
            'no_surat_jalan' => $this->no_surat_jalan,
            'supplier_id' => $this->supplier_id,
            'tanggal' => $this->tanggal,
            'multiple_input' => json_encode($this->multiple_input),
            'total_berat_real' => $this->total_berat_real,
            'total_berat_kotor' => $this->total_berat_kotor,
            'berat_timbangan' => $this->berat_timbangan,
            'berat_selisih' => $this->berat_selisih,
            'catatan' => $this->catatan,
            'tipe_pembayaran' => $this->tipe_pembayaran,
            'harga_beli' => $this->harga_beli,
            'tanggal_jatuh_tempo' => $this->tanggal_jatuh_tempo,
            'nama_pengirim' => $this->nama_pengirim,
            'pic_id' => $this->pic_id,
        ]);
        session()->flash('message', 'Penerimaan barang berhasil disimpan.');

        return redirect()->route('penerimaan-barang.index');
    }

    public function render()
    {
        return view('livewire.penerimaan-barang-form', [
            'suppliers' => Supplier::all(),
            'karats' => Karat::all(),
        ]);
    }
}
