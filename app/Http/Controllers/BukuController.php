<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Buku_model;
use Auth;

class BukuController extends Controller
{
    public function store(Request $request)
    {
        // if(Auth::User()->level=="admin"){
        $validator=Validator::make($request->all(),[
            'nama_buku'=>'required',
            'id_jenis_buku'=>'required',
            'harga'=>'required',
            'deskripsi'=>'required',
            'kondisi'=>'required',
            'foto'=>'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),
            400);
        }else{
            $insert=Buku_model::insert([
                'nama_buku'=>$request->nama_buku,
                'id_jenis_buku'=>$request->id_jenis_buku,
                'harga'=>$request->harga,
                'deskripsi'=>$request->deskripsi,
                'kondisi'=>$request->kondisi,
                'foto'=>$request->foto
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
            'nama_buku'=>'required',
            'id_jenis_buku'=>'required',
            'harga'=>'required',
            'kondisi'=>'required',
            'foto'=>'required',
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $ubah=Buku_model::where('id_buku', $id)->update([
            'nama_buku'=>$req->nama_buku,
            'id_jenis_buku'=>$req->id_jenis_buku,
            'harga'=>$req->harga,
            'deskripsi'=>$req->deskripsi,
            'kondisi'=>$req->kondisi,
            'foto'=>$req->foto
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
        $hapus=Buku_model::where('id_buku',$id)->delete();
        if($hapus){
            return Response()->json(['status'=>'Data berhasil dihapus!']);
        }else{
            return Response()->json(['status'=>'Data gagal dihapus!']);
        }
        // }else{
        // return response()->json(['status'=>'anda bukan admin']);
        // }
    }

    public function tampil_buku()
    {
        // if(Auth::User()->level=="admin"){
        $data_buku=Buku_model::get();
        return Response()->json($data_buku);
        
        // }else{
        // return response()->json(['status'=>'anda bukan admin']);
        // }
    }
}
