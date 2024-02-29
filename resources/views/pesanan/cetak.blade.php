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
    padding: 4px;
    background: #dbdbdb;
  }

  .presensi tr td{
    padding: 5px;
    font-size: 12px;
  }
  </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A5">
  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">

    <table style="width: 100%;">
        <tr>
            <td style="width: 30px;"><img src="{{ asset('assets/img/icon/i.png') }}" width="100px" height="100px" alt=""></td>
            <td><span id="h3">
                CETAK STRUK <br>
                CV. RUMAH JAHIT BAPAK WAHYU<br>
                </span>
                <span><i>Jalan Raya Sindangkasih No 117, Kecamatan Sindangkasih Kabupaten Ciamis, jawa Barat</i></span>
            </td>
        </tr>
        
    </table>
    =======================================================
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Produk Jasa Jahit Terpercaya&nbsp;
        =======================================================
    <table class="tblkaryawan">
        @foreach ($metode as $karyawan)
        <tr>
          <td rowspan="6">
              @php
                  $path = Storage::url('uploads/pelanggan/'.$karyawan->foto_pelanggan);
              @endphp
              <img src="{{ url($path) }}" alt="" width="50px" height="75px">
          </td>
      </tr>
      <tr>
          <td>Nama Pelanggan</td>
          <td>:</td>
          <td>{{ $karyawan->nama_pelanggan }}</td>
      </tr>
      <tr>
          <td>No HP</td>
          <td>:</td>
          <td>{{ $karyawan->no_hp }}</td>
      </tr>
      <tr>
          <td>Alamat</td>
          <td>:</td>
          <td>{{ $karyawan->alamat }}</td>
      </tr>
      <tr>
          <td>No Hp</td>
          <td>:</td>
          <td>{{ $karyawan->no_hp }}</td>
      </tr>
        @endforeach
    </table>

    <table class="presensi" style="width: 100%">
      <tr>
        <th>No</th>
        <th>No Antrian</th>
        <th>No Pesanan</th>
        <th>Metode Bayar</th>
        <th>Bukti</th>
        <th>Total</th>
      </tr>
      <?php
          $total = 0;
          $bayar = 0;
      ?>
      @foreach ($metode as $k)
          <?php
              $path = Storage::url('uploads/bukti_bayar/'.$k->bukti_bayar);
              $bayar = $k->total_bayar;
              $total += $bayar;
          ?>
          <tr>
              <td width="5px">{{ $loop->iteration }}</td>
              <td style="text-align: center">{{ $k->no_antrian }}</td>
              <td style="text-align: center">{{ $k->pesanan_id }}</td>
              <td style="text-align: center">{{ $k->metode_bayar }}</td>
              <td style="text-align: center">
                  @if (empty($k->bukti_bayar))
                  -
                  @else
                  <img src="{{ url($path) }}" width="50px" class="avatar" alt="">
                  @endif
              </td>
              <td style="text-align: center">{{ currency_IDR($k->total_bayar) }}</td>
          </tr>
      @endforeach
      ------------------------------------------------------------------------------------------
      <tr style="border: 1px solid #000">
          <td style="text-align: right" colspan="5">Total bayar</td>
          <td style="text-align: center">{{ currency_IDR($total) }}</td>
      </tr>
    </table>
    <table style="width: 100%; margin-top: 10px">
      <tr>
        <td style="text-align: center">SELAMAT BERBELANJA KEMBALI</td>
      </tr>
      <tr>
        <td style="text-align: center">NIKMATI DAN TUNGGU HARGA SPESIAL UNTUK ANDA</td>
      <tr>
        <br>
        <br>
    </table>
    =======================================================
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Terima Kasih Atas Kepercayaan Anda&nbsp;
        =======================================================
  </section>
<script>
  window.print()
</script>
</body>

</html>