<?php

namespace App\Http\Controllers;

use App\Models\Saksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $id = Auth::guard()->user()->admin_id;
        $setting = DB::table('tb_admin')->where('admin_id', $id)->first();

        return view('master.setting', compact('setting'));
    }

    public function upsetting(Request $request)
    {
        $email            = $request->email;
        $username     = $request->username;
        $alamat         = $request->alamat;
        $nohp          = $request->nohp;
        $nama_users          = $request->nama_users;
        $id = Auth::guard()->user()->admin_id;
        $id_role = Auth::guard()->user()->id_role;

        $c = $request->password;
        if($c = null){
          $password = Hash::make('12345');
        }else{
          $password = Hash::make($request->password);
        }
        try {
            $data = [
                'nama_users'    => $nama_users,
                'alamat'        => $alamat,
                'nohp'         => $nohp,
                'email'         => $email,
                'id_role'       => $id_role,
                'username'       => $username,
                'password'      => $password,
            ];
            $update = DB::table('tb_admin')->where('admin_id', $id)->update($data);
            if($update){
                return Redirect('/settings')->with(['success' => 'Data Berhasil Di Update!!']);
            }
        } catch (\Exception $e) {
            return Redirect('/settings')->with(['error' => 'Data Gagal Di Update!!']);
        }
    }

    public function req()
    {
        $id = Auth::guard('buy')->user()->pelanggan_id;
        $req = DB::table('tb_req')->where('pelanggan_id', $id)->get();

        return view('pesanan.req', compact('req'));
    }

    public function addreq()
    {

        return view('pesanan.addreq');
    }

    public function addRequest(Request $request)
    {
        $jenis       = $request->jenis;
        $bahan       = $request->bahan;
        $status      = 0;
        $pelid       = Auth::guard('buy')->user()->pelanggan_id;

        try {
            $data = [
                'jenis'              => $jenis,
                'bahan'              => $bahan,
                'status'             => $status,
                'pelanggan_id'       => $pelid,
            ];
            $simpan = DB::table('tb_req')->insert($data);
        if($simpan){
            return Redirect('/req')->with(['success' => 'Data Berhasil Di Simpan!!']);
        }
        } catch (\Exception $e) {
            return Redirect('/req')->with(['error' => 'Data Gagal Di Simpan!!']);
        }
    }

    public function deleteS($req_id)
    {
        $delete =  DB::table('tb_req')->where('req_id', $req_id)->delete();

        if($delete){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Delete!!']);
        }else{
            return Redirect::back()->with(['error' => 'Data Gagal Di Delete!!']);
        }
    }

    public function editSReq($req_id, Request $request)
    {
        $jenis       = $request->jenis;
        $bahan       = $request->bahan;
        $status      = $request->status;
        $harga       = $request->harga;

        try {
            $data = [
                'status'             => $status,
            ];
            DB::table('tb_jenis')->insert([
                'jenis_jahitan' => $jenis,
                'harga'         => $harga
            ]);
            DB::table('tb_bahan')->insert([
                'bahan' => $bahan
            ]);
            $simpan = DB::table('tb_req')->where('req_id', $req_id)->update($data);
        if($simpan){
            return Redirect('/panel/dashboardadmin')->with(['success' => 'Data Berhasil Di Simpan!!']);
        }
        } catch (\Exception $e) {
            echo $e;
        }
    }
}
