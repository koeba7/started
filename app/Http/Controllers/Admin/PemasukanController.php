<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;

class PemasukanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function read(){
        $pemasukan = DB::table('pemasukan')
            ->join('metode_pembayaran', 'pemasukan.id_metode', '=', 'metode_pembayaran.id')
            ->select('pemasukan.*', 'metode_pembayaran.nama as nama_metode')
            ->orderBy('pemasukan.id','DESC')
            ->get();

        return view('admin.pemasukan.index',['pemasukan'=>$pemasukan]);
    }

    public function add(){
        $metode_pembayaran = DB::table('metode_pembayaran')->get();
        return view('admin.pemasukan.tambah',['metode_pembayaran'=>$metode_pembayaran]);
    }

    public function create(Request $request){
        DB::table('pemasukan')->insert([  
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'id_metode' => $request->id_metode,
            'total' => $request->total]);

        return redirect('/admin/pemasukan')->with("success","Data Berhasil Ditambah !");
    }

    public function edit($id){
        $pemasukan = DB::table('pemasukan')->where('id',$id)->first();
        $metode_pembayaran = DB::table('metode_pembayaran')->get();
        
        return view('admin.pemasukan.edit',['pemasukan'=>$pemasukan, 'metode_pembayaran'=>$metode_pembayaran]);
    }

    public function update(Request $request, $id) {
        DB::table('pemasukan')  
            ->where('id', $id)
            ->update([
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'id_metode' => $request->id_metode,
            'total' => $request->total]);

        return redirect('/admin/pemasukan')->with("success","Data Berhasil Diupdate !");
    }

    public function delete($id)
    {
        DB::table('pemasukan')->where('id',$id)->delete();

        return redirect('/admin/pemasukan')->with("success","Data Berhasil Dihapus !");
    }
}
