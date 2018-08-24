<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page\Posts;

use GrottoPress\Jentil\Utilities\Page\Posts;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class ArchiveTest extends AbstractTestCase
{
    /**
     * @dataProvider postTypesProvider
     */
    public function testPostTypes(array $post_types, array $expected)
    {
        $posts = Stub::makeEmpty(Posts::class, ['postTypes' => $post_types]);

        FunctionMocker::replace(
            'get_post_type_archive_link',
            function (
                string $post_type
            ) use ($post_types): string {
                return $post_types[$post_type]->link;
            }
        );

        $archive = new Archive($posts);

        $this->assertEquals($expected, $archive->postTypes());
    }

    public function postTypesProvider(): array
    {
        $this->getMockBuilder('WP_Post_Type')->getMock();

        $post = new class extends \WP_Post_Type {
            public $name = 'post';
            public $link = 'http://my.site/blog';
        };

        $page = new class extends \WP_Post_Type {
            public $name = 'page';
            public $link = '';
        };

        $tutorial = new class extends \WP_Post_Type {
            public $name = 'tutorial';
            public $link = 'http://my.site/tutorials';
        };

        return [
            'post types empty' => [[], []],
            'post types set' => [
                [
                    'post' => $post,
                    'tutorial' => $tutorial,
                    'page' => $page,
                ],
                [
                    'post' => $post,
                    'tutorial' => $tutorial,
                ],
            ],
        ];
    }
}
