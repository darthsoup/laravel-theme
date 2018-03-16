<?php

namespace DarthSoup\Theme\Middleware;

use Closure;

/**
 * Class SetTheme
 *
 * @author Kevin Krummnacker <kevin.krummnacker@gmail.com>
 * @package Services\Theme\Middleware
 */
class SetTheme
{
    /**
     * Set Theme by request middleware
     *
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        \Theme::activate($brand->slug);
        return $next($request);
    }
}
