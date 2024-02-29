@extends('layout.presensi');
@section('header')

    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBacc">
                <ion-icon name="chevron-bacc-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Request</div>
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
                <div class="table-responsive">
                    <table class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Jenis</th>
                                <th class="text-center">Bahan</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($req as $k)
                                <tr>
                                    <td class="text-center" width="5px">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $k->jenis }}</td>
                                    <td class="text-center">{{ $k->bahan }}</td>
                                    <td class="text-center">
                                        @if ($k->status == 0)
                                            <button class="btn btn-warning btn-sm">pending</button>
                                        @elseif ($k->status == 1)
                                            <button class="btn btn-success btn-sm"> Verified</button>
                                        @elseif ($k->status == 2)
                                            <button class="btn btn-danger btn-sm"> Denied</button>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                        <form action="/req/{{ $k->req_id }}/deleteS" method="POST" style="margin-left: 5px;">
                                            @csrf
                                            <a class="btn btn-danger btn-sm btnEdit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eraser" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M19 20h-10.5l-4.21 -4.3a1 1 0 0 1 0 -1.41l10 -10a1 1 0 0 1 1.41 0l5 5a1 1 0 0 1 0 1.41l-9.2 9.3"></path>
                                                <path d="M18 13.3l-6.3 -6.3"></path>
                                                </svg>
                                            </a>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="fab-button animate bottom-right dropdown" style="margin-bottom: 70px;">
    <a href="/addreq" class="fab bg-success" >
        <ion-icon name="add-outline" role="img" class="md hydrated"></ion-icon>
    </a>
</div>

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

    });


</script>
@endpush
