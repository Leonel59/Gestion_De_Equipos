<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" id="errorContainer" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <div>
                <x-label for="username" value="{{ __('Usuario') }}" />
                <x-input id="username" class="block mt-1 w-full input-style" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4 relative">
                <x-label for="password" value="{{ __('Contraseña') }}" />
                <input id="password" class="block mt-1 w-full input-style pr-28" type="password" name="password" required autocomplete="current-password" />
                
                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-600">
                    <span id="toggleText">Ver Contraseña</span>
                </button>
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Recordar Usuario') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4">
                <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>

                <x-button class="ms-4 button-style">
                    {{ __('Acceso') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Restricción de caracteres especiales en el campo 'Usuario'
            const usernameField = document.getElementById('username');
            
            usernameField.addEventListener('input', function (event) {
                // Permitir solo letras, números y espacios
                this.value = this.value.replace(/[^a-zA-Z0-9\s]/g, '');
            });
        });
    </script>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleText = document.getElementById('toggleText');
        const loginForm = document.getElementById('loginForm');
        const errorContainer = document.getElementById('errorContainer');
        let attemptCount = 0; // Contador de intentos
        let isLocked = false; // Estado de bloqueo
        const lockDuration = 6000; // Duración del bloqueo en milisegundos

        togglePassword.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            toggleText.textContent = type === 'password' ? 'Ver Contraseña' : 'Ocultar Contraseña';
        });

        loginForm.addEventListener('submit', function(event) {
            if (isLocked) {
                event.preventDefault(); // Evita el envío si está bloqueado
                errorContainer.classList.add('text-red-600', 'mt-2');
                errorContainer.innerHTML = 'Demasiados intentos fallidos. Intenta de nuevo en 6 segundos.';
                return;
            }

            // Limpiar mensajes de error anteriores
            errorContainer.innerHTML = '';

            // Usar las validaciones de Laravel
            const formData = new FormData(loginForm);
            const username = formData.get('username');
            const password = formData.get('password');
            const passwordErrors = [];
            const usernameErrors = [];

            // Validaciones de usuario
            if (/[^a-zA-Z0-9]/.test(username)) {
                usernameErrors.push("El usuario no puede contener caracteres especiales.");
            }

            // Validaciones de contraseña
            if (password.length < 8) {
                passwordErrors.push("La contraseña debe tener al menos 8 caracteres.");
            }
            if (!/[A-Z]/.test(password)) {
                passwordErrors.push("La contraseña debe contener al menos una letra mayúscula.");
            }
            if (!/[0-9]/.test(password)) {
                passwordErrors.push("La contraseña debe contener al menos un número.");
            }
            if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                passwordErrors.push("La contraseña debe contener al menos un carácter especial.");
            }

            // Mostrar errores de usuario si hay
            if (usernameErrors.length > 0) {
                event.preventDefault(); // Evita el envío del formulario
                errorContainer.classList.add('text-red-600', 'mt-2');
                errorContainer.innerHTML = usernameErrors.join('<br>');
                return;
            }

            // Incrementar el contador de intentos
            attemptCount++;
            if (attemptCount >= 3) {
                isLocked = true;
                setTimeout(() => {
                    isLocked = false;
                    attemptCount = 0; // Reiniciar el contador
                }, lockDuration);
            }

            if (passwordErrors.length > 0) {
                event.preventDefault(); // Evita el envío del formulario
                // Mostrar errores en el contenedor
                errorContainer.classList.add('text-red-600', 'mt-2');
                errorContainer.innerHTML += passwordErrors.join('<br>');
            }
        });
    </script>

    <style>
        /* Estilo para los campos de entrada */
        .input-style {
            border: 1px solid #cbd5e0;
            border-radius: 0.375rem;
            padding: 0.5rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .input-style:focus {
            border-color: #4f46e5;
            outline: none;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.5);
        }

        .button-style {
            background-color: #4f46e5;
            color: #ffffff;
            transition: background-color 0.3s, transform 0.3s;
        }

        .button-style:hover {
            background-color: #3730a3;
            transform: translateY(-2px);
        }

        x-authentication-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0px 8px 24px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 100%;
            max-width: 400px;
            margin: auto;
        }
    </style>
</x-guest-layout>



