@extends('admin.layouts.app', [
'activePage' => 'transaksi',
])
@section('content')
<style>
.date-filter {
    display: flex;
    align-items: center;
    gap: 10px;
}
.date-input {
    position: relative;
    display: inline-block;
}
.date-input input[type="date"] {
    padding: 8px 35px 8px 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background: #f8f9fa;
    font-size: 14px;
    color: #333;
    width: 150px;
}
.date-input::after {
    content: "📅";
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    font-size: 14px;
}
.filter-btn {
    padding: 8px 15px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
}
.filter-btn:hover {
    background: #0056b3;
}
.reset-btn {
    padding: 8px 15px;
    background: #6c757d;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    text-decoration: none;
}
.reset-btn:hover {
    background: #545b62;
    color: white;
    text-decoration: none;
}
</style>

<div class="min-height-200px">
   <div class="page-header">
      <div class="row">
         <div class="col-md-6 col-sm-12">
            <div class="title">
               <h4>Data Transaksi</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Data Transaksi</li>
               </ol>
            </nav>
         </div>
         <div class="col-md-6 col-sm-12">
            <div class="pull-right">
               <form method="GET" action="/admin/transaksi" class="date-filter">
                  <div class="date-input">
                     <input type="date" name="filter_date" class="form-control" value="{{ request('filter_date', date('Y-m-d')) }}">
                  </div>
                  <select name="status" class="form-control form-control-sm">
                     <option value="">Semua Status</option>
                     <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                     <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                     <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                  </select>
                  <button type="submit" class="filter-btn">Filter</button>
                  <a href="/admin/transaksi" class="reset-btn">Reset</a>
               </form>
            </div>
         </div>
      </div>
   </div>
   <!-- Striped table start -->
   <div class="pd-20 card-box mb-30">
      <div class="clearfix">
         <div class="pull-left">
            <h2 class="text-primary h2"><i class="icon-copy dw dw-shopping-cart"></i> List Data Transaksi</h2>
         </div>
         <div class="pull-right">
            <a href="/admin/transaksi/add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Transaksi</a>
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
      @if (session('success'))
      <div class="alert alert-success">
         {{ session('success')}}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
      </div>
      @endif
      @if (session('info'))
      <div class="alert alert-info">
         {{ session('info')}}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
      </div>
      @endif
                           <table class="table table-striped table-bordered data-table hover">
          <thead class="bg-primary text-white">
             <tr>
                <th width="5%" >#</th>
                <th>Tanggal</th>
                <th>Nama Pelanggan</th>
                <th>Total</th>
                <th>Status</th>
                <th class="table-plus datatable-nosort text-center">Action</th>
             </tr>
          </thead>
          <tbody>
             <?php $no = 1; ?>
             @foreach($transaksi as $data)
             <tr>
                <td class="text-center">{{$no++}}</td>
                <td>{{date('d/m/Y', strtotime($data->tanggal))}} {{$data->pukul}}</td>
                <td>{{$data->nama}}</td>
                <td>Rp {{number_format($data->total, 0, ',', '.')}}</td>
                <td>
                   @if($data->status == 'pending')
                      <span class="badge badge-warning">Pending</span>
                   @elseif($data->status == 'completed')
                      <span class="badge badge-success">Completed</span>
                   @else
                      <span class="badge badge-danger">Cancelled</span>
                   @endif
                </td>
                <td class="text-center" width="20%">
                   <button class="btn btn-info btn-xs" data-toggle="modal" data-target="#detail-{{$data->id}}"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="Lihat Detail"></i></button>
                   <a href="/admin/transaksi/edit/{{$data->id}}"><button class="btn btn-success btn-xs"><i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="Edit Data"></i></button></a>
                   <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#data-{{$data->id}}"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete Data"></i></button>
                </td>
             </tr>
             @endforeach
          </tbody>
       </table>
   </div>
   <!-- Striped table End -->
</div>
<!-- Modal -->
@foreach($transaksi as $data)
<div class="modal fade" id="data-{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <h2 class="text-center">
            Apakah Anda Yakin Menghapus Data Ini ?
            </h2>
            <hr>
            <div class="form-group" style="font-size: 17px;">
               <label for="exampleInputUsername1">Tanggal</label>
               <input class="form-control" value="{{date('d/m/Y', strtotime($data->tanggal))}}" readonly style="background-color: white;pointer-events: none;">
            </div>
            <div class="form-group" style="font-size: 17px;">
               <label for="exampleInputUsername1">Nama Pelanggan</label>
               <input class="form-control" value="{{$data->nama}}" readonly style="background-color: white;pointer-events: none;">
            </div>
            <div class="form-group" style="font-size: 17px;">
               <label for="exampleInputUsername1">Total</label>
               <input class="form-control" value="Rp {{number_format($data->total, 0, ',', '.')}}" readonly style="background-color: white;pointer-events: none;">
            </div>
            <div class="row mt-4">
               <div class="col-md-6">
                  <a href="/admin/transaksi/delete/{{$data->id}}" style="text-decoration: none;">
                  <button type="button" class="btn btn-primary btn-block">Ya</button>
                  </a>
               </div>
               <div class="col-md-6">
                  <button type="button" class="btn btn-danger btn-block" data-dismiss="modal" aria-label="Close">Tidak</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endforeach

<!-- Modal Detail Transaksi -->
@foreach($transaksi as $data)
<div class="modal fade" id="detail-{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="detailModalLabel">Detail Transaksi - {{$data->nama}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
                   <div class="modal-body">
             <div class="row">
                <div class="col-md-12">
                   <h5 class="text-primary mb-3"><i class="fa fa-info-circle"></i> Informasi Transaksi</h5>
                   <div class="row">
                      <div class="col-md-6">
                         <table class="table table-borderless">
                            <tr>
                               <td width="30%"><strong>Tanggal & Waktu</strong></td>
                               <td>: {{date('d/m/Y', strtotime($data->tanggal))}} - {{$data->pukul}}</td>
                            </tr>
                            <tr>
                               <td><strong>Nama Pelanggan</strong></td>
                               <td>: {{$data->nama}}</td>
                            </tr>
                            <tr>
                               <td><strong>Contact</strong></td>
                               <td>: {{$data->contact}}</td>
                            </tr>
                            <tr>
                               <td><strong>Metode Pembayaran</strong></td>
                               <td>: {{$data->nama_metode}}</td>
                            </tr>
                            <tr>
                               <td><strong>Status</strong></td>
                               <td>: 
                                  @if($data->status == 'pending')
                                     <span class="badge badge-warning">Pending</span>
                                  @elseif($data->status == 'completed')
                                     <span class="badge badge-success">Completed</span>
                                  @else
                                     <span class="badge badge-danger">Cancelled</span>
                                  @endif
                               </td>
                            </tr>
                         </table>
                      </div>
                      <div class="col-md-6">
                         <table class="table table-borderless">
                            <tr>
                               <td width="30%"><strong>Total Transaksi</strong></td>
                               <td>: <span class="text-primary font-weight-bold">Rp {{number_format($data->total, 0, ',', '.')}}</span></td>
                            </tr>
                            <tr>
                               <td><strong>Potongan</strong></td>
                               <td>: Rp {{number_format($data->potongan, 0, ',', '.')}}</td>
                            </tr>
                            <tr>
                               <td><strong>Bayar</strong></td>
                               <td>: Rp {{number_format($data->bayar, 0, ',', '.')}}</td>
                            </tr>
                            <tr>
                               <td><strong>Kembali</strong></td>
                               <td>: Rp {{number_format($data->kembali, 0, ',', '.')}}</td>
                            </tr>
                         </table>
                      </div>
                   </div>
                </div>
             </div>
            
                         <hr>
             <h5 class="text-success mb-3"><i class="fa fa-shopping-cart"></i> Detail Item Transaksi</h5>
             <div class="table-responsive">
                <table class="table table-striped table-bordered">
                   <thead class="bg-success text-white">
                      <tr>
                         <th width="5%">No</th>
                         <th width="40%">Nama Barang</th>
                         <th width="10%" class="text-center">Jumlah</th>
                         <th width="15%" class="text-right">Harga Satuan</th>
                         <th width="15%" class="text-right">Diskon</th>
                         <th width="15%" class="text-right">Total</th>
                      </tr>
                   </thead>
                   <tbody>
                      @php
                         $detail_items = DB::table('detail_transaksi')
                            ->join('barang', 'detail_transaksi.id_barang', '=', 'barang.id')
                            ->where('detail_transaksi.id_transaksi', $data->id)
                            ->select('detail_transaksi.*', 'barang.nama as nama_barang')
                            ->get();
                         $no_detail = 1;
                         $total_items = 0;
                      @endphp
                      @foreach($detail_items as $item)
                      <tr>
                         <td class="text-center">{{$no_detail++}}</td>
                         <td><strong>{{$item->nama_barang}}</strong></td>
                         <td class="text-center">{{$item->jumlah}}</td>
                         <td class="text-right">Rp {{number_format($item->harga, 0, ',', '.')}}</td>
                         <td class="text-right">Rp {{number_format($item->diskon, 0, ',', '.')}}</td>
                         <td class="text-right"><strong>Rp {{number_format($item->total, 0, ',', '.')}}</strong></td>
                      </tr>
                      @php $total_items += $item->total; @endphp
                      @endforeach
                      <tr class="bg-light">
                         <td colspan="5" class="text-right"><strong>Total Semua Item:</strong></td>
                         <td class="text-right"><strong class="text-success">Rp {{number_format($total_items, 0, ',', '.')}}</strong></td>
                      </tr>
                   </tbody>
                </table>
             </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <a href="/admin/transaksi/edit/{{$data->id}}" class="btn btn-primary">Edit Transaksi</a>
         </div>
      </div>
   </div>
</div>
@endforeach
@endsection
