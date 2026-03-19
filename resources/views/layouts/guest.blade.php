<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --color-main:      #280905;
            --color-secondary: #740A03;
            --color-third:     #C3110C;
            --color-fourth:    #E6501B;
        }

        /* Navbar */
        .navbar-shop {
            background: linear-gradient(90deg, #280905 0%, #3d0c07 100%);
            border-bottom: 3px solid #C3110C;
            box-shadow: 0 2px 12px rgba(0,0,0,.35);
            padding-top: .65rem;
            padding-bottom: .65rem;
        }
        .navbar-shop .navbar-brand {
            color: #fff !important;
            font-size: 1.25rem;
            letter-spacing: .5px;
        }
        .navbar-shop .navbar-brand i { color: #E6501B; }
        .navbar-shop .navbar-brand:hover i { color: #ff7a40; }

        .navbar-shop .nav-link {
            color: #f5d5c8 !important;
            font-size: .9rem;
            font-weight: 500;
            padding: .45rem .75rem !important;
            position: relative;
            transition: color .2s;
        }
        .navbar-shop .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0; left: 50%; right: 50%;
            height: 2px;
            background: #E6501B;
            border-radius: 2px;
            transition: left .2s, right .2s;
        }
        .navbar-shop .nav-link:hover,
        .navbar-shop .nav-link.active { color: #fff !important; }
        .navbar-shop .nav-link:hover::after,
        .navbar-shop .nav-link.active::after { left: 8px; right: 8px; }
        .navbar-shop .nav-link.no-underline::after,
        .navbar-shop .nav-item.dropdown .nav-link::after,
        .navbar-shop .btn-nav-login::after,
        .navbar-shop .btn-nav-register::after { display: none; }

        /* Search */
        .navbar-shop .navbar-search .form-control {
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.2);
            color: #fff;
            border-radius: 20px 0 0 20px;
            font-size: .85rem;
        }
        .navbar-shop .navbar-search .form-control::placeholder { color: rgba(255,255,255,.5); }
        .navbar-shop .navbar-search .form-control:focus {
            background: rgba(255,255,255,.18);
            border-color: #E6501B;
            box-shadow: none;
            color: #fff;
        }
        .navbar-shop .navbar-search .btn {
            background: #C3110C;
            border: 1px solid #C3110C;
            color: #fff;
            border-radius: 0 20px 20px 0;
            padding: .25rem .75rem;
        }
        .navbar-shop .navbar-search .btn:hover { background: #E6501B; border-color: #E6501B; }

        /* Login / Register pills */
        .navbar-shop .btn-nav-login {
            color: #f5d5c8;
            border: 1px solid rgba(255,255,255,.3);
            border-radius: 20px;
            padding: .3rem .9rem;
            font-size: .85rem;
            transition: background .2s, border-color .2s, color .2s;
        }
        .navbar-shop .btn-nav-login:hover { background: rgba(255,255,255,.12); color: #fff; border-color: #fff; }
        .navbar-shop .btn-nav-register {
            background: #C3110C;
            border: 1px solid #C3110C;
            color: #fff;
            border-radius: 20px;
            padding: .3rem .9rem;
            font-size: .85rem;
            transition: background .2s;
        }
        .navbar-shop .btn-nav-register:hover { background: #E6501B; border-color: #E6501B; }

        /* User dropdown */
        .navbar-shop .user-toggle { display: flex; align-items: center; gap: 7px; }
        .navbar-shop .user-toggle .user-avatar {
            width: 30px; height: 30px;
            background: #C3110C;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: .75rem; font-weight: 700; color: #fff;
            flex-shrink: 0;
        }
        .navbar-shop .dropdown-menu {
            border: none;
            border-top: 3px solid #C3110C;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 8px 24px rgba(40,9,5,.35);
            background: #280905;
            min-width: 200px;
            padding: 6px 0;
        }
        .navbar-shop .dropdown-item {
            color: #f5d5c8;
            font-size: .88rem;
            padding: 9px 18px;
            transition: background .15s, color .15s;
        }
        .navbar-shop .dropdown-item:hover,
        .navbar-shop .dropdown-item:focus,
        .navbar-shop .dropdown-item:active { background: #740A03; color: #fff; }
        .navbar-shop .dropdown-item i { color: #E6501B; width: 16px; }
        .navbar-shop .dropdown-item:hover i,
        .navbar-shop .dropdown-item:focus i { color: #ffb89a; }
        .navbar-shop .dropdown-divider { border-color: #4a1208; margin: 4px 0; }

        /* Buttons */
        .btn-primary {
            --bs-btn-bg:                  #C3110C;
            --bs-btn-border-color:        #C3110C;
            --bs-btn-hover-bg:            #740A03;
            --bs-btn-hover-border-color:  #740A03;
            --bs-btn-active-bg:           #740A03;
            --bs-btn-active-border-color: #740A03;
            --bs-btn-disabled-bg:         #C3110C;
            --bs-btn-disabled-border-color: #C3110C;
            --bs-btn-focus-shadow-rgb:    195, 17, 12;
            color: #fff;
        }

        /* Focus rings */
        *:focus { outline: none !important; box-shadow: 0 0 0 .2rem rgba(195,17,12,.25) !important; }
        .form-control:focus, .form-select:focus { border-color: #C3110C !important; box-shadow: 0 0 0 .2rem rgba(195,17,12,.2) !important; }

        /* Sticky footer */
        html, body { height: 100%; }
        body { display: flex; flex-direction: column; background: #f0e8e7; }
        body > main { flex: 1; }

        /* Auth card */
        .auth-card {
            background: #fff;
            border: 1px solid #e8d5d0;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(40,9,5,.12);
        }
        .auth-card .auth-header {
            background: linear-gradient(135deg, #280905, #740A03);
            border-radius: 12px 12px 0 0;
            padding: 1.5rem;
            text-align: center;
            border-bottom: 3px solid #C3110C;
        }
        .auth-card .auth-header i { color: #E6501B; font-size: 2rem; margin-bottom: .5rem; }
        .auth-card .auth-header h4 { color: #fff; font-weight: 700; margin: 0; letter-spacing: .5px; }
        .auth-card .auth-body { padding: 1.75rem; }
        .auth-card label { color: #3d0c07; font-weight: 600; font-size: .875rem; margin-bottom: .35rem; }
        .auth-card .form-control {
            border-color: #e0ccc9;
            border-radius: 8px;
            font-size: .9rem;
            padding: .5rem .85rem;
        }
        .auth-card .form-control:focus {
            border-color: #C3110C !important;
            box-shadow: 0 0 0 .2rem rgba(195,17,12,.18) !important;
        }
        .auth-card .invalid-feedback { font-size: .8rem; }
        .auth-card .text-muted-link {
            color: #8a4040;
            font-size: .85rem;
            text-decoration: none;
            transition: color .15s;
        }
        .auth-card .text-muted-link:hover { color: #C3110C; text-decoration: underline; }
        .auth-card .form-check-input:checked {
            background-color: #C3110C;
            border-color: #C3110C;
        }
    </style>
</head>
<body>

    @include('partials.navbar')

    <main>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-sm-10 col-md-7 col-lg-5">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
