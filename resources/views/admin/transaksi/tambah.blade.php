@extends('admin.layouts.app', [
'activePage' => 'transaksi',
])
@section('content')
<div class="min-height-200px">
   <div class="page-header">
      <div class="row">
         <div class="col-md-6 col-sm-12">
            <div class="title">
               <h4>Tambah Data Transaksi</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/admin/transaksi">Transaksi</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Tambah Data Transaksi</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
   <!-- Default Basic Forms Start -->
   <div class="pd-20 card-box mb-30">
      <div class="clearfix">
         <div class="pull-left">
            <h2 class="text-primary h2"><i class="icon-copy dw dw-add"></i> Form Tambah Data Transaksi</h2>
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
      
      <form method="POST" action="/admin/transaksi/create">
         @csrf
         <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Metode Pembayaran</label>
            <div class="col-sm-12 col-md-10">
               <select name="id_metode" class="form-control" required>
                  <option value="">Pilih Metode Pembayaran</option>
                  @foreach($metode as $m)
                     <option value="{{$m->id}}">{{$m->nama}}</option>
                  @endforeach
               </select>
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Tanggal</label>
            <div class="col-sm-12 col-md-10">
               <input class="form-control" type="date" name="tanggal" value="{{date('Y-m-d')}}" required>
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Pukul</label>
            <div class="col-sm-12 col-md-10">
               <input class="form-control" type="time" name="pukul" value="{{date('H:i')}}" required>
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Nama Pelanggan</label>
            <div class="col-sm-12 col-md-10">
               <input class="form-control" type="text" name="nama" placeholder="Masukkan nama pelanggan" required>
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Contact</label>
            <div class="col-sm-12 col-md-10">
               <input class="form-control" type="text" name="contact" placeholder="Masukkan contact pelanggan" required>
            </div>
         </div>
         
         <hr>
         <h4>Detail Barang</h4>
         <div id="barang-container">
            <div class="barang-item">
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>Barang</label>
                        <select name="barang[]" class="form-control barang-select" required>
                           <option value="">Pilih Barang</option>
                           @foreach($barang as $b)
                              <option value="{{$b->id}}" data-harga="{{$b->harga}}">{{$b->nama}} - Rp {{number_format($b->harga, 0, ',', '.')}}</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah[]" class="form-control jumlah-input" placeholder="Jumlah" required min="1">
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <label>Diskon</label>
                        <input type="number" name="diskon[]" class="form-control" placeholder="Diskon" value="0" min="0">
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <label>Subtotal</label>
                        <input type="text" class="form-control subtotal-input" readonly>
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="button" class="btn btn-danger btn-block hapus-barang">Hapus</button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         
         <div class="form-group">
            <button type="button" class="btn btn-success" id="tambah-barang">+ Tambah Barang</button>
         </div>
         
         <hr>
         <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Total</label>
            <div class="col-sm-12 col-md-10">
               <input class="form-control" type="text" id="total-display" readonly>
               <input type="hidden" name="total" id="total-input">
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Potongan</label>
            <div class="col-sm-12 col-md-10">
               <input class="form-control" type="number" name="potongan" placeholder="Masukkan potongan" value="0" min="0">
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Bayar</label>
            <div class="col-sm-12 col-md-10">
               <input class="form-control" type="number" name="bayar" placeholder="Masukkan jumlah bayar" required min="0">
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Kembali</label>
            <div class="col-sm-12 col-md-10">
               <input class="form-control" type="text" id="kembali-display" readonly>
               <input type="hidden" name="kembali" id="kembali-input">
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Status</label>
            <div class="col-sm-12 col-md-10">
               <select name="status" class="form-control">
                  <option value="pending">Pending</option>
                  <option value="completed">Completed</option>
                  <option value="cancelled">Cancelled</option>
               </select>
            </div>
         </div>
         <div class="form-group row">
            <div class="col-sm-12 col-md-10 offset-md-2">
               <button type="submit" class="btn btn-primary">Simpan</button>
               <a href="/admin/transaksi" class="btn btn-secondary">Kembali</a>
            </div>
         </div>
      </form>
   </div>
   <!-- Default Basic Forms End -->
</div>

<script>
$(document).ready(function() {
    // Hitung subtotal
    function hitungSubtotal(item) {
        var harga = item.find('.barang-select option:selected').data('harga') || 0;
        var jumlah = item.find('.jumlah-input').val() || 0;
        var diskon = item.find('input[name="diskon[]"]').val() || 0;
        var subtotal = (harga * jumlah) - diskon;
        item.find('.subtotal-input').val('Rp ' + subtotal.toLocaleString('id-ID'));
        return subtotal;
    }
    
    // Hitung total
    function hitungTotal() {
        var total = 0;
        $('.barang-item').each(function() {
            total += hitungSubtotal($(this));
        });
        $('#total-display').val('Rp ' + total.toLocaleString('id-ID'));
        $('#total-input').val(total);
        
        // Hitung kembali
        var potongan = $('input[name="potongan"]').val() || 0;
        var bayar = $('input[name="bayar"]').val() || 0;
        var kembali = bayar - (total - potongan);
        $('#kembali-display').val('Rp ' + kembali.toLocaleString('id-ID'));
        $('#kembali-input').val(kembali);
    }
    
    // Event handlers
    $(document).on('change', '.barang-select, .jumlah-input', function() {
        hitungSubtotal($(this).closest('.barang-item'));
        hitungTotal();
    });
    
    $(document).on('input', 'input[name="diskon[]"]', function() {
        hitungSubtotal($(this).closest('.barang-item'));
        hitungTotal();
    });
    
    $('input[name="potongan"], input[name="bayar"]').on('input', function() {
        hitungTotal();
    });
    
    // Tambah barang
    $('#tambah-barang').click(function() {
        var newItem = $('.barang-item').first().clone();
        newItem.find('input, select').val('');
        newItem.find('.subtotal-input').val('');
        $('#barang-container').append(newItem);
    });
    
    // Hapus barang
    $(document).on('click', '.hapus-barang', function() {
        if ($('.barang-item').length > 1) {
            $(this).closest('.barang-item').remove();
            hitungTotal();
        }
    });
    
    // Initial calculation
    hitungTotal();
});
</script>
@endsection
