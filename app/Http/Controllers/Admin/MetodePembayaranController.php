<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;

class MetodePembayaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function read(){
        $metode_pembayaran = DB::table('metode_pembayaran')->orderBy('id','DESC')->get();

        return view('admin.metode_pembayaran.index',['metode_pembayaran'=>$metode_pembayaran]);
    }

    public function add(){
        return view('admin.metode_pembayaran.tambah');
    }

    public function create(Request $request){
        DB::table('metode_pembayaran')->insert([  
            'nama' => $request->nama]);

        return redirect('/admin/metode_pembayaran')->with("success","Data Berhasil Ditambah !");
    }

    public function edit($id){
        $metode_pembayaran = DB::table('metode_pembayaran')->where('id',$id)->first();
        
        return view('admin.metode_pembayaran.edit',['metode_pembayaran'=>$metode_pembayaran]);
    }

    public function update(Request $request, $id) {
        DB::table('metode_pembayaran')  
            ->where('id', $id)
            ->update([
            'nama' => $request->nama]);

        return redirect('/admin/metode_pembayaran')->with("success","Data Berhasil Diupdate !");
    }

    public function delete($id)
    {
        DB::table('metode_pembayaran')->where('id',$id)->delete();

        return redirect('/admin/metode_pembayaran')->with("success","Data Berhasil Dihapus !");
    }
}
