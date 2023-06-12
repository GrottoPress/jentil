<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page\Posts;

use GrottoPress\Jentil\Utilities\Page\Posts;
use GrottoPress\Jentil\Utilities;
use GrottoPress\Jentil\Utilities\Page;
use GrottoPress\WordPress\Posts as PostsPackage;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;

class AbstractPostsTest extends AbstractTestCase
{
    public function testPosts()
    {
        $posts = Stub::makeEmpty(Posts::class);
        $posts->page = Stub::makeEmpty(Page::class);
        $posts->page->utilities = Stub::makeEmpty(Utilities::class, [
            'posts' => function (array $args): PostsPackage {
                return Stub::makeEmpty(PostsPackage::class, [
                    'render' => \json_encode($args),
                ]);
            },
        ]);

        $args = ['a' => 'b', 'c' => 'd'];

        $posts = Stub::construct(AbstractPosts::class, [$posts], [
            'args' => $args,
        ]);

        $this->assertSame(\json_encode($args), $posts->posts()->render());
    }
}
