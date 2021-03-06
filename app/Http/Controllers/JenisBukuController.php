<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\JenisBuku_model;
use Auth;

class JenisBukuController extends Controller
{
    public function store(Request $request)
    {
        // if(Auth::User()->level=="admin"){
        $validator=Validator::make($request->all(),[
            'jenis_buku'=>'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),
            400);
        }else{
            $insert=JenisBuku_model::insert([
                'jenis_buku'=>$request->jenis_buku
            ]);
            if($insert){
                $status="Sukses menambahkan data!";
            }else{
                $status="Gagal menambahkan data!";
            }
            return response()->json(compact('status'));
        }
        // }else{
        // return response()->json(['status'=>'anda bukan admin']);
        // }
    }

    public function update($id,Request $req)
    {
        // if(Auth::User()->level=="admin"){
        $validator=Validator::make($req->all(),
        [
            'jenis_buku'=>'required'
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $ubah=JenisBuku_model::where('id_jenis_buku', $id)->update([
            'jenis_buku'=>$req->jenis_buku
        ]);
        if($ubah){
            return Response()->json(['status'=>'Data berhasil diubah!']);
        }else{
            return Response()->json(['status'=>'Data gagal diubah!']);
        }
        // }else{
        // return response()->json(['status'=>'anda bukan admin']);
        // }
    }
    public function destroy($id)
    {
        // if(Auth::User()->level=="admin"){
        $hapus=JenisBuku_model::where('id_jenis_buku',$id)->delete();
        if($hapus){
            return Response()->json(['status'=>'Data berhasil dihapus!']);
        }else{
            return Response()->json(['status'=>'Data gagal dihapus!']);
        }
        // }else{
        // return response()->json(['status'=>'anda bukan admin']);
        // }
    }

    public function tampil_jenis()
    {
        // if(Auth::User()->level=="admin"){
        $data_jenis=JenisBuku_model::get();
        return Response()->json($data_jenis);
        
        // }else{
        // return response()->json(['status'=>'anda bukan admin']);
        // }
    }
}
