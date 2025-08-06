<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DatePeriod;
use DateInterval;
use DateTime;
use Carbon\Carbon;
 
class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    { 

        // Ambil data ringkasan keuangan
        $totalPemasukan = DB::table('pemasukan')->sum('total');
        $totalPengeluaran = DB::table('pengeluaran')->sum('total');
        $saldo = $totalPemasukan - $totalPengeluaran;
        
        // Data untuk chart (7 hari terakhir)
        $pemasukanHarian = DB::table('pemasukan')
            ->select(DB::raw('DATE(tanggal) as tanggal'), DB::raw('SUM(total) as total'))
            ->where('tanggal', '>=', now()->subDays(7))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();
            
        $pengeluaranHarian = DB::table('pengeluaran')
            ->select(DB::raw('DATE(tanggal) as tanggal'), DB::raw('SUM(total) as total'))
            ->where('tanggal', '>=', now()->subDays(7))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();
        
        return view('admin.dashboard.index', compact('totalPemasukan', 'totalPengeluaran', 'saldo', 'pemasukanHarian', 'pengeluaranHarian'));
    }

    public function change()
    {
        return view('admin/dashboard/change');
    }

    public function change_password(Request $request){
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Kata sandi Anda saat ini tidak cocok dengan kata sandi yang Anda berikan. Silakan coba lagi.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","Kata Sandi Baru tidak boleh sama dengan kata sandi Anda saat ini. Silakan pilih kata sandi lain.");
        }

        DB::table('users')  
                ->where('id', Auth::User()->id)
                ->update([
                'password' => bcrypt($request->get('new-password'))]);

        return redirect('/admin/change')->with("success","Ganti Password Berhasil !");
    }

    public function keluar()
    {
        Auth::logout();
    
        // Redirect user ke halaman login atau halaman lainnya
        return redirect()->route('login')->with("error","Akun Anda Belum Diaktifkan !");
    }
}
