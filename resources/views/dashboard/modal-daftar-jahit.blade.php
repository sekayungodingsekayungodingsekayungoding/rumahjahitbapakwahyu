<div class="modal modal-blur fade" id="modal-daftar-jahit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header" style="background-color:#0000ff ">
        <h5 class="modal-title text-white">Daftar Jahitan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="col-12">
                <form action="/dashboard" method="GET">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <input type="text" name="jenis_jahitan" class="form-control" value="{{ Request('jenis_jahitan') }}" placeholder="Jenis Jahitan">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <button class="btn btn-primary">Cari</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>Jenis Jahitan</th>
                            <th>Harga</th>
                        </tr>
                        @foreach ($jenis as $j)
                            <tr>
                                <td>{{ $j->jenis_jahitan }}</td>
                                <td>{{ currency_IDR($j->harga) }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div><br>
                {{ $jenis->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
    </div>
</div>