<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page;

use GrottoPress\Jentil\Utilities\Page;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class PostsTest extends AbstractTestCase
{
    /**
     * @dataProvider renderProvider
     */
    public function testRender(
        string $page,
        bool $is_paged,
        bool $sticky_set,
        array $sticky_posts,
        string $expected
    ) {
        $this->markTestSkipped();

        $posts = Stub::make(Posts::class);

        $posts->page = Stub::makeEmpty(Page::class, [
            'is' => function (string $type) use ($page): bool {
                return ($page === $type);
            }
        ]);

        $posts->singular = Stub::makeEmpty(Singular::class, [
            'posts' => Stub::makeEmpty(Posts::class, ['render' => 'singular']),
        ]);

        $posts->archive = Stub::makeEmpty(Archive::class, [
            'isPaged' => $is_paged,
            'posts' => Stub::makeEmpty(Posts::class, ['render' => 'archive']),
        ]);

        $posts->sticky = Stub::makeEmpty(Sticky::class, [
            'isSet' => $sticky_set,
            'get' => $sticky_posts,
            'posts' => Stub::makeEmpty(Posts::class, ['render' => 'sticky']),
        ]);

        $this->assertSame($expected, $posts->render());
    }

    public function testPostTypes()
    {
        FunctionMocker::replace('get_post_types', function (
            array $args,
            string $type
        ): array {
            return [$args, $type];
        });

        $posts = new Posts(Stub::makeEmpty(Page::class));

        $this->assertSame([['public' => true], 'objects'], $posts->postTypes());
    }

    public function testTaxonomies()
    {
        FunctionMocker::replace('get_taxonomies', function (
            array $args,
            string $type
        ): array {
            return [$args, $type];
        });

        $posts = new Posts(Stub::makeEmpty(Page::class));

        $this->assertSame(
            [['public' => true], 'objects'],
            $posts->taxonomies()
        );
    }

    public function testImageSizes()
    {
        FunctionMocker::replace('wp_get_registered_image_subsizes', [
            'mini-thumb' => [
                'width' => 100,
                'height' => 100,
            ],
            'micro-thumb' => [
                'width' => 75,
                'height' => 75,
            ]
        ]);

        $posts = new Posts(Stub::makeEmpty(Page::class));

        $this->assertSame(
            [
                'mini-thumb' => 'mini-thumb (100 x 100)',
                'micro-thumb' => 'micro-thumb (75 x 75)'
            ],
            $posts->imageSizes()
        );
    }

    public function renderProvider()
    {
        return [
            'page is singular' => ['singular', false, false, [], 'singular'],
        ];
    }
}
