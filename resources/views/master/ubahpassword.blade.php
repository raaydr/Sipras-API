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
                                <h1>Ubah Password</h1>
                            </div>
                            
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                    @if(session('berhasil'))
                    <div class="alert alert-success alert-dismissable md-5">
                        <button type="button" class ="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fa fa-info"></i>Berhasil</h5>
                        {{session('berhasil')}}.
                    </div>
                  @endif
                    <div class="row justify-content-center">

                    <div class="col-md-8">

                        <div class="card">

                            <div class="card-header primary">Ubah Password</div>



                            <div class="card-body">

                                <form method="POST" action="{{ route('general.change.password') }}">

                                    @csrf 



                                    @foreach ($errors->all() as $error)

                                        <p class="text-danger">{{ $error }}</p>

                                    @endforeach 



                                    <div class="form-group row">

                                        <label for="password" class="col-md-4 col-form-label text-md-right">Password Sekarang</label>



                                        <div class="col-md-6">

                                            <input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password">

                                        </div>

                                    </div>



                                    <div class="form-group row">

                                        <label for="password" class="col-md-4 col-form-label text-md-right">Password Baru</label>



                                        <div class="col-md-6">

                                            <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">

                                        </div>

                                    </div>



                                    <div class="form-group row">

                                        <label for="password" class="col-md-4 col-form-label text-md-right">Konfirmasi Password Baru</label>



                                        <div class="col-md-6">

                                            <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">

                                        </div>

                                    </div>



                                    <div class="form-group row mb-0">

                                        <div class="col-md-8 offset-md-4">

                                            <button type="submit" class="btn btn-primary">

                                                Update Password

                                            </button>

                                        </div>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                    </div>

                        
                    </div>
                    <!-- /.container-fluid -->
                </section>
                <!-- /.content -->
@endsection
@section('script')
@endsection

