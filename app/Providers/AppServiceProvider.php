<?php

namespace App\Providers;

use App\Contracts\Mediator\DtoMediatorContract;
use App\Contracts\Mediator\StringMediatorContract;
use App\Contracts\Repositories\CategoryRepositoryContract;
use App\Contracts\Repositories\PostRepositoryContract;
use App\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Services\CategoryServiceContract;
use App\Contracts\Services\OtpServiceContract;
use App\Contracts\Services\PostServiceContract;
use App\Contracts\Services\UserServiceContract;
use App\Mediator\DtoMediator;
use App\Mediator\StringMediator;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use App\Services\CategoryService;
use App\Services\OtpService;
use App\Services\PostService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * @var array|string[]
     */
    public array $singletons = [
        // Repo
        CategoryRepositoryContract::class => CategoryRepository::class,
        PostRepositoryContract::class => PostRepository::class,
        UserRepositoryContract::class => UserRepository::class,

        // Service
        CategoryServiceContract::class => CategoryService::class,
        PostServiceContract::class => PostService::class,
        UserServiceContract::class => UserService::class,
        OtpServiceContract::class => OtpService::class,

        //Others
        DtoMediatorContract::class => DtoMediator::class,
        StringMediatorContract::class => StringMediator::class,
    ];


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
        //
    }
}
