<?php

namespace DarthSoup\Tests\Theme;

use DarthSoup\Theme\ThemeManager;

class ServiceProviderTest extends AbstractTestCase
{
    public function testThemeProviderBind()
    {
        $instance = $this->app->make('darthsoup.themes');

        $this->assertInstanceOf(ThemeManager::class, $instance);
    }
}
