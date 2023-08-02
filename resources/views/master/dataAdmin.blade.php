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
            <h1>Data Admin</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="/">Admin</a></li>
               <li class="breadcrumb-item active">List-Admin</li>
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
      <div class="col-12">
                     <div class="card">
                        <div class="card-header">
                           <h3 class="card-title">Pendaftaran Admin</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                           @if(session()->has('success'))
                           <div class="alert alert-success">{{ session()->get('success') }}</div>
                           @endif
                           <form id="formTarget" enctype="multipart/form-data" class="was-validated">
                              {{csrf_field()}}
                              <div class="form-group row">
                                 <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nama Lengkap') }}</label>
                                 <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus />
                                    <div class="valid-feedback"></div>
                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                 <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus />
                                    <div class="valid-feedback"></div>
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                                 <div class="col-md-5">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}"  required autofocus />
                                    <small id="passwordHelpBlock" class="form-text text-sucess">
                                    Minimal 8 karakter
                                    </small>
                                    <div class="valid-feedback"></div>
                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                 </div>
                              </div>
                              <div class="form-group row">
                                 <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                                 <div class="col-md-5">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="{{ old('password') }}"  required autofocus />
                                    <div class="valid-feedback"></div>
                                 </div>
                              </div>
                              
                              <div class="form-group row mb-0">
                                 <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                    {{ __('Daftar') }}
                                    </button>
                                 </div>
                              </div>
                           </form>
                        </div>
                        <!-- /.card-body -->
                     </div>
                     <!-- /.card -->
                  </div>
                  <!-- /.col -->
      <div class="col-12">
         <div class="card">
            <div class="card-header">
               <h3 class="card-title">List Admin</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
               <table id="example1" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>no</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>action</th>
                     </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                     <tr>
                        <th>no</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status</th>
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
                url: "{{route('TabelAdmin')}}",
                type: 'GET'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'email',
                    name: 'email',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'admin',
                    name: 'admin',
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
    $('body').on('click', '.levelAdmin', function() {
        var Item_id = $(this).data("id");
        var url = '{{ route("LevelAdmin",[":id"]) }}';
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

                name: {
                    required: true,


                },
                email: {
                    required: true,


                },
                password: {
                    required: true,


                },
                password_confirmation: {
                    required: true,


                },
               

            },
            messages: {
               name: {
                    required: 'Tolong Diisi',

                },
                email: {
                    required: 'Tolong Diisi',

                },
                password: {
                    required: 'Tolong Diisi',

                },
                password_confirmation: {
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
                    url: "{{ route('DaftarAdmin') }}", //url simpan data
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
