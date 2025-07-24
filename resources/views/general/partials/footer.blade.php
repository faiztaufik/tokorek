<!-- Footer Start -->
<style>
    .footer-custom {
        background: #1e1e2f;
        color: #ccc;
        padding-top: 60px;
        padding-bottom: 40px;
    }

    .footer-custom h5 {
        color: #fff;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .footer-custom a {
        color: #bbb;
        text-decoration: none;
    }

    .footer-custom a:hover {
        color: #0d6efd;
    }

    .footer-custom .logo-footer img {
        max-height: 60px;
    }

    .footer-custom .social-icons a {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: #2a2a3f;
        color: #fff;
        border-radius: 50%;
        margin-right: 10px;
        transition: all 0.3s ease-in-out;
    }

    .footer-custom .social-icons a:hover {
        background-color: #0d6efd;
        color: #fff;
    }

    .footer-custom .footer-bottom {
        border-top: 1px solid #444;
        margin-top: 30px;
        padding-top: 20px;
        font-size: 0.875rem;
    }
</style>

<footer class="footer-custom">
    <div class="container">
        <div class="row g-5">
            <!-- Logo & Alamat -->
            <div class="col-lg-4 col-md-6">
                <div class="logo-footer mb-3">
                    <img src="{{ asset('img/logoacs.png') }}" alt="Logo Access Computer Shop">
                </div>
                <p class="mb-2"><i class="fa fa-map-marker-alt me-2"></i>Jl. Ahmad Yani No.123, Pontianak</p>
                <p class="mb-2"><i class="fa fa-phone me-2"></i>+62 812 3456 7890</p>
                <p><i class="fa fa-envelope me-2"></i>servicekomputer@email.com</p>
            </div>

            <!-- Layanan Kami -->
            <div class="col-lg-4 col-md-6">
                <h5>Layanan Kami</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Servis Laptop</a></li>
                    <li><a href="#">Servis Komputer</a></li>
                    <li><a href="#">Instalasi Software</a></li>
                    <li><a href="#">Pembersihan Hardware</a></li>
                    <li><a href="#">Upgrade Perangkat</a></li>
                </ul>
            </div>

            <!-- Sosial & Jam -->
            <div class="col-lg-4 col-md-6">
                <h5>Ikuti Kami</h5>
                <div class="social-icons mb-4">
                    <a href="https://www.facebook.com/share/1BiFnoNXgg/?mibextid=wwXIfr"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/laptopbekaspontianak?igsh=Z3VndDB4ZHRuaHZh"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
                <h5>Jam Operasional</h5>
                <p class="mb-1"><strong>Senin - Jumat:</strong> 09.00 - 21.00 WIB</p>
                <p><strong>Sabtu - Minggu:</strong> 09.00 - 12.00 WIB</p>
            </div>
        </div>

        <!-- Bottom -->
        <div class="footer-bottom text-center mt-5">
            &copy; {{ date('Y') }} <strong>Access Computer Shop</strong>. All Rights Reserved.            
        </div>
    </div>
</footer>
<!-- Footer End -->
