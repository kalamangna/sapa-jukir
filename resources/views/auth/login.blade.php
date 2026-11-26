<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <x-seo title="Login | SAPA JUKIR Sinjai" :noindex="true" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: var(--public-bg);
            color: var(--public-ink);
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
        }

        .login-card {
            background: var(--public-panel);
            border: 1px solid var(--public-line);
            border-radius: 16px;
            padding: 34px 32px;
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
        }

        .brand {
            text-align: center;
            margin-bottom: 26px;
        }

        .brand-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-icon img {
            width: 56px;
            height: 56px;
            object-fit: contain;
        }

        .brand h1 {
            font-size: 22px;
            font-weight: 700;
            color: var(--public-ink);
            margin-bottom: 6px;
        }

        .brand p {
            color: var(--public-muted);
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
            color: var(--public-ink-soft);
        }

        .form-control {
            width: 100%;
            height: 48px;
            padding: 0 14px;
            border: 1px solid var(--public-line);
            border-radius: 10px;
            background: var(--public-panel);
            color: var(--public-ink);
            font: inherit;
            font-size: 16px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(26, 93, 255, 0.14);
        }

        .form-control.is-invalid {
            border-color: #dc2626;
        }

        .password-field {
            position: relative;
        }

        .password-field .form-control {
            padding-right: 48px;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 4px;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            display: inline-grid;
            place-items: center;
            border: 0;
            border-radius: 8px;
            background: transparent;
            color: var(--public-muted);
            cursor: pointer;
        }

        .password-toggle:hover {
            color: var(--public-ink);
        }

        .password-toggle:focus-visible {
            outline: 2px solid var(--blue);
            outline-offset: 1px;
        }

        .field-error {
            display: block;
            margin-top: 6px;
            color: #b91c1c;
            font-size: 12px;
        }

        .remember {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 40px;
            margin-bottom: 18px;
            font-size: 14px;
            color: var(--public-ink-soft);
            cursor: pointer;
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
            background: var(--blue);
            color: #ffffff;
            font: inherit;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-login:hover {
            background: var(--blue-deep);
        }

        .btn-login:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }

        .btn-login:focus-visible,
        .back-home-link:focus-visible {
            outline: 2px solid var(--blue);
            outline-offset: 2px;
        }

        .login-actions-footer {
            margin-top: 16px;
            text-align: center;
        }

        .back-home-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 40px;
            padding: 0 10px;
            border-radius: 8px;
            color: var(--blue);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
        }

        .back-home-link:hover {
            text-decoration: underline;
        }

        .alert {
            margin-bottom: 18px;
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
            margin-top: 20px;
            text-align: center;
            color: var(--public-muted);
            font-size: 12px;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 26px 20px;
            }
        }
    </style>
</head>
<body class="public-site login-page">

<div class="login-wrapper">
    <div class="login-card">
        <div class="brand">
            <div class="brand-icon">
                <img src="{{ asset('images/logo-sapa-jukir.png') }}" alt="Logo SAPA JUKIR">
            </div>
            <h1>SAPA JUKIR Sinjai</h1>
            <p>Sistem Informasi Petugas Kabupaten Sinjai</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @php
            $generalError = collect($errors->getMessages())
                ->except(['username', 'password'])
                ->flatten()
                ->first();
        @endphp
        @if($generalError)
            <div class="alert alert-error">
                {{ $generalError }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.process') }}">
            @csrf

            <div class="form-group">
                <label for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    class="form-control @error('username') is-invalid @enderror"
                    value="{{ old('username') }}"
                    placeholder="operator1"
                    autocomplete="username"
                    maxlength="50"
                    @error('username') aria-invalid="true" @enderror
                    required
                    autofocus
                >
                @error('username')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-field">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Minimal 8 karakter"
                        autocomplete="current-password"
                        maxlength="128"
                        @error('password') aria-invalid="true" @enderror
                        required
                    >
                    <button
                        type="button"
                        class="password-toggle"
                        aria-label="Tampilkan kata sandi"
                        aria-pressed="false"
                        data-password-toggle
                    >
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <label class="remember">
                <input type="checkbox" name="remember" value="1">
                <span>Ingat saya</span>
            </label>

            <button type="submit" class="btn-login">Login</button>
        </form>

        <div class="login-actions-footer">
            <a class="back-home-link" href="{{ route('home') }}">&larr; Kembali ke Beranda</a>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} SAPA JUKIR Sinjai
        </div>
    </div>
</div>

<script>
    const loginForm = document.querySelector('form[action="{{ route('login.process') }}"]');
    const loginButton = loginForm?.querySelector('.btn-login');
    const passwordInput = document.getElementById('password');
    const passwordToggle = document.querySelector('[data-password-toggle]');

    passwordToggle?.addEventListener('click', () => {
        if (!passwordInput) return;
        const isHidden = passwordInput.type === 'password';
        passwordInput.type = isHidden ? 'text' : 'password';
        passwordToggle.setAttribute('aria-pressed', isHidden ? 'true' : 'false');
        passwordToggle.setAttribute('aria-label', isHidden ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
    });

    loginForm?.addEventListener('submit', () => {
        if (!loginButton) return;
        loginButton.disabled = true;
        loginButton.textContent = 'Memproses...';
    });
</script>

</body>
</html>
