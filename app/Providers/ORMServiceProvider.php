<?php

namespace App\Providers;

use App\ORM\Managers\ClientManager;

use App\ORM\Managers\Contracts\ClientManagerContract;
use App\ORM\Repositories\ClientRepository;
use App\ORM\Repositories\Contracts\ClientRepositoryContract;
use Illuminate\Support\ServiceProvider;

class ORMServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ClientManagerContract::class, ClientManager::class);
        $this->app->singleton(ClientRepositoryContract::class, ClientRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
