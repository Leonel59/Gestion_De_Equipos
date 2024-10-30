<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Recarga Veloz</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            body {
                font-family: 'Figtree', sans-serif;
                background: linear-gradient(135deg, #2B2D42 0%, #3D405B 100%);
                color: #ffffff;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 20px;
            }
            .navbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
                max-width: 1200px;
                padding: 20px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 12px;
            }
            .navbar a {
                color: #ffffff;
                font-weight: 600;
                text-decoration: none;
                margin: 0 10px;
            }
            .navbar a:hover {
                color: #B2B2B2;
            }
            .logo {
                font-size: 24px;
                font-weight: bold;
            }
            .main-content {
                background: rgba(255, 255, 255, 0.15);
                backdrop-filter: blur(10px);
                padding: 40px;
                border-radius: 20px;
                text-align: center;
                box-shadow: 0px 8px 24px rgba(0, 0, 0, 0.2);
                margin-top: 40px; /* Ajuste para bajar el contenido */
            }
            .logo-circle {
                width: 80px; /* Reducción del tamaño del círculo */
                height: 80px; /* Reducción del tamaño del círculo */
                border-radius: 50%;
                background: #ffffff;
                display: flex;
                justify-content: center;
                align-items: center;
                margin: 0 auto 20px; /* Centrar y agregar margen inferior */
            }
            .logo-circle img {
                width: 70%; /* Ajuste del tamaño de la imagen dentro del círculo */
                height: 70%;
                object-fit: contain;
                border-radius: 50%;
            }
            footer {
                margin-top: 20px;
                color: #B2B2B2;
                font-size: 0.8rem;
            }
        </style>
    </head>
    <body>
        <div class="navbar">
            <a class="logo" href="#">Recarga Veloz</a>
            @if (Route::has('login'))
                <div>
                    @auth
                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Log in</a>
                        
                    @endauth
                </div>
            @endif
        </div>

        <main class="main-content">
            <div class="logo-circle">
                <img src="{{ asset('/logo/empresafondo.png') }}" alt="Recarga Veloz Logo">
            </div>
            <h1>Bienvenido</h1>
            <p>Administra y gestiona tus servicios de manera rápida y sencilla.</p>
        </main>

        <footer>
            Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        </footer>
    </body>
</html>
