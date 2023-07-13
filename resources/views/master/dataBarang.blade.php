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
            <h1>Data Barang</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="/">Barang</a></li>
               <li class="breadcrumb-item active">List-Barang</li>
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
               <h3 class="card-title">Barang Edit</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="formTarget" enctype="multipart/form-data" >
               @csrf  
               <div class="card-body">
                  <div class="form-group row">
                     <label for="nama_barang" class="col-md-4 col-form-label text-md-right">{{ __('Nama Barang') }}</label>
                     <div class="col-md-6">
                        <input id="nama_barang" type="text" class="form-control" name="nama_barang" value="{{ old('nama_barang') }}"required autofocus />
                        @if ($errors->has('nama_barang'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('nama_barang') }}</strong>
                        </span>
                        @endif
                     </div>
                  </div>
                  
                  <div class="form-group row">
                     <label for="kode_barang" class="col-md-4 col-form-label text-md-right">{{ __('Kode Barang') }}</label>
                     <div class="col-md-6">
                        <input id="kode_barang" type="text" class="form-control" name="kode_barang" value="{{ old('kode_barang') }}" />
                        <small>Contoh : "KOMP" untuk komputer</small><br>
                        <small>Kode Barang tidak akan bisa diganti setelahnya</small>
                        @if ($errors->has('kode_barang'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('kode_barang') }}</strong>
                        </span>
                        @endif
                     </div>
                  </div>
                    <div class="form-group row">
                     <label for="tipe_barang" class="col-md-4 col-form-label text-md-right">{{ __('Tipe Barang') }}</label>
                     <div class="col-md-6">
                        <input id="tipe_barang" type="text" class="form-control" name="tipe_barang" value="{{ old('tipe_barang') }}"required autofocus />
                        <small>Contoh : elektronik atau senyawa kimia</small>
                        @if ($errors->has('tipe_barang'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('tipe_barang') }}</strong>
                        </span>
                        @endif
                     </div>
                  </div>
                  <div class="form-group row">
                     <label for="satuan_barang" class="col-md-4 col-form-label text-md-right">{{ __('Satuan Barang') }}</label>
                     <div class="col-md-6">
                        <input id="satuan_barang" type="text" class="form-control" name="satuan_barang" value="{{ old('satuan_barang') }}"required autofocus />
                        <small>Contoh : unit atau liter</small>
                        @if ($errors->has('satuan_barang'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('satuan_barang') }}</strong>
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
         <!-- /.card -->
      </div>
      <div class="col-12">
         <div class="card">
            <div class="card-header">
               <h3 class="card-title">List Barang</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
               <table id="example1" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>no</th>
                        <th>Nama Barang</th>
                        <th>Kode</th>
                        <th>Jumlah</th>
                        <th>Updated By</th>
                        <th>status</th>
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
                        <th>Jumlah</th>
                        <th>Updated By</th>
                        <th>status</th>
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
                url: "{{route('tabelBarang')}}",
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
                    data: 'kode_barang',
                    name: 'kode_barang',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'jumlahbarang',
                    name: 'jumlahbarang',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'user_name',
                    name: 'user_name',
                    orderable: true,
                    searchable: true
                },
                
                {
                    data: 'status',
                    name: 'status',
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
    $('body').on('click', '.deleteBarang', function() {
        var Item_id = $(this).data("id");
        var url = '{{ route("BarangDelete",[":id"]) }}';
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
    $('body').on('click', '.publishBarang', function() {
        var Item_id = $(this).data("id");
        var url = '{{ route("BarangPublish",[":id"]) }}';
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

                nama_barang: {
                    required: true,


                },
                kode_barang: {
                    required: true,


                },
                tipe_barang: {
                    required: true,


                },
                satuan_barang: {
                    required: true,


                },
                keterangan: {
                    required: true,


                },

            },
            messages: {
               nama_barang: {
                    required: 'Tolong Diisi',

                },
                kode_barang: {
                    required: 'Tolong Diisi',

                },
                tipe_barang: {
                    required: 'Tolong Diisi',

                },
                satuan_barang: {
                    required: 'Tolong Diisi',

                },
                keterangan: {
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
                    url: "{{ route('BarangUpdate') }}", //url simpan data
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
