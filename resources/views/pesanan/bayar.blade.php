@extends('layout.presensi')

@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
<style>
    .datepicker-modal{
        max-height: 370px !important;
    }

    .datepicker-date-display{
        background-color: #0f3a7e !important;
    }
</style>
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Pembayaran</div>
        <div class="right"></div>
    </div>

@endsection

@section('content')
    <div class="row" style="margin-top: 4rem;">
        <div class="col">
            <form action="/addPembayaran" method="POST" id="frmizin" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" value="No Antrian : {{ $bayar->no_antrian }}" readonly>
                    <input type="hidden" name="pesanan_id" value="{{ $bayar->pesanan_id }}">
                </div>
                <div class="form-group">
                    <select name="metode_bayar" id="metode_bayar" class="form-control" required>
                        <option value="">Pilih Metode Bayar</option>
                        <option value="Transfer Bank">Transfer Bank - BRI 402801010849535 an. Dewi Septiani</option>
                        <option value="Cash Di Tempat">Cash Di Tempat</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for=""><b>Total Pembayaran</b></label>
                    <input type="text" name="total_bayar" value="{{ $total }}" class="form-control" readonly>
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
                <div class="form-group">
                    <button class="btn btn-success w-100">Kirim</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('myscript')
    <script>

        $(document).ready(function() {


            $("#frmizin").submit(function() {
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
