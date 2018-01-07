<?php

/**
 * Utilities
 *
 * @package GrottoPress\Jentil\Utilities
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities;

use GrottoPress\Jentil\Jentil;
use GrottoPress\Jentil\Utilities\ThemeMods\ThemeMods;
use GrottoPress\Jentil\Utilities\Page\Page;
use GrottoPress\Jentil\Utilities\Colophon;
use GrottoPress\WordPress\Breadcrumbs\Breadcrumbs;
use GrottoPress\WordPress\Posts\Posts;
use GrottoPress\WordPress\Post\Post;
use GrottoPress\Mobile\Detector;
use GrottoPress\Getter\Getter;
use Puc_v4p2_Theme_UpdateChecker;
use Puc_v4_Factory;

/**
 * Utilities
 *
 * @since 0.1.0
 */
final class Utilities
{
    use Getter;
    
    /**
     * Jentil
     *
     * @since 0.1.0
     * @access private
     *
     * @var Jentil
     */
    private $app;

    /**
     * ThemeMods
     *
     * @since 0.1.0
     * @access private
     *
     * @var ThemeMods
     */
    private $themeMods = null;

    /**
     * Page
     *
     * @since 0.1.0
     * @access private
     *
     * @var Page
     */
    private $page = null;

    /**
     * Colophon
     *
     * @since 0.1.0
     * @access private
     *
     * @var Colophon
     */
    private $colophon = null;

    /**
     * File System
     *
     * @since 0.1.0
     * @access private
     *
     * @var FileSystem
     */
    private $fileSystem = null;

    /**
     * Loader
     *
     * @since 0.1.0
     * @access private
     *
     * @var Loader
     */
    private $loader = null;

    /**
     * Mobile Detector
     *
     * @since 0.1.0
     * @access private
     *
     * @var Detector
     */
    private $mobileDetector = null;

    /**
     * Updater
     *
     * @since 0.1.0
     * @access private
     *
     * @var Puc_v4p2_Theme_UpdateChecker
     */
    private $updater = null;

    /**
     * Short Tags
     *
     * @since 0.1.0
     * @access private
     *
     * @var ShortTags
     */
    private $shortTags = null;

    /**
     * Constructor
     *
     * @var Jentil $jentil
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Jentil $jentil)
    {
        $this->app = $jentil;
    }

    /**
     * Get app
     *
     * @since 0.1.0
     * @access public
     *
     * @return Jentil
     */
    private function getApp(): Jentil
    {
        return $this->app;
    }

    /**
     * Get mods
     *
     * @since 0.1.0
     * @access private
     *
     * @return ThemeMods
     */
    private function getThemeMods(): ThemeMods
    {
        if (null === $this->themeMods) {
            $this->themeMods = new ThemeMods($this);
        }

        return $this->themeMods;
    }

    /**
     * Get page
     *
     * @since 0.1.0
     * @access private
     *
     * @return Page
     */
    private function getPage(): Page
    {
        if (null === $this->page) {
            $this->page = new Page($this);
        }

        return $this->page;
    }

    /**
     * Get colophon
     *
     * @since 0.1.0
     * @access private
     *
     * @return Colophon
     */
    private function getColophon(): Colophon
    {
        if (null === $this->colophon) {
            $this->colophon = new Colophon($this);
        }

        return $this->colophon;
    }

    /**
     * Get file System
     *
     * @since 0.1.0
     * @access private
     *
     * @return FileSystem
     */
    private function getFileSystem(): FileSystem
    {
        if (null === $this->fileSystem) {
            $this->fileSystem = new FileSystem($this);
        }

        return $this->fileSystem;
    }

    /**
     * Get loader
     *
     * @since 0.1.0
     * @access private
     *
     * @return Loader
     */
    private function getLoader(): Loader
    {
        if (null === $this->loader) {
            $this->loader = new Loader($this);
        }

        return $this->loader;
    }

    /**
     * Get mobile detector
     *
     * @since 0.1.0
     * @access private
     *
     * @return Detector
     */
    private function getMobileDetector(): Detector
    {
        if (null === $this->mobileDetector) {
            $this->mobileDetector = new Detector();
        }

        return $this->mobileDetector;
    }

    /**
     * Get updater
     *
     * @since 0.1.0
     * @access private
     *
     * @return Puc_v4p2_Theme_UpdateChecker
     */
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

    /**
     * Get short tags
     *
     * @since 0.5.0
     * @access public
     *
     * @return ShortTags
     */
    public function getShortTags(): ShortTags
    {
        if (null === $this->shortTags) {
            $this->shortTags = new ShortTags($this);
        }

        return $this->shortTags;
    }

    /**
     * Breadcrumbs
     *
     * @param array $args
     *
     * @since 0.1.0
     * @access public
     *
     * @return Breadcrumbs
     */
    public function breadcrumbs(array $args = []): Breadcrumbs
    {
        $breadcrumbs = new Breadcrumbs($this->getPage(), $args);
        
        return $breadcrumbs->collectLinks();
    }

    /**
     * Posts
     *
     * @param array $args
     *
     * @since 0.1.0
     * @access public
     *
     * @return Posts
     */
    public function posts(array $args = []): Posts
    {
        return new Posts($args);
    }

    /**
     * Post
     *
     * @param integer $id Post ID.
     *
     * @since 0.1.0
     * @access public
     *
     * @return Post
     */
    public function post(int $id = 0): Post
    {
        return new Post($id);
    }
}
