<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $role = DB::table('tb_role')->get();
        
        return view('master.role', compact('role'));
    }

    public function addRole(Request $request)
    {
        $nama_role     = $request->nama_role;

        try {
            $data = [
                'nama_role'    => $nama_role,
            ];
            $simpan = DB::table('tb_role')->insert($data);
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

    public function editRole($id_role, Request $request)
    {
        $nama_role     = $request->nama_role;

        try {
            $data = [
                'nama_role'    => $nama_role,
            ];
            $update = DB::table('tb_role')->where('id_role', $id_role)->update($data);
        if($update){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update!!']);
        }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Di Update!!']);
        }
    }

    public function delete($id_role)
    {
        $delete =  DB::table('tb_role')->where('id_role', $id_role)->delete();

        if($delete){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Delete!!']);
        }else{
            return Redirect::back()->with(['error' => 'Data Gagal Di Delete!!']);
        }
    }
}
