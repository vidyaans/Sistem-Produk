<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        {{ request('page') === 'register' ? 'Register Akun' : 'Login' }} - AISTOPHILE MANAGEMENT
    </title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/AistophileLogoV2.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #e6edc9ff;
            font-family: "Poppins", sans-serif;
        }

        .welcome-container {
            max-width: 950px;
            margin: 70px auto;
            background: #fffbebff;
            border-radius: 18px;
            padding: 40px 35px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
            display: flex;
            gap: 25px;

            align-items: center;   
        }

        .left-box {
            flex: 1;
            text-align: left;       
        }

        .left-box img {
            width: 160px;
            height: 160px;
            object-fit: contain;
            margin-bottom: 15px;
            display: block;         
        }

        .left-box h4 {
            font-weight: 700;
            color: #da915eff;
            margin-bottom: 12px;
            text-align: left;
            font-size: 15px;        
        }

        .left-box p {
            font-size: 14px;
            color: #da915eff;
            line-height: 1.6;
            text-align: left;         
        }

        .right-box {
            width: 330px;
        }

        .auth-card {
            background: #b1b98fff;
            border-radius: 14px;
            padding: 25px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.08);
        }

        .auth-btn {
            background: #da915eff !important;
            color: white !important;
            font-weight: 600;
            border-radius: 10px;
            padding: 10px;
        }

        .auth-btn:hover {
            background: #bd865fff !important;
        }

        .switch-link a {
            color: #FFF;
            font-weight: 600;
            text-decoration: none;
        }

        .switch-link a:hover {
            text-decoration: underline;
        }
    </style>

</head>
<body>

<div class="welcome-container">

    <div class="left-box">
        <img src="{{ asset('images/AistophileLogoV2.png') }}" alt="Aistophile Logo">

        <h4>Saatnya Rapikan Tokomu bersama Aistophile Management!</h4>

        <p>
            Aistophile Management adalah sistem yang dirancang untuk membuat pengelolaan produk di tokomu
            jadi jauh lebih mudah. Lupakan cara lama yang ribet, sekarang kamu bisa pantau stok dan atur semua barang dari satu tempat dengan rapi.
        </p>
    </div>

    <div class="right-box">
        <div class="auth-card">

            @php
                $page = request('page');
            @endphp

            @if ($page === 'register')
                <h4 class="text-center mb-3">Daftar</h4>

                <form action="{{ url('/register') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <button class="btn w-100 auth-btn">Daftar</button>
                </form>

                <div class="text-center mt-3 switch-link">
                    <small>Sudah punya akun? <a href="/?page=login">Masuk</a></small>
                </div>

            @else
                <h4 class="text-center mb-3">Login</h4>

                <form action="{{ url('/login') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button class="btn w-100 auth-btn">Login</button>
                </form>

                <div class="text-center mt-3 switch-link">
                    <small>Belum punya akun? <a href="/?page=register">Daftar</a></small>
                </div>

            @endif

        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('sweetalert'))
<script>
    Swal.fire({
        icon: '{{ session("sweetalert.type") }}',
        title: '{{ session("sweetalert.title") }}',
        text: '{{ session("sweetalert.text") }}',
        confirmButtonColor: '#DCA278',
        timer: 3000,
        timerProgressBar: true
    });
</script>
@endif

</body>
</html>
