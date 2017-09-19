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

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page;

use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\WordPress\Page\Page as PagePackage;

/**
 * Page
 *
 * @since 0.1.0
 */
final class Page extends PagePackage
{
    /**
     * Utilities
     *
     * @since 0.1.0
     * @access private
     *
     * @var Utilities $utilities Utilities.
     */
    private $utilities;

    /**
     * Title
     *
     * @since 0.1.0
     * @access protected
     *
     * @var Title $title Title.
     */
    protected $title = null;
    
    /**
     * Layout
     *
     * @since 0.1.0
     * @access private
     *
     * @var Layout $layout Layout.
     */
    private $layout = null;

    /**
     * Layouts
     *
     * @since 0.1.0
     * @access private
     *
     * @var Layouts $layouts Layouts.
     */
    private $layouts = null;

    /**
     * Posts
     *
     * @since 0.1.0
     * @access private
     *
     * @var Posts $posts Page posts.
     */
    private $posts = null;

    /**
     * Constructor
     *
     * @param Utilities $utilities Utilities.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Utilities $utilities)
    {
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
    public function utilities(): Utilities
    {
        return $this->utilities;
    }

    /**
     * Title
     *
     * @since 0.1.0
     * @access public
     *
     * @return Title Title.
     */
    public function title(): string
    {
        if (null === $this->title) {
            $this->title = new Title($this);
        }

        return $this->title->mod();
    }

    /**
     * Layout
     *
     * @since 0.1.0
     * @access public
     *
     * @return Layout Layout.
     */
    public function layout(): Layout
    {
        if (null === $this->layout) {
            $this->layout = new Layout($this);
        }

        return $this->layout;
    }

    /**
     * Layouts
     *
     * @since 0.1.0
     * @access public
     *
     * @return Layouts Layouts.
     */
    public function layouts(): Layouts
    {
        if (null === $this->layouts) {
             $this->layouts = new Layouts($this);
        }
 
        return $this->layouts;
    }

    /**
     * Posts
     *
     * @since 0.1.0
     * @access public
     *
     * @return Posts Posts.
     */
    public function posts(): Posts\Posts
    {
        if (null === $this->posts) {
            $this->posts = new Posts\Posts($this);
        }

        return $this->posts;
    }
}
