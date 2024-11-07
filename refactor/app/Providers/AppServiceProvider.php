<?php

namespace App\Providers;

use App\Services\BaseService;
use App\Repositories\BaseRepository;
use App\Contracts\BaseServiceContract;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Contracts\BaseRepositoryContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BaseServiceContract::class, BaseService::class);
        $this->app->bind(BaseRepositoryContract::class, BaseRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);

    }
}
