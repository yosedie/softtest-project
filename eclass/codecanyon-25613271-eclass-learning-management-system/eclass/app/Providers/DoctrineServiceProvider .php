<?php

namespace App\Providers;

use Doctrine\DBAL\Types\Type;
use Illuminate\Support\ServiceProvider;

class DoctrineServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register smallInteger type if not registered
        if (!Type::hasType('smallInteger')) {
            Type::addType('smallInteger', 'Doctrine\DBAL\Types\SmallIntType');
        }

        // Register tinyInteger type if not registered
        if (!Type::hasType('tinyInteger')) {
            Type::addType('tinyInteger', 'Doctrine\DBAL\Types\SmallIntType');
        }
         // Register longText type if not registered
         if (!Type::hasType('longText')) {
            Type::addType('longText', 'Doctrine\DBAL\Types\TextType');
        }
    }
}