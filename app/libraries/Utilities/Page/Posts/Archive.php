<?php

/**
 * Archive Posts
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
 * Archive Posts
 *
 * @since 0.1.0
 */
final class Archive extends AbstractPosts
{
    /**
     * Archives Posts Args
     *
     * @since 0.1.0
     * @access protected
     *
     * @return array Archives posts args.
     */
    protected function args(): array
    {
        $args = [
            // 'tag' => $this->posts->themeMod('wrap_tag')->get(),
            'class' => $this->posts->themeMod('wrap_class')->get(),
            'id' => $this->posts->id,
            'layout' => $this->posts->themeMod('layout')->get(),
            'text_offset' => $this->posts->themeMod('text_offset')->get(),
            'image' => [
                'size' => $this->posts->themeMod('image')->get(),
                'align' => $this->posts->themeMod('image_alignment')->get(),
            ],
            'excerpt' => [
                'length' => $this->posts->themeMod('excerpt')->get(),
                'paginate' => false,
                'more_text' => $this->posts->themeMod('more_text')->get(),
                'after' => [
                    'types' => \explode(
                        ',',
                        $this->posts->themeMod('after_content')->get()
                    ),
                    'separator' => $this->posts->themeMod('after_content_separator')->get(),
                ],
            ],
            'pagination' => [
                // 'type' => $this->posts->themeMod('pagination')->get(),
                // 'max' => $this->posts->themeMod('pagination_maximum')->get(),
                'position' => \explode(
                    ',',
                    $this->posts->themeMod('pagination_position')->get()
                ),
                'prev_text' => $this->posts->themeMod(
                    'pagination_previous_text'
                )->get(),
                'next_text' => $this->posts->themeMod(
                    'pagination_next_text'
                )->get(),
            ],
            'title' => [
                'length' => $this->posts->themeMod('title_words')->get(),
                'position' => $this->posts->themeMod('title_position')->get(),
                'tag' => 'h2',
                'link' => true,
                'before' => [
                    'types' => \explode(
                        ',',
                        $this->posts->themeMod('before_title')->get()
                    ),
                    'separator' => $this->posts->themeMod('before_title_separator')->get(),
                ],
                'after' => [
                    'types' => \explode(
                        ',',
                        $this->posts->themeMod('after_title')->get()
                    ),
                    'separator' => $this->posts->themeMod('after_title_separator')->get(),
                ],
            ],
            'wp_query' => [
                'posts_per_page' => $this->posts->themeMod('number')->get(),
                's' => \get_search_query(),
                'post__not_in' => (
                    $this->posts->sticky->isSet()
                        ? $this->posts->sticky->get() : null
                ),
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
            ],
        ];

        if (($post_type = \get_query_var('post_type'))
            || $this->posts->page->is('home')
            || $this->posts->page->is('post_type_archive')
        ) {
            $args['wp_query']['post_type'] = $post_type;
        } else {
            $args['wp_query']['post_type'] = \array_keys(
                $this->postTypes()
            );
        }

        if (($taxonomy = \get_query_var('taxonomy'))) {
            $args['wp_query']['tax_query'] = [
                [
                    'taxonomy' => $taxonomy,
                    'terms' => \get_query_var('term'),
                    'field' => 'slug',
                ],
            ];
        }

        if (\get_query_var('year') || \get_query_var('monthnum') || \get_query_var('day')) {
            $args['wp_query']['date_query'] = [
                [
                    'year' => \get_query_var('year'),
                    'month' => \get_query_var('monthnum'),
                    'day' => \get_query_var('day'),
                ],
            ];
        }

        if (($cat = \get_query_var('cat'))) {
            $args['wp_query']['cat'] = $cat;
        }

        if (($cat_in = \get_query_var('category__in'))) {
            $args['wp_query']['category__in'] = $cat_in;
        }

        if (($cat_not_in = \get_query_var('category__not_in'))) {
            $args['wp_query']['category__not_in']   = $cat_not_in;
        }

        if (($cat_and = \get_query_var('category__and'))) {
            $args['wp_query']['category__and']  = $cat_and;
        }

        if (($tag_id = \get_query_var('tag_id'))) {
            $args['wp_query']['tag_id'] = $tag_id;
        }

        if (($tag_in = \get_query_var('tag__in'))) {
            $args['wp_query']['tag__in']    = $tag_in;
        }

        if (($tag_not_in = \get_query_var('tag__not_in'))) {
            $args['wp_query']['tag__not_in']    = $tag_not_in;
        }

        if (($tag_and = \get_query_var('tag__and'))) {
            $args['wp_query']['tag__and']   = $tag_and;
        }

        if (($author_id = \get_query_var('author'))) {
            $args['wp_query']['author'] = $author_id;
        }

        if (($author_in = \get_query_var('author__in'))) {
            $args['wp_query']['author__in'] = $author_in;
        }

        if (($author_not_in = \get_query_var('author__not_in'))) {
            $args['wp_query']['author__not_in'] = $author_not_in;
        }

        return $args;
    }

    /**
     * Archive Post types
     *
     * @since 0.1.0
     * @access public
     *
     * @return \WP_Post_Type[] Public post types with archive.
     */
    public function postTypes(): array
    {
        $archive_post_types = [];

        if (!($post_types = $this->posts->postTypes())) {
            return $archive_post_types;
        }

        foreach ($post_types as $post_type) {
            if (!\get_post_type_archive_link($post_type->name)) {
                continue;
            }

            $archive_post_types[$post_type->name] = $post_type;
        }

        return $archive_post_types;
    }

    /**
     * Are we on a paged archive
     *
     * @since 0.6.0
     * @access public
     *
     * @return bool
     */
    public function isPaged(): bool
    {
        $key = $this->posts()->pagination->key;

        return (isset($_GET[$key]) && \absint($_GET[$key]) > 1);
    }
}
