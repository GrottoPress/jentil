<?php

/**
 * Singular Posts
 *
 * @package GrottoPress\Jentil\Utilities\Page\Posts
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page\Posts;

use WP_Post;

/**
 * Singular Posts
 *
 * @since 0.1.0
 */
class Singular extends AbstractPosts
{
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
        return [
            'layout' => 'stack',
            'id' => $this->posts->id,
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
                'post_type' => \get_post()->post_type,
                'p' => \get_post()->ID,
                'ignore_sticky_posts' => 1,
            ],
        ];
    }
}
