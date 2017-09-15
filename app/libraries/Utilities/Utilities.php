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
use GrottoPress\Jentil\Utilities\Logo;
use GrottoPress\WordPress\Breadcrumbs\Breadcrumbs;
// use GrottoPress\WordPress\Posts\Posts;
// use GrottoPress\WordPress\Post\Post;
use GrottoPress\MagPack\Utilities\Query\Posts;
use GrottoPress\MagPack\Utilities\Post\Post;
use GrottoPress\Mobile\Detector;
use \Puc_v4p2_Theme_UpdateChecker;
use \Puc_v4_Factory;

/**
 * Utilities
 *
 * @since 0.1.0
 */
final class Utilities
{
    /**
     * Jentil
     *
     * @since 0.1.0
     * @access private
     *
     * @var Jentil $jentil Jentil.
     */
    private $jentil;

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
     * @var FileSystem $file_system FileSystem.
     */
    private $file_system = null;

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
     * @var Detector $detector Mobile detector.
     */
    private $detector = null;

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
    public function jentil(): Jentil
    {
        return $this->jentil;
    }

    /**
     * Mods
     *
     * @since 0.1.0
     * @access public
     *
     * @return Mods Mods.
     */
    public function mods(): Mods
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
     * @access public
     *
     * @return Page Page.
     */
    public function page(): Page
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
     * @access public
     *
     * @return Colophon Colophon.
     */
    public function colophon(): Colophon
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
     * @access public
     *
     * @return FileSystem FileSystem.
     */
    public function fileSystem(): FileSystem
    {
        if (null === $this->file_system) {
            $this->file_system = new FileSystem($this);
        }

        return $this->file_system;
    }

    /**
     * Loader
     *
     * @since 0.1.0
     * @access public
     *
     * @return Loader Loader.
     */
    public function loader(): Loader
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
     * @access public
     *
     * @return Detector Mobile detector.
     */
    public function mobileDetector(): Detector
    {
        if (null === $this->detector) {
            $this->detector = new Detector();
        }

        return $this->detector;
    }

    /**
     * Updater
     *
     * @since 0.1.0
     * @access public
     *
     * @return Theme_UpdateChecker Updater.
     */
    public function updater(): Puc_v4p2_Theme_UpdateChecker
    {
        if (null === $this->updater) {
            $this->updater = Puc_v4_Factory::buildUpdateChecker(
                'https://api.grottopress.com/wp-update-server/v1/?action=get_metadata&slug=jentil',
                $this->fileSystem()->themeDir('path', '/functions.php'),
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
        return new Breadcrumbs($this->page(), $args);
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
