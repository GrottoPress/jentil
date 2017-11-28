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
use GrottoPress\Jentil\Utilities\Mods\Mods;
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
     * @var Jentil $theme Jentil.
     */
    private $theme;

    /**
     * Mods
     *
     * @since 0.1.0
     * @access private
     *
     * @var Mods\Mods $mods Mods.
     */
    private $mods = null;

    /**
     * Page
     *
     * @since 0.1.0
     * @access private
     *
     * @var Page\Page $page Page.
     */
    private $page = null;

    /**
     * Colophon
     *
     * @since 0.1.0
     * @access private
     *
     * @var Colophon $colophon Colophon.
     */
    private $colophon = null;

    /**
     * File System
     *
     * @since 0.1.0
     * @access private
     *
     * @var FileSystem $fileSystem FileSystem.
     */
    private $fileSystem = null;

    /**
     * Loader
     *
     * @since 0.1.0
     * @access private
     *
     * @var Loader $loader Loader.
     */
    private $loader = null;

    /**
     * Mobile Detector
     *
     * @since 0.1.0
     * @access private
     *
     * @var Detector $mobileDetector Mobile detector.
     */
    private $mobileDetector = null;

    /**
     * Updater
     *
     * @since 0.1.0
     * @access private
     *
     * @var Theme_UpdateChecker $updater Updater.
     */
    private $updater = null;

    /**
     * Constructor
     *
     * @var Jentil $jentil Jentil.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Jentil $jentil)
    {
        $this->theme = $jentil;
    }

    /**
     * Get theme
     *
     * @since 0.1.0
     * @access public
     *
     * @return Jentil Jentil.
     */
    private function getTheme(): Jentil
    {
        return $this->theme;
    }

    /**
     * Mods
     *
     * @since 0.1.0
     * @access private
     *
     * @return Mods Mods.
     */
    private function getMods(): Mods
    {
        if (null === $this->mods) {
            $this->mods = new Mods($this);
        }

        return $this->mods;
    }

    /**
     * Page
     *
     * @since 0.1.0
     * @access private
     *
     * @return Page Page.
     */
    private function getPage(): Page
    {
        if (null === $this->page) {
            $this->page = new Page($this);
        }

        return $this->page;
    }

    /**
     * Colophon
     *
     * @since 0.1.0
     * @access private
     *
     * @return Colophon Colophon.
     */
    private function getColophon(): Colophon
    {
        if (null === $this->colophon) {
            $this->colophon = new Colophon($this);
        }

        return $this->colophon;
    }

    /**
     * File System
     *
     * @since 0.1.0
     * @access private
     *
     * @return FileSystem FileSystem.
     */
    private function getFileSystem(): FileSystem
    {
        if (null === $this->fileSystem) {
            $this->fileSystem = new FileSystem($this);
        }

        return $this->fileSystem;
    }

    /**
     * Loader
     *
     * @since 0.1.0
     * @access private
     *
     * @return Loader Loader.
     */
    private function getLoader(): Loader
    {
        if (null === $this->loader) {
            $this->loader = new Loader($this);
        }

        return $this->loader;
    }

    /**
     * Mobile Detector
     *
     * @since 0.1.0
     * @access private
     *
     * @return Detector Mobile detector.
     */
    private function getMobileDetector(): Detector
    {
        if (null === $this->mobileDetector) {
            $this->mobileDetector = new Detector();
        }

        return $this->mobileDetector;
    }

    /**
     * Updater
     *
     * @since 0.1.0
     * @access private
     *
     * @return Theme_UpdateChecker Updater.
     */
    private function getUpdater(): Puc_v4p2_Theme_UpdateChecker
    {
        if (null === $this->updater) {
            $this->updater = Puc_v4_Factory::buildUpdateChecker(
                'https://api.grottopress.com/wp-update-server/v1/?action=get_metadata&slug=jentil',
                $this->fileSystem->dir('path', '/functions.php'),
                'jentil'
            );
        }

        return $this->updater;
    }

    /**
     * Breadcrumbs
     *
     * @param array $args Breadcrumb args.
     *
     * @since 0.1.0
     * @access public
     *
     * @return Breadcrumbs Breadcrumbs.
     */
    public function breadcrumbs(array $args = []): Breadcrumbs
    {
        return (new Breadcrumbs($this->getPage(), $args))->collectLinks();
    }

    /**
     * Posts
     *
     * @param array $args Posts args.
     *
     * @since 0.1.0
     * @access public
     *
     * @return Posts Posts.
     */
    public function posts(array $args = []): Posts
    {
        return new Posts($args);
    }

    /**
     * Post
     *
     * @param integer $id Posts ID.
     *
     * @since 0.1.0
     * @access public
     *
     * @return Post Post.
     */
    public function post(int $id = 0): Post
    {
        return new Post($id);
    }
}
