<?php

namespace DarthSoup\Tests\Theme;

use DarthSoup\Theme\Facades\Theme;
use DarthSoup\Theme\ThemeServiceProvider;
use Orchestra\Testbench\TestCase;

abstract class AbstractTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ThemeServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return ['Whmcs' => Theme::class];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('session.driver', 'array');
    }
}
