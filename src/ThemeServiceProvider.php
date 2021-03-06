<?php

namespace DarthSoup\Theme;

use DarthSoup\Theme\Console\ListThemes;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            dirname(__DIR__).'/config/theme.php' => config_path('theme.php'),
        ], 'config');

        $this->bootBlade();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(dirname(__DIR__) . '/config/theme.php', 'theme');

        $this->registerTheme();

        $this->registerConsole();
    }

    /**
     * registerBlade
     */
    protected function registerTheme()
    {
        $this->app->singleton('darthsoup.themes', function ($app) {
            return new ThemeManager($app['files'], $app['config'], $app['view']);
        });

        $this->app->booting(function ($app) {
            $app['darthsoup.themes']->register();
        });
    }

    /**
     * bootBlade
     */
    protected function bootBlade()
    {
        $this->app['blade.compiler']->directive('includeTheme', function ($expression) {
            return "<?= app('darthsoup.themes')->view({$expression}); ?>";
        });
    }

    /**
     * registerConsole
     */
    protected function registerConsole()
    {
        $this->commands([
            ListThemes::class
        ]);
    }

    /**
     * Get the config path
     *
     * @return string
     */
    protected function getConfigPath()
    {
        return config_path('theme.php');
    }
}
