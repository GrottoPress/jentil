<?php

/**
 * Abstract Archive Posts
 *
 * @package GrottoPress\Jentil\Utilities\Page\Posts
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page\Posts;

use GrottoPress\WordPress\Posts\Posts as PostsPackage;

/**
 * Abstract Archive Posts
 *
 * @since 0.1.0
 */
abstract class AbstractPosts
{
    /**
     * Posts
     *
     * @since 0.1.0
     * @access protected
     *
     * @var Posts $posts Posts.
     */
    protected $posts;

    /**
     * Constructor
     *
     * @param Posts $posts Posts.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Posts $posts)
    {
        $this->posts = $posts;
    }

    /**
     * Get posts
     *
     * @since 0.6.0
     * @access public
     *
     * @return PostsPackage
     */
    public function posts(): PostsPackage
    {
        return $this->posts->page->utilities->posts(
            $this->args()
        );
    }

    /**
     * Posts Args
     *
     * @since 0.1.0
     * @access protected
     *
     * @return array Archives posts args.
     */
    abstract protected function args(): array;
}
