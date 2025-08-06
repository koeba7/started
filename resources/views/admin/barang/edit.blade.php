@extends('admin.layouts.app', [
'activePage' => 'barang',
])
@section('content')
<div class="min-height-200px">
   <div class="page-header">
      <div class="row">
         <div class="col-md-6 col-sm-12">
            <div class="title">
               <h4>Data Barang</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Data Master</a></li>
                  <li class="breadcrumb-item"><a href="/admin/barang">Data Barang</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Edit Data Barang</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
   <!-- Striped table start -->
   <div class="pd-20 card-box mb-30">
      <div class="clearfix">
         <div class="pull-left">
            <h2 class="text-primary h2"><i class="icon-copy dw dw-edit-1"></i> Edit Data Barang</h2>
         </div>
         <div class="pull-right">
            <a href="/admin/barang" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
         </div>
      </div>
      <hr style="margin-top: 0px">
      <form action="/admin/barang/update/{{$barang->id}}" method="POST" enctype="multipart/form-data">
         {{ csrf_field() }}
         <div class="form-group">
            <label>Nama Barang<span class="text-danger">*</span></label>
            <input type="text" autofocus name="nama" required class="form-control" value="{{$barang->nama}}" placeholder="Masukkan Nama Barang .....">
         </div>
         <div class="form-group">
            <label>Kategori<span class="text-danger">*</span></label>
            <select name="id_kategori" required class="form-control select2">
               <option value="">Pilih Kategori</option>
               @foreach($kategori as $kat)
               <option value="{{$kat->id}}" {{$barang->id_kategori == $kat->id ? 'selected' : ''}}>{{$kat->nama}}</option>
               @endforeach
            </select>
         </div>
         <div class="form-group">
            <label>Jenis<span class="text-danger">*</span></label>
            <select name="id_jenis" required class="form-control select2">
               <option value="">Pilih Jenis</option>
               @foreach($jenis as $jen)
               <option value="{{$jen->id}}" {{$barang->id_jenis == $jen->id ? 'selected' : ''}}>{{$jen->nama}}</option>
               @endforeach
            </select>
         </div>
         <div class="form-group">
            <label>Harga<span class="text-danger">*</span></label>
            <input type="number" name="harga" required class="form-control" value="{{$barang->harga}}" placeholder="Masukkan Harga .....">     
         </div>
         <div class="form-group">
            <label>Foto</label>
            @if($barang->foto)
            <div class="mb-2">
               <img src="{{url('uploads/barang/'.$barang->foto)}}" alt="Foto Barang" style="max-width: 200px; max-height: 200px;">
               <br><small class="text-muted">Foto saat ini</small>
            </div>
            @endif
            <input type="file" name="foto" class="form-control" accept="image/*">
            <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</small>
         </div>
         <button type="submit" class="btn btn-primary mt-1 mr-2"><span class="icon-copy ti-save"></span> Update Data</button>               
      </form>
   </div>
   <!-- Striped table End -->
</div>
@endsection 