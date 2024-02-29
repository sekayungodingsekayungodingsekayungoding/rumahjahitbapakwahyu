@extends('layout.admin.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
    <div class="row g-2 align-items-center">
        <div class="col">
        <!-- Page pre-title -->
        <h2 class="page-title">
            Data Kelola Pembayaran
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
                        <div class="row">
                            <div class="col-12">

                            @if (Session::get('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                </div>
                            @endif

                            @if (Session::get('error'))
                                <div class="alert alert-error">
                                    {{ Session::get('error') }}
                                </div>
                            @endif
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <form action="/master/pembayaran" method="GET">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <input type="text" name="pesanan_id" id="pesanan_id" value="{{ Request('pesanan_id') }}"  class="form-control" placeholder="pesanan id">
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
                                                <th class="text-center">Id Pesanan</th>
                                                <th class="text-center">Metode Bayar</th>
                                                <th class="text-center">Total Bayar</th>
                                                <th class="text-center">Bukti Bayar</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pembayaran as $k)
                                            @php
                                                $path = Storage::url('uploads/bukti_bayar/'.$k->bukti_bayar);
                                            @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration + $pembayaran->firstItem()-1 }}</td>
                                                    <td>{{ $k->pesanan_id }}</td>
                                                    <td class="text-center">{{ $k->metode_bayar }}</td>
                                                    <td>{{ $k->total_bayar }}</td>
                                                    <td class="text-center">
                                                        @if (empty($k->bukti_bayar))
                                                        TF
                                                        @else
                                                        <img src="{{ url($path) }}" class="avatar" alt="">
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($k->status_bayar == 0)
                                                            <button class="btn btn-danger btn-sm">Not Verified</button>
                                                        @else
                                                            <button class="btn btn-success btn-sm"> Verified</button>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group">
                                                        <form action="/pembayaran/{{ $k->pembayaran_id }}/delete" method="POST" style="margin-left: 5px;">
                                                            @csrf
                                                            <a class="btn btn-danger btn-sm btnEdit">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eraser" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M19 20h-10.5l-4.21 -4.3a1 1 0 0 1 0 -1.41l10 -10a1 1 0 0 1 1.41 0l5 5a1 1 0 0 1 0 1.41l-9.2 9.3"></path>
                                                            <path d="M18 13.3l-6.3 -6.3"></path>
                                                            </svg>Hapus
                                                            </a>
                                                            <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editpembayaran{{ $k->pembayaran_id }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                                <path d="M16 5l3 3"></path>
                                                                </svg>Set
                                                            </a>
                                                        </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div><br>
                                {{ $pembayaran->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


@foreach ($pembayaran as $k)
<div class="modal modal-blur fade" id="editpembayaran{{ $k->pembayaran_id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Edit Data pembayaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/pembayaran/{{ $k->pembayaran_id }}/editSPembayaran" method="POST" id="frpembayaran">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <select name="status_bayar" id="status_bayar" class="form-control" required>
                                <option value="{{ $k->status_bayar }}">{{ $k->status_bayar == 1 ? 'Verified' : 'Not Verified' }}</option>
                                <option value="1">Verified</option>
                                <option value="0">Not Verified</option>
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

@push('myscripct')
    <script>
        $(function(){

            $("#btnTambah").click(function(){
                $("#modal-inputpembayaran").modal("show");
            });

            $(".btnEdit").click(function(e){
                var form = $(this).closest('form');
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah yakin ingin menghapus?',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire('Data Berhasil Di Hapus !!!', '', 'success')
                }
                })
            });

        });


    </script>
@endpush