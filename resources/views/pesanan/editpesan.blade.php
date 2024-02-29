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
        <div class="pageTitle">Edit Pesan Jahit</div>
        <div class="right"></div>
    </div>

@endsection

@section('content')
    <div class="row" style="margin-top: 4rem;">
        <div class="col">
            <form action="/pesanan/{{ $pesan->pesanan_id }}/edit" method="POST" id="frmizin">
                @csrf
                <div class="form-group">
                    <input type="text" value="{{ $pesan->tgl_pemesanan }}" class="form-control datepicker" placeholder="Tanggal" id="tgl_pemesanan" name="tgl_pemesanan">
                </div>
                <div class="form-group">
                    <select name="jenis_id" id="jenis_id" class="form-control">
                        @foreach ($jenis as $j)
                            <option value="{{ $j->jenis_id }}" {{$pesan->jenis_id == $j->jenis_id ? 'selected' : ''}}>{{ $j->jenis_jahitan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" value="{{ $pesan->jumlah }}" name="jumlah" id="jumlah" placeholder="Jumlah" class="form-control">
                </div>
                <div class="form-group">
                <select name="bahan" id="bahan" class="form-control">
                        @foreach ($bahan as $b)
                            <option value="{{ $b->bahan_id }}" {{ ($pesan->bahan == $b->bahan_id ? 'selected' : '') }}>{{ $b->bahan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" value="{{ $pesan->ukuran }}" name="ukuran" id="ukuran" placeholder="ukuran S/M/L/XL/XXL/XXXL" class="form-control">
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
        var currYear = (new Date()).getFullYear();

        $(document).ready(function() {
        $(".datepicker").datepicker({
            format: "yyyy-mm-dd"
        });

        $("#tgl_pemesanan").change(function(){
            var tgl_pemesanan = $(this).val();
            $.ajax({
                type: 'POST',
                url: '/presensi/cekpengajuan',
                data: {
                    _token:"{{  csrf_token()  }}",
                    tgl_pemesanan: tgl_pemesanan
                },
                cache: false,
                success: function(respond){
                    if(respond==1){
                        Swal.fire({
                        title: 'Oops!',
                        text: "Tanggal Hari Ini Sudah Diisi!!",
                        icon: 'warning',
                        }).then((result) => {
                            $("#tgl_pemesanan").val("");
                        });
                    }
                }
            });
        });

        $("#frmizin").submit(function() {
            var tglizin = $("#tgl_pemesanan").val();
            var jenis_id = $("#jenis_id").val();
            var jumlah = $("#jumlah").val();
            var bahan = $("#bahan").val();


            if(tglizin == ""){
                Swal.fire({
                title: 'Oops!',
                text: "Tanggal harus diisi!!",
                icon: 'warning',
                });
                return false;
            }else if(jenis_id == ""){
                Swal.fire({
                title: 'Oops!',
                text: "Jenis harus diisi!!",
                icon: 'warning',
                });
                return false;
            }else if(jumlah == ""){
                Swal.fire({
                title: 'Oops!',
                text: "jumlah harus diisi!!",
                icon: 'warning',
                });
                return false;
            }else if(bahan == ""){
                Swal.fire({
                title: 'Oops!',
                text: "bahan harus diisi!!",
                icon: 'warning',
                });
                return false;
            }
        });
        });

    </script>
@endpush
