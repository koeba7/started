<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;

class DetailTransaksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function read(){
        $detail_transaksi = DB::table('detail_transaksi')
            ->join('transaksi', 'detail_transaksi.id_transaksi', '=', 'transaksi.id')
            ->join('barang', 'detail_transaksi.id_barang', '=', 'barang.id')
            ->select('detail_transaksi.*', 'transaksi.nama as nama_pelanggan', 'barang.nama as nama_barang')
            ->orderBy('detail_transaksi.id','DESC')
            ->get();

        return view('admin.detail_transaksi.index',['detail_transaksi'=>$detail_transaksi]);
    }

    public function add(){
        $transaksi = DB::table('transaksi')->get();
        $barang = DB::table('barang')
            ->join('kategori', 'barang.id_kategori', '=', 'kategori.id')
            ->join('jenis', 'barang.id_jenis', '=', 'jenis.id')
            ->select('barang.*', 'kategori.nama as nama_kategori', 'jenis.nama as nama_jenis')
            ->get();
        return view('admin.detail_transaksi.tambah',['transaksi'=>$transaksi, 'barang'=>$barang]);
    }

    public function create(Request $request){
        $barang = DB::table('barang')->where('id', $request->id_barang)->first();
        $total = ($barang->harga * $request->jumlah) - ($request->diskon ?? 0);
        
        DB::table('detail_transaksi')->insert([
            'id_transaksi' => $request->id_transaksi,
            'id_barang' => $request->id_barang,
            'nama' => $barang->nama,
            'jumlah' => $request->jumlah,
            'harga' => $barang->harga,
            'diskon' => $request->diskon ?? 0,
            'total' => $total
        ]);

        return redirect('/admin/detail-transaksi')->with("success","Detail Transaksi Berhasil Ditambah !");
    }

    public function edit($id){
        $detail_transaksi = DB::table('detail_transaksi')->where('id',$id)->first();
        $transaksi = DB::table('transaksi')->get();
        $barang = DB::table('barang')
            ->join('kategori', 'barang.id_kategori', '=', 'kategori.id')
            ->join('jenis', 'barang.id_jenis', '=', 'jenis.id')
            ->select('barang.*', 'kategori.nama as nama_kategori', 'jenis.nama as nama_jenis')
            ->get();
        
        return view('admin.detail_transaksi.edit',[
            'detail_transaksi'=>$detail_transaksi, 
            'transaksi'=>$transaksi, 
            'barang'=>$barang
        ]);
    }

    public function update(Request $request, $id) {
        $barang = DB::table('barang')->where('id', $request->id_barang)->first();
        $total = ($barang->harga * $request->jumlah) - ($request->diskon ?? 0);
        
        DB::table('detail_transaksi')
            ->where('id', $id)
            ->update([
            'id_transaksi' => $request->id_transaksi,
            'id_barang' => $request->id_barang,
            'nama' => $barang->nama,
            'jumlah' => $request->jumlah,
            'harga' => $barang->harga,
            'diskon' => $request->diskon ?? 0,
            'total' => $total
        ]);

        return redirect('/admin/detail-transaksi')->with("success","Detail Transaksi Berhasil Diupdate !");
    }

    public function delete($id)
    {
        DB::table('detail_transaksi')->where('id',$id)->delete();
        return redirect('/admin/detail-transaksi')->with("success","Detail Transaksi Berhasil Dihapus !");
    }
}
