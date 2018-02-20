<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Utilities\Page\Posts;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\AbstractTestCase;
use GrottoPress\Jentil\Utilities\ThemeMods\Posts as StickyMod;
use GrottoPress\Jentil\Utilities\Page\Posts\Posts;
use GrottoPress\Jentil\Utilities\Page\Posts\Sticky;
use tad\FunctionMocker\FunctionMocker;

class StickyTest extends AbstractTestCase
{
    /**
     * @dataProvider getProvider
     */
    public function testGet(
        array $stickyPosts,
        string $postType,
        array $expected
    ) {
        FunctionMocker::replace('get_option', \array_keys($stickyPosts));
        FunctionMocker::replace('get_post_type', function (int $post) use (
            $stickyPosts
        ): string {
            return $stickyPosts[$post];
        });

        $sticky = new Sticky(Stub::makeEmpty(Posts::class));

        $this->assertSame($expected, $sticky->get($postType));
    }

    public function getProvider(): array
    {
        return [
            'post type arg not set' => [[
                1 => 'post',
                2 => 'post',
                3 => 'tutorial',
                4 => 'tutorial',
                5 => 'page',
            ], '', [1, 2, 3, 4, 5]],
            'sticky posts empty' => [[], 'post', []],
            'post type arg set, valid' => [[
                1 => 'post',
                2 => 'post',
                3 => 'tutorial',
                4 => 'tutorial',
                5 => 'page',
            ], 'tutorial', [3 , 4]],
            'post type arg set, invalid' => [[
                1 => 'post',
                2 => 'post',
                3 => 'tutorial',
                4 => 'tutorial',
                5 => 'page',
            ], 'book', []],
        ];
    }
}
