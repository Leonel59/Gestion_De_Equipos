<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.update') }}" id="resetPasswordForm">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

          

            <!-- Campo de Correo -->
            <div class="block mt-4">
                <x-label for="email" value="{{ __('Correo') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            </div>

            <!-- Campo de Contraseña -->
            <div class="mt-4 relative">
                <x-label for="password" value="{{ __('Contraseña') }}" />
                <x-input id="password" class="block mt-1 w-full pr-10" type="password" name="password" required autocomplete="new-password" />
                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center px-3">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.58 12.5a3.5 3.5 0 11-7.16 0 3.5 3.5 0 017.16 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-.274 1.057-.734 2.047-1.365 2.923M3.193 9.177A9.964 9.964 0 002 12a9.964 9.964 0 003.193 2.823"></path>
                    </svg>
                </button>
            </div>

            <!-- Campo de Confirmar Contraseña -->
            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirmar Contraseña') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <!-- Contenedor de Errores -->
            <div id="errorContainer" class="hidden p-4 rounded-lg bg-red-100 border-l-4 border-red-500 text-red-700 mt-4">
                <strong class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m-6 4h6m-3-10V4m0 10v6"></path>
                    </svg>
                    Errores encontrados:
                </strong>
                <ul id="errorList" class="list-disc pl-5 mt-2"></ul>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Restablecer Contraseña') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const resetPasswordForm = document.getElementById('resetPasswordForm');
            const errorContainer = document.getElementById('errorContainer');
            const errorList = document.getElementById('errorList');
            const passwordInput = document.getElementById('password');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const togglePassword = document.getElementById('togglePassword');

            // Mostrar u ocultar contraseña
            togglePassword.addEventListener('click', () => {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                passwordConfirmationInput.setAttribute('type', type);
            });

            resetPasswordForm.addEventListener('submit', function(event) {
                let errors = [];

                const password = passwordInput.value.trim();
                const passwordConfirmation = passwordConfirmationInput.value.trim();

                // Validaciones de contraseña
                if (password.length < 8) {
                    errors.push("Debe tener al menos 8 caracteres.");
                }
                if (!/[A-Z]/.test(password)) {
                    errors.push("Debe contener al menos una mayúscula.");
                }
                if (!/[0-9]/.test(password)) {
                    errors.push("Debe contener al menos un número.");
                }
                if (!/[!@#$%^&*(),.?\":{}|<>]/.test(password)) {
                    errors.push("Debe incluir un carácter especial.");
                }
                if (password !== passwordConfirmation) {
                    errors.push("Las contraseñas no coinciden.");
                }

                // Mostrar errores si existen
                if (errors.length > 0) {
                    event.preventDefault();
                    showError(errors);
                    return;
                }
            });

            function showError(errors) {
                errorList.innerHTML = errors.map(error => `<li>${error}</li>`).join('');
                errorContainer.classList.remove('hidden');

                // Animación de opacidad
                errorContainer.style.opacity = "0";
                setTimeout(() => errorContainer.style.opacity = "1", 100);
            }
        });
    </script>
</x-guest-layout>
