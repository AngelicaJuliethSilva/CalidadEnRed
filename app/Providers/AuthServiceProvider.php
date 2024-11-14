<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate; // Descomentado para usar Gate
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Aquí podrías mapear políticas de modelos, si las tuvieras.
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Definir el Gate para el acceso a evaluaciones
        Gate::define('access-evaluations', function ($user) {
            return $user->hasRole('admin'); // Solo usuarios con el rol 'admin' pueden acceder
        });
    }
}
