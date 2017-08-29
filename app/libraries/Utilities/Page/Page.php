<?php

/**
 * Page
 *
 * @package GrottoPress\Jentil\Utilities\Page
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Utilities\Page;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\WordPress\Page\Page as WPage;

/**
 * Page
 *
 * @since 0.1.0
 */
final class Page extends WPage {
    /**
     * Utilities
     *
     * @since 0.1.0
     * @access private
     * 
     * @var GrottoPress\Jentil\Utilites\Utilities $utilities Utilities.
     */
    private $utilities;

    /**
     * Title
     *
     * @since 0.1.0
     * @access protected
     * 
     * @var GrottoPress\Jentil\Utilities\Page\Title $title Title.
     */
    protected $title = null;
    
    /**
     * Layout
     *
     * @since 0.1.0
     * @access private
     * 
     * @var GrottoPress\Jentil\Utilities\Page\Layout $layout Layout.
     */
    private $layout = null;

    /**
     * Posts
     *
     * @since 0.1.0
     * @access private
     * 
     * @var GrottoPress\Jentil\Utilities\Page\Posts $posts Page posts.
     */
    private $posts = null;

    /**
     * Constructor
     * 
     * @param GrottoPress\Jentil\Utilities\Utilities $utilities Utilities.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct( Utilities $utilities ) {
        $this->utilities = $utilities;
    }

    /**
     * Utilities
     * 
     * @since 0.1.0
     * @access public
     * 
     * @return GrottoPress\Jentil\Utilities\Utilities Utilities.
     */
    public function utilities(): Utilities {
        return $this->utilities;
    }

    /**
     * Title
     * 
     * @since 0.1.0
     * @access public
     * 
     * @return GrottoPress\Jentil\Utilities\Page\Title Title.
     */
    public function title(): string {
        if ( null === $this->title ) {
            $this->title = new Title( $this );
        }

        return $this->title->mod();
    }

    /**
     * Layout
     * 
     * @since 0.1.0
     * @access public
     * 
     * @return GrottoPress\Jentil\Utilities\Page\Layout Layout.
     */
    public function layout(): Layout {
        if ( null === $this->layout ) {
            $this->layout = new Layout( $this );
        }

        return $this->layout;
    }

    /**
     * Posts
     * 
     * @since 0.1.0
     * @access public
     * 
     * @return GrottoPress\Jentil\Utilities\Page\Posts Posts.
     */
    public function posts(): Posts {
        if ( null === $this->posts ) {
            $this->posts = new Posts( $this );
        }

        return $this->posts;
    }
}
