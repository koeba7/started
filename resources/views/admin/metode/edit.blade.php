@extends('admin.layouts.app', [
'activePage' => 'metode',
])
@section('content')
<div class="min-height-200px">
   <div class="page-header">
      <div class="row">
         <div class="col-md-6 col-sm-12">
            <div class="title">
               <h4>Edit Data Metode</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/admin/metode">Master Data</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Edit Data Metode</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
   <!-- Default Basic Forms Start -->
   <div class="pd-20 card-box mb-30">
      <div class="clearfix">
         <div class="pull-left">
            <h2 class="text-primary h2"><i class="icon-copy dw dw-edit"></i> Form Edit Data Metode</h2>
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
      
      <form method="POST" action="/admin/metode/update/{{$metode->id}}">
         @csrf
         <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Nama Metode</label>
            <div class="col-sm-12 col-md-10">
               <input class="form-control" type="text" name="nama" value="{{$metode->nama}}" placeholder="Masukkan nama metode" required>
            </div>
         </div>
         <div class="form-group row">
            <div class="col-sm-12 col-md-10 offset-md-2">
               <button type="submit" class="btn btn-primary">Update</button>
               <a href="/admin/metode" class="btn btn-secondary">Kembali</a>
            </div>
         </div>
      </form>
   </div>
   <!-- Default Basic Forms End -->
</div>
@endsection
