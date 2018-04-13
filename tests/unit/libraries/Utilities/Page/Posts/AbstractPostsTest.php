<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page\Posts;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\Utilities\Page\Page;
use GrottoPress\WordPress\Posts\Posts as PostsPackage;
use tad\FunctionMocker\FunctionMocker;

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
