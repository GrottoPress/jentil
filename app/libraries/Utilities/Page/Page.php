<?php

/**
 * Page
 *
 * @package GrottoPress\Jentil\Utilities\Page
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page;

use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\WordPress\Page\Page as PagePackage;
use GrottoPress\Getter\GetterTrait;

/**
 * Page
 *
 * @since 0.1.0
 */
class Page extends PagePackage
{
    use GetterTrait;
    
    /**
     * Utilities
     *
     * @since 0.1.0
     * @access private
     *
     * @var Utilities
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
     * @var string[] $type Page type.
     */
    private $type = null;

    /**
     * Constructor
     *
     * @param Utilities $utilities
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
     * @access private
     *
     * @return Utilities Utilities.
     */
    private function getUtilities(): Utilities
    {
        return $this->utilities;
    }

    /**
     * Get title
     *
     * @since 0.1.0
     * @access private
     *
     * @return Title Title.
     */
    private function getTitle(): Title
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
     * @access private
     *
     * @return Layout Layout.
     */
    private function getLayout(): Layout
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
     * @access private
     *
     * @return Layouts Layouts.
     */
    private function getLayouts(): Layouts
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
     * @access private
     *
     * @return Posts Posts.
     */
    private function getPosts(): Posts\Posts
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
     * is called only once per page cycle, except, of course,
     * in the customizer.
     *
     * @since 0.1.0
     * @access private
     *
     * @return string[]
     */
    private function getType(): array
    {
        if (null === $this->type || $this->is('customize_preview')) {
            $this->type = parent::type();
        }

        return $this->type;
    }
}
