<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Cetak Laporan</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>
  @page { size: A4 }
  #h3{
    font-family: Arial, Helvetica, sans-serif;
    font-size: 18px;
    font-weight: bold;
  }
  .tblkaryawan{
    margin-top: 10px;
  }

  .tblkaryawan td {
    padding: 2px;
  }

  .presensi{
    width: 50%;
    margin-top: 20px;
    border-collapse: collapse;
  }

  .presensi tr th{
    border: 1px solid #000;
    padding: 4px;
    background: #dbdbdb;
  }

  .presensi tr td{
    border: 1px solid #000;
    padding: 5px;
    font-size: 12px;
  }
  </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4">
  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">

    <table style="width: 100%;">
        <tr>
            <td style="width: 30px;"><img src="{{ asset('assets/img/icon/i.png') }}" width="100px" height="100px" alt=""></td>
            <td><span id="h3">
                LAPORAN PERIODE {{ strtoupper($namabulan[$bulan]) }} {{ $tahun }} <br>
                CV. RUMAH JAHIT BAPAK WAHYU<br>
                </span>
                <span><i>Jalan Raya Sindangkasih No 117, Kecamatan Sindangkasih Kabupaten Ciamis, jawa Barat</i></span>
            </td>
        </tr>

    </table>

    <table class="presensi" style="width:100%">
        <thead>
            <tr>
                <th class="text-center">No Antrian</th>
                <th class="text-center">Jenis Jahit</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Bahan</th>
                <th class="text-center">Tanggal Pesan</th>
                <th class="text-center">Tanggal Kirim</th>
                <th class="text-center">Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $total_bayar = 0;
                $jml_bayar = 0;
                $jml=0;
            ?>
            @foreach ($mypes as $k)
                <?php
                    $bayar = DB::table('tb_pembayaran')->where('pesanan_id', $k->pesanan_id)->first();
                    $total_bayar = $bayar->total_bayar;
                    $jml_bayar += $total_bayar;
                    if ($bayar ==null) {
                        $path = null;
                    }else {
                        $path = Storage::url('uploads/bukti_bayar/'.$bayar->bukti_bayar);
                    }


                    $desain = DB::table('tb_desain')->where('pesanan_id', $k->pesanan_id)->first();
                    if ($desain ==null) {
                        $path1 = null;
                    }else {
                        $path1 = Storage::url('uploads/desain/'.$desain->file_desain);
                    }
                ?>
                <tr>
                    <td style="text-align: center">{{ $k->no_antrian }}</td>
                    <td style="text-align: center">{{ $k->jenis_jahitan }}</td>
                    <td style="text-align: center">{{ $k->jumlah }}</td>
                    <td style="text-align: center">{{ $k->bahan }}</td>
                    <td style="text-align: center">{{ $k->tgl_pemesanan }}</td>
                    <td style="text-align: center">
                        @if ($k->tgl_kirim == null)
                            <button class="btn btn-danger btn-sm">on progress</button>
                        @else
                            <button class="btn btn-success btn-sm">{{ $k->tgl_kirim }}</button>
                        @endif
                    <td style="text-align: center">{{ currency_IDR($bayar->total_bayar) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="6" style="text-align: right">Pendapatan</td>
                <td style="text-align: center">{{ currency_IDR($jml_bayar) }}</td>
            </tr>
        </tbody>
    </table>
  </section>
<script>
  window.print()
</script>
</body>

</html>
