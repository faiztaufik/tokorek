<!-- Topbar Start -->
<style>
    .topbar {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        font-size: 0.95rem;
    }

    .topbar .contact-info i {
        color: #0d6efd;
        margin-right: 8px;
    }

    .topbar .contact-info .whatsapp-icon {
        color: #25D366;
    }

    .topbar .social-icons a {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: #fff;
        color: #0d6efd;
        border-radius: 50%;
        margin-left: 6px;
        transition: all 0.3s ease;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.05);
    }

    .topbar .social-icons a:hover {
        background-color: #0d6efd;
        color: #fff;
    }

    .brand-logo {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .brand-logo img {
        height: 35px;
    }

    .brand-logo span {
        font-weight: 600;
        color: #0d6efd;
        font-size: 1rem;
    }

    @media (max-width: 767.98px) {
        .topbar .contact-info {
            text-align: center;
            margin-bottom: 8px;
        }

        .topbar .social-icons {
            justify-content: center !important;
        }

        .brand-logo {
            justify-content: center;
            margin-bottom: 8px;
        }
    }
</style>

<div class="topbar py-2">
    <div class="container">
        <div class="row align-items-center gy-2">
            <!-- Logo + Brand -->
            <div class="col-lg-3 col-md-12 brand-logo">
                <img src="{{ asset('img/logoacs.png') }}" alt="Logo">
                <span>Access Computer Shop</span>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-6 col-md-7 contact-info d-flex align-items-center flex-wrap justify-content-md-start justify-content-center">
                <div class="me-4 d-flex align-items-center">
                    <i class="fa fa-map-marker-alt"></i>
                    <span>Jl. Sepakat 2 A. Yani 1, Pontianak</span>
                </div>
                <div class="me-4 d-flex align-items-center">
                    <i class="fab fa-whatsapp whatsapp-icon"></i>
                    <a href="https://wa.me/+6282148424778" target="_blank" class="text-decoration-none text-dark">
                    <!-- <a href="https://wa.me/+6282148424778?text=Saya%20ingin%20bertanya%20admin" target="_blank" class="text-decoration-none text-dark">   jika di perlukan -->
                        <span>+62 821-4842-4778</span>
                    </a>
                </div>                
            </div>

            <!-- Social Media -->
            <div class="col-lg-3 col-md-5 social-icons d-flex justify-content-md-end justify-content-center">
                <a href="https://www.facebook.com/share/1BiFnoNXgg/?mibextid=wwXIfr"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                <a href="https://www.instagram.com/laptopbekaspontianak?igsh=Z3VndDB4ZHRuaHZh"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
</div>
<!-- Topbar End -->
