<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::query();
        $query->select('tb_pembayaran.*');
        $query->orderBy('status_bayar');
        if(!empty($request->pesanan_id)){
            $query->where('pesanan_id', 'like', '%'. $request->pesanan_id.'%');
        }
        $pembayaran = $query->paginate(25);

        return view('master.pembayaran', compact('pembayaran'));
    }

    public function addPembayaran(Request $request)
    {
        $pesanan_id          = $request->pesanan_id;
        $metode_bayar        = $request->metode_bayar;
        $total_bayar         = $request->total_bayar;
        $status_bayar        = 0;
        $id                  = Auth::guard('buy')->user()->pelanggan_id;

        if($request->hasFile('bukti_bayar')){
            $bukti_bayar = $id.".".$request->file('bukti_bayar')->getClientOriginalExtension();
        }else{
            $bukti_bayar = null;
        }

        try {
            $data = [
                'pesanan_id'          => $pesanan_id,
                'metode_bayar'        => $metode_bayar,
                'total_bayar'         => $total_bayar,
                'status_bayar'        => $status_bayar,
                'bukti_bayar'         => $bukti_bayar,
                'pelanggan_id'        => $id
            ];
            $simpan = DB::table('tb_pembayaran')->insert($data);
        if($simpan){
            if($request->hasFile('bukti_bayar')){
                $folderPath = "public/uploads/bukti_bayar/";
                $request->file('bukti_bayar')->storeAs($folderPath, $bukti_bayar);
            }
            return Redirect('/metodebayar')->with(['success' => 'Data Berhasil Di Simpan!!']);
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

    public function editPembayaran($pembayaran_id, Request $request)
    {
        $metode_bayar        = $request->metode_bayar;

        $bayar = DB::table('tb_pembayaran')->where('pembayaran_id', $pembayaran_id)->first();
        $old_bukti_bayar = $bayar->bukti_bayar;

        if($request->hasFile('bukti_bayar')){
            $bukti_bayar = $bayar->pelanggan_id.date("s").".".$request->file('bukti_bayar')->getClientOriginalExtension();
        }else{
            $bukti_bayar = null;
        }

        try {
            $data = [
                'metode_bayar'        => $metode_bayar,
                'bukti_bayar'         => $bukti_bayar,
            ];
            $update = DB::table('tb_pembayaran')->where('pembayaran_id', $pembayaran_id)->update($data);
        if($update){
            if($request->hasFile('bukti_bayar')){
                $folderPath = "public/uploads/bukti_bayar/";
                $folderPathOld = "public/uploads/bukti_bayar/".$old_bukti_bayar;
                Storage::delete($folderPathOld);
                $request->file('bukti_bayar')->storeAs($folderPath, $bukti_bayar);
            }
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update!!']);
        }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Di Update!!']);
        }
    }

    public function editPembayaranS($pesanan_id, Request $request)
    {
        $metode_bayar        = $request->metode_bayar;
        $total_bayar         = $request->total_bayar;
        $status_bayar        = 0;
        $id                  = Auth::guard('buy')->user()->pelanggan_id;

        if($request->hasFile('bukti_bayar')){
            $bukti_bayar = $id.".".$request->file('bukti_bayar')->getClientOriginalExtension();
        }else{
            $bukti_bayar = null;
        }

        try {
            $data = [
                'metode_bayar'        => $metode_bayar,
                'total_bayar'         => $total_bayar,
                'status_bayar'        => $status_bayar,
                'bukti_bayar'         => $bukti_bayar,
                'pelanggan_id'        => $id
            ];
            $simpan = DB::table('tb_pembayaran')->where('pesanan_id', $pesanan_id)->update($data);
        if($simpan){
            if($request->hasFile('bukti_bayar')){
                $folderPath = "public/uploads/bukti_bayar/";
                $request->file('bukti_bayar')->storeAs($folderPath, $bukti_bayar);
            }
            return Redirect('/metodebayar')->with(['success' => 'Data Berhasil Di Simpan!!']);
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

    public function editSPembayaran($pembayaran_id, Request $request)
    {
        $status_bayar           = $request->status_bayar;

        try {
            $data = [
                'status_bayar'             => $status_bayar,
            ];
            $update = DB::table('tb_pembayaran')->where('pembayaran_id', $pembayaran_id)->update($data);
        if($update){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update!!']);
        }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Di Update!!']);
        }
    }

    public function delete($pembayaran_id)
    {
        $delete =  DB::table('tb_pembayaran')->where('pembayaran_id', $pembayaran_id)->delete();

        if($delete){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Delete!!']);
        }else{
            return Redirect::back()->with(['error' => 'Data Gagal Di Delete!!']);
        }
    }

    public function deleteS($pembayaran_id)
    {
        $delete =  DB::table('tb_pembayaran')->where('pembayaran_id', $pembayaran_id)->delete();

        if($delete){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Delete!!']);
        }else{
            return Redirect::back()->with(['error' => 'Data Gagal Di Delete!!']);
        }
    }

    public function metodebayar()
    {
        $id     = Auth::guard('buy')->user()->pelanggan_id;
        $metode = DB::table('tb_pembayaran')
        ->leftJoin('tb_pesanan', 'tb_pembayaran.pesanan_id', '=', 'tb_pesanan.pesanan_id')
        ->where('tb_pembayaran.pelanggan_id', $id)
        ->where('status_bayar', 0)
        ->get();

        return view('pesanan.metodebayar', compact('metode'));
    }

    public function editmetode($pesanan_id)
    {
        $id     = Auth::guard('buy')->user()->pelanggan_id;
        $metode = DB::table('tb_pembayaran')
        ->leftJoin('tb_pesanan', 'tb_pembayaran.pesanan_id', '=', 'tb_pesanan.pesanan_id')
        ->where('tb_pembayaran.pesanan_id', $pesanan_id)
        ->first();

        return view('pesanan.editmetode', compact('metode'));
    }

    public function bayar($pesanan_id){
        $bayar = DB::table('tb_pesanan')
        ->leftJoin('tb_jenis', 'tb_pesanan.jenis_id', '=', 'tb_jenis.jenis_id')
        ->where('pesanan_id', $pesanan_id)->first();
        $harga = $bayar->harga;
        $jumlah = $bayar->jumlah;
        $total = $jumlah * $harga;

        return view('pesanan.bayar', compact('bayar', 'total'));
    }

    public function cetak(Request $request)
    {
        $id     = Auth::guard('buy')->user()->pelanggan_id;
        $query = Pembayaran::query();
        $query->select('tb_pembayaran.*', 'tb_pelanggan.*', 'no_antrian');
        $query->leftJoin('tb_pesanan', 'tb_pembayaran.pesanan_id', '=', 'tb_pesanan.pesanan_id');
        $query->leftJoin('tb_pelanggan', 'tb_pembayaran.pelanggan_id', '=', 'tb_pelanggan.pelanggan_id');
        if(!empty($request->metode_bayar)){
            $query->where('metode_bayar', 'like', '%'. $request->metode_bayar.'%');
        }
        $query->where('tb_pembayaran.pelanggan_id', $id);
        $query->where('status_bayar', 0);
        $metode = $query->get();

        return view('pesanan.cetak', compact('metode'));
    }
}
