<!DOCTYPE html>
<html lang="en">

<head>
    <title>SIPRASMI - {{$perlengkapan->kode_perlengkapan}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{asset('stikes')}}/stikes.png" rel="icon" />
    <link rel="stylesheet" href="{{asset('zay')}}/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('zay')}}/assets/css/templatemo.css">
    <link rel="stylesheet" href="{{asset('zay')}}/assets/css/custom.css">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="{{asset('zay')}}/assets/css/fontawesome.min.css">

    <!-- Slick -->
    <link rel="stylesheet" type="text/css" href="{{asset('zay')}}/assets/css/slick.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('zay')}}/assets/css/slick-theme.css">
</head>

<body>
    <!-- Open Content -->
    <section class="bg-light">
        <div class="container pb-5">
            <div class="row">
                <div class="col-lg-5 mt-5">
                    <div class="card mb-3">
                        <img class="card-img img-fluid" src="{{asset('foto-perlengkapan')}}/{{$perlengkapan->foto_perlengkapan}}" alt="Card image cap" id="product-detail">
                    </div>
                </div>
                <!-- col end -->
                <div class="col-lg-7 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="h2">Nama Barang : {{$barang->nama_barang}}</h1>
                            <h1 class="h4">Kode Barang : {{$perlengkapan->kode_perlengkapan}}</h1>
                            <h1 class="h4">Tipe Barang : {{$barang->tipe_barang}}</h1>
                            <p class="h3 py-2"><a read only><b><omset  ></omset></b></a></p>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <h6>Kondisi:</h6>
                                </li>
                                <li class="list-inline-item">
                                @switch( $perlengkapan->kondisi_perlengkapan )
                                    @case(3)
                                    <p class="text-danger"><strong>Rusak</strong></p>
                                    @break
                                    @case(1)
                                    <p class="text-success"><strong>Bagus</strong></p>
                                    @break
                                    @case(2)
                                    <p class="text-warning"><strong>Kurang Bagus</strong></p>
                                    @break
                                @endswitch
                                    
                                </li>
                            </ul>

                            <h6>Keterangan Barang:</h6>
                            <p>{{$barang->keterangan}}</p>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <h6>Tanggal Pembelian :</h6>
                                </li>
                                <li class="list-inline-item">
                                    <p class="text-primary"><strong>{{\Carbon\Carbon::parse($perlengkapan->tanggal_pembelian)->toFormattedDateString()}}</strong></p>
                                </li>
                            </ul>

                            <h6>Detail Perlengkapan:</h6>
                            <ul class="list-unstyled pb-3">
                                <li>Departemen : <strong>{{$perlengkapan->departemen}}</strong></li>
                                <li>Lokasi Perlengkapan : <strong>{{$perlengkapan->lokasi_perlengkapan}}</strong></li>
                                <li>Jumlah Perlengkapan : <strong>{{$perlengkapan->jumlah_perlengkapan}}</strong></li>
                                <li>Peminjaman Perlengkapan : 
                                @switch( $perlengkapan->leandable_perlengkapan )
                                    @case(1)
                                    <a class="text-success"><strong>Boleh Dipinjam</strong></a>
                                    @break
                                    @case(2)
                                    <a class="text-danger"><strong>Tidak Dapat Dipinjam</strong></a>
                                    @break
                                @endswitch
                                </li>
                                @switch( $perlengkapan->status_peminjaman )
                                    @case(1)
                                    Status Peminjaman : 
                                    <a class="text-success"><strong>Sedang Dipinjam</strong></a>
                                    @break
                                    @case(0)
                                    
                                    @break
                                @endswitch
                            </ul>
                            <h6>Keterangan Perlengkapan:</h6>
                            <p>{{$perlengkapan->keterangan_perlengkapan}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Close Content -->

    
    <!-- Start Script -->
    <script src="{{asset('zay')}}/assets/js/jquery-1.11.0.min.js"></script>
    <script src="{{asset('zay')}}/assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="{{asset('zay')}}/assets/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('zay')}}/assets/js/templatemo.js"></script>
    <script src="{{asset('zay')}}/assets/js/custom.js"></script>
    <!-- End Script -->

    <!-- Start Slider Script -->
    <script src="{{asset('zay')}}/assets/js/slick.min.js"></script>
    <script>
        $('#carousel-related-product').slick({
            infinite: true,
            arrows: false,
            slidesToShow: 4,
            slidesToScroll: 3,
            dots: true,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 3
                    }
                }
            ]
        });

        function rupiah(){
               var bilangan = {{$perlengkapan->harga_perlengkapan}};
               var	number_string = bilangan.toString(),
               sisa 	= number_string.length % 3,
               rupiah 	= number_string.substr(0, sisa),
               ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
               
               if (ribuan) {
                  separator = sisa ? '.' : '';
                  rupiah += separator + ribuan.join('.');
               }
               
               // Cetak hasil
               
                  
               
               $("omset").text("Rp "+rupiah)
         
         //the function body is the same as you have defined sue the textbox object to set the value
         }
         rupiah();
    </script>
    <!-- End Slider Script -->

</body>

</html>