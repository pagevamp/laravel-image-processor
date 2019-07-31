<?php

namespace Pagevamp\Providers;

use Illuminate\Support\ServiceProvider;

class ProcessorServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     */
    public function register()
    {
            $this->mergeConfigFrom(
                __DIR__ . '/../Config/Storage.php',
                'storage'
            );
    }

    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        //
    }
}
