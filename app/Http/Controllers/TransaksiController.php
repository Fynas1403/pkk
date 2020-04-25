<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Transaksi_model;
use App\Detail_model;
use App\Buku_model;
use Auth;
use DB;
class TransaksiController extends Controller
{
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'tgl_transaksi'=>'required',
            'id_user'=>'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),
            400);
        }else{
            $insert=Transaksi_model::insert([
                'tgl_transaksi'=>$request->tgl_transaksi,

                'id_user'=>$request->id_user
            ]);
            if($insert){
                $status="Sukses menambahkan data!";
            }else{
                $status="Gagal menambahkan data!";
            }
            return response()->json(compact('status'));
        }
    }

    public function tampil_transaksi(Request $req)
    {
        $transaksi=DB::table('transaksi')->join('user', 'user.id_user', 'transaksi.id_user')
                                         ->get();

        if($transaksi->count() > 0){
            $data_transaksi = array();
       

        foreach ($transaksi as $t){
            $grand = DB::table('detail_transaksi')->where('id_transaksi','=',$t->id_transaksi) 
            ->groupBy('id_transaksi')
            ->select(DB::raw('sum(subtotal) as grandtotal'))
            ->first();
            
            $detail = DB::table('detail_transaksi')
            ->join('buku','detail_transaksi.id_buku','=','buku.id_buku')
            ->join('jenis_buku','buku.id_jenis_buku','=','jenis_buku.id_jenis_buku')
            ->where('id_transaksi','=',$t->id_transaksi)
            ->get();

            $data_transaksi = array(
                'nama' => $t->nama,
                'email' => $t->email,
                'total bayar' => $grand,
                'detail' => $detail,
            );
        }
        return Response()->json($data_transaksi);
    
    }
    }
}
