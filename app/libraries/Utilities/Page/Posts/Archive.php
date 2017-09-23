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
     * @access public
     *
     * @return array Archives posts args.
     */
    public function args(): array
    {
        global $wp_rewrite;

        $args = [
            // 'tag' => $this->posts->mod('wrap_tag'),
            'class' => $this->posts->mod('wrap_class'),
            'id' => 'main-query',
            'layout' => $this->posts->mod('layout'),
            'text_offset' => $this->posts->mod('text_offset'),
            'image' => [
                'size' => $this->posts->mod('image'),
                'align' => $this->posts->mod('image_alignment'),
            ],
            'excerpt' => [
                'length' => $this->posts->mod('excerpt'),
                'paginate' => false,
                'more_text' => $this->posts->mod('more_text'),
                'after' => [
                    'types' => \explode(',', $this->posts->mod('after_content')),
                    'separator' => $this->posts->mod('after_content_separator'),
                ],
            ],
            'pagination' => [
                // 'type' => $this->posts->mod('pagination'),
                // 'max' => $this->posts->mod('pagination_maximum'),
                'key' => $wp_rewrite->pagination_base,
                'position' => \explode(',', $this->posts->mod('pagination_position')),
                'prev_text' => $this->posts->mod('pagination_previous_label'),
                'next_text' => $this->posts->mod('pagination_next_label'),
            ],
            'title' => [
                'length' => $this->posts->mod('title_words'),
                'position' => $this->posts->mod('title_position'),
                'tag' => 'h2',
                'link' => true,
                'before' => [
                    'types' => \explode(',', $this->posts->mod('before_title')),
                    'separator' => $this->posts->mod('before_title_separator'),
                ],
                'after' => [
                    'types' => \explode(',', $this->posts->mod('after_title')),
                    'separator' => $this->posts->mod('after_title_separator'),
                ],
            ],
            'wp_query' => [
                'posts_per_page' => $this->posts->mod('number'),
                's' => \get_search_query(),
                'post__not_in' => (
                    $this->posts->sticky()->isSet()
                        ? $this->posts->sticky()->get() : null
                ),
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
            ],
        ];

        if (($post_type = \get_query_var('post_type'))
            || $this->posts->page()->is('home')
            || $this->posts->page()->is('post_type_archive')
        ) {
            $args['wp_query']['post_type'] = $post_type;
        } else {
            $args['wp_query']['post_type'] = \array_keys(
                $this->archivePostTypes()
            );
        }

        if ($this->posts->page()->is('search')) {
            // $args['wp_query']['orderby']['all_time_views'] = 'DESC';
            $args['wp_query']['orderby']['comment_count'] = 'DESC';
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
     * @return array Public post types with archive.
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
}
