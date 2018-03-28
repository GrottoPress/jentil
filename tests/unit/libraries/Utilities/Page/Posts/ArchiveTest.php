<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page\Posts;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use tad\FunctionMocker\FunctionMocker;

class ArchiveTest extends AbstractTestCase
{
    /**
     * @dataProvider postTypesProvider
     */
    public function testPostTypes(
        array $post_types,
        array $expected
    ) {
        \array_walk($post_types, function (&$v, $k) {
            $v = \json_decode(\json_encode($v));
        });

        \array_walk($expected, function (&$v, $k) {
            $v = \json_decode(\json_encode($v));
        });

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
        return [
            'post types empty' => [[], []],
            'post types set' => [
                [
                    'post' => [
                        'name' => 'post',
                        'link' => 'http://my.site/blog'
                    ],
                    'tutorial' => [
                        'name' => 'tutorial',
                        'link' => 'http://my.site/tutorials'
                    ],
                    'page' => ['name' => 'page', 'link' => ''],
                ],
                [
                    'post' => [
                        'name' => 'post',
                        'link' => 'http://my.site/blog'
                    ],
                    'tutorial' => [
                        'name' => 'tutorial',
                        'link' => 'http://my.site/tutorials'
                    ],
                ],
            ],
        ];
    }
}
