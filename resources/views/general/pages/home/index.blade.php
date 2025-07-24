@extends('general.layouts.main')
@section('container')
    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5">
        <div class="owl-carousel header-carousel position-relative">
            <!-- Slide 1 -->
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="{{ asset('img/carousel/carousel-1.jpg') }}" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                    style="background: rgba(0, 0, 0, .4);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-10 col-lg-8">
                                <h5 class="text-white text-uppercase mb-3 animated slideInDown">Servis & Perbaikan Laptop
                                </h5>
                                <h1 class="display-3 text-white animated slideInDown mb-4">Servis Laptop & Komputer Cepat
                                    dan Terpercaya</h1>
                                <p class="fs-5 fw-medium text-white mb-4 pb-2">Kami melayani berbagai jenis perbaikan laptop
                                    dan komputer dengan teknisi profesional dan harga terjangkau.</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="{{ asset('img/carousel/carousel-2.jpg') }}" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                    style="background: rgba(0, 0, 0, .4);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-10 col-lg-8">
                                <h5 class="text-white text-uppercase mb-3 animated slideInDown">Servis & Perbaikan Komputer
                                </h5>
                                <h1 class="display-3 text-white animated slideInDown mb-4">Solusi Komputer Anda di Tangan
                                    Profesional</h1>
                                <p class="fs-5 fw-medium text-white mb-4 pb-2">Dari instalasi software hingga perbaikan
                                    hardware, kami siap membantu kebutuhan komputer Anda.</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Carousel End -->

    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 service-item-top wow fadeInUp" data-wow-delay="0.1s">
                    <div class="overflow-hidden">
                        <img class="img-fluid w-100 h-100" src="{{ asset('img/services/service-1.jpg') }}" alt="">
                    </div>
                    <div class="d-flex align-items-center justify-content-between bg-light p-4">
                        <h5 class="text-truncate me-3 mb-0">Servis Hardware Laptop</h5>
                        <a class="btn btn-square btn-outline-primary border-2 border-white flex-shrink-0" href=""><i
                                class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 service-item-top wow fadeInUp" data-wow-delay="0.3s">
                    <div class="overflow-hidden">
                        <img class="img-fluid w-100 h-100" src="{{ asset('img/services/service-2.jpg') }}" alt="">
                    </div>
                    <div class="d-flex align-items-center justify-content-between bg-light p-4">
                        <h5 class="text-truncate me-3 mb-0">Instalasi & Troubleshooting Software</h5>
                        <a class="btn btn-square btn-outline-primary border-2 border-white flex-shrink-0" href=""><i
                                class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 service-item-top wow fadeInUp" data-wow-delay="0.5s">
                    <div class="overflow-hidden">
                        <img class="img-fluid w-100 h-100" src="{{ asset('img/services/service-3.jpg') }}" alt="">
                    </div>
                    <div class="d-flex align-items-center justify-content-between bg-light p-4">
                        <h5 class="text-truncate me-3 mb-0">Pemeriksaan Cepat</h5>
                        <a class="btn btn-square btn-outline-primary border-2 border-white flex-shrink-0" href=""><i
                                class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->

    <!-- Team Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-secondary text-uppercase">Teknisi Kami</h6>
                <h1 class="mb-5">Teknisi Ahli & Berpengalaman</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="{{ asset('img/technician/technician-1.jpg') }}" alt="">
                        </div>
                        <div class="team-text">
                            <div class="bg-light">
                                <h5 class="fw-bold mb-0">Nama Lengkap</h5>
                                <small>Posisi / Spesialisasi</small>
                            </div>
                            <div class="bg-primary">
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="team-item">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="{{ asset('img/technician/technician-2.jpg') }}" alt="">
                        </div>
                        <div class="team-text">
                            <div class="bg-light">
                                <h5 class="fw-bold mb-0">Nama Lengkap</h5>
                                <small>Posisi / Spesialisasi</small>
                            </div>
                            <div class="bg-primary">
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="team-item">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="{{ asset('img/technician/technician-3.jpg') }}" alt="">
                        </div>
                        <div class="team-text">
                            <div class="bg-light">
                                <h5 class="fw-bold mb-0">Nama Lengkap</h5>
                                <small>Posisi / Spesialisasi</small>
                            </div>
                            <div class="bg-primary">
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="team-item">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid" src="{{ asset('img/technician/technician-4.jpg') }}" alt="">
                        </div>
                        <div class="team-text">
                            <div class="bg-light">
                                <h5 class="fw-bold mb-0">Nama Lengkap</h5>
                                <small>Posisi / Spesialisasi</small>
                            </div>
                            <div class="bg-primary">
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->
@endsection
