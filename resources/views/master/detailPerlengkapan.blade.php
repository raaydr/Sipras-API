@extends('general.layout')
@section('head')
<style>
   .ui-autocomplete.ui-menu {
   z-index: 3001;
   } 
</style>
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1>Detail Perlengkapan</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="/">Perlengkapan</a></li>
               <li class="breadcrumb-item active">Detail-Perlengkapan</li>
            </ol>
         </div>
      </div>
   </div>
   <!-- /.container-fluid -->
</section>
<section class="content">
   <div class="container-fluid">
      @if(session('pesan'))
      <div class="alert alert-success alert-dismissable">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
         <h4><i class="icon fa fa-check"></i>Success</h4>
         {{session('pesan')}}.
      </div>
      @endif
      <div class="col-12" id="accordion">
         <div class="card card-warning card-outline">
            <a class="d-block w-100" data-toggle="collapse" href="#collapseFour">
               <div class="card-header">
                  <h4 class="card-title w-100">
                     <b>Edit Perlengkapan</b> 
                  </h4>
               </div>
            </a>
            <div id="collapseFour" class="collapse show" data-parent="#accordion">
               <!-- form start -->
               <form id="formTarget1" enctype="multipart/form-data" >
                  @csrf  
                  <div class="card-body">
                  <input type="hidden" id="id" name="id" value="{{$perlengkapan->id}}" >
                     <input type="hidden" id="barang_id" name="barang_id" value="{{$barang->id}}" >
                     <input type="hidden" id="kode" name="kode" value="{{$barang->kode_barang}}" >
                     <div class="form-group row">
                        <label for="jumlah_perlengkapan" class="col-md-4 col-form-label text-md-right">{{ __('Jumlah Barang') }}</label>
                        <div class="col-md-6">
                           <input id="jumlah_perlengkapan" type="text" class="form-control" name="jumlah_perlengkapan" value="{{ $perlengkapan->jumlah_perlengkapan }}"required autofocus />
                           @if ($errors->has('jumlah_perlengkapan'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('jumlah_perlengkapan') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="harga_perlengkapan" class="col-md-4 col-form-label text-md-right">{{ __('Harga Lama') }}</label>
                        <div class="col-md-6">
                        <a read only><b><omset  ></omset></b></a>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="harga_perlengkapan" class="col-md-4 col-form-label text-md-right">{{ __('Harga Baru') }}</label>
                        <div class="col-md-6">
                           <input id="harga_perlengkapan" type="text" class="form-control @error('harga_perlengkapan') is-invalid @enderror" name="harga_perlengkapan" value="" autocomplete="harga_perlengkapan"></input>
                           @error('harga_perlengkapan')
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="keterangan_perlengkapan" class="col-md-4 col-form-label text-md-right">{{ __('Keterangan') }}</label>
                        <div class="col-md-6">
                           <textarea id="keterangan_perlengkapan" type="text" class="form-control" name="keterangan_perlengkapan" value="{{ old('keterangan_perlengkapan') }}"required autofocus>{{$perlengkapan->keterangan_perlengkapan}}</textarea>
                           @if ($errors->has('keterangan_perlengkapan'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('keterangan_perlengkapan') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="tanggal_pembelian" class="col-md-4 col-form-label text-md-right">{{ __('Tanggal Pembelian') }}</label>
                        <div class="col-md-6">
                           <div class="input-group date">
                              <div class="input-group-addon">
                                 <span class="glyphicon glyphicon-th"></span>
                              </div>
                              <input placeholder="tanggal pembelian" type="text" class="form-control datepicker" name="tanggal_pembelian"  value="{{$perlengkapan->tanggal_pembelian}}"   />
                           </div>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="lokasi_perlengkapan" class="col-md-4 col-form-label text-md-right">{{ __('lokasi perlengkapan') }}</label>
                        <div class="col-md-6">
                           <input id="lokasi_perlengkapan" type="text" class="form-control" name="lokasi_perlengkapan" value="{{ $perlengkapan->lokasi_perlengkapan}}"required autofocus />
                           @if ($errors->has('lokasi_perlengkapan'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('lokasi_perlengkapan') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="departemen" class="col-md-4 col-form-label text-md-right">{{ __('departemen') }}</label>
                        <div class="col-md-6">
                           <input id="departemen" type="text" class="form-control" name="departemen" value="{{ $perlengkapan->departemen }}"required autofocus />
                           @if ($errors->has('departemen'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('departemen') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="foto" class="col-md-4 col-form-label text-md-right">{{ __('foto perlengkapan') }}</label>
                        <div class="col-md-4">
                           <input id="foto_perlengkapan" type="file" class="form-control" name="foto_perlengkapan" value="{{ old('foto_perlengkapan') }}" ></input>
                           @if ($errors->has('foto_perlengkapan'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('foto_perlengkapan') }}</strong>
                           </span>
                           @endif
                        </div>
                        <div class="col-md-2">
                        <a href="{{asset('foto-perlengkapan')}}/{{$perlengkapan->foto_perlengkapan}}" target="_blank" class="btn btn-outline-primary">Gambar Sebelumnya</a>
                     </div>
                     </div>
                     <div class="form-group row">
                        <label for="kondisi_perlengkapan" class="col-md-4 col-form-label text-md-right">{{ __('Kondisi Perlengkapan') }}</label>
                        <div class="col-md-8">
                           <div class="custom-control custom-radio custom-control-inline mt-2">
                              <input type="radio" id="customRadioInline1" name="kondisi_perlengkapan" class="custom-control-input" value="1" {{ ($perlengkapan->kondisi_perlengkapan == 1)? "checked" : "" }}/>
                              <label class="custom-control-label" for="customRadioInline1">Bagus</label>
                           </div>
                           <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="customRadioInline2" name="kondisi_perlengkapan" class="custom-control-input" value="2" {{ ($perlengkapan->kondisi_perlengkapan == 2)? "checked" : "" }} />
                              <label class="custom-control-label" for="customRadioInline2">Kurang Bagus</label>
                           </div>
                           <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="customRadioInline3" name="kondisi_perlengkapan" class="custom-control-input" {{ ($perlengkapan->kondisi_perlengkapan == 3)? "checked" : "" }} />
                              <label class="custom-control-label" for="customRadioInline3">Rusak</label>
                           </div>
                           @if ($errors->has('kondisi_perlengkapan'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('kondisi_perlengkapan') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="leandable_perlengkapan" class="col-md-4 col-form-label text-md-right">{{ __('Peminjaman Perlengkapan') }}</label>
                        <div class="col-md-8">
                           <div class="custom-control custom-radio custom-control-inline mt-2">
                              <input type="radio" id="customRadioInline4" name="leandable_perlengkapan" class="custom-control-input" value="1" {{ ($perlengkapan->leandable_perlengkapan == 1)? "checked" : "" }} />
                              <label class="custom-control-label" for="customRadioInline4">Bisa Dipinjam</label>
                           </div>
                           <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="customRadioInline5" name="leandable_perlengkapan" class="custom-control-input" value="2" {{ ($perlengkapan->leandable_perlengkapan == 2)? "checked" : "" }} />
                              <label class="custom-control-label" for="customRadioInline5">Tidak Boleh</label>
                           </div>
                           @if ($errors->has('leandable_perlengkapan'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('leandable_perlengkapan') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                     <!-- /.card-body -->
                     <div class="text-center">
                        <button class="btn btn-success btn-submit" id="simpanBTN1">Submit</button>
                        <div id="load1" class="spinner-border text-primary"></div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
         <div class="card card-danger card-outline">
            <a class="d-block w-100" data-toggle="collapse" href="#collapseSeven">
               <div class="card-header">
                  <h4 class="card-title w-100">
                     <b>Mutasi Perlengkapan</b> 
                  </h4>
               </div>
            </a>
            <div id="collapseSeven" class="collapse" data-parent="#accordion">
               <!-- form start -->
               <form id="formTarget" enctype="multipart/form-data" >
                  @csrf  
                  <div class="card-body">
                  <input type="hidden" id="perlengkapan_id" name="perlengkapan_id" value="{{$perlengkapan->id}}" >
                  <input type="hidden" id="kode" name="kode" value="{{$perlengkapan->kode_perlengkapan}}" >
                     <input type="hidden" id="barang_id" name="barang_id" value="{{$barang->id}}" >
                     <div class="form-group row">
                        <label for="lokasi_penempatan_lama" class="col-md-4 col-form-label text-md-right">{{ __('Lokasi Perlengkapan yang Lama') }}</label>
                        <div class="col-md-6">
                           <input id="lokasi_penempatan_lama" type="text" class="form-control" name="lokasi_penempatan_lama" value="{{$perlengkapan->lokasi_perlengkapan}}"required autofocus />
                           @if ($errors->has('lokasi_penempatan_lama'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('lokasi_penempatan_lama') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="lokasi_penempatan_baru" class="col-md-4 col-form-label text-md-right">{{ __('Lokasi Perlengkapan yang Baru') }}</label>
                        <div class="col-md-6">
                           <input id="lokasi_penempatan_baru" type="text" class="form-control" name="lokasi_penempatan_baru"required autofocus />
                           @if ($errors->has('lokasi_penempatan_baru'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('lokasi_penempatan_baru') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="departemen_lama" class="col-md-4 col-form-label text-md-right">{{ __('Departemen yang lama') }}</label>
                        <div class="col-md-6">
                           <input id="departemen_lama" type="text" class="form-control" name="departemen_lama" value="{{$perlengkapan->departemen}}" required autofocus/>
                           @if ($errors->has('departemen_lama'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('departemen_lama') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="departemen_baru" class="col-md-4 col-form-label text-md-right">{{ __('Departemen yang baru') }}</label>
                        <div class="col-md-6">
                           <input id="departemen_baru" type="text" class="form-control" name="departemen_baru" required autofocus/>
                           @if ($errors->has('departemen_baru'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('departemen_baru') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                     
                     <div class="form-group row">
                        <label for="tanggal_mutasi" class="col-md-4 col-form-label text-md-right">{{ __('Tanggal Mutasi') }}</label>
                        <div class="col-md-6">
                           <div class="input-group date">
                              <div class="input-group-addon">
                                 <span class="glyphicon glyphicon-th"></span>
                              </div>
                              <input placeholder="tanggal mutasi" type="text" class="form-control datepicker" name="tanggal_mutasi" required autofocus    />
                           </div>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="foto_pemindahan" class="col-md-4 col-form-label text-md-right">{{ __('foto pemindahan') }}</label>
                        <div class="col-md-4">
                           <input id="foto_pemindahan" type="file" class="form-control" name="foto_pemindahan" value="{{ old('foto_pemindahan') }}" ></input>
                           @if ($errors->has('foto_pemindahan'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('foto_pemindahan') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="keterangan" class="col-md-4 col-form-label text-md-right">{{ __('Keterangan') }}</label>
                        <div class="col-md-6">
                           <textarea id="keterangan" type="text" class="form-control" name="keterangan" value="{{ old('keterangan') }}"required autofocus></textarea>
                           @if ($errors->has('keterangan'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('keterangan') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                     <!-- /.card-body -->
                     <div class="text-center">
                        <button class="btn btn-success btn-submit" id="simpanBTN">Submit</button>
                        <div id="load" class="spinner-border text-primary"></div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <div class="col-md-12">
         <!-- general form elements -->
         <div class="card card-primary">
            <div class="card-header">
               <h3 class="card-title">perlengkapan Edit</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
         </div>
         <!-- /.card -->
      </div>
      <div class="col-12">
         <div class="card">
            <div class="card-header">
               <h3 class="card-title">List perlengkapan</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
               <table id="example1" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>no</th>
                        <th>Loasi Baru</th>
                        <th>Departemen Baru</th>
                        <th>Tanggal</th>
                        <th>Gambar</th>
                        <th>action</th>
                     </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                     <tr>
                     <th>no</th>
                        <th>Loasi Baru</th>
                        <th>Departemen Baru</th>
                        <th>Tanggal</th>
                        <th>Gambar</th>
                        <th>action</th>
                     </tr>
                  </tfoot>
               </table>
            </div>
            <!-- /.card-body -->
         </div>
         <!-- /.card -->
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</section>
@endsection
@section('script')
<script>
    function goBack() {
        window.history.back();
        }
        function rupiah(){
               var bilangan = {{$harga_perlengkapan}};
               var	number_string = bilangan.toString(),
               sisa 	= number_string.length % 3,
               rupiah 	= number_string.substr(0, sisa),
               ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
               
               if (ribuan) {
                  separator = sisa ? '.' : '';
                  rupiah += separator + ribuan.join('.');
               }
               
               // Cetak hasil
               
                  
               
               $("omset").text("Rp "+rupiah)
         
         //the function body is the same as you have defined sue the textbox object to set the value
         }
         rupiah();
   $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   });
   $(function() {
       $("#example1")
           .DataTable({
               processing: true,
               serverSide: true,
               ajax: {
                   url: "{{route('tabelMutasiPerlengkapan',$perlengkapan->id)}}",
                   type: 'GET'
               },
               columns: [{
                       data: 'DT_RowIndex',
                       name: 'DT_RowIndex'
                   },
                   {
                       data: 'Lokasi',
                       name: 'Lokasi',
                       orderable: true,
                       searchable: true
                   },
                   {
                       data: 'Departemen',
                       name: 'Departemen',
                       orderable: true,
                       searchable: true
                   },
                   {
                       data: 'tanggal',
                       name: 'tanggal',
                       orderable: true,
                       searchable: true
                   },
                   {
                       data: 'image',
                       name: 'image',
                   },
                   
                   {
                       data: 'action',
                       name: 'action'
                   },
   
   
               ],
               order: [
                   [0, 'asc']
               ],
               responsive: true,
               lengthChange: false,
               autoWidth: false,
               buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
               initComplete: function() {
                   // Apply the search
                   this.api()
                       .columns()
                       .every(function() {
                           var that = this;
   
                           $('input', this.header()).on('keyup change clear', function() {
                               if (that.search() !== this.value) {
                                   that.search(this.value).draw();
                               }
                           });
                       });
               },
           })
           .buttons()
           .container()
           .appendTo("#example1_wrapper .col-md-6:eq(0)");
   });
   var rupiah = document.getElementById("harga_perlengkapan");
         harga_perlengkapan.addEventListener("keyup", function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah.value = formatRupiah(this.value, "Rp. ");
         });
         
         /* Fungsi formatRupiah */
         function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            
            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
            }
            
            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
         }
        
   $('#load').hide();
   $('#load1').hide();
   $(function() {
       $(".datepicker").datepicker({
           format: 'yyyy-mm-dd',
           autoclose: true,
           todayHighlight: true,
       });
       // Summernote
       $('#summernote').summernote()
   
   })
   $(function() {
       $(document).on('click', '[data-toggle="lightbox"]', function(event) {
           event.preventDefault();
           $(this).ekkoLightbox({
               alwaysShowClose: true
           });
       });
   
       $('.btn[data-filter]').on('click', function() {
           $('.btn[data-filter]').removeClass('active');
           $(this).addClass('active');
       });
   })
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   $(document).ready(function() {    
       $('body').on('click', '.deleteMutasi', function() {
           var Item_id = $(this).data("id");
           var url = '{{ route("MutasiDelete",[":id"]) }}';
           url = url.replace(':id', Item_id);
           $.ajax({
   
               type: "GET",
   
               url: url,
   
               success: function(data) {
   
                   iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                       title: 'Data Berhasil Disimpan',
                       message: '{{ Session('
                       success ')}}',
                       position: 'bottomRight'
                   });
                   var oTable = $('#example1').dataTable(); //inialisasi datatable
                   oTable.fnDraw(false); //reset datatable
   
               },
   
               error: function(data) {
   
                   console.log('Error:', data);
   
               }
   
           });
   
       });
       $('body').on('click', '.publishPerlengkapan', function() {
           var Item_id = $(this).data("id");
           var url = '{{ route("PerlengkapanPublish",[":id"]) }}';
           url = url.replace(':id', Item_id);
           $.ajax({
   
               type: "GET",
   
               url: url,
   
               success: function(data) {
   
                   iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                       title: 'Data Berhasil Disimpan',
                       message: '{{ Session('
                       success ')}}',
                       position: 'bottomRight'
                   });
                   var oTable = $('#example1').dataTable(); //inialisasi datatable
                   oTable.fnDraw(false); //reset datatable
   
               },
   
               error: function(data) {
   
                   console.log('Error:', data);
   
               }
   
           });
   
       });
       if ($("#formTarget").length > 0) {
           $.validator.addMethod('filesize', function(value, element, param) {
               return this.optional(element) || (element.files[0].size <= param * 1000000)
           }, 'File size must be less than {0} MB');
   
           $("#formTarget").validate({
   
               rules: {
   
                  lokasi_penempatan_baru: {
                       required: true,
                   },
                   
                  lokasi_penempatan_lama: {
                       required: true,
                   },
                   departemen_lama: {
                       required: true,
                   },
                   departemen_baru: {
                       required: true,
   
   
                   },
                   tanggal_mutasi: {
                       required: true,
   
   
                   },
                   keterangan: {
                       required: true,
   
   
                   },
   
               },
               messages: {
                  lokasi_penempatan_baru: {
                       required: 'Tolong Diisi',
   
                   },
                   lokasi_penempatan_lama: {
                       required: 'Tolong Diisi',
   
                   },
                   departemen_baru: {
                       required: 'Tolong Diisi',
   
                   },
                   departemen_lama: {
                       required: 'Tolong Diisi',
   
                   },
                   keterangan: {
                       required: 'Tolong Diisi',
   
                   },
                   tanggal_mutasi: {
                       required: 'Tolong Diisi',
   
                   },
                   
               },
               submitHandler: function(form) {
                   var actionType = $('#simpanBTN').val();
                   $('#simpanBTN').html('Sending..');
                   $('#load').show();
                   var form = $("#formTarget").closest("form");
                   var formData = new FormData(form[0]);
                   $.ajax({
                       xhr: function() {
                           var xhr = new window.XMLHttpRequest();
                           xhr.upload.addEventListener("progress", function(evt) {
                               if (evt.lengthComputable) {
                                   var percentComplete = Math.round(((evt.loaded / evt.total) * 100));
                                   $(".progress-bar").width(percentComplete + '%');
                                   $(".progress-bar").html(percentComplete + '%');
                               }
                           }, false);
                           return xhr;
                       },
                       data: formData,
                       url: "{{ route('MutasiUpdate') }}", //url simpan data
                       type: "POST", //karena simpan kita pakai method POST
                       dataType: 'json', //data tipe kita kirim berupa JSON
                       processData: false,
                       contentType: false,
                       success: function(data) { //jika berhasil
                           switch (data.status) {
                               case 0:
                                   $('#load').hide();
                                   $('#simpanBTN').html('Submit');
                                   $('#simpanBTN').show();
                                   iziToast.error({
                                       title: 'Error',
                                       message: data.error,
                                   });
                                   console.log('Error:', "periksa");
                                   break;
                               case 1:
                                   $('#load').hide();
                                   $('#simpanBTN').html('Submit'); //tombol simpan
                                   $('#simpanBTN').show();
                                   document.getElementById("formTarget1").reset();
                                   var oTable = $('#example1').dataTable(); //inialisasi datatable
                                    oTable.fnDraw(false); //reset datatable 
                                    location.reload();
                                   //$('#uploadStatus').html('<p style="color:#28A74B;">File Berhasil diupload!</p>');
                                   iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                                       title: 'Data Berhasil Disimpan',
                                       message: '{{ Session('
                                       success ')}}',
                                       position: 'bottomRight'
                                   });
                                   break;
                               default:
                                   // code block
   
                           }
   
                       },
                       error: function(data) { //jika error tampilkan error pada console
                           $('#load').hide();
   
   
                           $('#simpanBTN').html('Submit'); //tombol simpan
                           iziToast.error({
                               title: 'Error',
                               message: 'Illegal operation',
                           });
                           console.log('Error:', "Data kosong");
   
                       }
                   });
               }
           })
       }

       if ($("#formTarget1").length > 0) {
           $.validator.addMethod('filesize', function(value, element, param) {
               return this.optional(element) || (element.files[0].size <= param * 1000000)
           }, 'File size must be less than {0} MB');
   
           $("#formTarget1").validate({
   
               rules: {
   
                    jumlah_perlengkapan: {
                       required: true,
                       number: true,
   
   
                   },
                   
                   keterangan_perlengkapan: {
                       required: true,
   
   
                   },
                   tanggal_pembelian: {
                       required: true,
                   },
                   lokasi_perlengkapan: {
                       required: true,
                   },
                   departemen: {
                       required: true,
                   },
                   kondisi_perlengkapan: {
                       required: true,
                   },
                   leandable_perlengkapan: {
                       required: true,
                   },
                   foto_perlengkapan: {
                        
                        extension: "jpeg|jpg|png",
                          filesize : 5, // here we are working with MB
                           
                        },
   
               },
               messages: {
                jumlah_perlengkapan: {
                       required: 'Tolong Diisi',
                       number: 'Tolong Diisi hanya dengan angka',
   
                   },
                   
                   keterangan_perlengkapan: {
                       required: 'Tolong Diisi',
   
                   },
                   tanggal_pembelian: {
                       required: 'Tolong Diisi',
   
                   },
                   lokasi_perlengkapan: {
                       required: 'Tolong Diisi',
   
                   },
                   departemen: {
                       required: 'Tolong Diisi',
   
                   },
                   kondisi_perlengkapan: {
                       required: 'Tolong Diisi',
   
                   },

                   leandable_perlengkapan: {
                       required: 'Tolong Diisi',
   
                   },
                   foto_perlengkapan: {
                     
                     extension: 'Harap mengupload file dengan format jpeg,jpg,png',
                     filesize: 'ukuran file terlalu besar, harap upload file dibawah 5 mb',
                       
                    },
                   
               },
               submitHandler: function(form) {
                   var actionType = $('#simpanBTN1').val();
                   $('#simpanBTN1').html('Sending..');
                   $('#load1').show();
                   var form = $("#formTarget1").closest("form");
                   var formData = new FormData(form[0]);
                   $.ajax({
                       xhr: function() {
                           var xhr = new window.XMLHttpRequest();
                           xhr.upload.addEventListener("progress", function(evt) {
                               if (evt.lengthComputable) {
                                   var percentComplete = Math.round(((evt.loaded / evt.total) * 100));
                                   $(".progress-bar").width(percentComplete + '%');
                                   $(".progress-bar").html(percentComplete + '%');
                               }
                           }, false);
                           return xhr;
                       },
                       data: formData,
                       url: "{{ route('PerlengkapanUpdate') }}", //url simpan data
                       type: "POST", //karena simpan kita pakai method POST
                       dataType: 'json', //data tipe kita kirim berupa JSON
                       processData: false,
                       contentType: false,
                       success: function(data) { //jika berhasil
                           switch (data.status) {
                               case 0:
                                   $('#load1').hide();
                                   $('#simpanBTN1').html('Submit');
                                   $('#simpanBTN1').show();
                                   iziToast.error({
                                       title: 'Error',
                                       message: data.error,
                                   });
                                   console.log('Error:', "periksa");
                                   break;
                               case 1:
                                   $('#load1').hide();
                                   $('#simpanBTN1').html('Submit'); //tombol simpan
                                   $('#simpanBTN1').show();
                                   location.reload();
                                   //$('#uploadStatus').html('<p style="color:#28A74B;">File Berhasil diupload!</p>');
                                   iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                                       title: 'Data Berhasil Disimpan',
                                       message: '{{ Session('
                                       success ')}}',
                                       position: 'bottomRight'
                                   });
                                   break;
                                 case 2:
                                   $('#load1').hide();
                                   $('#simpanBTN1').html('Submit'); //tombol simpan
                                   $('#simpanBTN1').show();
                                   
                                   //$('#uploadStatus').html('<p style="color:#28A74B;">File Berhasil diupload!</p>');
                                   iziToast.success({ //tampilkan iziToast dengan notif data berhasil disimpan pada posisi kanan bawah
                                       title: 'Data Berhasil Disimpan',
                                       message: '{{ Session('
                                       success ')}}',
                                       position: 'bottomRight'
                                   });
                                   break;
                               default:
                                   // code block
   
                           }
   
                       },
                       error: function(data) { //jika error tampilkan error pada console
                           $('#load1').hide();
   
   
                           $('#simpanBTN1').html('Submit'); //tombol simpan
                           iziToast.error({
                               title: 'Error',
                               message: 'Illegal operation',
                           });
                           console.log('Error:', "Data kosong");
   
                       }
                   });
               }
           })
       }
       function printErrorMsg(msg) {
   
           $(".print-error-msg").find("ul").html('');
   
           $(".print-error-msg").css('display', 'block');
   
           $.each(msg, function(key, value) {
   
               $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
   
           });
   
       }
   
   });
</script>
@endsection
