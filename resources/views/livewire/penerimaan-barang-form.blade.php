@extends('layouts.app')

@section('content')
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <style>
        .upload-area {
            border: 2px dashed #ffa07a;
            border-radius: 4px;
            padding: 20px;
            text-align: center;
            color: #ffa07a;
            margin-bottom: 20px;
            margin-top: 40px;
        }

        .upload-icon {
            font-size: 50px;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .btn-group {
            display: flex;
            justify-content: flex-end;
        }
    </style>
    <form wire:submit.prevent="submit" class="form">
        <h2>Penerimaan Barang</h2>
        <div class="form-row">

            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="uploadOption" id="upload" value="upload" checked>
                    <label class="form-check-label" for="upload">
                        Upload
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="uploadOption" id="webcam" value="webcam">
                    <label class="form-check-label" for="webcam">
                        Webcam
                    </label>
                </div>
                <div class="upload-area">
                    <div class="upload-icon">&#8679;</div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="no_penerimaan">No Penerimaan Barang</label>
                        <input type="text" wire:model="no_penerimaan" readonly class="form-control"
                            placeholder="PO-00102">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="no_surat_jalan">No Surat Jalan / Invoice</label>
                        <input type="text" wire:model="no_surat_jalan" class="form-control">
                        @error('no_surat_jalan')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="supplier_id">Supplier</label>
                        <select wire:model="supplier_id" class="form-control">
                            <option value="">Pilih Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" wire:model="tanggal" class="form-control">
                        @error('tanggal')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    @foreach ($multiple_input as $index => $input)
                        <div class="form-row align-items-end">
                            <div class="form-group col-md-3">
                                <label for="karat">Parameter Karat</label>
                                <select wire:model="multiple_input.{{ $index }}.parameter_karat"
                                    class="form-control">
                                    <option value="">Pilih Karat</option>
                                    @foreach ($karats as $karat)
                                        <option value="{{ $karat->parameter_karat }}">{{ $karat->parameter_karat }}</option>
                                    @endforeach
                                </select>
                                @error('multiple_input.' . $index . '.parameter_karat')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="beratReal">Berat Real</label>
                                <input type="number" wire:model="multiple_input.{{ $index }}.berat_real"
                                    placeholder="Berat Real" class="form-control">
                                @error('multiple_input.' . $index . '.berat_real')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="beratKotor">Berat Kotor</label>
                                <input type="number" wire:model="multiple_input.{{ $index }}.berat_kotor"
                                    placeholder="Berat Kotor" class="form-control">
                                @error('multiple_input.' . $index . '.berat_kotor')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <button type="button" wire:click="addRow" class="btn btn-primary mt-2">Tambah</button>
                            </div>
                        </div>
                    @endforeach
                </div>


                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="total_berat_real">Total Berat Real</label>
                        <input type="number" wire:model="total_berat_real" class="form-control">
                        @error('total_berat_real')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="total_berat_kotor">Total Berat Kotor</label>
                        <input type="number" wire:model="total_berat_kotor" class="form-control">
                        @error('total_berat_kotor')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="berat_timbangan">Berat Timbangan</label>
                        <input type="number" wire:model="berat_timbangan" class="form-control">
                        @error('berat_timbangan')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="berat_selisih">Berat Selisih</label>
                        <input type="number" wire:model="berat_selisih" readonly class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="catatan">Catatan</label>
                    <textarea wire:model="catatan" class="form-control"></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tipe_pembayaran">Tipe Pembayaran</label>
                        <select wire:model="tipe_pembayaran" class="form-control">
                            <option value="">Pilih Tipe Pembayaran</option>
                            <option value="Lunas">Lunas</option>
                            <option value="Jatuh Tempo">Jatuh Tempo</option>
                        </select>
                        @error('tipe_pembayaran')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        @if ($tipe_pembayaran == 'Lunas')
                            <div class="form-group">
                                <label for="harga_beli">Harga Beli</label>
                                <input type="number" wire:model="harga_beli" class="form-control">
                                @error('harga_beli')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif

                        @if ($tipe_pembayaran == 'Jatuh Tempo')
                            <div class="form-group">
                                <label for="tanggal_jatuh_tempo">Tanggal Jatuh Tempo</label>
                                <input type="date" wire:model="tanggal_jatuh_tempo" class="form-control">
                                @error('tanggal_jatuh_tempo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nama_pengirim">Nama Pengirim</label>
                        <input type="text" wire:model="nama_pengirim" class="form-control">
                        @error('nama_pengirim')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="pic_id">PIC</label>
                        <input type="text" wire:model="pic_id" readonly class="form-control" value="Administrator">
                    </div>
                </div>

                <div class="form-row justify-content-end">
                    <button type="button" class="btn btn-danger col-md-2 mr-2">Batal</button>
                    <button type="submit" class="btn btn-success col-md-3">Simpan</button>
                </div>


            </div>
        </div>
    </form>
@endsection
