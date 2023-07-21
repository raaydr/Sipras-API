@extends('general.layout')
@section('head')
<link rel="stylesheet" href="{{asset('jquery-ui')}}/jquery-ui.min.css" type="text/css"/>
<link rel="stylesheet" href="{{asset('jquery-ui')}}/jquery-ui.structure.min.css"type="text/css"/>
<link rel="stylesheet" href="{{asset('jquery-ui')}}/jquery-ui.theme.min.css"type="text/css"/>
<link href="{{asset('colorlib-reg')}}/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">
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
            <h1>Mutasi Perlengkapan</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="/">Mutasi</a></li>
               <li class="breadcrumb-item active">Mutasi-Perlengkapan</li>
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
      <!-- /.modal -->
      <div class="modal fade" id="modal-edit-konten">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header bg-primary">
                  <h4 class="modal-title">Mutasi </h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <form id="formTarget" enctype="multipart/form-data" >
                  @csrf     
                  <div class="modal-body">
                  <input type="hidden" id="perlengkapan_id" name="perlengkapan_id"  >
                     <input type="hidden" id="barang_id" name="barang_id" >
                     <div class="form-group row">
                        <label for="lokasi_penempatan_lama" class="col-md-4 col-form-label text-md-right">{{ __('Lokasi Perlengkapan yang Lama') }}</label>
                        <div class="col-md-6">
                           <input id="lokasi_penempatan_lama" type="text" class="form-control" name="lokasi_penempatan_lama" required autofocus />
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
                           <input id="departemen_lama" type="text" class="form-control" name="departemen_lama"  required autofocus/>
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
                              <input placeholder="tanggal mutasi" type="text" class="form-control js-datepicker" name="tanggal_mutasi" required autofocus    />
                           </div>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="foto_pemindahan" class="col-md-4 col-form-label text-md-right">{{ __('foto pemindahan') }}</label>
                        <div class="col-md-4">
                           <input id="foto_pemindahan" type="file" class="form-control" name="foto_pemindahan" value="{{ old('foto_pemindahan') }}" ></input>
                           <p class="text-primary" role="alert">
                           <strong>file harus jpeg,jpg,png dan maksimal 2 MB</strong>
                           </p>
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
                  <div class="modal-footer justify-content-between ">
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                     <button class="btn btn-outline-primary btn-submit" id="tombol-simpan">Submit</button>
                     <div id="load" class="spinner-border text-primary"></div>
                  </div>
               </form>
            </div>
            <!-- /.modal-content -->
         </div>
         <!-- /.modal-dialog -->
      </div>
      <div class="col-12">
         <div class="card">
            <div class="card-header">
               <h3 class="card-title">List Mutasi Perlengkapan</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
               <table id="example1" class="table table-bordered table-striped">
               <thead>
                     <tr>
                        <th>no</th>
                        <th>Nama Barang</th>
                        <th>Kode</th>
                        <th>gambar</th>
                        <th>Pemindahan Tempat</th>
                        <th>Pemindahan Unit</th>
                        <th>action</th>
                     </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                     <tr>
                        <th>no</th>
                        <th>Nama Barang</th>
                        <th>Kode</th>
                        <th>gambar</th>
                        <th>Pemindahan Tempat</th>
                        <th>Pemindahan Unit</th>
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
<script src="{{asset('jquery-ui')}}/jquery-ui.min.js"></script>
<script src="{{asset('colorlib-reg')}}/vendor/datepicker/moment.min.js"></script>
<script src="{{asset('colorlib-reg')}}/vendor/datepicker/daterangepicker.js"></script>
<!-- Main JS-->
<script src="{{asset('colorlib-reg')}}/js/global.js"></script>
<script>    
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
                   url: "{{route('tabelMutasi')}}",
                   type: 'GET'
               },
               columns: [{
                       data: 'DT_RowIndex',
                       name: 'DT_RowIndex'
                   },
                   {
                       data: 'nama_barang',
                       name: 'nama_barang',
                       orderable: true,
                       searchable: true
                   },
                   {
                       data: 'kode_perlengkapan',
                       name: 'kode_perlengkapan',
                       orderable: true,
                       searchable: true
                   },
                   {
                       data: 'image',
                       name: 'image',
                       
                       
                   },
                   
                   {
                       data: 'penempatan',
                       name: 'penempatan',
                       orderable: true,
                       searchable: true
                   },
                   {
                       data: 'departemen',
                       name: 'departemen',
                       orderable: true,
                       searchable: true
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
   $('#load').hide();
   $('#load1').hide();
   $(function() {
       $(".datepicker").datepicker({
           format: 'yyyy-mm-dd',
           autoclose: true,
           todayHighlight: true,
       });
       
   
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
                                   document.getElementById("formTarget").reset();
                                   $('#modal-edit-konten').modal('hide'); 
                                   var oTable = $('#example1').dataTable(); //inialisasi datatable
                                   oTable.fnDraw(false); //reset datatable
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
                          filesize : 2, // here we are working with MB
                           
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
                     filesize: 'ukuran file terlalu besar, harap upload file dibawah 2 mb',
                       
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
   $('#modal-edit-konten').on('show.bs.modal', function(event) {
      
      var button = $(event.relatedTarget) // Button that triggered the modal
      var perlengkapan_id = button.data('perlengkapan')
      var barang_id = button.data('barang')
      var lokasi_penempatan_lama = button.data('lokasi')
      var departemen_lama = button.data('departemen')
      
      
      var modal = $(this)
      modal.find('.modal-footer #load').hide();
      modal.find('.modal-footer #tombol-simpan').show();
      modal.find('.modal-body #perlengkapan_id').val(perlengkapan_id)
      modal.find('.modal-body #barang_id').val(barang_id)
      modal.find('.modal-body #lokasi_penempatan_lama').val(lokasi_penempatan_lama)
      modal.find('.modal-body #departemen_lama').val(departemen_lama)
      
      
      
      });
</script>
@endsection
