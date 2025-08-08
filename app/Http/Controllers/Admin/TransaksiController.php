<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;

class TransaksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function read(Request $request){
        $query = DB::table('transaksi')
            ->join('metode', 'transaksi.id_metode', '=', 'metode.id')
            ->select('transaksi.*', 'metode.nama as nama_metode');
        
        // Filter tanggal
        if ($request->filled('filter_date')) {
            $query->where('transaksi.tanggal', $request->filter_date);
        }
        
        // Filter status
        if ($request->filled('status')) {
            $query->where('transaksi.status', $request->status);
        }
        
        $transaksi = $query->orderBy('transaksi.id','DESC')->get();

        return view('admin.transaksi.index',['transaksi'=>$transaksi]);
    }

    public function add(){
        $metode = DB::table('metode')->get();
        $barang = DB::table('barang')
            ->join('kategori', 'barang.id_kategori', '=', 'kategori.id')
            ->join('jenis', 'barang.id_jenis', '=', 'jenis.id')
            ->select('barang.*', 'kategori.nama as nama_kategori', 'jenis.nama as nama_jenis')
            ->get();
        return view('admin.transaksi.tambah',['metode'=>$metode, 'barang'=>$barang]);
    }

    public function create(Request $request){
        // Hitung total dari detail transaksi
        $total = 0;
        if ($request->has('barang')) {
            foreach ($request->barang as $index => $id_barang) {
                $barang = DB::table('barang')->where('id', $id_barang)->first();
                $jumlah = $request->jumlah[$index];
                $diskon = $request->diskon[$index] ?? 0;
                $subtotal = ($barang->harga * $jumlah) - $diskon;
                $total += $subtotal;
            }
        }
        
        $potongan = $request->potongan ?? 0;
        $bayar = $request->bayar ?? 0;
        $kembali = $bayar - ($total - $potongan);
        
        // Insert transaksi
        $id_transaksi = DB::table('transaksi')->insertGetId([
            'id_metode' => $request->id_metode,
            'tanggal' => $request->tanggal,
            'pukul' => $request->pukul,
            'nama' => $request->nama,
            'contact' => $request->contact,
            'total' => $total,
            'potongan' => $potongan,
            'bayar' => $bayar,
            'kembali' => $kembali,
            'status' => $request->status ?? 'pending'
        ]);
        
        // Insert detail transaksi
        if ($request->has('barang')) {
            foreach ($request->barang as $index => $id_barang) {
                $barang = DB::table('barang')->where('id', $id_barang)->first();
                $jumlah = $request->jumlah[$index];
                $diskon = $request->diskon[$index] ?? 0;
                $subtotal = ($barang->harga * $jumlah) - $diskon;
                
                DB::table('detail_transaksi')->insert([
                    'id_transaksi' => $id_transaksi,
                    'id_barang' => $id_barang,
                    'nama' => $barang->nama,
                    'jumlah' => $jumlah,
                    'harga' => $barang->harga,
                    'diskon' => $diskon,
                    'total' => $subtotal
                ]);
            }
        }

        return redirect('/admin/transaksi')->with("success","Transaksi Berhasil Ditambah !");
    }

    public function edit($id){
        $transaksi = DB::table('transaksi')->where('id',$id)->first();
        $metode = DB::table('metode')->get();
        $detail_transaksi = DB::table('detail_transaksi')->where('id_transaksi',$id)->get();
        $barang = DB::table('barang')
            ->join('kategori', 'barang.id_kategori', '=', 'kategori.id')
            ->join('jenis', 'barang.id_jenis', '=', 'jenis.id')
            ->select('barang.*', 'kategori.nama as nama_kategori', 'jenis.nama as nama_jenis')
            ->get();
        
        return view('admin.transaksi.edit',[
            'transaksi'=>$transaksi, 
            'metode'=>$metode, 
            'detail_transaksi'=>$detail_transaksi,
            'barang'=>$barang
        ]);
    }

    public function update(Request $request, $id) {
        // Hitung total dari detail transaksi
        $total = 0;
        if ($request->has('barang')) {
            foreach ($request->barang as $index => $id_barang) {
                $barang = DB::table('barang')->where('id', $id_barang)->first();
                $jumlah = $request->jumlah[$index];
                $diskon = $request->diskon[$index] ?? 0;
                $subtotal = ($barang->harga * $jumlah) - $diskon;
                $total += $subtotal;
            }
        }
        
        $potongan = $request->potongan ?? 0;
        $bayar = $request->bayar ?? 0;
        $kembali = $bayar - ($total - $potongan);
        
        // Update transaksi
        DB::table('transaksi')
            ->where('id', $id)
            ->update([
            'id_metode' => $request->id_metode,
            'tanggal' => $request->tanggal,
            'pukul' => $request->pukul,
            'nama' => $request->nama,
            'contact' => $request->contact,
            'total' => $total,
            'potongan' => $potongan,
            'bayar' => $bayar,
            'kembali' => $kembali,
            'status' => $request->status ?? 'pending'
        ]);
        
        // Hapus detail transaksi lama
        DB::table('detail_transaksi')->where('id_transaksi', $id)->delete();
        
        // Insert detail transaksi baru
        if ($request->has('barang')) {
            foreach ($request->barang as $index => $id_barang) {
                $barang = DB::table('barang')->where('id', $id_barang)->first();
                $jumlah = $request->jumlah[$index];
                $diskon = $request->diskon[$index] ?? 0;
                $subtotal = ($barang->harga * $jumlah) - $diskon;
                
                DB::table('detail_transaksi')->insert([
                    'id_transaksi' => $id,
                    'id_barang' => $id_barang,
                    'nama' => $barang->nama,
                    'jumlah' => $jumlah,
                    'harga' => $barang->harga,
                    'diskon' => $diskon,
                    'total' => $subtotal
                ]);
            }
        }

        return redirect('/admin/transaksi')->with("success","Transaksi Berhasil Diupdate !");
    }

    public function delete($id)
    {
        // Hapus detail transaksi terlebih dahulu
        DB::table('detail_transaksi')->where('id_transaksi',$id)->delete();
        // Hapus transaksi
        DB::table('transaksi')->where('id',$id)->delete();

        return redirect('/admin/transaksi')->with("success","Transaksi Berhasil Dihapus !");
    }
}
