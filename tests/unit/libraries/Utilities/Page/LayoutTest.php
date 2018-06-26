<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use GrottoPress\Jentil\Utilities\ThemeMods\Layout as LayoutMod;
use tad\FunctionMocker\FunctionMocker;

class LayoutTest extends AbstractTestCase
{
    /**
     * @dataProvider columnProvider
     */
    public function testColumn(string $theme_mod, string $expected)
    {
        FunctionMocker::replace('sanitize_title', function (
            string $text
        ): string {
            return $text;
        });

        $page = Stub::makeEmpty(Page::class);
        $page->layouts = Stub::makeEmpty(Layouts::class, [
            'get' => [
                'l-3-c' => [
                    'c-s-s' => 'CSS',
                    's-s-c' => 'SSC',
                    's-c-s' => 'SCS',
                ],
                'l-2-c' => ['c-s' => 'CS', 's-c' => 'SC'],
                'l-1-c' => ['c' => 'C'],
            ],
        ]);

        $layout = Stub::construct(Layout::class, [$page], [
            'themeMod' => Stub::makeEmpty(LayoutMod::class, [
                'get' => $theme_mod,
            ]),
        ]);

        $this->assertSame($expected, $layout->column());
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

        $layout = new Layout(Stub::makeEmpty(Page::class));

        $this->assertSame($expected, $layout->isPagelike($post_type, $post_id));
    }

    public function columnProvider(): array
    {
        return [
            'content-sidebar-sidebar' => [
                'c-s-s',
                'l-3-c',
            ],
            'sidebar-sidebar-content' => [
                's-s-c',
                'l-3-c',
            ],
            'sidebar-content-sidebar' => [
                's-c-s',
                'l-3-c',
            ],
            'content-sidebar' => [
                'c-s',
                'l-2-c',
            ],
            'sidebar-content' => [
                's-c',
                'l-2-c',
            ],
            'content' => [
                'c',
                'l-1-c',
            ],
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
