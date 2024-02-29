<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $query = Pesanan::query();
        $query->select('tb_pesanan.*', 'nama_pelanggan', 'jenis_jahitan');
        $query->join('tb_pelanggan', 'tb_pesanan.pelanggan_id', '=', 'tb_pelanggan.pelanggan_id');
        $query->join('tb_jenis', 'tb_pesanan.jenis_id', '=', 'tb_jenis.jenis_id');
        if(!empty($request->no_antrian)){
            $query->where('no_antrian', 'like', '%'. $request->no_antrian.'%');
        }
        $pesanan = $query->paginate(25);

        return view('master.pesanan', compact('pesanan'));
    }

    public function addPesanan(Request $request)
    {
        $pelanggan_id       = Auth::guard('buy')->user()->pelanggan_id;
        $pesanan_id         = date('dmyHis').$pelanggan_id;
        $jenis_id           = $request->jenis_id;
        $jumlah             = $request->jumlah;
        $bahan              = $request->bahan;
        $ukuran             = $request->ukuran;
        $status_pesanan     = 0;
        $tgl_pemesanan      = $request->tgl_pemesanan;
        $tgl_kirim          = $request->tgl_kirim;

        try {
            $data = [
                'pelanggan_id'         => $pelanggan_id,
                'jenis_id'             => $jenis_id,
                'jumlah'               => $jumlah,
                'bahan'                => $bahan,
                'ukuran'               => $ukuran,
                'status_pesanan'       => $status_pesanan,
                'pesanan_id'           => $pesanan_id,
                'tgl_pemesanan'        => $tgl_pemesanan,
                'tgl_kirim'            => $tgl_kirim,
            ];
            $simpan = DB::table('tb_pesanan')->insert($data);
        if($simpan){
            return Redirect('/metodebayar/'.$pesanan_id)->with(['success' => 'Data Berhasil Di Simpan!!, Silahkan Lanjutkan Metode Pembayaran']);
        }
        } catch (\Exception $e) {
            if($e->getCode()==23000){
                $message = "Data Sudah Ada!!";
            }else {
                $message = "Hubungi Tim IT";
            }
            return Redirect::back()->with(['error' => 'Data Gagal Di Simpan!! '. $message]);
        }
    }

    public function editPesanan($pesanan_id, Request $request)
    {
        $pelanggan_id       = Auth::guard('buy')->user()->pelanggan_id;
        $jenis_id           = $request->jenis_id;
        $jumlah             = $request->jumlah;
        $bahan              = $request->bahan;
        $ukuran             = $request->ukuran;
        $status_pesanan     = 0;
        $tgl_pemesanan      = $request->tgl_pemesanan;
        $tgl_kirim          = $request->tgl_kirim;

        $harga = DB::table('tb_jenis')->where('jenis_id', $jenis_id)->first();
        $total = $jumlah * $harga->harga;
        try {
            $data = [
                'pelanggan_id'         => $pelanggan_id,
                'jenis_id'             => $jenis_id,
                'jumlah'               => $jumlah,
                'bahan'                => $bahan,
                'ukuran'               => $ukuran,
                'status_pesanan'       => $status_pesanan,
                'tgl_pemesanan'        => $tgl_pemesanan,
                'tgl_kirim'            => $tgl_kirim,
            ];
            DB::table('tb_pembayaran')->where('pesanan_id', $pesanan_id)->update([
                'total_bayar' => $total
            ]);
            $update = DB::table('tb_pesanan')->where('pesanan_id', $pesanan_id)->update($data);
        if($update){
            return Redirect('/editmetode/'.$pesanan_id)->with(['success' => 'Data Berhasil Di Update!! Silahkan Lanjutkan Pembayaran Ulang']);
        } else {
            return 'error';
        }
        } catch (\Exception $e) {
            return Redirect('/lihatpesanan')->with(['error' => 'Data Gagal Di Update!!']);
        }
    }

    public function delete($pesanan_id)
    {
        $delete =  DB::table('tb_pesanan')->where('pesanan_id', $pesanan_id)->delete();

        if($delete){
            DB::table('tb_pembayaran')->where('pesanan_id', $pesanan_id)->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Di Delete!!']);
        }else{
            return Redirect::back()->with(['error' => 'Data Gagal Di Delete!!']);
        }
    }

    public function deleteS($pesanan_id)
    {
        $delete =  DB::table('tb_pesanan')->where('pesanan_id', $pesanan_id)->delete();

        if($delete){
            DB::table('tb_pembayaran')->where('pesanan_id', $pesanan_id)->delete();
            return Redirect('/lihatpesanan')->with(['success' => 'Data Berhasil Di Delete!!']);
        }else{
            return Redirect('/lihatpesanan')->with(['error' => 'Data Gagal Di Delete!!']);
        }
    }

    public function editStatus($pesanan_id, Request $request)
    {
        $status_pesanan     = $request->status_pesanan;
        $tgl_kirim          = $request->tgl_kirim;

        try {
            $data = [
                'status_pesanan'       => $status_pesanan,
                'tgl_kirim'            => $tgl_kirim,
            ];
            $update = DB::table('tb_pesanan')->where('pesanan_id', $pesanan_id)->update($data);
        if($update){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update!!']);
        }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Di Update!!']);
        }
    }

    public function lihatpesanan()
    {
        $pelid = Auth::guard('buy')->user()->pelanggan_id;
        $mypes = DB::table('tb_pesanan')
        ->leftJoin('tb_pelanggan', 'tb_pesanan.pelanggan_id', '=', 'tb_pelanggan.pelanggan_id')
        ->leftJoin('tb_jenis', 'tb_pesanan.jenis_id', '=', 'tb_jenis.jenis_id')
        ->where('tb_pesanan.pelanggan_id',$pelid)
        ->get();

        return view('pesanan.lihatpesanan', compact('mypes'));
    }

    public function editpesan($pesanan_id)
    {
        $pesan = DB::table('tb_pesanan as a')
        ->leftJoin('tb_jenis as b', 'a.jenis_id', '=', 'b.jenis_id')
        // ->leftJoin('tb_bahan as c', 'a.bahan', '=', 'c.bahan_id')
        ->where('pesanan_id', $pesanan_id)->first();
        $jenis = DB::table('tb_jenis as a')->get();
        $bahan = Bahan::all();
        return view('pesanan.editpesan', compact('pesan', 'jenis', 'bahan'));
    }

    public function addDesain($pesanan_id,Request $request)
    {
        $cek = DB::table('tb_desain')->where('pesanan_id', $pesanan_id)->count();
        if($cek > 0) {

            $des = DB::table('tb_desain')->where('pesanan_id', $pesanan_id)->first();
            $old_des = $des->file_desain;

            if($request->hasFile('file_desain')){
                $file_desain = $pesanan_id.date('s').".".$request->file('file_desain')->getClientOriginalExtension();
            }else{
                $file_desain = null;
            }

            try {
                $data = [
                    'file_desain' => $file_desain
                ];
                $update = DB::table('tb_desain')->where('pesanan_id', $pesanan_id)->update($data);
            if($update){
                if($request->hasFile('file_desain')){
                    $folderPath = "public/uploads/desain/";
                    $folderPathOld = "public/uploads/desain/".$old_des;
                    Storage::delete($folderPathOld);
                    $request->file('file_desain')->storeAs($folderPath, $file_desain);
                }
                return Redirect::back()->with('success', 'Data Berhasil Di Update!!');
            }
            } catch (\Exception $e) {
                return Redirect::back()->with('error', 'Data Gagal Di Simpan!! ');
            }
        } else {
            if($request->hasFile('file_desain')){
                $file_desain = $pesanan_id.".".$request->file('file_desain')->getClientOriginalExtension();
            }else{
                $file_desain = null;
            }

            try {
                $data = [
                    'pesanan_id' => $pesanan_id,
                    'file_desain' => $file_desain
                ];
                $simpan = DB::table('tb_desain')->insert($data);
                if($simpan){
                    if($request->hasFile('file_desain')){
                        $folderPath = "public/uploads/desain/";
                        $request->file('file_desain')->storeAs($folderPath, $file_desain);
                    }
                    return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!!']);
                }
            } catch (\Exception $e) {
                return Redirect::back()->with('error', 'Data Gagal Di Simpan!! ');
            }
    }

    }

    public function harian()
    {
        return view('laporan.harian');
    }

    public function cetakharian(Request $request)
    {
        $tgl = $request->tgl_pemesanan;
        $query = Pesanan::query();
        $query->select('tb_pesanan.*', 'nama_pelanggan', 'jenis_jahitan');
        $query->join('tb_pelanggan', 'tb_pesanan.pelanggan_id', '=', 'tb_pelanggan.pelanggan_id');
        $query->join('tb_jenis', 'tb_pesanan.jenis_id', '=', 'tb_jenis.jenis_id');
        if(!empty($request->tgl_pemesanan)){
            $query->where('tgl_pemesanan', 'like', '%'. $request->tgl_pemesanan.'%');
        }
        $query->where('status_pesanan', 1);
        $mypes = $query->get();
        if(isset($_POST['excel'])){
            $time = date("d-M-Y H:i:s");

            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Rekap-Laporan-Harian-$time.xls");
        }
        return view('laporan.cetakharian', compact('mypes', 'tgl'));
    }

    public function bulanan()
    {
        $namabulan = ["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('laporan.bulanan', compact('namabulan'));
    }

    public function cetakbulanan(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $query = Pesanan::query();
        $query->select('tb_pesanan.*', 'nama_pelanggan', 'jenis_jahitan');
        $query->join('tb_pelanggan', 'tb_pesanan.pelanggan_id', '=', 'tb_pelanggan.pelanggan_id');
        $query->join('tb_jenis', 'tb_pesanan.jenis_id', '=', 'tb_jenis.jenis_id');
        $query->whereRaw('MONTH(tgl_pemesanan)="'.$bulan.'"');
        $query->whereRaw('YEAR(tgl_pemesanan)="'.$tahun.'"');
        $query->where('status_pesanan', 1);
        $mypes = $query->get();
        if(isset($_POST['excel'])){
            $time = date("d-M-Y H:i:s");

            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Rekap-Laporan-Bulanan-$bulan-$tahun.xls");
        }
        $namabulan = ["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('laporan.cetakbulanan', compact('namabulan', 'bulan', 'tahun','mypes'));
    }
}
