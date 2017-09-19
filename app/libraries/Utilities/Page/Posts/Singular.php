<?php

/**
 * Singular Posts
 *
 * @package GrottoPress\Jentil\Utilities\Page\Posts
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page\Posts;

/**
 * Singular Posts
 *
 * @since 0.1.0
 */
final class Singular
{
    /**
     * Posts
     *
     * @since 0.1.0
     * @access private
     *
     * @var Posts $posts Posts.
     */
    private $posts;
    
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
     * Singular posts args.
     *
     * @since 0.1.0
     * @access public
     *
     * @return array Singular posts args.
     */
    public function args(): array
    {
        global $post;

        return [
            'layout' => 'stack',
            'id' => 'main-query',
            'class' => 'singular-post',
            'excerpt' => [
                'length' => -2,
                'paginate' => true,
                'more_text' => '',
            ],
            'title' => [
                'length' => -1,
                'position' => 'top',
                'tag' => 'h1',
                'link' => false,
                'after' => [
                    'types' => ['jentil_singular_after_title'],
                ],
            ],
            'wp_query' => [
                'posts_per_page' => 1,
                'post_type' => $post->post_type,
                'p' => $post->ID,
                'ignore_sticky_posts' => 1,
            ],
        ];
    }
}
