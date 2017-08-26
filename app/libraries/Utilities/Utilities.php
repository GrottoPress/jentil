<?php

/**
 * Utilities
 *
 * @package GrottoPress\Jentil\Utilities
 * @since 0.1.0
 *
 * @author GrottoPress (https://www.grottopress.com)
 * @author N Atta Kus Adusei (https://twitter.com/akadusei)
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Utilities;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

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

/**
 * Utilities
 *
 * @since 0.1.0
 */
final class Utilities {
    /**
     * Jentil
     *
     * @since 0.1.0
     * @access private
     * 
     * @var GrottoPress\Jentil\Jentil $jentil Jentil.
     */
    private $jentil;

    /**
     * Mods
     *
     * @since 0.1.0
     * @access private
     * 
     * @var GrottoPress\Jentil\Utilities\Mods\Mods $mods Mods.
     */
    private $mods;

    /**
     * Page
     *
     * @since 0.1.0
     * @access private
     * 
     * @var GrottoPress\Jentil\Utilities\Page\Page $page Page.
     */
    private $page;

    /**
     * Colophon
     *
     * @since 0.1.0
     * @access private
     * 
     * @var GrottoPress\Jentil\Utilities\Colophon $colophon Colophon.
     */
    private $colophon;

    /**
     * Logo
     *
     * @since 0.1.0
     * @access private
     * 
     * @var GrottoPress\Jentil\Utilities\Logo $logo Logo.
     */
    private $logo;

    /**
     * Filesystem
     *
     * @since 0.1.0
     * @access private
     * 
     * @var GrottoPress\Jentil\Utilities\Filesystem $filesystem Filesystem.
     */
    private $filesystem;

    /**
     * Loader
     *
     * @since 0.1.0
     * @access private
     * 
     * @var GrottoPress\Jentil\Utilities\Loader $loader Loader.
     */
    private $loader;

    /**
     * Constructor
     * 
     * @var GrottoPress\Jentil\Jentil $jentil Jentil.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct( Jentil $jentil ) {
        $this->jentil = $jentil;
        
        $this->mods = new Mods( $this );
        $this->page = new Page( $this );
        $this->colophon = new Colophon( $this );
        $this->logo = new Logo( $this );
        $this->filesystem = new Filesystem( $this );
        $this->loader = new Loader( $this );
    }

    /**
     * Jentil
     *
     * @since 0.1.0
     * @access public
     *
     * @return GrottoPress\Jentil\Jentil Jentil.
     */
    public function jentil(): Jentil {
        return $this->jentil;
    }

    /**
     * Mods
     *
     * @since 0.1.0
     * @access public
     *
     * @return GrottoPress\Jentil\Utilities\Mods\Mods Mods.
     */
    public function mods(): Mods {
        return $this->mods;
    }

    /**
     * Page
     *
     * @since 0.1.0
     * @access public
     *
     * @return GrottoPress\Jentil\Utilities\Page\Page Page.
     */
    public function page(): Page {
        return $this->page;
    }

    /**
     * Colophon
     *
     * @since 0.1.0
     * @access public
     *
     * @return GrottoPress\Jentil\Utilities\Colophon Colophon.
     */
    public function colophon(): Colophon {
        return $this->colophon;
    }

    /**
     * Logo
     *
     * @since 0.1.0
     * @access public
     *
     * @return GrottoPress\Jentil\Utilities\Logo Logo.
     */
    public function logo(): Logo {
        return $this->logo;
    }

    /**
     * Filesystem
     *
     * @since 0.1.0
     * @access public
     *
     * @return GrottoPress\Jentil\Utilities\Filesystem Filesystem.
     */
    public function filesystem(): Filesystem {
        return $this->filesystem;
    }

    /**
     * Loader
     *
     * @since 0.1.0
     * @access public
     *
     * @return GrottoPress\Jentil\Utilities\Loader Loader.
     */
    public function loader(): Loader {
        return $this->loader;
    }

    /**
     * Breadcrumbs
     *
     * @var array $args Breadcrumb args.
     *
     * @since 0.1.0
     * @access public
     *
     * @return GrottoPress\WordPress\Breadcrumbs\Breadcrumbs Breadcrumbs.
     */
    public function breadcrumbs( array $args = [] ): Breadcrumbs {
        return new Breadcrumbs( $this->page, $args );
    }

    /**
     * Posts
     *
     * @var array $args Posts args.
     *
     * @since 0.1.0
     * @access public
     *
     * @return GrottoPress\WordPress\Posts\Posts Posts.
     */
    public function posts( array $args = [] ): Posts {
        return new Posts( $args );
    }

    /**
     * Post
     *
     * @var integer|object $post Posts ID/object.
     *
     * @since 0.1.0
     * @access public
     *
     * @return GrottoPress\WordPress\Post\Post Post.
     */
    public function post( int $post = 0 ): Post {
        return new Post( $post );
    }
}
