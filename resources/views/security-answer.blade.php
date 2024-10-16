<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('security.answer') }}">
            @csrf

            <div>
                <x-label for="username" value="{{ __('Usuario') }}" />
                <x-input id="username" class="block mt-1 w-full" type="text" name="username" required autofocus />
            </div>

            <div class="mt-4">
                <x-label for="security_answer" value="{{ __('Respuesta a la pregunta de seguridad') }}" />
                <x-input id="security_answer" class="block mt-1 w-full" type="text" name="security_answer" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ms-4">
                    {{ __('Verificar Respuesta') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

