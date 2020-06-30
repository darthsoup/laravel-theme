<?php

namespace DarthSoup\Theme\Contracts;

use Illuminate\Support\Collection;

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
