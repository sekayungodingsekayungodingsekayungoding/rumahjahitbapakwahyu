<?php

namespace App\Http\Controllers;

use App\Models\Harga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class HargaController extends Controller
{
    public function index(Request $request)
    {
        $query = Harga::query();
        $query->select('tb_jenis.*');
        if(!empty($request->jenis_jahitan)){
            $query->where('jenis_jahitan', 'like', '%'. $request->jenis_jahitan.'%');
        }
        $jenis = $query->paginate(25);
        
        return view('master.jenis', compact('jenis'));
    }

    public function addHarga(Request $request)
    {
        $jenis_jahitan     = $request->jenis_jahitan;
        $harga             = $request->harga;

        try {
            $data = [
                'jenis_jahitan'    => $jenis_jahitan,
                'harga'            => $harga,
            ];
            $simpan = DB::table('tb_jenis')->insert($data);
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

    public function editHarga($jenis_id, Request $request)
    {
        $jenis_jahitan     = $request->jenis_jahitan;
        $harga             = $request->harga;

        try {
            $data = [
                'jenis_jahitan'    => $jenis_jahitan,
                'harga'            => $harga,
            ];
            $update = DB::table('tb_jenis')->where('jenis_id', $jenis_id)->update($data);
        if($update){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update!!']);
        }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Di Update!!']);
        }
    }

    public function delete($jenis_id)
    {
        $delete =  DB::table('tb_jenis')->where('jenis_id', $jenis_id)->delete();

        if($delete){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Delete!!']);
        }else{
            return Redirect::back()->with(['error' => 'Data Gagal Di Delete!!']);
        }
    }
}
