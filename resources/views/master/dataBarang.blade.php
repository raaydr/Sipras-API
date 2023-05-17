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
                  <div class="form-group row">
                     <label for="nama" class="col-md-4 col-form-label text-md-right">{{ __('tipe konten') }}</label>
                     <div class="col-md-6">
                        <div class="input-group mb-3">
                           <select class="form-control" id="tipe_konten" name="tipe_konten">
                              <option value="1">URL</option>
                              <option value="2">File</option>
                           </select>
                           @error('nama_mata_pelatihan')
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
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
                  <div class="form-group row" id="files">
                     <label for="file_konten" class="col-md-4 col-form-label text-md-right">{{ __('File') }}</label>
                     <div class="col-md-8">
                        <input
                           id="file_konten"
                           type="file"
                           class="form-control{{ $errors->has('file_konten') ? ' is-invalid' : '' }}"
                           name="file_konten"
                           value="{{ old('file_konten') }}"
                           required
                           autofocus
                           /></input>
                        <small id="passwordHelpBlock" class="form-text text-sucess">
                        Format harus jpg,png,jpeg,pdf dan ukuran 5 mb
                        </small>
                        @if ($errors->has('file_konten'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('file_konten') }}</strong>
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
                  <div class="form-group row">
                     <label for="nama" class="col-md-4 col-form-label text-md-right">{{ __('tipe konten') }}</label>
                     <div class="col-md-6">
                        <div class="input-group mb-3">
                           <select class="form-control" id="tipe_konten" name="tipe_konten">
                              <option value="1">URL</option>
                              <option value="2">File</option>
                           </select>
                           @error('nama_mata_pelatihan')
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
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
                  <div class="form-group row" id="files">
                     <label for="file_konten" class="col-md-4 col-form-label text-md-right">{{ __('File') }}</label>
                     <div class="col-md-8">
                        <input
                           id="file_konten"
                           type="file"
                           class="form-control{{ $errors->has('file_konten') ? ' is-invalid' : '' }}"
                           name="file_konten"
                           value="{{ old('file_konten') }}"
                           required
                           autofocus
                           /></input>
                        <small id="passwordHelpBlock" class="form-text text-sucess">
                        Format harus jpg,png,jpeg,pdf dan ukuran 5 mb
                        </small>
                        @if ($errors->has('file_konten'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('file_konten') }}</strong>
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
                        
                        <th>status</th>
                        <th>action</th>
                     </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                     <tr>
                        <th>no</th>
                        <th>Judul</th>
                        
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
                url: "{{route(getMyPermission(Auth::user()->level) .'.tabelBarang')}}",
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
      
</script>
@endsection
