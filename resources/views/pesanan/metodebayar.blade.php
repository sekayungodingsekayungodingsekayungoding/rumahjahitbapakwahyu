@extends('layout.presensi');
@section('header')

    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBacc">
                <ion-icon name="chevron-bacc-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Pembayaran</div>
        <div class="right"></div>
    </div>
    <style>
        table, th, td
         {

        border
        : 2px solid green;
        }
    </style>
@endsection

@section('content')
<div id="sweetalert" data-pesan="{{session('success')}}"></div>
<div id="pesanan" data-pesanan="{{session('pesanan_id')}}"></div>

<script>
   ;
    let flashData = $("#sweetalert").attr("data-pesan");
    let pesanan = $("#pesanan").attr("data-pesanan");
         if (flashData != '') {
            Swal.fire({
                icon: "success",
                title: "Good Job",
                text: flashData,
                showConfirmButton: false,
                footer: '<a href="/lihatpesanan/'+pesanan+'">Klik Disini Untuk Add Desain!</a>'
            });
         }
</script>
<div class="row" style="margin-top: 3rem;">
    <div class="col">
    @php
        $messagesuccess = Session::get('success');
        $messageerror = Session::get('error');
    @endphp
    @if (Session::get('success'))
        <div class="alert alert-outline-success">
            {{ $messagesuccess }}
        </div>
    @else
        <div class="alert alert-outline-error">
            {{ $messageerror }}
        </div>
    @endif

    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card mt-2">
            <div class="card-body">
                <div class="col-12">
                    <div class="row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-6"></div>
                        <div class="col-sm-2">
                            <form action="/cetak" method="get">
                                <div class="form-group d-flex">
                                    <select name="metode_bayar" id="metode_bayar" class="form-control mr-1" style="width:50px">
                                        <option value="Transfer Bank">TF</option>
                                        <option value="Cash Di Tempat">COD</option>
                                    </select>
                                    <button class="btn btn-danger">Cetak</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="table-responsive" style="overflow-x:auto;">
                    <table class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">No Antrian</th>
                                <th class="text-center">No Pesanan</th>
                                <th class="text-center">Metode Bayar</th>
                                <th class="text-center">Bukti Bayar</th>
                                <th class="text-center">Total Bayar</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
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
                                    <td class="text-center">{{ $k->no_antrian }}</td>
                                    <td class="text-center">{{ $k->pesanan_id }}</td>
                                    <td class="text-center">{{ $k->metode_bayar }}</td>
                                    <td class="text-center">
                                        @if (empty($k->bukti_bayar))
                                        -
                                        @else
                                        <img src="{{ url($path) }}" width="50px" class="avatar" alt="">
                                        @endif
                                    </td>
                                    <td class="text-center">{{ currency_IDR($k->total_bayar) }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                        <form action="/pembayaran/{{ $k->pembayaran_id }}/deleteS" method="POST" style="margin-left: 5px;">
                                            @csrf
                                            <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editmetode{{ $k->pembayaran_id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                <path d="M16 5l3 3"></path>
                                                </svg>
                                            </a>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="5"></td>
                                <td class="text-center">{{ currency_IDR($total) }}</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="fab-button animate bottom-right dropdown" style="margin-bottom: 70px;">
    <a href="/jahit/pesan" class="fab bg-success" >
        <ion-icon name="add-outline" role="img" class="md hydrated"></ion-icon>
    </a>
</div>


@foreach ($metode as $k)
<div class="modal modal-blur fade" id="editmetode{{ $k->pembayaran_id }}" tabindex="-1" metode="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" metode="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Edit Data metode</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/pembayaran/{{ $k->pembayaran_id }}/edit" method="POST" id="frmetode" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <select name="metode_bayar" id="metode_bayar" class="form-control" required>
                        <option value="">Pilih Metode Bayar</option>
                        <option value="Transfer Bank">Transfer Bank - BRI 404301020943537 an. Sumarni</option>
                    </select>
                </div>
                <div class="custom-file-upload" id="fileUpload1">
                    <input type="file" name="bukti_bayar" id="fileuploadInput" accept=".png, .jpg, .jpeg">
                    <label for="fileuploadInput">
                        <span>
                            <strong>
                                <ion-icon name="cloud-upload-outline" role="img" class="md hydrated" aria-label="cloud upload outline"></ion-icon>
                                <i>Tap to Upload</i>
                            </strong>
                        </span>
                    </label>
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

@push('myscript')

<script>
    $(function(){
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
        $("#frmmetode").submit(function(){
            var metode_bayar = $("#metode_bayar").val();
                var bukti_bayar = $("#fileuploadInput").val();

                if(metode_bayar == "Transfer Bank" && bukti_bayar == ""){
                    Swal.fire({
                    title: 'Oops!',
                    text: "Bukti Bayar harus diisi!!",
                    icon: 'warning',
                    });
                    return false;
                }
        });

    });


</script>
@endpush
