<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;

class JenisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function read(){
        $jenis = DB::table('jenis')->orderBy('id','DESC')->get();

        return view('admin.jenis.index',['jenis'=>$jenis]);
    }

    public function add(){
        return view('admin.jenis.tambah');
    }

    public function create(Request $request){
        DB::table('jenis')->insert([  
            'nama' => $request->nama]);

        return redirect('/admin/jenis')->with("success","Data Berhasil Ditambah !");
    }

    public function edit($id){
        $jenis = DB::table('jenis')->where('id',$id)->first();
        
        return view('admin.jenis.edit',['jenis'=>$jenis]);
    }

    public function update(Request $request, $id) {
        DB::table('jenis')  
            ->where('id', $id)
            ->update([
            'nama' => $request->nama]);

        return redirect('/admin/jenis')->with("success","Data Berhasil Diupdate !");
    }

    public function delete($id)
    {
        DB::table('jenis')->where('id',$id)->delete();

        return redirect('/admin/jenis')->with("success","Data Berhasil Dihapus !");
    }
}
