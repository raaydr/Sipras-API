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
                                <h1>Ubah Akun</h1>
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

                            <div class="card-header primary">Ubah Akun</div>



                            <div class="card-body">

                            <form method="POST" action="{{ route('change_account') }}">
                              {{csrf_field()}}
                              <input id="name" type="hidden" name="id" value="{{$user->id}}" required autofocus />
                              <div class="form-group row">
                                 <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nama Lengkap') }}</label>
                                 <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{$user->name}}" required autofocus />
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
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{$user->email}}" required autofocus />
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
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}"  />
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
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="{{ old('password') }}"   />
                                    <div class="valid-feedback"></div>
                                 </div>
                              </div>
                              
                              <div class="form-group row mb-0">
                                 <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                    {{ __('Ubah') }}
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

