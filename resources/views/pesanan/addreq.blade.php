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
        <div class="pageTitle">Add Request</div>
        <div class="right"></div>
    </div>

@endsection

@section('content')
    <div class="row" style="margin-top: 4rem;">
        <div class="col">
            <form action="/addRequest" method="POST" id="frmizin">
                @csrf
                <div class="form-group">
                    <input type="text" name="jenis" id="jenis" placeholder="Jenis" class="form-control">
                </div>
                <div class="form-group">
                    <input type="text" name="bahan" id="bahan" placeholder="bahan" class="form-control">
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
            var jenis = $("#jenis").val();
            var bahan = $("#bahan").val();


            if(jenis == ""){
                Swal.fire({
                title: 'Oops!',
                text: "jenis harus diisi!!",
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
