@extends('layout.admin.tabler')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<div class="page-header d-print-none">
    <div class="container-xl">
    <div class="row g-2 align-items-center">
        <div class="col">
        <!-- Page pre-title -->
        <h2 class="page-title">
            Settings Profile
        </h2>
        </div>
        <!-- Page title actions -->
    </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="card">
                <form action="/upsetting" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-0">
                    <div class="col-12 col-md-3 border-end">
                      <div class="card-body">
                        <h4 class="subheader">Settings profile</h4>
                        <div class="list-group list-group-transparent">
                          <a href="./settings.html" class="list-group-item list-group-item-action d-flex align-items-center active">My Account</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-9 d-flex flex-column">
                      <div class="card-body">
                        <h2 class="mb-4">My Account</h2>
                        <h3 class="card-title">Profile Details</h3>
                        <div class="row align-items-center">
                          <div class="col-auto">
                              <img src="{{ asset('assets/img/sample/avatar/avatar1.jpg') }}" alt="avatar" class="imaged w32 rounded" style="height: 40px;">
                          </div>
                          <div class="col-auto">
                          </div>
                        </div>
                        <h3 class="card-title mt-4">My Profile</h3>
                        <div class="row g-3">
                          <div class="col-md">
                            <div class="form-label">Nama Lengkap</div>
                            <input type="text" class="form-control" name="nama_users" value="{{ $setting->nama_users }}">
                          </div>
                          <div class="col-md">
                            <div class="form-label">No Hp</div>
                            <input type="text" class="form-control" name="nohp" value="{{ $setting->nohp }}">
                          </div>
                          <div class="col-md">
                            <div class="form-label">Alamat</div>
                            <input type="text" class="form-control" name="alamat" value="{{ $setting->alamat }}">
                          </div>
                        </div>
                        <h3 class="card-title mt-4">Username</h3>
                        <div>
                          <div class="row g-2">
                            <div class="col-auto">
                              <input type="text" class="form-control w-auto" name="username" value="{{ $setting->username }}">
                            </div>
                          </div>
                        </div>
                        <h3 class="card-title mt-4">Email</h3>
                        <div>
                          <div class="row g-2">
                            <div class="col-auto">
                              <input type="email" class="form-control w-auto" name="email" value="{{ $setting->email }}">
                            </div>
                          </div>
                        </div>
                        <h3 class="card-title mt-4">Password</h3>
                        <div>
                          <input type="password" class="form-control w-auto" name="password" required>
                        </div>
                      </div>
                      <div class="card-footer bg-transparent mt-auto">
                        <div class="btn-list justify-content-end">
                          <button class="btn btn-primary">Submit</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
