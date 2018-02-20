<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Utilities\Page\Posts;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\TestCase;
use GrottoPress\Jentil\Utilities\Page\Posts\Posts;
use GrottoPress\Jentil\Utilities\Page\Posts\Archive;
use tad\FunctionMocker\FunctionMocker;

class ArchiveTest extends TestCase
{
    /**
     * @dataProvider postTypesProvider
     */
    public function testPostTypes(
        array $postTypes,
        array $expected
    ) {
        \array_walk($postTypes, function (&$v, $k) {
            $v = \json_decode(\json_encode($v));
        });

        \array_walk($expected, function (&$v, $k) {
            $v = \json_decode(\json_encode($v));
        });

        $posts = Stub::makeEmpty(Posts::class, ['postTypes' => $postTypes]);

        FunctionMocker::replace(
            'get_post_type_archive_link',
            function (
                string $postType
            ) use ($postTypes): string {
                return $postTypes[$postType]->link;
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
