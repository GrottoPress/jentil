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
    private $themeMods;

    /**
     * @var Utilities\Page
     */
    private $page;

    /**
     * @var Utilities\Footer
     */
    private $footer;

    /**
     * @var Utilities\FileSystem
     */
    private $fileSystem;

    /**
     * @var Utilities\Loader
     */
    private $loader;

    /**
     * @var Utilities\ShortTags
     */
    private $shortTags;

    /**
     * @var Utilities\PostTypeTemplate
     */
    private $postTypeTemplate;

    /**
     * @var Detector
     */
    private $mobileDetector;

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
        return $this->themeMods = $this->themeMods ?:
            new Utilities\ThemeMods($this);
    }

    private function getPage(): Utilities\Page
    {
        return $this->page = $this->page ?: new Utilities\Page($this);
    }

    private function getFooter(): Utilities\Footer
    {
        return $this->footer = $this->footer ?: new Utilities\Footer($this);
    }

    private function getFileSystem(): Utilities\FileSystem
    {
        return $this->fileSystem = $this->fileSystem ?:
            new Utilities\FileSystem($this);
    }

    private function getLoader(): Utilities\Loader
    {
        return $this->loader = $this->loader ?: new Utilities\Loader($this);
    }

    private function getShortTags(): Utilities\ShortTags
    {
        return $this->shortTags = $this->shortTags ?:
            new Utilities\ShortTags($this);
    }

    private function getPostTypeTemplate(): Utilities\PostTypeTemplate
    {
        return $this->postTypeTemplate = $this->postTypeTemplate ?:
            new Utilities\PostTypeTemplate($this);
    }

    private function getMobileDetector(): Detector
    {
        return $this->mobileDetector = $this->mobileDetector ?: new Detector();
    }

    /**
     * @param array<string, mixed> $args
     */
    public function breadcrumbs(array $args = []): Breadcrumbs
    {
        return new Breadcrumbs($this->getPage(), $args);
    }

    /**
     * @param array<string, mixed> $args
     */
    public function posts(array $args = []): Posts
    {
        return new Posts($args);
    }

    public function post($post = null): Post
    {
        return new Post($post);
    }

    /**
     * @param array<string, mixed> $args
     */
    public function metaBox(array $args): MetaBox
    {
        return new MetaBox($args);
    }
}
