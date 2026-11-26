<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <x-seo title="Login | SAPA JUKIR Sinjai" :noindex="true" />

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, Helvetica, sans-serif;
            background: #f1f5f9;
            padding: 20px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 36px;
            box-shadow:
                0 10px 30px rgba(15, 23, 42, 0.08);
        }

        .brand {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 16px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 16px;

            color: #ffffff;

            font-size: 26px;
            font-weight: 700;
        }

        .brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
        .brand h1 {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .brand p {
            color: #64748b;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;

            font-size: 14px;
            font-weight: 600;

            color: #334155;
        }

        .form-control {
            width: 100%;
            height: 48px;

            padding: 0 14px;

            border: 1px solid #cbd5e1;
            border-radius: 10px;

            font-size: 14px;

            outline: none;

            transition: 0.2s;
        }

        .form-control:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;

            margin-bottom: 22px;

            font-size: 14px;
            color: #475569;
        }

        .remember input {
            width: 16px;
            height: 16px;
        }

        .btn-login {
            width: 100%;
            height: 48px;

            border: none;
            border-radius: 10px;

            background: #2563eb;
            color: #ffffff;

            font-size: 15px;
            font-weight: 600;

            cursor: pointer;

            transition: 0.2s;
        }

        .btn-login:hover {
            background: #1d4ed8;
        }

        .alert {
            margin-bottom: 20px;

            padding: 12px 14px;

            border-radius: 10px;

            font-size: 13px;
        }

        .alert-error {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .footer {
            margin-top: 24px;

            text-align: center;

            color: #94a3b8;
            font-size: 12px;
        }

        @media (max-width: 480px) {

            .login-card {
                padding: 28px 22px;
            }

        }

    </style>

</head>

<body>

<div class="login-wrapper">

    <div class="login-card">

        {{-- BRAND --}}

        <div class="brand">

            <div class="brand-icon">
                <div style="text-align: center; margin-bottom: 15px;">
    <img src="{{ asset('images/logo-sapa-jukir.png') }}" alt="Logo" style="width: 50px; height: 50px; object-fit: contain; display: inline-block;">
</div>
            </div>

            <h1>
                SAPA JUKIR Sinjai
            </h1>

            <p>
                Sistem Informasi Petugas Kabupaten Sinjai
            </p>

        </div>


        {{-- SUCCESS MESSAGE --}}

        @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif


        {{-- ERROR MESSAGE --}}

        @if($errors->any())

            <div class="alert alert-error">

                {{ $errors->first() }}

            </div>

        @endif


        {{-- LOGIN FORM --}}

        <form
            method="POST"
            action="{{ route('login.process') }}"
        >

            @csrf


            {{-- USERNAME --}}

            <div class="form-group">

                <label for="username">
                    Username
                </label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    class="form-control"
                    value="{{ old('username') }}"
                    placeholder="operator1"
                    autocomplete="username"
                    required
                    autofocus
                >

            </div>


            {{-- PASSWORD --}}

            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    placeholder="Masukkan password"
                    autocomplete="current-password"
                    required
                >

            </div>


            {{-- REMEMBER --}}

            <label class="remember">

                <input
                    type="checkbox"
                    name="remember"
                    value="1"
                >

                <span>
                    Ingat saya
                </span>

            </label>


            {{-- BUTTON --}}

            <button
                type="submit"
                class="btn-login"
            >
                Masuk ke Sistem
            </button>

        </form>


        <div class="footer">

            © {{ date('Y') }} SAPA JUKIR Sinjai

        </div>

    </div>

</div>

</body>

</html>