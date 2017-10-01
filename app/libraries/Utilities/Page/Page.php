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
     * Title
     *
     * @since 0.1.0
     * @access private
     *
     * @var string $title Page title.
     */
    private $title = null;

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
     * Type
     *
     * @since 0.1.0
     * @access private
     *
     * @var array $type Page type.
     */
    private $type = null;

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
     * Get utilities
     *
     * @since 0.1.0
     * @access public
     *
     * @return Utilities Utilities.
     */
    public function utilities(): Utilities
    {
        return $this->utilities;
    }

    /**
     * Get title
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
     * Get layout
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
     * Get layouts
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
     * Get posts
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

    /**
     * Get type
     *
     * Page type is used too many times on archives
     * for getting posts mods, so let's make sure method
     * is called only once per page cycle.
     *
     * @since 0.1.0
     * @access public
     *
     * @return array
     */
    public function type(): array
    {
        if (null === $this->type) {
            $this->type = parent::type();
        }

        return $this->type;
    }
}
