<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page\Posts;

use GrottoPress\Jentil\Utilities\ThemeMods\Posts as PostsMod;

class Singular extends AbstractPosts
{
    /**
     * @return array<string, mixed>
     */
    public function args(): array
    {
        return [
            'layout' => 'stack',
            'id' => $this->id,
            'class' => 'singular-post big',
            'excerpt' => [
                'length' => -2,
                'paginate' => true,
                'more_text' => '',
                // 'after' => [ // already added via @action jentil_after_content
                //     'types' => \explode(
                //         ',',
                //         $this->themeMod('after_content')->get()
                //     ),
                //     'separator' => $this->themeMod('after_content_separator')->get(),
                // ]
            ],
            'title' => [
                'length' => -1,
                'position' => 'top',
                'tag' => 'h1',
                'link' => false,
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
                'posts_per_page' => 1,
                'post_type' => \get_post()->post_type,
                'p' => \get_post()->ID,
                'ignore_sticky_posts' => 1,
            ],
        ];
    }

    public function themeMod(string $setting): PostsMod
    {
        $args = [
            'context' => 'singular',
            'specific' => \get_post()->post_type,
        ];

        return $this->posts->themeMod($setting, $args);
    }
}
