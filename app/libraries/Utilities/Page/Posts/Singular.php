<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page\Posts;

class Singular extends AbstractPosts
{
    /**
     * @return mixed[string]
     */
    public function args(): array
    {
        return [
            'layout' => 'stack',
            'id' => $this->id,
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
