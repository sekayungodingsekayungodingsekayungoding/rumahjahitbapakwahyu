<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class BahanController extends Controller
{
    public function index(Request $request)
    {
        $bahan = DB::table('tb_bahan')->get();

        return view('master.bahan', compact('bahan'));
    }

    public function addBahan(Request $request)
    {
        $bahan     = $request->bahan;

        try {
            $data = [
                'bahan'    => $bahan,
            ];
            $simpan = DB::table('tb_bahan')->insert($data);
        if($simpan){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Simpan!!']);
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

    public function editBahan($bahan_id, Request $request)
    {
        $bahan     = $request->bahan;

        try {
            $data = [
                'bahan'    => $bahan,
            ];
            $update = DB::table('tb_bahan')->where('bahan_id', $bahan_id)->update($data);
        if($update){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update!!']);
        }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Di Update!!']);
        }
    }

    public function delete($bahan_id)
    {
        $delete =  DB::table('tb_bahan')->where('bahan_id', $bahan_id)->delete();

        if($delete){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Delete!!']);
        }else{
            return Redirect::back()->with(['error' => 'Data Gagal Di Delete!!']);
        }
    }
}