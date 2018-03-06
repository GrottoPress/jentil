<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities;

use GrottoPress\Jentil\Jentil;
use GrottoPress\Jentil\Utilities\ThemeMods\ThemeMods;
use GrottoPress\Jentil\Utilities\Page\Page;
use GrottoPress\WordPress\Breadcrumbs\Breadcrumbs;
use GrottoPress\WordPress\Posts\Posts;
use GrottoPress\WordPress\Post\Post;
use GrottoPress\Mobile\Detector;
use GrottoPress\Getter\GetterTrait;
use GrottoPress\WordPress\MetaBox\MetaBox;
use Puc_v4p2_Theme_UpdateChecker;
use Puc_v4_Factory;

class Utilities
{
    use GetterTrait;

    /**
     * @var Jentil
     */
    private $app;

    /**
     * @var ThemeMods
     */
    private $themeMods = null;

    /**
     * @var Page
     */
    private $page = null;

    /**
     * @var Colophon
     */
    private $colophon = null;

    /**
     * @var FileSystem
     */
    private $fileSystem = null;

    /**
     * @var Loader
     */
    private $loader = null;

    /**
     * @var Detector
     */
    private $mobileDetector = null;

    /**
     * @var Puc_v4p2_Theme_UpdateChecker
     */
    private $updater = null;

    /**
     * @var ShortTags
     */
    private $shortTags = null;

    /**
     * @var PostTypeTemplate
     */
    private $postTypeTemplate = null;

    public function __construct(Jentil $jentil)
    {
        $this->app = $jentil;
    }

    private function getApp(): Jentil
    {
        return $this->app;
    }

    private function getThemeMods(): ThemeMods
    {
        if (null === $this->themeMods) {
            $this->themeMods = new ThemeMods($this);
        }

        return $this->themeMods;
    }

    private function getPage(): Page
    {
        if (null === $this->page) {
            $this->page = new Page($this);
        }

        return $this->page;
    }

    private function getColophon(): Colophon
    {
        if (null === $this->colophon) {
            $this->colophon = new Colophon($this);
        }

        return $this->colophon;
    }

    private function getFileSystem(): FileSystem
    {
        if (null === $this->fileSystem) {
            $this->fileSystem = new FileSystem($this);
        }

        return $this->fileSystem;
    }

    private function getLoader(): Loader
    {
        if (null === $this->loader) {
            $this->loader = new Loader($this);
        }

        return $this->loader;
    }

    private function getMobileDetector(): Detector
    {
        if (null === $this->mobileDetector) {
            $this->mobileDetector = new Detector();
        }

        return $this->mobileDetector;
    }

    private function getUpdater(): Puc_v4p2_Theme_UpdateChecker
    {
        if (null === $this->updater) {
            $this->updater = Puc_v4_Factory::buildUpdateChecker(
                'https://api.grottopress.com/wp-update-server/v1/?action=get_metadata&slug=jentil',
                $this->fileSystem()->dir('path', '/functions.php'),
                'jentil'
            );
        }

        return $this->updater;
    }

    private function getShortTags(): ShortTags
    {
        if (null === $this->shortTags) {
            $this->shortTags = new ShortTags($this);
        }

        return $this->shortTags;
    }

    private function getPostTypeTemplate(): PostTypeTemplate
    {
        if (null === $this->postTypeTemplate) {
            $this->postTypeTemplate = new PostTypeTemplate($this);
        }

        return $this->postTypeTemplate;
    }

    public function breadcrumbs(array $args = []): Breadcrumbs
    {
        $breadcrumbs = new Breadcrumbs($this->getPage(), $args);

        return $breadcrumbs->collectLinks();
    }

    public function posts(array $args = []): Posts
    {
        return new Posts($args);
    }

    public function post(int $id = 0): Post
    {
        return new Post($id);
    }

    public function metaBox(array $args): MetaBox
    {
        return new MetaBox($args);
    }
}
