@extends('admin.layouts.app', [
'activePage' => 'detail_transaksi',
])
@section('content')
<div class="min-height-200px">
   <div class="page-header">
      <div class="row">
         <div class="col-md-6 col-sm-12">
            <div class="title">
               <h4>Tambah Data Detail Transaksi</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/admin/detail-transaksi">Transaksi</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Tambah Data Detail Transaksi</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
   <!-- Default Basic Forms Start -->
   <div class="pd-20 card-box mb-30">
      <div class="clearfix">
         <div class="pull-left">
            <h2 class="text-primary h2"><i class="icon-copy dw dw-add"></i> Form Tambah Data Detail Transaksi</h2>
         </div>
      </div>
      <hr style="margin-top: 0px;">
      
      @if (session('error'))
      <div class="alert alert-danger">
         {{ session('error')}}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
      </div>
      @endif
      
      <form method="POST" action="/admin/detail-transaksi/create">
         @csrf
         <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Transaksi</label>
            <div class="col-sm-12 col-md-10">
               <select name="id_transaksi" class="form-control" required>
                  <option value="">Pilih Transaksi</option>
                  @foreach($transaksi as $t)
                     <option value="{{$t->id}}">{{$t->nama}} - {{date('d/m/Y', strtotime($t->tanggal))}}</option>
                  @endforeach
               </select>
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Barang</label>
            <div class="col-sm-12 col-md-10">
               <select name="id_barang" class="form-control" required>
                  <option value="">Pilih Barang</option>
                  @foreach($barang as $b)
                     <option value="{{$b->id}}" data-harga="{{$b->harga}}">{{$b->nama}} - Rp {{number_format($b->harga, 0, ',', '.')}}</option>
                  @endforeach
               </select>
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Jumlah</label>
            <div class="col-sm-12 col-md-10">
               <input class="form-control" type="number" name="jumlah" placeholder="Masukkan jumlah" required min="1">
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Diskon</label>
            <div class="col-sm-12 col-md-10">
               <input class="form-control" type="number" name="diskon" placeholder="Masukkan diskon (opsional)" value="0" min="0">
            </div>
         </div>
         <div class="form-group row">
            <div class="col-sm-12 col-md-10 offset-md-2">
               <button type="submit" class="btn btn-primary">Simpan</button>
               <a href="/admin/detail-transaksi" class="btn btn-secondary">Kembali</a>
            </div>
         </div>
      </form>
   </div>
   <!-- Default Basic Forms End -->
</div>
@endsection
