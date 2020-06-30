<?php

namespace DarthSoup\Theme;

use DarthSoup\Theme\Contracts\Themable;
use DarthSoup\Theme\Exceptions\ThemeException;
use Illuminate\Support\Collection;

class Theme implements Themable
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    private $config;

    /**
     * Theme constructor.
     * @param string $name
     * @param string $path
     */
    public function __construct(string $name, string $path = null)
    {
        $this->name = $name;
        $this->path = $path ?: config('theme.theme_path') . '/' . $name;

        $this->config = new Collection($this->parseConfig());
    }

    /**
     * @throws ThemeException
     * @return array|mixed
     */
    protected function parseConfig()
    {
        $file = $this->path . '/config.php';
        if (!file_exists($file)) {
            return [];
        }

        $config = require $file;

        if (!isset($config['name']) && empty($config['name'])) {
            throw new ThemeException("Theme '{$this->getName()}' does not include a name parameter.");
        }
        if (!isset($config['slug']) && empty($config['slug'])) {
            throw new ThemeException("Theme '{$this->getName()}'' does not include a slug parameter.");
        }

        return $config;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Returns View Path
     *
     * @return string
     */
    public function getViewPath(): string
    {
        return $this->path . '/views';
    }

    /**
     * Returns Namespace of Theme
     */
    public function getNamespace(): string
    {
        return $this->name . '::';
    }

    /**
     * Get Properties of the theme
     * @return Repository
     */
    public function getConfig(): Collection
    {
        return $this->config;
    }

    /**
     * Get Properties of the theme
     * @return array
     */
    public function getProperties(): array
    {
        if ($this->config->offsetExists('properties')) {
            return $this->config->offsetGet('properties');
        }

        return [];
    }
}
