@extends('general.layout')
@section('content')
            <!-- Content Header (Page header) -->
            <section class="content-header">
               <div class="container-fluid">
                  <div class="row mb-2">
                     <div class="col-sm-6">
                        <h1>Selamat Datang</h1>
                     </div>
                     <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                           <li class="breadcrumb-item"><a href="/">Home</a></li>
                           <li class="breadcrumb-item active">Landing Page</li>
                        </ol>
                     </div>
                  </div>
               </div>
               <!-- /.container-fluid -->
            </section>
            <!-- Main content -->
            <section class="content">
                
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Sistem</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                  Saat ini berada di halaman untuk admin.
                        
                    Selamat Bekerja
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        {{$date}}
                    </div>
                    <!-- /.card-footer-->
                </div>
                
                <!-- /.card -->
            
                
                
            </section>
            <!-- /.content -->
@endsection
@section('script')
@endsection