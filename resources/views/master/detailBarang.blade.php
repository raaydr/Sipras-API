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
            <h1>Detail Barang</h1>
         </div>
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="/">Barang</a></li>
               <li class="breadcrumb-item active">List-perlengkapan</li>
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
         <div class="card card-primary card-outline">
            <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
               <div class="card-header">
                  <h4 class="card-title w-100">
                     <b>Detail Barang</b>
                  </h4>
               </div>
            </a>
            <div id="collapseOne" class="collapse show" data-parent="#accordion">
               <!-- form start -->
               <form id="formTarget" enctype="multipart/form-data" >
                  @csrf  
                  <div class="card-body">
                     <input type="hidden" id="id" name="id" value="{{$barang->id}}" >
                     <div class="form-group row">
                        <label for="nama_barang" class="col-md-4 col-form-label text-md-right">{{ __('Nama Barang') }}</label>
                        <div class="col-md-6">
                           <input id="nama_barang" type="text" class="form-control" name="nama_barang" value="{{$barang->nama_barang}}"required autofocus />
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
                           <input id="kode_barang" type="text" class="form-control" name="kode" value="{{$barang->kode_barang}}" readonly/>
                           @if ($errors->has('kode_barang'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('kode_barang') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="Jumlah" class="col-md-4 col-form-label text-md-right">{{ __('Jumlah') }}</label>
                        <div class="col-md-6">
                           <input id="Jumlah" type="text" class="form-control" name="Jumlah" value="{{$barang->jumlah}}" readonly/>
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
                           <input id="tipe_barang" type="text" class="form-control" name="tipe_barang" value="{{$barang->tipe_barang}}"required autofocus />
                           <small>Contoh : elektronik atau senyawa kimia</small>
                           @if ($errors->has('tipe_barang'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('tipe_barang') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="keterangan" class="col-md-4 col-form-label text-md-right">{{ __('Keterangan') }}</label>
                        <div class="col-md-6">
                           <textarea id="keterangan" type="text" class="form-control" name="keterangan" value="{{ old('keterangan') }}"required autofocus>{{$barang->keterangan}}</textarea>
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
                        <button class="btn btn-success btn-submit" id="simpanBTN">Ubah</button>
                        <div id="load" class="spinner-border text-primary"></div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
         <div class="card card-warning card-outline">
            <a class="d-block w-100" data-toggle="collapse" href="#collapseFour">
               <div class="card-header">
                  <h4 class="card-title w-100">
                     <b>Input Perlengkapan</b> 
                  </h4>
               </div>
            </a>
            <div id="collapseFour" class="collapse" data-parent="#accordion">
               <!-- form start -->
               <form id="formTarget1" enctype="multipart/form-data" >
                  @csrf  
                  <div class="card-body">
                     <input type="hidden" id="barang_id" name="barang_id" value="{{$barang->id}}" >
                     <input type="hidden" id="kode" name="kode" value="{{$barang->kode_barang}}" >
                     <div class="form-group row">
                        <label for="jumlah_perlengkapan" class="col-md-4 col-form-label text-md-right">{{ __('Jumlah Barang') }}</label>
                        <div class="col-md-6">
                           <input id="jumlah_perlengkapan" type="text" class="form-control" name="jumlah_perlengkapan" value="{{ old('jumlah_perlengkapan') }}"required autofocus />
                           @if ($errors->has('jumlah_perlengkapan'))
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $errors->first('jumlah_perlengkapan') }}</strong>
                           </span>
                           @endif
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="harga_perlengkapan" class="col-md-4 col-form-label text-md-right">{{ __('Harga') }}</label>
                        <div class="col-md-6">
                           <input id="harga_perlengkapan" type="text" class="form-control @error('harga_perlengkapan') is-invalid @enderror" name="harga_perlengkapan" value="" autocomplete="harga_perlengkapan"required autofocus></input>
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
                           <textarea id="keterangan_perlengkapan" type="text" class="form-control" name="keterangan_perlengkapan" value="{{ old('keterangan_perlengkapan') }}"required autofocus></textarea>
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
                              <input placeholder="tanggal pembelian" type="text" class="form-control datepicker" name="tanggal_pembelian"   />
                           </div>
                        </div>
                     </div>
                     <div class="form-group row">
                        <label for="lokasi_perlengkapan" class="col-md-4 col-form-label text-md-right">{{ __('lokasi perlengkapan') }}</label>
                        <div class="col-md-6">
                           <input id="lokasi_perlengkapan" type="text" class="form-control" name="lokasi_perlengkapan" value="{{ old('lokasi_perlengkapan') }}"required autofocus />
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
                           <input id="departemen" type="text" class="form-control" name="departemen" value="{{ old('departemen') }}"required autofocus />
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
                     </div>
                     <div class="form-group row">
                        <label for="kondisi_perlengkapan" class="col-md-4 col-form-label text-md-right">{{ __('Kondisi Perlengkapan') }}</label>
                        <div class="col-md-8">
                           <div class="custom-control custom-radio custom-control-inline mt-2">
                              <input type="radio" id="customRadioInline1" name="kondisi_perlengkapan" class="custom-control-input" value="1" required autofocus />
                              <label class="custom-control-label" for="customRadioInline1">Bagus</label>
                           </div>
                           <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="customRadioInline2" name="kondisi_perlengkapan" class="custom-control-input" value="2" required autofocus />
                              <label class="custom-control-label" for="customRadioInline2">Kurang Bagus</label>
                           </div>
                           <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="customRadioInline3" name="kondisi_perlengkapan" class="custom-control-input" value="3" required autofocus />
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
                              <input type="radio" id="customRadioInline4" name="leandable_perlengkapan" class="custom-control-input" value="1" required autofocus />
                              <label class="custom-control-label" for="customRadioInline4">Bisa Dipinjam</label>
                           </div>
                           <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="customRadioInline5" name="leandable_perlengkapan" class="custom-control-input" value="2" required autofocus />
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
                     <b>3. BUSSINESS CHALLENGE!</b> 
                  </h4>
               </div>
            </a>
            <div id="collapseSeven" class="collapse" data-parent="#accordion">
               <div class="card-body">
                  <a>Di Challenge kali ini kamu di haruskan memberanikan diri untuk berjualan dengan target omzet <b>pembelian</b> yang sudah kami tentukan, yaitu sebesar <b>LIMA RATUS RIBU RUPIAH</b></a>
                  <a>Nah, gimana sih teknis challenge ini? </a>
                  <a>Panitia sudah menyediakan produk untuk kalian jual.</a>
                  <ol>
                     <li>SUSCO BITE</li>
                     <ul>
                        <li>Susco bite ini adalah kue sus kering isi coklat, vanilla, dan strawberry yang rasanya enak dan nagih banget.</li>
                        <li>Harga dari SLP Rp 20.000</li>
                        <li>Harga jual Rp 25.000 </li>
                     </ul>
                     <li>Pempek Asli Jambi.</li>
                     <ul>
                        <li>1kg	    : Harga dari SLP Rp 65.000 -> Harga Jual Rp 75.000 – Rp 85.000</li>
                        <li>½kg     : Harga dari SLP Rp 35.000 -> Harga Jual Rp 40.000 – Rp 50.000</li>
                        <li>KSB	    : Harga dari SLP Rp 60.000 -> Harga Jual Rp 65.000 – Rp 75.000</li>
                        <li>Tekwan  : Harga dari SLP Rp 65.000 -> Harga Jual Rp 75.000 – Rp 85.000</li>
                     </ul>
                     <li>Buku SHINEBRIDE</li>
                     <ul>
                        <li>Berat : 1kg/2 buah buku</li>
                        <li>Harga dari SLP Rp 60.000</li>
                        <li>Harga jual Rp 75.000 – Rp 90.000</li>
                     </ul>
                  </ol>
                  <a>▶ Sistem pemesanan </a>
                  <br>
                  <ol>
                     <li>Teman-teman pesan produk dengan menghubungi admin SLP via link berikut : </li>
                     <ul>
                        <li>Pemesanan SUSCO  <a href="http://bit.ly/PesenSUSCOdong">di sini</a></li>
                        <li>Pemesanan Pempek Asli Jambi   <a href="http://bit.ly/PesenPEMPEK">di sini</a></li>
                        <li>Pemesanan Buku SHINEBRIDE   <a href="http://bit.ly/PesenSHINEBRIDE">di sini</a></li>
                     </ul>
                     <li>Pembayaran dilakukan dengan cara transfer ke rekening <b>BNI Syariah, 0691552012 an. Aprillia Lusiana</b> dan tidak menerima <b>CASH</b>.
                        <br>
                        *Gunakan aplikasi flip.id bila beda bank.
                     </li>
                     <li>Melakukan pembayaran sesuai dengan panduan admin. Menyertakan <b>KODE UNIK</b> di tiga angka terakhir jumlah transfer.</li>
                     <ul>
                        <li>Contoh Kasus 1 : Ari dengan kode unik 48. Ari membeli 10 buah SUSCO dengan akses pengiriman Jabodetabek (Rp 9.000,00/kg). Maka Ari wajib membayar pesanannya senilai Rp 209.048,00.</li>
                        <li>•	Contoh Kasus 2 : Hani bernomor absen 76. Hani membeli 10kg pempek (1kg) dengan akses pengiriman Jabodetabek (Medium - Rp 20.000,00/5kg). Maka Hani wajib membayar pesanannya senilai Rp .670.076,00.</li>
                     </ul>
                     <li>Setelah melakukan pembayaran, admin akan merekap dan tim akan membantu mengirimkan pesanannya.</li>
                  </ol>
                  <a>▶ Rules of Business Challenge: </a>
                  <ol>
                     <li>Mencapai target OMZET <b>PEMBELIAN</b> senilai <b>LIMA RATUS RIBU RUPIAH</b> Contoh target keberhasilan Bussiness Challenge : </li>
                     <ul>
                        <li>Berhasil meraih pemesanan SUSCO sebanyak 25pcs, atau</li>
                        <li>Berhasil meraih pemesanan Pempek (1kg) sebanyak 8pcs , atau</li>
                        <li>Berhasil meraih pemesanan Pempek (½kg) sebanyak 15pcs, atau</li>
                        <li>Berhasil meraih pemesanan Pempek (KSB) sebanyak 9pcs, atau</li>
                        <li>Berhasil meraih pemesanan Tekwan sebanyak 8pcs, atau</li>
                        <li>Berhasil meraih pemesanan Buku SHINEBRIDE sebanyak 9pcs, atau</li>
                        <li>Berhasil meraih pemesanan produk random dengan omzet pembelian senilai Lima Ratus Ribu Rupiah. </li>
                     </ul>
                     <li>Peserta wajib klik link pemesanan yang telah disediakan untuk melakukan pemesanan dan mengisi lengkap format yang telah disiapkan. </li>
                     <li>Sistem pembayaran hanya melalui transfer yang terpusat pada satu rekening, yaitu rekening 
                        <br>
                        <b>BNI Syariah, 0691552012 an. Aprillia Lusiana</b>
                     </li>
                     <li>Marketing Tools berupa poster penjualan telah di lampirkan oleh TIM Smart Leader Preneur, silakan kalian edit info pemesanan dengan nomor WA aktif kalian masing-masing menggunakan aplikasi edit foto/gambar di smartphone dan buat copywriting/broadcast penjualan sekreatif mungkin. </li>
                     <li>Seluruh keuntungan yang kalian dapatkan dari hasil penjualan bisa kalian nikmati sepenuhnya. Seluruh keuntungan yang didapatkan oleh TIM Smart Leader Preneur akan dialokasikan untuk kebutuhan administrasi program beasiswa selama 6 bulan dan di sedekahkan kepada Rumah Qur’an Youthcare. </li>
                  </ol>
                  <a>Periode challenge ini yaitu mulai tanggal 26 April – 5 Mei 2021. </a>
                  <br>
                  <b>Note :</b>
                  <ol>
                     <li><b>Jika challenge ini belum selesai pada rentang waktu yang sudah ditentukan, maka otomatis gugur dalam seleksi.</b></li>
                     <li><b>Kode Unik bisa di cek di profil pendaftaran.</b></li>
                     <li>Budayakan BACA sebelum BERTANYA.</li>
                  </ol>
               </div>
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
                        <th>Kode</th>
                        <th>Jumlah</th>
                        <th>QrCode</th>
                        <th>status</th>
                        <th>action</th>
                     </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                     <tr>
                        <th>no</th>
                        <th>Kode</th>
                        <th>Jumlah</th>
                        <th>QrCode</th>
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
                   url: "{{route('tabelPerlengkapan')}}",
                   type: 'GET'
               },
               columns: [{
                       data: 'DT_RowIndex',
                       name: 'DT_RowIndex'
                   },
                   {
                       data: 'kode_perlengkapan',
                       name: 'kode_perlengkapan',
                       orderable: true,
                       searchable: true
                   },
                   {
                       data: 'jumlah_perlengkapan',
                       name: 'jumlah',
                       orderable: true,
                       searchable: true
                   },
                   {
                       data: 'qrcode',
                       name: 'qrcode',
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
       $('body').on('click', '.deletePerlengkapan', function() {
           var Item_id = $(this).data("id");
           var url = '{{ route("PerlengkapanDelete",[":id"]) }}';
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
   
                   nama_perlengkapan: {
                       required: true,
   
   
                   },
                   tipe_barang: {
                       required: true,
   
   
                   },
                   keterangan: {
                       required: true,
   
   
                   },
   
               },
               messages: {
                  nama_perlengkapan: {
                       required: 'Tolong Diisi',
   
                   },
                   tipe_barang: {
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
                   harga_perlengkapan: {
                       required: true,
   
   
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
                   harga_perlengkapan: {
                       required: 'Tolong Diisi',
   
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
                     required: 'Tolong Diisi',
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
                                   document.getElementById("formTarget1").reset();
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
                                   $('#simpanBTN1').html('Submit'); //tombol simpan
                                   $('#simpanBTN1').show();
                                   document.getElementById("formTarget1").reset();
                                   var oTable = $('#example1').dataTable(); //inialisasi datatable
                                    oTable.fnDraw(false); //reset datatable
                                    document.getElementById("Jumlah").value = data['jumlah'];
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
