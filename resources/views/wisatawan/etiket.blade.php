<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @php
        $debug = $debug ?? false;
        // $logo = pathpdf('/img/logo_proposal.png', $debug);
    @endphp
    <title>E tiket </title>
    @include('layout.pdf_style')
    <style>
        body {
            font-size: 16px;
            line-height: 1.2;
        }

        .h3 {
            font-family: 'Calibri', sans-serif;
        }

        .h4 {
            font-family: 'Calibri', sans-serif;
        }

        .h5 {
            font-family: 'Calibri', sans-serif;
        }

        .h6 {
            font-family: 'Calibri', sans-serif;
        }

        .text-raw p {
            margin: 0;
            line-height: 1;
        }

        .barcode {
            text-align: right !important;
        }

        @page {
            margin: 60px 100px 10px;
        }

        .border-outline tr:first-child th {
            border-top: 2px solid #5b5757 !important;
        }

        .border-outline tr:last-child td,
        .border-outline .border-bottom td {
            border-bottom: 2px solid #5b5757 !important;
        }

        .border-outline tr th:first-child,
        .border-outline tr td:first-child {
            border-left: 2px solid #5b5757 !important;
        }

        .border-outline tr th:last-child,
        .border-outline tr td:last-child {
            border-right: 2px solid #5b5757 !important;
        }
    </style>
</head>

<body>
    <div class="page">
        <div class="">
            <div class="header header-tall">
                <table class="table table-condensed no-border" style="width:100%;height:auto">
                    <tr>
                        <td style="width:50%">
                            <table class="table no-border table-condensed">
                                <tr>
                                    <td style="width:2.2cm">
                                        <div style="margin-bottom: 20px;">
                                            {{-- <img src="{{ $logo }}" alt="RouteLINK" style="height:65px"><br> --}}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:50%">
                            <table class="table no-border table-condensed">
                                <tr>
                                    <td style="width:40%" class="text-right">
                                        <span style="font-size: 1em; font-weight:bold">Travel GK</span><br>
                                        {{-- <span style="font-size: 1em; font-weight:bold">Cabang
                                            {{ $invoice->to_payment->customer->company->name ?? null }}</span><br>
                                        {{ Str::title($invoice->to_payment->customer->company->address ?? null) }},
                                        {{ $invoice->to_payment->customer->company->kecamatan->nama ?? null }}
                                        {{ $invoice->to_payment->customer->company->kecamatan->kabupaten->nama ?? null }}
                                        <br>
                                        {{ $invoice->to_payment->customer->company->kecamatan->kabupaten->provinsi->nama ?? null }}
                                        @if ($invoice->to_payment->customer->company->postal_code ?? null)
                                            &mdash;
                                            {{ $invoice->to_payment->customer->company->postal_code }}
                                        @endif --}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <hr>
            <br>
            <div class="body" style="margin-top:0">
                <div style="text-align: center;">
                    <span style="font-size: 1.6em; font-weight:bold">E tiket</span> <br>
                    <strong style="font-size: 1.2em; font-weight:bold">TRX00000{{ $pesanan->id }}</strong>

                </div>

                <p>Telah Diterima</p>
                <table class="table" width="100%">
                    <tr>
                        <th width=21%>Dari</th>
                        <td>{{ $pesanan->user->name ?? null }}</>
                    </tr>
                    <tr>
                        <th>Sebesar</th>
                        <td>Rp. {{ nominal($pesanan->pembayaran->jumlah_pembayaran) ?? null }}</>

                    </tr>

                    <tr>
                        <th>Terbilang</th>
                        <td>{{ terbilang($pesanan->pembayaran->jumlah_pembayaran) ?? null }}</>

                    </tr>
                </table>
                <p>Dengan Rincian Pesanan</p>
                <table class="table" width="100%">

                    <tr>
                        <td>Tanggal-Jam</td>
                        <td>{{ tgl($pesanan->tanggal) }} {{ $pesanan->jam }}</td>
                    </tr>
                    <tr>
                        <td>Travel</td>
                        <td>{{ $pesanan->travel->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Sopir</td>
                        <td>{{ $pesanan->travel->sopir->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah Wisatawan</td>
                        <td>{{ $pesanan->jumlah_wisatawan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Harga Travel</td>
                        <td>{{ nominal($pesanan->travel->harga) ?? '-' }}</td>
                    </tr>
                </table>
                <p>Dengan Rincian Objek Wisata + Biaya Travel</p>
                <table class="table" width="100%">
                    @php
                        $total_biaya_masuk = 0;
                    @endphp
                    @foreach ($pesanan->objek_wisata as $item)
                        @php
                            $subtotal_biaya_masuk = $item->biaya_masuk * $pesanan->jumlah_wisatawan;
                            $total_biaya_masuk += $subtotal_biaya_masuk;
                        @endphp
                        <tr>
                            <td scope="col">{{ $item->nama }}</td>
                            <td scope="col">{{ nominal($item->biaya_masuk) }} X
                                {{ $pesanan->jumlah_wisatawan }}</td>
                            <td style="text-align: right" scope="col">
                                {{ nominal($item->biaya_masuk * $pesanan->jumlah_wisatawan) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="2">Total dibayarkan</th>
                        <th style="text-align: right">
                            {{ nominal($total_biaya_masuk + $pesanan->travel->harga) }}</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>



</body>

</html>
