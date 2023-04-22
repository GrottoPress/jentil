<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page\Posts;

use GrottoPress\Jentil\Utilities\ThemeMods\Posts as PostsMod;

class Sticky extends AbstractPosts
{
    /**
     * @return array<string, mixed>
     */
    public function args(): array
    {
        $args = [
            // 'tag' => $this->themeMod('wrap_tag')->get(),
            'class' => $this->themeMod('wrap_class')->get(),
            'id' => "{$this->id}-sticky-posts",
            'layout' => $this->themeMod('layout')->get(),
            'text_offset' => $this->themeMod('text_offset')->get(),
            'image' => [
                'size' => $this->themeMod('image')->get(),
                'align' => $this->themeMod('image_alignment')->get(),
                'margin' => $this->themeMod('image_margin')->get(),
            ],
            'excerpt' => [
                'length' => $this->themeMod('excerpt')->get(),
                'paginate' => false,
                'more_text' => $this->themeMod('more_text')->get(),
                'after' => [
                    'types' => \explode(
                        ',',
                        $this->themeMod('after_content')->get()
                    ),
                    'separator' => $this->themeMod('after_content_separator')->get(),
                ],
            ],
            'title' => [
                'length' => $this->themeMod('title_words')->get(),
                'position' => $this->themeMod('title_position')->get(),
                'tag' => 'h2',
                'link' => true,
                'before' => [
                    'types' => \explode(',', $this->themeMod('before_title')->get()),
                    'separator' => $this->themeMod('before_title_separator')->get(),
                ],
                'after' => [
                    'types' => \explode(',', $this->themeMod('after_title')->get()),
                    'separator' => $this->themeMod('after_title_separator')->get(),
                ],
            ],
            'wp_query' => [
                'posts_per_page' => \count($this->get()),
                'post__in' => $this->get(),
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
                'no_found_rows' => true,
            ],
        ];

        $args['wp_query']['post_type'] = \get_query_var('post_type');

        if ($taxonomy = \get_query_var('taxonomy')) {
            $args['wp_query']['tax_query'] = [
                [
                    'taxonomy' => $taxonomy,
                    'terms' => \get_query_var('term_id'),
                    'field' => 'term_id',
                ],
            ];
        }

        if (\get_query_var('year') ||
            \get_query_var('monthnum') ||
            \get_query_var('day')
        ) {
            $args['wp_query']['date_query'] = [
                [
                    'year' => \get_query_var('year'),
                    'month' => \get_query_var('monthnum'),
                    'day' => \get_query_var('day'),
                ],
            ];
        }

        if ($cat = \get_query_var('cat')) {
            $args['wp_query']['cat'] = $cat;
        }

        if ($cat_in = \get_query_var('category__in')) {
            $args['wp_query']['category__in'] = $cat_in;
        }

        if ($cat_not_in = \get_query_var('category__not_in')) {
            $args['wp_query']['category__not_in'] = $cat_not_in;
        }

        if ($cat_and = \get_query_var('category__and')) {
            $args['wp_query']['category__and'] = $cat_and;
        }

        if ($tag_id = \get_query_var('tag_id')) {
            $args['wp_query']['tag_id'] = $tag_id;
        }

        if ($tag_in = \get_query_var('tag__in')) {
            $args['wp_query']['tag__in'] = $tag_in;
        }

        if ($tag_not_in = \get_query_var('tag__not_in')) {
            $args['wp_query']['tag__not_in'] = $tag_not_in;
        }

        if ($tag_and = \get_query_var('tag__and')) {
            $args['wp_query']['tag__and'] = $tag_and;
        }

        if ($author_id = \get_query_var('author')) {
            $args['wp_query']['author'] = $author_id;
        }

        if ($author_in = \get_query_var('author__in')) {
            $args['wp_query']['author__in'] = $author_in;
        }

        if ($author_not_in = \get_query_var('author__not_in')) {
            $args['wp_query']['author__not_in'] = $author_not_in;
        }

        return $args;
    }

    /**
     * @return int[]
     */
    public function get(string $post_type = ''): array
    {
        $sticky_posts = \get_option('sticky_posts');

        if (!$sticky_posts || !$post_type) {
            return $sticky_posts;
        }

        return \array_filter(
            $sticky_posts,
            function (int $post) use ($post_type) {
                return \get_post_type($post) === $post_type;
            }
        );
    }

    /**
     * Sticky posts enabled?
     */
    public function isSet(): bool
    {
        return (bool)$this->posts->themeMod('sticky_posts')->get();
    }

    public function themeMod(string $setting): PostsMod
    {
        $args = [
            'context' => 'sticky',
            'specific' => $this->posts->archive->postType(),
        ];

        if (\is_array($args['specific'])) {
            $args['specific'] = $args['specific'][0];
        }

        return $this->posts->themeMod($setting, $args);
    }
}
