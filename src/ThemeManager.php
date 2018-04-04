<?php

namespace DarthSoup\Theme;

use DarthSoup\Theme\Exceptions\ThemeException;
use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\View\Factory as ViewFactory;

/**
 * Class Theme
 *
 * @author Kevin Krummnacker <kevin.krummnacker@gmail.com>
 * @package DarthSoup\Theme
 */
class ThemeManager
{
    /**
     * @var
     */
    protected $config;

    /**
     * @var Filesystem
     */
    protected $file;

    /**
     * @var ViewFactory
     */
    protected $view;

    /**
     * @var Theme
     */
    protected $theme;

    /**
     * @var Collection
     */
    protected $themesList;

    /**
     * @var string
     */
    private $path;

    /**
     * Theme Manager
     *
     * @param Filesystem $filesystem
     * @param Repository $config
     * @param ViewFactory $view
     */
    public function __construct(Filesystem $filesystem, Repository $config, ViewFactory $view)
    {
        $this->config = $config;
        $this->filesystem = $filesystem;
        $this->view = $view;

        $this->themesList = new Collection();
    }

    /**
     * Register Theme Namespace
     */
    public function register(): void
    {
        foreach ($this->fetch() as $theme) {
            $this->view->addNamespace($theme->getName(), $theme->getViewPath());
        }
    }

    /**
     * Fetch all Themes from Filesystem
     *
     * @return Collection
     */
    private function fetch(): Collection
    {
        if ($this->filesystem->exists($this->getPath())) {
            foreach ($this->filesystem->directories($this->getPath()) as $theme) {
                $themeName = pathinfo($theme, PATHINFO_BASENAME);
                $this->themesList->put($themeName, new Theme($themeName));
            }
        }

        return $this->themesList;
    }

    /**
     * @param string $themeName
     * @throws ThemeException
     * @return mixed
     */
    public function get(string $themeName)
    {
        if (!$this->exists($themeName)) {
            throw new ThemeException("Theme ['{$themeName}'] does not exist");
        }

        return $this->themesList->get($themeName);
    }

    /**
     * @param string $themeName
     * @return bool
     */
    public function exists(string $themeName): bool
    {
        return $this->themesList->has($themeName);
    }

    /**
     * @return string
     */
    private function getPath(): string
    {
        return $this->path ?: $this->config->get('theme.theme_path');
    }

    /**
     * Gets active theme.
     * @return Theme
     */
    public function active(): ?Theme
    {
        return $this->theme;
    }

    /**
     * @param string $asset
     * @return null|string
     */
    protected function getAsset(string $asset): ?string
    {
        $assetList = [$asset];

        if ($this->active() instanceof Theme) {
            $asset = $this->config->get('theme.assets_path') . '/'
                . $this->active()->getName() . '/'
                . $asset;
            $assetList = Arr::prepend($assetList, $asset);
        }

        foreach ($assetList as $value) {
            if ($this->filesystem->exists($value)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * get asset
     *
     * @param $asset
     * @param bool|null $secure
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function asset(string $asset, bool $secure = null)
    {
        return url()->asset($this->getAsset($asset), $secure);
    }

    /**
     * @param string $view
     * @return string
     */
    protected function getView(string $view): ?string
    {
        $viewList = [$view];

        if ($this->active() instanceof Theme) {
            $viewList = Arr::prepend($viewList, $this->active()->getNamespace() . $view);
        }

        foreach ($viewList as $value) {
            if ($this->view->exists($value)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @param string $view
     * @param array $data
     * @return \Illuminate\Contracts\View\View
     */
    public function view(string $view, array $data = [])
    {
        $this->view->share('theme', $this->getProperties());

        return $this->view->make($this->getView($view), $data);
    }

    /**
     * @param string $view
     * @return string
     */
    public function viewName(string $view)
    {
        return $this->getView($view);
    }

    /**
     * @return array
     */
    protected function getProperties(): ?array
    {
        if (!$this->theme) {
            return null;
        }

        return $this->theme->getProperties();
    }

    /**
     * @return array
     */
    protected function getConfig()
    {
        if (!$this->theme) {
            return collect();
        }

        return $this->theme->getConfig();
    }

    /**
     * @param $key
     * @param string|null $default
     * @return array|string
     */
    public function property($key = null, $default = null)
    {
        return Arr::get($this->getProperties(), $key, $default);
    }

    /**
     * @param $key
     * @param string|null $default
     * @return array|string
     */
    public function config($key = null, $default = null)
    {
        return Arr::get($this->getConfig(), $key, $default);
    }

    /**
     * Sets active theme.
     *
     * @param string $themeName
     * @throws ThemeException
     * @return $this
     */
    public function activate(string $themeName)
    {
        if (!$this->exists($themeName)) {
            throw new ThemeException("Theme ['{$themeName}'] does not exist");
        }

        $this->theme = $this->get($themeName);
        return $this;
    }
}
