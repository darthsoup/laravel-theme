<?php

namespace DarthSoup\Theme\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Theme
 *
 * @author Kevin Krummnacker <kevin.krummnacker@gmail.com>
 * @package DarthSoup\Theme\Facade
 */
class Theme extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'darthsoup.themes';
    }
}
