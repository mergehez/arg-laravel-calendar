<?php
namespace MergeSoft;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class CalendarServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'arg-calendar');
    }

    public function boot()
    {
        if ($this->app->runningInConsole())
        {
            // php artisan vendor:publish --provider="MergeSoft\CalendarServiceProvider" --tag="config" --force
            $this->publishes([__DIR__ . '/config.php' => config_path('arg-calendar.php') , ], 'config');

            // php artisan vendor:publish --provider="MergeSoft\CalendarServiceProvider" --tag="component" --force
            $this->publishes([__DIR__ . '/views/arg-calendar.blade.php' => resource_path('views/mergesoft/arg-calendar.blade.php')], 'component');

            
            $langs = scandir(__DIR__ . "/translations");
            foreach ($langs as $lang) {
                if(strpos($lang, ".php") !== false){
                    $lang = str_replace(".php", "", $lang);
                    // php artisan vendor:publish --provider="MergeSoft\CalendarServiceProvider" --tag="lang.<lang-code>" --force
                    $this->publishes([__DIR__ . "/translations/$lang.php" => resource_path("lang/$lang/arg-calendar.php")], "lang.$lang");
                }
            }
        }

        $this->loadViewsFrom(__DIR__ . '/views', 'arg-calendar');
        if (!view()->exists("mergesoft.arg-calendar"))
        {
            Blade::component('arg-calendar::arg-calendar', 'arg-calendar');
        }
        else
        {
            Blade::component('mergesoft.arg-calendar', 'arg-calendar');
        }
    }
}

