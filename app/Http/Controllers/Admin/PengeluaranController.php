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
    
    public function read(Request $request){
        $query = DB::table('pengeluaran')
            ->join('metode_pembayaran', 'pengeluaran.id_metode', '=', 'metode_pembayaran.id')
            ->join('users', 'pengeluaran.id_user', '=', 'users.id')
            ->join('barang', 'pengeluaran.id_barang', '=', 'barang.id')
            ->join('kategori', 'barang.id_kategori', '=', 'kategori.id')
            ->join('jenis', 'barang.id_jenis', '=', 'jenis.id')
            ->select('pengeluaran.*', 'metode_pembayaran.nama as nama_metode', 'users.name as nama_penginput', 
                    'barang.nama as nama_barang', 'barang.harga as harga_barang', 'kategori.nama as nama_kategori', 'jenis.nama as nama_jenis');
        
        // Filter tanggal sederhana
        if ($request->filled('filter_date')) {
            $query->where('pengeluaran.tanggal', $request->filter_date);
        }
        
        $pengeluaran = $query->orderBy('pengeluaran.id','DESC')->get();

        return view('admin.pengeluaran.index',['pengeluaran'=>$pengeluaran]);
    }

    public function add(){
        $metode_pembayaran = DB::table('metode_pembayaran')->get();
        $barang = DB::table('barang')
            ->join('kategori', 'barang.id_kategori', '=', 'kategori.id')
            ->join('jenis', 'barang.id_jenis', '=', 'jenis.id')
            ->select('barang.*', 'kategori.nama as nama_kategori', 'jenis.nama as nama_jenis')
            ->get();
        return view('admin.pengeluaran.tambah',['metode_pembayaran'=>$metode_pembayaran, 'barang'=>$barang]);
    }

    public function create(Request $request){
        DB::table('pengeluaran')->insert([  
            'tanggal' => $request->tanggal,
            'id_user' => Auth::user()->id,
            'id_barang' => $request->id_barang,
            'keterangan' => $request->keterangan,
            'id_metode' => $request->id_metode,
            'total' => $request->total]);

        return redirect('/admin/pengeluaran')->with("success","Data Berhasil Ditambah !");
    }

    public function edit($id){
        $pengeluaran = DB::table('pengeluaran')->where('id',$id)->first();
        $metode_pembayaran = DB::table('metode_pembayaran')->get();
        $barang = DB::table('barang')
            ->join('kategori', 'barang.id_kategori', '=', 'kategori.id')
            ->join('jenis', 'barang.id_jenis', '=', 'jenis.id')
            ->select('barang.*', 'kategori.nama as nama_kategori', 'jenis.nama as nama_jenis')
            ->get();
        
        return view('admin.pengeluaran.edit',['pengeluaran'=>$pengeluaran, 'metode_pembayaran'=>$metode_pembayaran, 'barang'=>$barang]);
    }

    public function update(Request $request, $id) {
        DB::table('pengeluaran')  
            ->where('id', $id)
            ->update([
            'tanggal' => $request->tanggal,
            'id_barang' => $request->id_barang,
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
