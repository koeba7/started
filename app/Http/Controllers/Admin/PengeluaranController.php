<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;

class PengeluaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function read(){
        $pengeluaran = DB::table('pengeluaran')
            ->join('metode_pembayaran', 'pengeluaran.id_metode', '=', 'metode_pembayaran.id')
            ->select('pengeluaran.*', 'metode_pembayaran.nama as nama_metode')
            ->orderBy('pengeluaran.id','DESC')
            ->get();

        return view('admin.pengeluaran.index',['pengeluaran'=>$pengeluaran]);
    }

    public function add(){
        $metode_pembayaran = DB::table('metode_pembayaran')->get();
        return view('admin.pengeluaran.tambah',['metode_pembayaran'=>$metode_pembayaran]);
    }

    public function create(Request $request){
        DB::table('pengeluaran')->insert([  
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'id_metode' => $request->id_metode,
            'total' => $request->total]);

        return redirect('/admin/pengeluaran')->with("success","Data Berhasil Ditambah !");
    }

    public function edit($id){
        $pengeluaran = DB::table('pengeluaran')->where('id',$id)->first();
        $metode_pembayaran = DB::table('metode_pembayaran')->get();
        
        return view('admin.pengeluaran.edit',['pengeluaran'=>$pengeluaran, 'metode_pembayaran'=>$metode_pembayaran]);
    }

    public function update(Request $request, $id) {
        DB::table('pengeluaran')  
            ->where('id', $id)
            ->update([
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'id_metode' => $request->id_metode,
            'total' => $request->total]);

        return redirect('/admin/pengeluaran')->with("success","Data Berhasil Diupdate !");
    }

    public function delete($id)
    {
        DB::table('pengeluaran')->where('id',$id)->delete();

        return redirect('/admin/pengeluaran')->with("success","Data Berhasil Dihapus !");
    }
}
