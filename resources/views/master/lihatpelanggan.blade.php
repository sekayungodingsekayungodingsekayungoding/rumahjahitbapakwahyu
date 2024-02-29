@extends('layout.admin.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
    <div class="row g-2 align-items-center">
        <div class="col">
        <!-- Page pre-title -->
        <h2 class="page-title">
            Kelola Pesanan {{ $pel->nama_pelanggan }}
        </h2>
        </div>
        <!-- Page title actions -->
    </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                              <td rowspan="5">
                                  @php
                                      $path = Storage::url('uploads/pelanggan/'.$pel->foto_pelanggan);
                                  @endphp
                                  <img src="{{ url($path) }}" alt="" width="100px" height="150px">
                              </td>
                          </tr>
                          <tr>
                              <td>Nama Pelanggan</td>
                              <td>{{ $pel->nama_pelanggan }}</td>
                          </tr>
                          <tr>
                              <td>No HP</td>
                              <td>{{ $pel->no_hp }}</td>
                          </tr>
                          <tr>
                              <td>Alamat</td>
                              <td>{{ $pel->alamat }}</td>
                          </tr>
                          <tr>
                              <td>No Hp</td>
                              <td>{{ $pel->no_hp }}</td>
                          </tr>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row mt-2">
                            <div class="col-12">
                                <form action="/master/pesanan" method="GET">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <input type="text" name="no_antrian" id="alamat" value="{{ Request('no_antrian') }}"  class="form-control" placeholder="No antrian">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                    <path d="M21 21l-6 -6"></path>
                                                    </svg>Cari
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-responsive">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Desain</th>
                                                <th class="text-center">Jenis Jahitan</th>
                                                <th class="text-center">Jumlah</th>
                                                <th class="text-center">Bahan</th>
                                                <th class="text-center">No Antrian</th>
                                                <th class="text-center">Tanggal Pesan</th>
                                                <th class="text-center">Tanggal Kirim</th>
                                                <th class="text-center">Status. Pesanan</th>
                                                <th class="text-center">Bukti</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pesanan as $k)
                                            <?php
                                                $bayar = DB::table('tb_pembayaran')->where('pesanan_id', $k->pesanan_id)->first();
                                                if ($bayar ==null) {
                                                    $path = null;
                                                }else {
                                                    $path = Storage::url('uploads/bukti_bayar/'.$bayar->bukti_bayar);
                                                }
                                                
                                                $desain = DB::table('tb_desain')->where('pesanan_id', $k->pesanan_id)->first();
                                                if ($desain ==null) {
                                                    $path1 = null;
                                                    $file = null;
                                                }else {
                                                    $path1 = Storage::url('uploads/desain/'.$desain->file_desain);
                                                    $file = asset('storage/uploads/desain/'.$desain->file_desain);
                                                }
                                            ?>
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration + $pesanan->firstItem()-1 }}</td>
                                                    <td class="text-center">
                                                        @if (empty($desain->file_desain))
                                                        <button class="btn btn-warning btn-sm">Not Design</button>
                                                        @else
                                                        <img src="{{ url($path1) }}" width="50px" class="avatar" alt="">
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{ $k->jenis_jahitan }}</td>
                                                    <td class="text-center">{{ $k->jumlah }}</td>
                                                    <td class="text-center">{{ $k->bahan}}</td>
                                                    <td class="text-center">{{ $k->no_antrian }}</td>
                                                    <td class="text-center">{{ $k->tgl_pemesanan }}</td>
                                                    <td class="text-center">
                                                        @if ($k->tgl_kirim == null)
                                                            <button class="btn btn-danger btn-sm">on progress</button>
                                                        @else
                                                            <button class="btn btn-success btn-sm">{{ $k->tgl_kirim }}</button>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($k->status_pesanan == 0)
                                                            <button class="btn btn-danger btn-sm">Not Verified</button>
                                                        @else
                                                            <button class="btn btn-success btn-sm"> Verified</button>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if (empty($bayar->bukti_bayar))
                                                        COD
                                                        @else
                                                        <img src="{{ url($path) }}" width="50px" class="avatar" alt="">
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group">
                                                            <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editpesanan{{ $k->pesanan_id }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                                <path d="M16 5l3 3"></path>
                                                                </svg>Set
                                                            </a>
                                                            @if (empty($desain->file_desain))
                                                            <button class="btn btn-success btn-sm">Not Design</button>
                                                            @else
                                                            <a href="{{ $file }}" class="btn btn-success btn-sm" download>
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
                                                                Cetak Desain</a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div><br>
                                {{ $pesanan->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@foreach ($pesanan as $k)
<div class="modal modal-blur fade" id="editpesanan{{ $k->pesanan_id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Edit Data pesanan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/pesanan/{{ $k->pesanan_id }}/editStatus" method="POST" id="frpesanan">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-barcode" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M4 7v-1a2 2 0 0 1 2 -2h2"></path>
                                <path d="M4 17v1a2 2 0 0 0 2 2h2"></path>
                                <path d="M16 4h2a2 2 0 0 1 2 2v1"></path>
                                <path d="M16 20h2a2 2 0 0 0 2 -2v-1"></path>
                                <path d="M5 11h1v2h-1z"></path>
                                <path d="M10 11l0 2"></path>
                                <path d="M14 11h1v2h-1z"></path>
                                <path d="M19 11l0 2"></path>
                                </svg>
                            </span>
                            <input type="date" value="{{ $k->tgl_kirim }}" name="tgl_kirim" class="form-control" placeholder="Tanggal kirim" id="tgl_kirim" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <select name="status_pesanan" id="status_pesanan" class="form-control" required>
                                <option value="{{ $k->status_pesanan }}">{{ $k->status_pesanan == 1 ? 'Selesai' : 'Belum Selesai' }}</option>
                                <option value="1">Selesai</option>
                                <option value="0">Belum Selesai</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <div class="form-group">
                            <button class="btn btn-primary w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 14l11 -11"></path>
                                <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5"></path>
                                </svg>
                            Edit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>
@endforeach
@endsection
