<?php

/**
 * Related Posts
 *
 * @package GrottoPress\Jentil\Utilities\Page\Posts
 * @since 0.6.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page\Posts;

use GrottoPress\Jentil\Utilities\ThemeMods\Posts as PostsMod;

/**
 * Related Posts
 *
 * @since 0.6.0
 */
class Related extends AbstractPosts
{
    /**
     * Related Posts Args
     *
     * @since 0.6.0
     * @access public
     *
     * @return array
     */
    public function args(): array
    {
        $args = [
            // 'tag' => $this->themeMod('wrap_tag')->get(),
            'class' => $this->themeMod('wrap_class')->get(),
            'id' => 'related-posts',
            'layout' => $this->themeMod('layout')->get(),
            'text_offset' => $this->themeMod('text_offset')->get(),
            'related_to' => \get_post()->ID,
            'image' => [
                'size' => $this->themeMod('image')->get(),
                'align' => $this->themeMod('image_alignment')->get(),
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
                'tag' => 'h4',
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
                'posts_per_page' => $this->themeMod('number')->get(),
                'post_status' => 'publish',
                'orderby' => ['comment_count' => 'DESC', 'rand' => 'DESC'],
                'ignore_sticky_posts' => 1,
                'no_found_rows' => true,
            ],
        ];

        return $args;
    }

    /**
     * Related posts mod
     *
     * @param string $setting
     *
     * @since 0.6.0
     * @access public
     *
     * @return mixed Related posts mod.
     */
    public function themeMod(string $setting): PostsMod
    {
        $args = [
            'context' => 'related',
            'specific' => \get_post()->post_type,
        ];

        return $this->posts->themeMod($setting, $args);
    }
}
