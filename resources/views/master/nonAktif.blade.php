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
                                <h1>Mohon meminta admin untuk mengaktifkan akun kembali </h1>
                            </div>
                            
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </section>

                
@endsection
@section('script')
@endsection

