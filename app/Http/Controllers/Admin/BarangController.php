<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function read(){
        $barang = DB::table('barang')
            ->join('kategori', 'barang.id_kategori', '=', 'kategori.id')
            ->join('jenis', 'barang.id_jenis', '=', 'jenis.id')
            ->select('barang.*', 'kategori.nama as nama_kategori', 'jenis.nama as nama_jenis')
            ->orderBy('barang.id','DESC')
            ->get();

        return view('admin.barang.index',['barang'=>$barang]);
    }

    public function add(){
        $kategori = DB::table('kategori')->get();
        $jenis = DB::table('jenis')->get();
        return view('admin.barang.tambah',['kategori'=>$kategori, 'jenis'=>$jenis]);
    }

    public function create(Request $request){
        $foto = null;
        if($request->hasFile('foto')){
            $file = $request->file('foto');
            $foto = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/barang'), $foto);
        }

        DB::table('barang')->insert([  
            'id_kategori' => $request->id_kategori,
            'id_jenis' => $request->id_jenis,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'foto' => $foto]);

        return redirect('/admin/barang')->with("success","Data Berhasil Ditambah !");
    }

    public function edit($id){
        $barang = DB::table('barang')->where('id',$id)->first();
        $kategori = DB::table('kategori')->get();
        $jenis = DB::table('jenis')->get();
        
        return view('admin.barang.edit',['barang'=>$barang, 'kategori'=>$kategori, 'jenis'=>$jenis]);
    }

    public function update(Request $request, $id) {
        $barang = DB::table('barang')->where('id',$id)->first();
        $foto = $barang->foto;
        
        if($request->hasFile('foto')){
            // Hapus foto lama jika ada
            if($barang->foto && file_exists(public_path('uploads/barang/'.$barang->foto))){
                unlink(public_path('uploads/barang/'.$barang->foto));
            }
            
            $file = $request->file('foto');
            $foto = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/barang'), $foto);
        }

        DB::table('barang')  
            ->where('id', $id)
            ->update([
            'id_kategori' => $request->id_kategori,
            'id_jenis' => $request->id_jenis,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'foto' => $foto]);

        return redirect('/admin/barang')->with("success","Data Berhasil Diupdate !");
    }

    public function delete($id)
    {
        $barang = DB::table('barang')->where('id',$id)->first();
        
        // Hapus foto jika ada
        if($barang->foto && file_exists(public_path('uploads/barang/'.$barang->foto))){
            unlink(public_path('uploads/barang/'.$barang->foto));
        }
        
        DB::table('barang')->where('id',$id)->delete();

        return redirect('/admin/barang')->with("success","Data Berhasil Dihapus !");
    }
}
