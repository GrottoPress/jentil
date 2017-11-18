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
class Utilities
{
    use Getter;
    
    /**
     * Jentil
     *
     * @since 0.1.0
     * @access protected
     *
     * @var Jentil $jentil Jentil.
     */
    protected $jentil;

    /**
     * Mods
     *
     * @since 0.1.0
     * @access protected
     *
     * @var Mods\Mods $mods Mods.
     */
    protected $mods = null;

    /**
     * Page
     *
     * @since 0.1.0
     * @access protected
     *
     * @var Page\Page $page Page.
     */
    protected $page = null;

    /**
     * Colophon
     *
     * @since 0.1.0
     * @access protected
     *
     * @var Colophon $colophon Colophon.
     */
    protected $colophon = null;

    /**
     * File System
     *
     * @since 0.1.0
     * @access protected
     *
     * @var FileSystem $fileSystem FileSystem.
     */
    protected $fileSystem = null;

    /**
     * Loader
     *
     * @since 0.1.0
     * @access protected
     *
     * @var Loader $loader Loader.
     */
    protected $loader = null;

    /**
     * Mobile Detector
     *
     * @since 0.1.0
     * @access protected
     *
     * @var Detector $mobileDetector Mobile detector.
     */
    protected $mobileDetector = null;

    /**
     * Updater
     *
     * @since 0.1.0
     * @access protected
     *
     * @var Theme_UpdateChecker $updater Updater.
     */
    protected $updater = null;

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
        $this->jentil = $jentil;
    }

    /**
     * Jentil
     *
     * @since 0.1.0
     * @access public
     *
     * @return Jentil Jentil.
     */
    protected function getJentil(): Jentil
    {
        return $this->jentil;
    }

    /**
     * Mods
     *
     * @since 0.1.0
     * @access protected
     *
     * @return Mods Mods.
     */
    protected function getMods(): Mods
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
     * @access protected
     *
     * @return Page Page.
     */
    protected function getPage(): Page
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
     * @access protected
     *
     * @return Colophon Colophon.
     */
    protected function getColophon(): Colophon
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
     * @access protected
     *
     * @return FileSystem FileSystem.
     */
    protected function getFileSystem(): FileSystem
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
     * @access protected
     *
     * @return Loader Loader.
     */
    protected function getLoader(): Loader
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
     * @access protected
     *
     * @return Detector Mobile detector.
     */
    protected function getMobileDetector(): Detector
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
     * @access protected
     *
     * @return Theme_UpdateChecker Updater.
     */
    protected function getUpdater(): Puc_v4p2_Theme_UpdateChecker
    {
        if (null === $this->updater) {
            $this->updater = Puc_v4_Factory::buildUpdateChecker(
                'https://api.grottopress.com/wp-update-server/v1/?action=get_metadata&slug=jentil',
                $this->fileSystem->themeDir('path', '/functions.php'),
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
