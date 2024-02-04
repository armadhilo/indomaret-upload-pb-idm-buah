<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>REKAP ORDER</title>
    <style>
        body{
            font-family: sans-serif;
        }
        table{
            width: 100%;
        }
        table th{
            font-size: 11px;
            background: #e9e7e7;
        }
        table td{
            font-size: 9px;
        }
        p{
            font-size: .7rem;
            font-weight: 400;
            margin: 0;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        }
        .italic {
            font-style: italic;
        }

        .inline-block-content > *{
            display: inline-block;
        }

        .title > *{
            text-align: center;
        }

        .body{
            margin-top: 20px;
        }

        .text-center{
            text-align: center;
        }

        .page-number:before {
            content: counter(page);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div style="width: 100%">
            <div class="header">
                <div style="float: left;">
                    <p style="font-size: .8rem;"><b>{{ $namaCabang }}</b></p>
                </div>
                <div style="float: right">
                    <p>Tanggal : {{ \Carbon\Carbon::now()->format('d-m-Y') . ' | Pukul :  ' . \Carbon\Carbon::now()->format('H.i.s') }}</p>
                    <p style="text-align: right;"> Hal : <span class="page-number"></span></p>
                </div>
                <hr style="margin-top: 40px">
            </div>

            <div class="body">
                <p style="text-align: center"><b>REKAP ORDER PER DIVISI</b></p>
                <div style="margin: 0 30px 35px 30px">
                    <div style="float: left">
                        <p>Toko : {{$namaToko}} ({{$kodeToko}})</p>
                        <p>No. Order : 99999 (Dummy)</p>
                    </div>
                    <div style="float: right">
                        <p>Tgl : {{$tglPb}}</p>
                    </div>
                </div>
                <table border="1" style="border-collapse: collapse; margin-top:20px" cellpadding="2">
                    <thead>
                        <tr>
                            <th style="width: 4%">No</th>
                            <th colspan="2">DIVISI</th>
                            <th>ITEM</th>
                            <th>NILAI</th>
                            <th>PPN</th>
                            <th>SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $total_item = 0;
                            $total_nilai = 0;
                            $total_ppn = 0;
                            $total_subtotal = 0;
                        @endphp

                        @foreach ($data as $item)

                            @php
                                $total_item += $item->item;
                                $total_nilai += $item->nilai;
                                $total_ppn += $item->ppn;
                                $total_subtotal += $item->subtotal;
                            @endphp

                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td colspan="2">{{ $item->namadivisi }}</td>
                                <td class="text-center">{{ (int)$item->item }}</td>
                                <td class="text-center">{{ number_format($item->nilai,0,',','.'); }}</td>
                                <td class="text-center">{{ number_format($item->ppn,0,',','.'); }}</td>
                                <td class="text-center">{{ number_format($item->subtotal,0,',','.'); }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align: right"><b>TOTAL TRANSFER : &nbsp;</b></td>
                            <td class="text-center">{{ $total_item }}</td>
                            <td class="text-center">{{ number_format($total_nilai,0,',','.'); }}</td>
                            <td class="text-center">{{ number_format($total_ppn,0,',','.'); }}</td>
                            <td class="text-center">{{ number_format($total_subtotal,0,',','.'); }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $text = "page {PAGE_NUM} / {PAGE_COUNT}";
            $size = 10;
            $font = $fontMetrics->getFont("Verdana");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 35;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
</body>
</html>
