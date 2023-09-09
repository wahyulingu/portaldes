<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->bootResponseMacros();
    }

    protected function bootResponseMacros(): void
    {
        Response::macro('created', fn (
            $content,
            $headers = []
        ) => Response::make($content, 202, $headers));

        Response::macro('see', fn (
            string $path,
            array $headers = [],
            bool $secure = null
        ) => Response::redirectTo($path, 303, $headers, $secure));
    }
}
