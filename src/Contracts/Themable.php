<?php

namespace DarthSoup\Theme\Contracts;

use Illuminate\Support\Collection;

/**
 * Interface Themable
 *
 * @author Kevin Krummnacker <kevin.krummnacker@gmail.com>
 * @package DarthSoup\Theme\Contracts
 */
interface Themable
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return array
     */
    public function getConfig(): Collection;

    /**
     * @return string
     */
    public function getViewPath(): string;

    /**
     * @return string
     */
    public function getNamespace(): string;
}
