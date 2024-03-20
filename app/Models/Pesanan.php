<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesanan extends Model
{
    use HasFactory;
    protected $table = "tb_pesanan";

    public function waiting($pesanan_id)
    {
        $angka = 0; // 2
        $count2 = 1;
        $array = []; // [1,2,3]
        $hasil = 0;
        $query = DB::table($this->table)->whereNull('tgl_kirim')->get();
        foreach($query as $index => $row)
        {
            $array[] = $index + 1;
            if($pesanan_id != $row->pesanan_id){
                $count2 ++;
            } else {
                $angka += $count2; //Yusi = 2
            }
        }

        if ($angka > 0 && $angka <= count($array)) {
            $array = array_slice($array, 0, $angka - 1); // Output: Array ( [0] => 1 )
            $hasil = count($array);
        }
    
        return $hasil;
    }
}
