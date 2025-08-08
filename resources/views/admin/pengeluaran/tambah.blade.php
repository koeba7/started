@extends('admin.layouts.app', [
'activePage' => 'pengeluaran',
])
@section('content')
<div class="min-height-200px">
   <div class="page-header">
      <div class="row">
         <div class="col-md-12 col-sm-12">
            <div class="title">
               <h4>Data Pengeluaran</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Pengeluaran</a></li>
                  <li class="breadcrumb-item"><a href="/admin/pengeluaran">Data Pengeluaran</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Tambah Data Pengeluaran</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
   <!-- Striped table start -->
   <div class="pd-20 card-box mb-30">
      <div class="clearfix">
         <div class="pull-left">
            <h2 class="text-primary h2"><i class="icon-copy dw dw-add-file-1"></i> Tambah Data Pengeluaran</h2>
         </div>
         <div class="pull-right">
            <a href="/admin/pengeluaran" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
         </div>
      </div>
      <hr style="margin-top: 0px">
      <form action="/admin/pengeluaran/create" method="POST" enctype="multipart/form-data">
         {{ csrf_field() }}
         <div class="form-group">
            <label>Tanggal<span class="text-danger">*</span></label>
            <input type="date" autofocus name="tanggal" required class="form-control">
         </div>
         <!-- <div class="form-group">
            <label>Data Barang<span class="text-danger">*</span></label>
            <select name="id_barang" required class="form-control select2">
               <option value="">Pilih Data Barang</option>
               @foreach($barang as $item)
               <option value="{{$item->id}}">{{$item->nama}} ({{$item->nama_kategori}} - {{$item->nama_jenis}}) - Rp {{number_format($item->harga, 0, ',', '.')}}</option>
               @endforeach
            </select>
         </div> -->
         <div class="form-group">
            <label>Keterangan<span class="text-danger">*</span></label>
            <textarea name="keterangan" required class="form-control" rows="3" placeholder="Masukkan Keterangan ....."></textarea>
         </div>
         <div class="form-group">
            <label>Metode Pembayaran<span class="text-danger">*</span></label>
            <select name="id_metode" required class="form-control select2">
               <option value="">Pilih Metode Pembayaran</option>
               @foreach($metode_pembayaran as $metode)
               <option value="{{$metode->id}}">{{$metode->nama}}</option>
               @endforeach
            </select>
         </div>
         <div class="form-group">
            <label>Total<span class="text-danger">*</span></label>
            <input type="number" name="total" required class="form-control" placeholder="Masukkan Total .....">
         </div>
         <button type="submit" class="btn btn-primary mt-1 mr-2"><span class="icon-copy ti-save"></span> Tambah Data</button>               
      </form>
   </div>
   <!-- Striped table End -->
</div>
@endsection