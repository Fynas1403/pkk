<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Detail_model;
use App\Buku_model;
use Auth;

class DetailController extends Controller
{
    public function store(Request $request)
    {

        // if(Auth::User()->level=="petugas"){
        $validator=Validator::make($request->all(),[
            'id_transaksi'=>'required',
            'id_buku'=>'required',
            'qty'=>'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        $harga = Buku_model::where('id_buku',$request->id_buku)->first();
        $subtotal = $harga->harga * $request->qty;

            $simpan=Detail_model::insert([
                'id_transaksi'=>$request->id_transaksi,
                'id_buku'=>$request->id_buku,
                'subtotal'=>$subtotal,
                'qty'=>$request->qty

            ]);
            if($simpan){
                $status="Sukses menambahkan data!";
            }else{
                $status="Gagal menambahkan data!";
            }
            return response()->json(compact('status'));
        
        // }else{
        // return response()->json(['status'=>'anda bukan petugas']);
        // }
    }

    public function tampil_detail()
    {
        // if(Auth::User()->level=="petugas"){
            $dt_detail=Detail_model::get();
            return response()->json($dt_detail);
        // }else{
        //     return response()->json(['status'=>'anda bukan petugas']);
        // }
    }
}
