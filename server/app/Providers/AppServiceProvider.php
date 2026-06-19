<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($url = env('DATABASE_URL')) {
            $parsed = parse_url($url);
            config([
                'database.connections.pgsql.host' => $parsed['host'] ?? null,
                'database.connections.pgsql.port' => $parsed['port'] ?? null,
                'database.connections.pgsql.database' => ltrim($parsed['path'] ?? '', '/'),
                'database.connections.pgsql.username' => $parsed['user'] ?? null,
                'database.connections.pgsql.password' => $parsed['pass'] ?? null,
                'database.connections.pgsql.sslmode' => 'require',
            ]);
        }
    }
}
