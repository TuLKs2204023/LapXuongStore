<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Repositories\Product\ProductRepositoryInterface::class,
            \App\Repositories\Product\ProductRepository::class,
        );

        $this->app->bind(
            
            \App\Service\Product\ProductServiceInterface::class,
            \App\Service\Product\ProductService::class,
        );

         //ProductComment
         $this->app->bind(
            \App\Repositories\ProductComment\ProductCommentRepositoryInterface::class,
            \App\Repositories\ProductComment\ProductCommentRepository::class,
        );

        $this->app->bind(
            
            \App\Service\ProductComment\ProductCommentServiceInterface::class,
            \App\Service\ProductComment\ProductCommentService::class,
        );
        $this->app->bind(
            \App\Repositories\Cate\CateRepositoryInterface::class,
            \App\Repositories\Cate\CateRepository::class,
        );

        $this->app->bind(
            
            \App\Service\Cate\CateServiceInterface::class,
            \App\Service\Cate\CateService::class,
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
