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
            <h1>Edit Dokumen</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="/">Informasi</a></li>
               <li class="breadcrumb-item active">Dokumen-Edit</li>
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
      <div class="col-md-12">
         <!-- general form elements -->
         <div class="card card-primary">
            <div class="card-header">
               <h3 class="card-title">Dokumen Edit</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="formTarget" enctype="multipart/form-data" >
               @csrf  
               <div class="card-body">
                  <div class="form-group row">
                     <label for="judul" class="col-md-4 col-form-label text-md-right">{{ __('Judul') }}</label>
                     <div class="col-md-6">
                        <input id="judul" type="text" class="form-control" name="judul" value="{{ old('judul') }}"required autofocus />
                        @if ($errors->has('judul'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('judul') }}</strong>
                        </span>
                        @endif
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="nomor" class="col-md-4 col-form-label text-md-right">{{ __('Nomor') }}</label>
                     <div class="col-md-6">
                        <input id="nomor" type="text" class="form-control" name="nomor" value="{{ old('nomor') }}" />
                        @if ($errors->has('nomor'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('nomor') }}</strong>
                        </span>
                        @endif
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="unit" class="col-md-4 col-form-label text-md-right">{{ __('Yang Mengeluarkan/Penerbit') }}</label>
                     <div class="col-md-6">
                        <input id="search_unit" type="text" class="form-control" name="search_unit"  >
                        @if ($errors->has('judul'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('judul') }}</strong>
                        </span>
                        @endif
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="terbit" class="col-md-4 col-form-label text-md-right">{{ __('Tanggal Terbit') }}</label>
                     <div class="col-md-6">
                        <div class="input-group date">
                           <div class="input-group-addon">
                              <span class="glyphicon glyphicon-th"></span>
                           </div>
                           <input class="form-control js-datepicker" type="text"  name="terbit" required autofocus />
                        </div>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="tanggal_lahir" class="col-md-4 col-form-label text-md-right">{{ __('Tanggal Kadaluarsa') }}</label>
                     <div class="col-md-6">
                        <div class="input-group date">
                           <div class="input-group-addon">
                              <span class="glyphicon glyphicon-th"></span>
                           </div>
                           <input class="form-control js-datepicker" type="text"  name="kadaluarsa" />
                        </div>
                        <small id="passwordHelpBlock" class="form-text text-sucess">Dapat dikosongkan</small>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="kategori" class="col-md-4 col-form-label text-md-right">{{ __('Kategori Dokumen') }}</label>
                     <div class="col-md-6">
                        <input id="kategori" type="text" class="form-control" name="kategori" value="{{ old('kategori') }}"required autofocus />
                        @if ($errors->has('kategori'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('kategori') }}</strong>
                        </span>
                        @endif
                     </div>
                  </div>
                  <div class="form-group row" id="link">
                     <label for="url_konten" class="col-md-4 col-form-label text-md-right">{{ __('URL') }}</label>
                     <div class="col-md-6">
                        <input id="url_konten" type="text" class="form-control" name="url_konten" value="{{ old('url_konten') }}"required autofocus />
                        @if ($errors->has('url_konten'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('url_konten') }}</strong>
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
         <!-- /.card -->
      </div>
      <div class="modal fade" id="modal-edit-konten">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header bg-primary">
                  <h4 class="modal-title">Edit Dokumen</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <form id="formUpdate" enctype="multipart/form-data" >
                  @csrf     
                  <div class="modal-body">
                     <input type="hidden" id="id" name="id" >
                     <div class="form-group row">
                        <label for="judul" class="col-md-4 col-form-label text-md-right">{{ __('Judul') }}</label>
                        <div class="col-md-6">
                           <input id="judul" type="text" class="form-control" name="judul" value="{{ old('judul') }}"required autofocus />
                           @if ($errors->has('judul'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('judul') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="nomor" class="col-md-4 col-form-label text-md-right">{{ __('Nomor') }}</label>
                        <div class="col-md-6">
                           <input id="nomor" type="text" class="form-control" name="nomor" value="{{ old('nomor') }}" />
                           @if ($errors->has('nomor'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('nomor') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="unit" class="col-md-4 col-form-label text-md-right">{{ __('Yang Mengeluarkan/Penerbit') }}</label>
                        <div class="col-md-6">
                           <input id="search_unitUpdate" type="text" class="form-control" name="search_unit" >
                           @if ($errors->has('judul'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('judul') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="terbit" class="col-md-4 col-form-label text-md-right">{{ __('Tanggal Terbit') }}</label>
                        <div class="col-md-6">
                           <div class="input-group date">
                              <div class="input-group-addon">
                                 <span class="glyphicon glyphicon-th"></span>
                              </div>
                              <input class="form-control js-datepicker" type="text" id="terbit"  name="terbit" required autofocus />
                           </div>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="tanggal_lahir" class="col-md-4 col-form-label text-md-right">{{ __('Tanggal Kadaluarsa') }}</label>
                        <div class="col-md-6">
                           <div class="input-group date">
                              <div class="input-group-addon">
                                 <span class="glyphicon glyphicon-th"></span>
                              </div>
                              <input class="form-control js-datepicker" type="text" id="kadaluarsa" name="kadaluarsa" />
                           </div>
                           <small id="passwordHelpBlock" class="form-text text-sucess">Dapat dikosongkan</small>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="kategori" class="col-md-4 col-form-label text-md-right">{{ __('Kategori Dokumen') }}</label>
                        <div class="col-md-6">
                           <input id="kategori" type="text" class="form-control" name="kategori" value="{{ old('kategori') }}"required autofocus />
                           @if ($errors->has('kategori'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('kategori') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                     <div class="form-group row" id="link">
                        <label for="url_konten" class="col-md-4 col-form-label text-md-right">{{ __('URL') }}</label>
                        <div class="col-md-6">
                           <input id="url_konten" type="text" class="form-control" name="url_konten" value="{{ old('url_konten') }}"required autofocus />
                           @if ($errors->has('url_konten'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('url_konten') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                  </div>
                  <div class="modal-footer justify-content-between ">
                     <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                     <button class="btn btn-outline-primary btn-submit" id="simpanBTN1">Submit</button>
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
               <h3 class="card-title">List Dokumen</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
               <table id="example1" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>no</th>
                        <th><input type="text" placeholder="Search"  style="width: 100%"  />Judul</th>
                        <th><input type="text" placeholder="Search"  style="width: 100%"  />Nomor</th>
                        <th><input type="text" placeholder="Search"  style="width: 100%"  />Penerbit</th>
                        <th><input type="text" placeholder="Search"  style="width: 100%"  />Kategori</th>
                        <th><input type="text" placeholder="Search"  style="width: 100%"  />Tanggal Terbit</th>
                        <th>File</th>
                        <th>Status Berlaku</th>
                        <th>CreatedBy</th>
                        <th>action</th>
                     </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                     <tr>
                        <th>no</th>
                        <th>Judul</th>
                        <th>Nomor</th>
                        <th>Penerbit</th>
                        <th>Kategori</th>
                        <th>Tanggal Terbit</th>
                        <th>File</th>
                        <th>Status Berlaku</th>
                        <th>CreatedBy</th>
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
                url: "{{route('tabelDokumen')}}",
                type: 'GET'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'judul',
                    name: 'judul',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'nomor',
                    name: 'nomor',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'unit',
                    name: 'unit',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'kategori',
                    name: 'kategori',
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
                    data: 'konten',
                    name: 'konten'

                },
                {
                    data: 'berlaku',
                    name: 'berlaku',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'nama_pembuat',
                    name: 'nama_pembuat',
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
    $("#search_unit").autocomplete({
        source: function(request, response) {
            // Fetch data
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            $.ajax({
                url: "{{route('searchUnit')}}",
                type: "post",
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    search: request.term,
                },
                success: function(data) {
                    response(data);
                },
            });
        },
        select: function(event, ui) {
            // Set selection
            $("#search_unit").val(ui.item.value);
            //location.reload();
            return false;
        },
    });
    $("#search_unitUpdate").autocomplete({
        source: function(request, response) {
            // Fetch data
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            $.ajax({
                url: "{{route('searchUnit')}}",
                type: "post",
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    search: request.term,
                },
                success: function(data) {
                    response(data);
                },
            });
        },
        select: function(event, ui) {
            // Set selection
            $("#search_unitUpdate").val(ui.item.value);
            //location.reload();
            return false;
        },
    });
    $('body').on('click', '.deleteDokumen', function() {
        var Item_id = $(this).data("id");
        var url = '{{ route("dokumenDelete",[":id"]) }}';
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
    $('body').on('click', '.publishDokumen', function() {
        var Item_id = $(this).data("id");
        var url = '{{ route("dokumenPublish",[":id"]) }}';
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

                judul: {
                    required: true,


                },
                terbit: {
                    required: true,


                },
                tipe_konten: {
                    required: true,


                },
                url_konten: {
                    required: true,


                },

               

            },
            messages: {
                judul: {
                    required: 'Tolong Diisi',

                },
                terbit: {
                    required: 'Tolong Diisi',

                },
                tipe_konten: {
                    required: 'Tolong Diisi',

                },
                url_konten: {
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
                    url: "{{ route('dokumenUpdate') }}", //url simpan data
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
                                var oTable = $('#example1').dataTable(); //inialisasi datatable
                                oTable.fnDraw(false); //reset datatable
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
                                $("#link").show();
                                $("#url_konten").attr("required");
                                $("#url_konten").attr("data-error");
                                $("#files").hide();
                                $("#file_konten").val("");
                                $("#file_konten").removeAttr("required");
                                $("#file_konten").removeAttr("data-error");
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
    if ($("#formUpdate").length > 0) {
        $.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param * 1000000)
        }, 'File size must be less than {0} MB');

        $("#formUpdate").validate({

            rules: {

                judul: {
                    required: true,


                },
                terbit: {
                    required: true,


                },
                tipe_konten: {
                    required: true,


                },
                url_konten: {
                    required: true,


                },

                

            },
            messages: {
                judul: {
                    required: 'Tolong Diisi',

                },
                terbit: {
                    required: 'Tolong Diisi',

                },
                tipe_konten: {
                    required: 'Tolong Diisi',

                },
                url_konten: {
                    required: 'Tolong Diisi',

                },
                
            },
            submitHandler: function(form) {
                var actionType = $('#simpanBTN1').val();
                $('#simpanBTN1').html('Sending..');

                var form = $("#formUpdate").closest("form");
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
                    url: "{{ route('dokumenUpdate') }}", //url simpan data
                    type: "POST", //karena simpan kita pakai method POST
                    dataType: 'json', //data tipe kita kirim berupa JSON
                    processData: false,
                    contentType: false,
                    success: function(data) { //jika berhasil
                        switch (data.status) {
                            case 0:

                                $('#simpanBTN1').html('Submit');
                                $('#simpanBTN1').show();
                                iziToast.error({
                                    title: 'Error',
                                    message: data.error,
                                });
                                console.log('Error:', "periksa");
                                break;
                            case 1:
                                $('#simpanBTN1').html('Submit');
                                $('#simpanBTN1').show();
                                document.getElementById("formUpdate").reset();
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

                                case 2:
                                   $('#load1').hide();
                                   $('#simpanBTN1').html('Submit');
                                   $('#simpanBTN1').show();
                                   iziToast.error({
                                       title: 'Error',
                                       message: data.error,
                                   });
                                   console.log('Error:', "Hanya Super Admin yang dapat mengganti");
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
    var id = button.data('myid')
    var judul = button.data('judul')
    var nomor = button.data('nomor')
    var search_unitUpdate = button.data('unit')
    var terbit = button.data('terbit')
    var kadaluarsa = button.data('kadaluarsa')
    var kategori = button.data('kategori')
    
    var url_konten = button.data('url_konten')


    var modal = $(this)
    modal.find('.modal-body #id').val(id)
    modal.find('.modal-body #judul').val(judul)
    modal.find('.modal-body #nomor').val(nomor)
    modal.find('.modal-body #search_unitUpdate').val(search_unitUpdate)
    modal.find('.modal-body #terbit').val(terbit)
    modal.find('.modal-body #kadaluarsa').val(kadaluarsa)
    modal.find('.modal-body #kategori').val(kategori)
    modal.find('.modal-body #url_konten').val(url_konten)
    


});     
</script>
@endsection
