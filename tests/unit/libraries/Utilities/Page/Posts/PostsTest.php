<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page\Posts;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use GrottoPress\Jentil\Utilities\Page\Page;
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

    /**
     * @dataProvider isPagelikeProvider
     */
    public function testIsPagelike(
        string $post_type,
        int $post_id,
        int $page_for_posts,
        string $show_on_front,
        array $post_types,
        bool $expected
    ) {
        FunctionMocker::replace('is_post_type_hierarchical', function (
            string $type
        ) use ($post_types): bool {
            return !empty($post_types[$type]['h']);
        });

        FunctionMocker::replace('get_post_type_archive_link', function (
            string $type
        ) use ($post_types): bool {
            return !empty($post_types[$type]['link']);
        });

        FunctionMocker::replace('get_option', function (string $id) use (
            $page_for_posts,
            $show_on_front
        ) {
            return ${$id};
        });

        FunctionMocker::replace('post_type_exists', function (
            string $post_type
        ) use ($post_types): bool {
            return \array_key_exists($post_type, $post_types);
        });

        $posts = new Posts(Stub::makeEmpty(Page::class));

        $this->assertSame($expected, $posts->isPagelike($post_type, $post_id));
    }

    public function testImageSizes()
    {
        FunctionMocker::replace('wp_get_additional_image_sizes', [
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

    public function isPagelikeProvider(): array
    {
        return [
            'post type is non-hierarchical, has archive' => [
                'post',
                4,
                222,
                'posts',
                [
                    'post' => ['h' => false, 'link' => true],
                    'page' => ['h' => true, 'link' => false]
                ],
                false,
            ],
            'post type is non-hierarchical, no archive' => [
                'post',
                4,
                222,
                'posts',
                [
                    'post' => ['h' => false, 'link' => false],
                    'page' => ['h' => true, 'link' => false]
                ],
                false,
            ],
            'post type is hierarchical, is front page, no archive' => [
                'page',
                123,
                123,
                'page',
                [
                    'post' => ['h' => false, 'link' => true],
                    'page' => ['h' => true, 'link' => false]
                ],
                false,
            ],
            'post type is hierarchical, not front page, no archive' => [
                'page',
                123,
                111,
                'page',
                [
                    'post' => ['h' => false, 'link' => true],
                    'page' => ['h' => true, 'link' => false]
                ],
                true,
            ],
            'post type is hierarchical, has archive' => [
                'page',
                123,
                111,
                'page',
                [
                    'post' => ['h' => false, 'link' => true],
                    'page' => ['h' => true, 'link' => true]
                ],
                false,
            ],
            'post type arg not set' => [
                '',
                4,
                111,
                'posts',
                [
                    'post' => ['h' => false, 'link' => true],
                    'page' => ['h' => true, 'link' => false]
                ],
                false,
            ],
            'post type arg non-existent' => [
                'book',
                111,
                123,
                'posts',
                [
                    'post' => ['h' => false, 'link' => true],
                    'page' => ['h' => true, 'link' => false]
                ],
                false,
            ],
            'post id not set' => [
                'page',
                0,
                111,
                'page',
                [
                    'post' => ['h' => false, 'link' => true],
                    'page' => ['h' => true, 'link' => false]
                ],
                true,
            ],
        ];
    }
}
