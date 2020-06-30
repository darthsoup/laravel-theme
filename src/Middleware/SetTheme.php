<?php

namespace DarthSoup\Theme\Middleware;

use Closure;
use DarthSoup\Theme\Theme;

class SetTheme
{
    /**
     * @var DarthSoup\Theme\Theme
     */
    protected $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    /**
     * Set Theme by request middleware
     *
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->theme->activate('default');

        return $next($request);
    }
}
