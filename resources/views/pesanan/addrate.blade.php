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
        <div class="pageTitle">Add Rate</div>
        <div class="right"></div>
    </div>

@endsection

@section('content')
    <div class="row" style="margin-top: 4rem;">
        <div class="col">
            <form action="/addRating" method="POST" id="frmizin">
                @csrf
                <div class="form-group">
                    <select name="pesanan_id" id="pesanan_id" class="form-control">
                        <option value="">Pilih Pesanan</option>
                        @foreach ($rate as $r)
                            <option value="{{ $r->pesanan_id }}">{{ $r->no_antrian }} / {{ $r->jenis_jahitan }}({{ $r->bahan }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select name="penilaian" id="penilaian" class="form-control">
                        <option value="1">*</option>
                        <option value="2">**</option>
                        <option value="3">***</option>
                        <option value="4">****</option>
                        <option value="5">*****</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" name="komentar" id="komentar" placeholder="Komentar Anda" class="form-control">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary w-100">Kirim</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('myscript')
    <script>

        $(document).ready(function() {


        $("#frmizin").submit(function() {
            var pesanan_id = $("#pesanan_id").val();
            var komentar = $("#komentar").val();


            if(pesanan_id == ""){
                Swal.fire({
                title: 'Oops!',
                text: "Pilih pesanan harus diisi!!",
                icon: 'warning',
                });
                return false;
            }else if(komentar == ""){
                Swal.fire({
                title: 'Oops!',
                text: "Komentar harus diisi !! karena komentar anda sangat berharga bagi pelayanan kami",
                icon: 'warning',
                });
                return false;
            }
        });
        });

    </script>
@endpush
