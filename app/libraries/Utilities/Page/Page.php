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
use GrottoPress\Getter\Getter;

/**
 * Page
 *
 * @since 0.1.0
 */
class Page extends PagePackage
{
    use Getter;
    
    /**
     * Utilities
     *
     * @since 0.1.0
     * @access protected
     *
     * @var Utilities $utilities Utilities.
     */
    protected $utilities;
    
    /**
     * Layout
     *
     * @since 0.1.0
     * @access protected
     *
     * @var Layout $layout Layout.
     */
    protected $layout = null;

    /**
     * Layouts
     *
     * @since 0.1.0
     * @access protected
     *
     * @var Layouts $layouts Layouts.
     */
    protected $layouts = null;

    /**
     * Title
     *
     * @since 0.1.0
     * @access protected
     *
     * @var string $title Page title.
     */
    protected $title = null;

    /**
     * Posts
     *
     * @since 0.1.0
     * @access protected
     *
     * @var Posts $posts Page posts.
     */
    protected $posts = null;

    /**
     * Type
     *
     * @since 0.1.0
     * @access protected
     *
     * @var array $type Page type.
     */
    protected $type = null;

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
     * @access protected
     *
     * @return Utilities Utilities.
     */
    protected function getUtilities(): Utilities
    {
        return $this->utilities;
    }

    /**
     * Get title
     *
     * @since 0.1.0
     * @access protected
     *
     * @return Title Title.
     */
    protected function getTitle(): Title
    {
        if (null === $this->title) {
            $this->title = new Title($this);
        }

        return $this->title;
    }

    /**
     * Get layout
     *
     * @since 0.1.0
     * @access protected
     *
     * @return Layout Layout.
     */
    protected function getLayout(): Layout
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
     * @access protected
     *
     * @return Layouts Layouts.
     */
    protected function getLayouts(): Layouts
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
     * @access protected
     *
     * @return Posts Posts.
     */
    protected function getPosts(): Posts\Posts
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
     * @access protected
     *
     * @return array
     */
    protected function getType(): array
    {
        if (null === $this->type) {
            $this->type = parent::type();
        }

        return $this->type;
    }
}
