<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    // Autenticación personalizada para mayor seguridad
    Fortify::authenticateUsing(function (Request $request) {
        // Sanitizar el input del usuario
        $username = filter_var($request->input('username'), FILTER_SANITIZE_STRING);
        $password = $request->input('password');

        // Validar que el username cumple con los requisitos
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username) || strlen($password) < 8) {
            return null; // Retorna null si no pasa la validación
        }

        // Intentar autenticación con credenciales limpias
        if (Auth::attempt(['username' => $username, 'password' => $password])) {
            return Auth::user();
        }

        return null;
    });

    // Limitar intentos de inicio de sesión (5 por minuto)
    RateLimiter::for('login', function (Request $request) {
        $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());
        return Limit::perMinute(5)->by($throttleKey);
    });

    // Limitar intentos de autenticación 2FA (5 por minuto)
    RateLimiter::for('two-factor', function (Request $request) {
        return Limit::perMinute(5)->by($request->session()->get('login.id'));
    });

    // Mantenemos la configuración original de Laravel Jetstream
    Fortify::createUsersUsing(CreateNewUser::class);
    Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
    Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
    Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
}

}