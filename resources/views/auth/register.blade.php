
<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full input-style" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div>
                <x-label for="username" value="{{ __('Nombre de usuario') }}" />
                <x-input id="username" class="block mt-1 w-full input-style" type="text" name="username" :value="old('username')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full input-style" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4 relative">
                <x-label for="password" value="{{ __('Contraseña') }}" />
                <input id="password" class="block mt-1 w-full input-style pr-28" type="password" name="password" required autocomplete="new-password" />
                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-600">
                    <span id="toggleText" class="text-xs">Ver Contraseña</span>
                </button>
            </div>

            <div class="mt-4 relative">
                <x-label for="password_confirmation" value="{{ __('Confirmar Contraseña') }}" />
                <input id="password_confirmation" class="block mt-1 w-full input-style pr-28" type="password" name="password_confirmation" required autocomplete="new-password" />
                <button type="button" id="toggleConfirmationPassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-sm text-gray-600">
                    <span id="toggleConfirmationText" class="text-xs">Ver Contraseña</span>
                </button>
            </div>

            <div class="mt-4">
                <x-label for="role" value="{{ __('Rol') }}" />
                <select id="role" name="role" class="block mt-1 w-full input-style">
                    <option value="user" selected>{{ __('Usuario') }}</option>
                    <option value="admin">{{ __('Admin') }}</option>
                </select>
            </div>

            <div class="mt-4">
                <x-label for="security_question" value="{{ __('Pregunta de Seguridad') }}" />
                <x-input id="security_question" class="block mt-1 w-full input-style" type="text" name="security_question" :value="old('security_question')" required />
            </div>

            <div class="mt-4">
                <x-label for="security_answer" value="{{ __('Respuesta de Seguridad') }}" />
                <x-input id="security_answer" class="block mt-1 w-full input-style" type="text" name="security_answer" :value="old('security_answer')" required />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('Estoy de acuerdo con los :terms_of_service y :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Términos de Servicio').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Política de Privacidad').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('¿Ya estás registrado?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Registrar') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleText = document.getElementById('toggleText');

        togglePassword.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            toggleText.textContent = type === 'password' ? 'Ver Contraseña' : 'Ocultar Contraseña';
        });

        const toggleConfirmationPassword = document.getElementById('toggleConfirmationPassword');
        const confirmationPasswordInput = document.getElementById('password_confirmation');
        const toggleConfirmationText = document.getElementById('toggleConfirmationText');

        toggleConfirmationPassword.addEventListener('click', () => {
            const type = confirmationPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmationPasswordInput.setAttribute('type', type);
            toggleConfirmationText.textContent = type === 'password' ? 'Ver Contraseña' : 'Ocultar Contraseña';
        });
    </script>

    <style>
        /* Estilo para los campos de entrada */
        .input-style {
            border: 1px solid #cbd5e0; /* Color del borde */
            border-radius: 0.375rem; /* Bordes redondeados */
            padding: 0.5rem; /* Espaciado interno */
            transition: border-color 0.3s; /* Transición suave para el color del borde */
        }

        /* Efecto al enfocarse en el campo de entrada */
        .input-style:focus {
            border-color: #4f46e5; /* Color del borde al enfocarse */
            outline: none; /* Quitar el borde de enfoque predeterminado */
            box-shadow: 0 0 0 1px rgba(79, 70, 229, 0.5); /* Sombra de enfoque */
        }
    </style>
</x-guest-layout>
