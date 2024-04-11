@extends('layout.admin')

@push('css')
    <style>
        .mt-4,
        .my-4 {
            margin-top: 1rem !important;
        }

        .alert {
            position: relative;
            padding: .5rem .5rem;
            padding-right: 0.5rem;
            margin-bottom: 0rem;
            border: 1px solid transparent;
            border-top-color: transparent;
            border-right-color: transparent;
            border-bottom-color: transparent;
            border-left-color: transparent;
            border-radius: .25rem;
        }

        dl,
        ol,
        ul {
            margin-top: 0;
            margin-bottom: 0rem;
        }
    </style>
@endpush
@section('content')
    <div class="wire-form">
        @php
            // dikumpulkan dan ditambah # didepannya, untuk dijadikan id di js
            $_multiple = $_select = [];
        @endphp
        <div wire:loading class="wire-loading text-warning">
            <span class="fa fa-spin fa-spinner "></span> Sedang memproses...
        </div>
        <div class="col-8">
            <h5 class="mt-4 mb-2">Tambah Produk</h5>
            {{-- $table->char('produk_id', 5)->primary();
            $table->string('nama_produk', 20);
            $table->integer('harga_beli');
            $table->integer('harga_jual');
            $table->integer('stok_awal');
            $table->integer('stok_akhir');
            $table->integer('produk_terjual');
            $table->integer('keuntungan');
            $table->enum('kategori_produk', ['F', 'D']);
            $table->integer('lama_kadaluarsa'); --}}
            <form action="{{ url('admin/produk/store') }}" name="form" id="form" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label>Alternative Name</label>
                        <input type="text" class="form-control" id="produk_id" name="produk_id"
                            value="{{ old('produk_id') }}">
                    </div>
                    <div class="form-group col-lg-8">
                        <label>Nama Produk</label>
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk"
                            value="{{ old('nama_produk') }}" maxlength="20">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label>Harga Beli</label>
                        <input type="text" class="form-control" id="harga_beli" name="harga_beli"
                            value="{{ old('harga_beli') }}" maxlength="20"
                            oninput="formatCurrency(this); calculateProfit();">
                    </div>
                    <div class="form-group col-lg-4">
                        <label>Harga Jual</label>
                        <input type="text" class="form-control" id="harga_jual" name="harga_jual"
                            value="{{ old('harga_jual') }}" maxlength="20"
                            oninput="formatCurrency(this); calculateProfit();">
                    </div>
                    <div class="form-group col-lg-4">
                        <label>Keuntungan Per Item</label>
                        <input type="text" class="form-control" id="keuntungan" name="keuntungan" readonly
                            value="{{ old('keuntungan') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label>Stok Awal</label>
                        <input type="text" class="form-control" id="stok_awal" name="stok_awal"
                            value="{{ old('stok_awal') }}" maxlength="20">
                    </div>
                    <div class="form-group col-lg-6">
                        <label>Stok Akhir</label>
                        <input type="text" class="form-control" id="stok_akhir" name="stok_akhir"
                            value="{{ old('stok_akhir') }}" maxlength="20">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label>Kategori Produk</label>
                        <select class="form-control" name="kategori_produk">
                            <option selected>--Silahkan Pilih--</option>
                            <option value="F">Food</option>
                            <option value="D">Drink</option>
                        </select>
                    </div>

                    </select>
                    <div class="form-group col-lg-6">
                        <label>Tanggal Kadaluarsa</label>
                        <input type="date" class="form-control" id="tgl_kadaluarsa" name="tgl_kadaluarsa"
                            value="{{ old('tgl_kadaluarsa') }}">
                    </div>
                    {{-- <div class="form-group col-lg-6">
                        <label>Tanggal Kadaluarsa</label>
                        <input type="text" class="form-control" id="tgl_kadaluarsa" name="tgl_kadaluarsa" readonly
                            value="{{ old('tgl_kadaluarsa') }}">
                    </div> --}}
                </div>

        </div>
        <!-- /.card-body -->
        <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection

@push('js')
    <script>
        function formatCurrency(input) {
            // Menghilangkan karakter "Rp" dan titik ribuan, kemudian mengganti koma dengan titik desimal
            var value = input.value.replace('Rp ', '').replace(/\./g, '').replace(',', '.');

            // Mengatur format sebagai mata uang (Rp) dengan pemisahan ribuan
            input.value = 'Rp ' + parseFloat(value).toLocaleString('id-ID');
        }

        function calculateProfit() {
            var hargaBeliInput = document.getElementById('harga_beli');
            var hargaJualInput = document.getElementById('harga_jual');
            var keuntunganInput = document.getElementById('keuntungan');

            var hargaBeli = parseFloat(hargaBeliInput.value.replace('Rp ', '').replace(/\./g, '').replace(',', '.'));
            var hargaJual = parseFloat(hargaJualInput.value.replace('Rp ', '').replace(/\./g, '').replace(',', '.'));

            if (!isNaN(hargaBeli) && !isNaN(hargaJual)) {
                var profit = hargaJual - hargaBeli;
                keuntunganInput.value = 'Rp ' + profit.toLocaleString('id-ID');
            } else {
                keuntunganInput.value = '';
            }
        }
    </script>
@endpush
