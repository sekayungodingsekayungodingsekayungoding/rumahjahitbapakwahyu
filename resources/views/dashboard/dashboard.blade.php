@extends('layout.presensi')
@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
        <div class="section" id="user-section">
            <div id="user-detail">
                <div class="avatar">

                    @if (!empty(Auth::guard()->user()->foto_pelanggan))
                    @php
                        $path = Storage::url('public/uploads/pelanggan/'.Auth::guard('buy')->user()->foto_pelanggan);
                    @endphp
                    <img src="{{ url($path) }}" alt="avatar" class="imaged w64 rounded" style="height: 60px;">
                    @else
                    <img src="{{ asset('assets/img/sample/avatar/avatar1.jpg') }}" alt="avatar" class="imaged w32 rounded" style="height: 40px;">
                    @endif 

                </div>
                <div id="user-info">
                    <h2 id="user-name">{{ Auth::guard('buy')->user()->nama_pelanggan }}</h2>
                    <span id="user-role"><b>Users</span>
                </div>
            </div>
        </div>

        <div class="section" id="menu-section">
            <div class="card">
                <div class="card-body text-center">
                    <div class="list-menu">
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="/editprofile" class="green" style="font-size: 40px;">
                                    <ion-icon name="person-sharp"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Profil</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="#" data-toggle="modal" data-target="#modal-daftar-jahit" class="green" style="font-size: 40px;">
                                    <ion-icon name="list-outline"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Daftar Jahitan</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="/req" class="danger" style="font-size: 40px;">
                                    <ion-icon name="archive-outline"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Request Outline</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="/lihatpesanan" class="warning" style="font-size: 40px;">
                                    <ion-icon name="pricetags-outline"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Lihat Pesanan</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="/lihatrate" class="orange" style="font-size: 40px;">
                                    <ion-icon name="star-half-outline"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                Rate ALL
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="/proseslogout" class="danger" style="font-size: 40px;">
                                    <ion-icon name="log-out-outline"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                Logout
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section mt-2" id="presence-section">
            <div class="todaypresence">
                <div class="row">
                    
                </div>
            </div>


            <div class="presencetab mt-2">
                <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                    <ul class="nav nav-tabs style1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                Pesanan Saya
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                Lainnya
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content mt-2" style="margin-bottom:100px;">
                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                        <ul class="listview image-listview">
                            @php
                                $i=1;
                            @endphp
                            @foreach ($mypes as $index => $p)
                                @php
                                    $waiting.$i = $waiting->waiting($p->pesanan_id);
                                @endphp
                                <li>
                                    <div class="item">
                                        <div class="icon-box bg-primary">
                                            @if (!empty(Auth::guard()->user()->foto_pelanggan))
                                            @php
                                                $path = '/storage/uploads/pelanggan/'.Auth::guard('buy')->user()->foto_pelanggan;
                                            @endphp
                                            <img src="{{ url($path) }}" alt="avatar" class="imaged w32 rounded" width="30px" height="30px">
                                            @else
                                            <img src="{{ asset('assets/img/sample/avatar/avatar1.jpg') }}" alt="avatar" class="imaged w32 rounded" style="height: 40px;">
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <div>{{ $p->nama_pelanggan }}</div>
                                            <span class="badge badge-warning">{{ $p->jenis_jahitan }}</span>
                                            @if ($p->tgl_kirim == null && $p->status_pesanan == 0)
                                            <span class="badge badge-danger">Not Verified</span>
                                            <span class="badge badge-info">No Antrian: {{ $p->no_antrian }}</span>
                                            <span class="badge badge-info" class="span-menunggu">Menunggu:&nbsp; <span class="array">{{ $waiting.$i++ }}</span>&nbsp; Pesanan</span>
                                            @elseif($p->tgl_kirim != null && $p->status_pesanan == 0)
                                            <span class="badge badge-success">Verified</span>
                                            <span class="badge badge-info">On Progress</span>
                                            @elseif($p->tgl_kirim != null && $p->status_pesanan == 1)
                                            <span class="badge badge-success">Verified</span>
                                            <span class="badge badge-success">Paket Telah Dikirim</span>
                                            @endif
                                            
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            <script>
                                let array = document.querySelectorAll('.array')
                                array.forEach((a) => {
                                    let split = a.innerHTML.split('[]')
                                    a.innerHTML = split[1]
                                    if(split[1] == '0') {
                                        a.parentElement.innerHTML = `Pesanan Menunggu Di Proses`
                                    }
                                })
                            </script>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel">
                        <ul class="listview image-listview">

                            @foreach ($pes as $p)
                                <li>
                                    <div class="item">
                                        <div class="icon-box bg-primary">
                                            @if (!empty($p->foto_pelanggan))
                                            @php
                                                $path = Storage::url('public/uploads/pelanggan/'.$p->foto_pelanggan);
                                            @endphp
                                            <img src="{{ url($path) }}" alt="avatar" class="imaged w32 rounded" width="30px" height="30px">
                                            @else
                                            <img src="{{ asset('assets/img/sample/avatar/avatar1.jpg') }}" alt="avatar" class="imaged w32 rounded" style="height: 40px;">
                                            @endif 
                                        </div>
                                        <div class="form-group">
                                            <div>{{ $p->nama_pelanggan }}</div>
                                            <span class="badge badge-warning">{{ $p->jenis_jahitan }}</span>
                                            @if ($p->tgl_kirim == null && $p->status_pesanan == 0)
                                            <span class="badge badge-danger">Not Verified</span>
                                            <span class="badge badge-danger">Menunggu</span>
                                            @elseif($p->tgl_kirim != null && $p->status_pesanan == 0)
                                            <span class="badge badge-success">Verified</span>
                                            <span class="badge badge-info">On Progress</span>
                                            @elseif($p->tgl_kirim != null && $p->status_pesanan == 1)
                                            <span class="badge badge-success">Verified</span>
                                            <span class="badge badge-success">Paket Telah Dikirim</span>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach

                        </ul>
                    </div>

                </div>
            </div>
        </div>
        @include('dashboard.modal-daftar-jahit')
@endsection

