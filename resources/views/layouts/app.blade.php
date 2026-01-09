<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    {{-- Dynamic Title --}}
    <title>
        @yield('title', 'AISTOPHILE MANAGEMENT')
    </title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/AistophileLogo.png') }}">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom-datatables.css') }}">

    <style>
    body, .nav-link, .navbar-brand {
        font-family: "Poppins", sans-serif;
        letter-spacing: 0.3px;
    }

    * {
        transition: 0.25s ease-in-out;
    }

    body {
        background: #e6edc9ff;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .content-wrapper {
        flex: 1;
    }

    .navbar-custom {
        padding: 14px 0;
        box-shadow: 0 4px 14px rgba(0,0,0,0.1);
    }

    .navbar-logo {
        width: 65px;
        height: 40px;
        border-radius: 6px;
        object-fit: contain;
    }

    .navbar-brand {
        font-size: 22px;
        font-weight: 700;
        color: #FFFFFF !important;
    }

    .nav-link {
        color: #ebeccc !important;
        font-size: 15px;
        font-weight: 500;
        margin-right: 22px;
        opacity: 0.75;
        border-bottom: 2px solid transparent;
    }

    .nav-link:hover {
        opacity: 1;
        color: #FFFFFF !important;
        border-bottom: 2px solid #ebeccc;
    }

    .nav-link.active {
        font-weight: 600;
        opacity: 1;
        color: #FFFFFF !important;
        border-bottom: 2px solid #FFFFFF;
    }

    .navbar-user {
        color: #FFFFFF;
        font-weight: 600;
        margin-right: 18px;
        font-size: 15px;
    }

    .btn-logout {
        background: #DC2626;
        color: #FFFFFF;
        font-weight: 600;
        padding: 7px 18px;
        border-radius: 10px;
        border: none;
        box-shadow: 0px 4px 10px rgba(220, 38, 38, 0.3);
        cursor: pointer;
    }

    .btn-logout:hover {
        background: #b91c1c;
        transform: translateY(-2px);
    }

    .footer-custom {
        color: #FFFFFF;
        padding: 28px 0;
        margin-top: 60px;
        text-align: center;
    }

    .footer-custom .footer-brand {
        font-weight: 700;
        font-size: 16px;
        margin-bottom: 5px;
    }

    .footer-custom p {
        font-size: 14px;
        opacity: 0.9;
        margin: 0;
    }

    body[data-role="admin"] .navbar-custom,
    body[data-role="admin"] .footer-custom {
        background: #9ba377ff;
    }

    body[data-role="superadmin"] .navbar-custom,
    body[data-role="superadmin"] .footer-custom {
        background: #da915eff;
    }

    </style>
</head>

<body data-role="{{ session('role') }}">
<nav class="navbar navbar-expand-lg navbar-custom shadow-sm">
    <div class="container">
        <img src="{{ asset('images/AistophileLogo.png') }}" alt="AISTOPHILE Logo" class="navbar-logo">

        <a class="navbar-brand" href="{{ route('dashboard') }}">AISTOPHILE</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            @if(session('role') !== 'superadmin')
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}"
                       href="{{ route('dashboard') }}">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('produk*') ? 'active' : '' }}"
                       href="{{ route('produk.index') }}">Produk</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('kategori*') ? 'active' : '' }}"
                       href="{{ route('kategori.index') }}">Kategori</a>
                </li>
            </ul>
            @endif

            @if(session('role') === 'superadmin')
            <ul class="navbar-nav me-auto"></ul>
            @endif

            <span class="navbar-user">
                Hai, {{ session('username') ?? 'User' }}!
            </span>

            <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: inline;">
                <button type="button" class="btn btn-logout" id="btn-logout-confirm">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="content-wrapper">
    <div class="container mt-4">
        @yield('content')
    </div>
</div>

<footer class="footer-custom">
    <div class="container">
        <p class="footer-brand">AISTOPHILE MANAGEMENT</p>
        <p>&copy; {{ date('Y') }} AISTOPHILE - All Rights Reserved</p>
    </div>
</footer>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const logoutBtn = document.getElementById('btn-logout-confirm');
    const logoutForm = document.getElementById('logout-form');

    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: 'Kamu akan keluar dari sistem!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DC2626',
                cancelButtonColor: '#6C757D',
                confirmButtonText: 'Ya, Keluar!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Logging out...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    logoutForm.submit();
                }
            });
        });
    }
});
</script>

@if(session('sweetalert'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: '{{ session("sweetalert.type") }}',
            title: '{{ session("sweetalert.title") }}',
            text: '{{ session("sweetalert.text") }}',
            confirmButtonColor: '{{ session("role") === "superadmin" ? "#da915eff" : "#bd865fff" }}',
            timer: 3000,
            timerProgressBar: true
        });
    });
</script>
@endif

@stack('scripts')

</body>
</html>