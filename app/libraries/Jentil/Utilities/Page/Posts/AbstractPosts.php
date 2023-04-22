<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page\Posts;

use GrottoPress\Jentil\Utilities\Page\Posts;
use GrottoPress\WordPress\Posts as PostsPackage;

abstract class AbstractPosts
{
    /**
     * @var Posts
     */
    protected $posts;

    /**
     * @var string
     */
    protected $id = 'main-query';

    public function __construct(Posts $posts)
    {
        $this->posts = $posts;
    }

    public function posts(): PostsPackage
    {
        return $this->posts->page->utilities->posts($this->args());
    }

    /**
     * @return array<string, mixed>
     */
    abstract protected function args(): array;
}
