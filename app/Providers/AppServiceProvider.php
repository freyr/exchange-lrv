<?php

namespace App\Providers;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            Connection::class,
            function () {
                $connectionParams = [
                    'dbname' => config('database.connections.mysql.database'),
                    'user' => config('database.connections.mysql.username'),
                    'password' => config('database.connections.mysql.password'),
                    'host' => config('database.connections.mysql.host'),
                    'driver' => 'pdo_mysql',
                    'charset' => 'utf8mb4'
                ];

                return DriverManager::getConnection($connectionParams);
            }
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
