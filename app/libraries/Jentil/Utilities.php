<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil;

use GrottoPress\Jentil;
use GrottoPress\WordPress\Breadcrumbs;
use GrottoPress\WordPress\Posts;
use GrottoPress\WordPress\Post;
use GrottoPress\Mobile\Detector;
use GrottoPress\Getter\GetterTrait;
use GrottoPress\WordPress\MetaBox;

class Utilities
{
    use GetterTrait;

    /**
     * @var Jentil
     */
    private $app;

    /**
     * @var Utilities\ThemeMods
     */
    private $themeMods = null;

    /**
     * @var Utilities\Page
     */
    private $page = null;

    /**
     * @var Utilities\Colophon
     */
    private $colophon = null;

    /**
     * @var Utilities\FileSystem
     */
    private $fileSystem = null;

    /**
     * @var Utilities\Loader
     */
    private $loader = null;

    /**
     * @var Utilities\ShortTags
     */
    private $shortTags = null;

    /**
     * @var Utilities\PostTypeTemplate
     */
    private $postTypeTemplate = null;

    /**
     * @var Detector
     */
    private $mobileDetector = null;

    public function __construct(Jentil $jentil)
    {
        $this->app = $jentil;
    }

    private function getApp(): Jentil
    {
        return $this->app;
    }

    private function getThemeMods(): Utilities\ThemeMods
    {
        if (null === $this->themeMods) {
            $this->themeMods = new Utilities\ThemeMods($this);
        }

        return $this->themeMods;
    }

    private function getPage(): Utilities\Page
    {
        if (null === $this->page) {
            $this->page = new Utilities\Page($this);
        }

        return $this->page;
    }

    private function getColophon(): Utilities\Colophon
    {
        if (null === $this->colophon) {
            $this->colophon = new Utilities\Colophon($this);
        }

        return $this->colophon;
    }

    private function getFileSystem(): Utilities\FileSystem
    {
        if (null === $this->fileSystem) {
            $this->fileSystem = new Utilities\FileSystem($this);
        }

        return $this->fileSystem;
    }

    private function getLoader(): Utilities\Loader
    {
        if (null === $this->loader) {
            $this->loader = new Utilities\Loader($this);
        }

        return $this->loader;
    }

    private function getShortTags(): Utilities\ShortTags
    {
        if (null === $this->shortTags) {
            $this->shortTags = new Utilities\ShortTags($this);
        }

        return $this->shortTags;
    }

    private function getPostTypeTemplate(): Utilities\PostTypeTemplate
    {
        if (null === $this->postTypeTemplate) {
            $this->postTypeTemplate = new Utilities\PostTypeTemplate($this);
        }

        return $this->postTypeTemplate;
    }

    private function getMobileDetector(): Detector
    {
        if (null === $this->mobileDetector) {
            $this->mobileDetector = new Detector();
        }

        return $this->mobileDetector;
    }

    /**
     * @param mixed[string] $args
     */
    public function breadcrumbs(array $args = []): Breadcrumbs
    {
        return new Breadcrumbs($this->getPage(), $args);
    }

    /**
     * @param mixed[string] $args
     */
    public function posts(array $args = []): Posts
    {
        return new Posts($args);
    }

    public function post(int $id = 0): Post
    {
        return new Post($id);
    }

    /**
     * @param mixed[string] $args
     */
    public function metaBox(array $args): MetaBox
    {
        return new MetaBox($args);
    }
}
