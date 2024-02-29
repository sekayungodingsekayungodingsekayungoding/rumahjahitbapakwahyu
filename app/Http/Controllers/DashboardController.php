<?php

namespace App\Http\Controllers;

use App\Models\Harga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Harga::query();
        $query->select('tb_jenis.*');
        if(!empty($request->jenis_jahitan)){
            $query->where('jenis_jahitan', 'like', '%'. $request->jenis_jahitan.'%');
        }
        $jenis = $query->paginate(25);
        $pelid = Auth::guard('buy')->user()->pelanggan_id;
        $mypes = DB::table('tb_pesanan')
        ->leftJoin('tb_pelanggan', 'tb_pesanan.pelanggan_id', '=', 'tb_pelanggan.pelanggan_id')
        ->leftJoin('tb_jenis', 'tb_pesanan.jenis_id', '=', 'tb_jenis.jenis_id')
        ->where('tb_pesanan.pelanggan_id',$pelid)
        ->where('status_pesanan', 0)
        ->get();
        $pes = DB::table('tb_pesanan')
        ->leftJoin('tb_pelanggan', 'tb_pesanan.pelanggan_id', '=', 'tb_pelanggan.pelanggan_id')
        ->leftJoin('tb_jenis', 'tb_pesanan.jenis_id', '=', 'tb_jenis.jenis_id')
        ->get();

        return view('dashboard.dashboard', compact('jenis', 'mypes', 'pes'));
    }

    public function dashboardadmin()
    {
        $cpel = DB::table('tb_pelanggan')
        ->selectRaw('COUNT(pelanggan_id) as jpel')
        ->first();
        $cpes = DB::table('tb_pesanan')
        ->selectRaw('COUNT(pesanan_id) as jpes')
        ->first();
        $req = DB::table('tb_req')->paginate(25);
        
        return view('dashboard.dashboardadmin', compact('cpel', 'cpes', 'req'));
    }

}
