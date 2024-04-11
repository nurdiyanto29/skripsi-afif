@extends('layout.admin')

@push('css')
    <style>
        .mt-4,
        .my-4 {
            margin-top: 1rem !important;
        }

        .select2-selection {
            height: 37px !important;

        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #007bff;
            border-color: #006fe6;
            color: #000;
            padding: 0 10px;
            margin-top: 0.31rem;
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

        .invoice {
            background-color: transparent !important;
            border: 0px solid rgba(0, 0, 0, .125);
            position: relative;
        }

        .floating-label {
            position: absolute;
            pointer-events: none;
            left: 10px;
            top: 10px;
            transition: 0.2s ease all;
        }

        .form-control:focus+.floating-label,
        .form-control:not(:placeholder-shown)+.floating-label {
            top: -10px;
            left: 10px;
            font-size: 14px;
            background-color: #e9ecef;
            padding: 2px 5px;
            border-radius: 20%;
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
        <div class="col-12">
            <h5 class="mt-4 mb-2">Penjualan {{$no_penjualan}}</h5>

            <div class="row invoice-info">
                <div class="col-lg-12">
                    <form action="{{route('admin.penjualan.store')}}" onsubmit="return kirim()" name="form" id="form" method="post"
                        enctype="multipart/form-data">
                        <div class="section-body">
                            <div class="invoice">
                                @csrf
                                @method('POST')
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <select class="form-control inpt" id="produk_id" name="idd"
                                                        style="width: 100%">
                                                        <option selected>Pilih Barang</option>
                                                        @foreach ($produk as $val)
                                                            <option value={{ $val->produk_id }}>{{ $val->nama_produk }}
                                                                ({{ $val->produk_id }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <input type="hidden" class="form-control" id="nama_produk">
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <input type="text" class="form-control" id="stok" disabled
                                                            >
                                                        <label class="floating-label" for="nama">Stok Tersedia</label>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <input type="text" class="form-control" id="harga" disabled
                                                            >
                                                        <label class="floating-label" for="nama">Harga Satuan</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control inpt" id="jumlah"
                                                        maxlength="11" placeholder="jumlah">
                                                </div>
                                                <button type="button" class="btn btn-primary btn-xs btn-block" id="tambah">Tambah</button>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="table-responsive">
                                                    <table class="table table-striped" style="" id="list-inv">
                                                        <thead style="height: 10px">
                                                            <tr>
                                                                <th>Nama Produk</th>
                                                                <th>Jumlah</th>
                                                                <th>Harga @</th>
                                                                <th>Total Harga</th>
                                                                <th><i class="fas fa-cog"></i></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody style="height: 20px;" class="incTbl">
                                                        </tbody>
                                                    </table>
                                                </div>
                                                
                                                <div class="col-sm-12">
                                                    <button type="submit"  class="btn btn-primary btn-sm">Simpan</button>
                                                    <a href="">Kembali</a>
                                                </div>


                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                           
                    </form>
                </div>
            </div>
        </div>
        <!-- /.card-body -->

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



        $(document).ready(function() {
            $('#produk_id').select2();
            $('#produk_id').on('change', function() {
                $("#stok").val("");
                $("#harga").val("");
                let id = $(this).val();
                $.ajax({
                    type: 'GET',
                    url: '/admin/produk/cek/' + id,
                    success: function(response) {
                        var response = JSON.parse(response);
                        console.log(response);
                        response.forEach(element => {
                            $('#stok').val(
                                `${element['stok_akhir']}`
                            );
                            $('#harga').val(
                                `${element['harga_jual']}`
                            );
                            $('#nama_produk').val(
                                `${element['nama_produk']}`
                            );

                        });
                    }
                });
            });

            $('#tambah').on('click', function() {
                var produk_id = $('#produk_id').val();

                var jumlah = parseInt($('#jumlah').val());
                var stok = parseInt($('#stok').val());
                
                var nama_produk = $('#nama_produk').val();

                var harga = $('#harga').val();

                var cek = jumlah <= stok ? true : false;

                if (jumlah && produk_id && cek) {
                    $('input[name=idd]').val("");
                    $('.incTbl').append(`
                        <tr>
                                <td> <input type="hidden" readonly  class="kodein" name="produk_id[]" value="${produk_id}" >${nama_produk} (${produk_id})</td>
                                <td> <input type="hidden" readonly  class="kodein" name="jumlah[]" value="${jumlah}">${jumlah} </td>
                                <td> <input type="hidden" readonly  class="kodein" name="harga[]" value="${harga}">${harga} </td>
                                <td> <input type="hidden" readonly  class="kodein" name="total[]" value="${harga*jumlah}">${harga*jumlah} </td>
                                <td><span class="btn btn-sm btn-warning btn-delete"> <span class="fa fa-trash"></span> </span></td>
                            </tr>`);

                    // $("#id_barang").val("");
                    $("#jumlah").val("");
                    $("#stok").val("");
                    $("#harga").val("");
                    $('#id_barang').val($('select option:first').val()).trigger('change');

                } else {
                    toastr.error("Jumlah Tidak Boleh Melebihi stok");
                    return false;
                }


            });

            $(document).on('click', '.btn-delete', function(event) {
                event.preventDefault();
                let tr = $(this).closest('tr');
                $.confirm({
                    theme: 'material',
                    closeIcon: true,
                    animation: 'none',
                    title: '',
                    content: 'Hapus Data?',
                    buttons: {
                        batal: {},
                        Hapus: {
                            btnClass: 'btn-blue',
                            keys: ['enter', 'shift'],
                            action: function() {
                                tr.remove()
                            }
                        }
                    }
                });

            });
        });





        function kirim() {
            let valid = $('#form').valid();
            if (valid && !$('.kodein').map(function() {
                    return $(this).val();
                }).get().length) {
                $.alert('Barang belum dipilih!');
                return false
            }

            if (valid) {
                $.ajax({
                    url: $('#form').attr('action'),
                    method: 'POST',
                    data: $('#form').serialize(),
                    success: function(response) {
                        if (response.success) {
                            $.confirm({
                                theme: 'material',
                                closeIcon: true,
                                animation: 'none',
                                title: '',
                                content: 'Apakah Anda ingin mencetak nota?',
                                buttons: {
                                    Ya: {
                                        btnClass: 'btn-blue',
                                        keys: ['enter'],
                                        action: function() {
                                            var kodeTransaksi = response.kodeTransaksi;
                                            var url = '/penjualan/nota?kd=' + kodeTransaksi;
                                            window.location.href = url;
                                        }
                                    },
                                    Tidak: {
                                        action: function() {
                                            // Mereset form
                                            data = [];
                                            $('#form')[0].reset();
                                            $('#list-inv tbody').empty();
                                            // Menampilkan modal kembali dengan pesan
                                            $.alert({
                                                theme: 'material',
                                                closeIcon: true,
                                                animation: 'none',
                                                title: '',
                                                content: 'Terima kasih, data berhasil disimpan',
                                                buttons: {
                                                    Ok: {}
                                                },
                                                onClose: function() {
                                                    // Kode yang akan dijalankan setelah modal ditutup
                                                }
                                            });
                                        }

                                    }
                                }
                            });
                        } else {
                            toastr.error('Gagal menyimpan data');
                        }
                    },
                });
            }

            return false;
        }
    </script>
@endpush
