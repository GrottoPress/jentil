<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\ThemeMods;

use GrottoPress\Jentil\Utilities\ThemeMods;
use GrottoPress\Jentil\Utilities\Page;
use GrottoPress\Jentil\Utilities\Page\Layout as LayoutUtil;
use GrottoPress\Jentil\Utilities\Page\Layouts;
use GrottoPress\Jentil\Utilities;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class LayoutTest extends AbstractTestCase
{
    public function _before()
    {
        FunctionMocker::replace('wp_parse_args', function (
            array $args,
            array $default
        ): array {
            return $args;
        });

        FunctionMocker::replace('sanitize_key', function (string $key): string {
            return $key;
        });

        FunctionMocker::replace(
            'apply_filters',
            function (string $name, $value) {
                return $value;
            }
        );
    }

    /**
     * @dataProvider getIDProvider
     */
    public function testGetID(
        string $context,
        string $specific,
        int $more_specific,
        array $post_types,
        array $taxonomies,
        bool $is_pagelike,
        string $expected_name
    ) {
        FunctionMocker::replace('post_type_exists', function (
            string $post_type
        ) use ($post_types): bool {
            return \in_array($post_type, $post_types);
        });

        FunctionMocker::replace('taxonomy_exists', function (
            string $tax
        ) use ($taxonomies): bool {
            return \in_array($tax, $taxonomies);
        });

        $theme_mods = Stub::makeEmpty(ThemeMods::class);
        $theme_mods->utilities = Stub::makeEmpty(Utilities::class);
        $theme_mods->utilities->page = Stub::makeEmpty(Page::class);
        $theme_mods->utilities->page->layout = Stub::makeEmpty(Layout::class, [
            'isPagelike' => $is_pagelike,
        ]);

        $layout = new Layout($theme_mods, [
            'context' => $context,
            'specific' => $specific,
            'more_specific' => $more_specific,
        ]);

        $this->assertSame($expected_name, $layout->id);
    }

    /**
     * @dataProvider getProvider
     */
    public function testGet(
        string $context,
        string $specific,
        int $more_specific,
        bool $is_pagelike,
        string $expected
    ) {
        FunctionMocker::replace('get_post_meta', 'myMeta');
        FunctionMocker::replace('get_theme_mod', (
            'tutorial' === $specific ? 'myOtherMod' : 'myMod'
        ));
        FunctionMocker::replace('sanitize_title', function (
            string $text
        ): string {
            return $text;
        });
        FunctionMocker::replace('taxonomy_exists', true);
        FunctionMocker::replace('post_type_exists', true);

        $theme_mods = Stub::makeEmpty(ThemeMods::class);
        $theme_mods->utilities = Stub::makeEmpty(Utilities::class);
        $theme_mods->utilities->page = Stub::makeEmpty(Page::class);
        $theme_mods->utilities->page->layouts = Stub::makeEmpty(Layouts::class, [
            'IDs' => ['myMod' => 'My Mod', 'myMeta' => 'My Meta'],
        ]);

        $layout = Stub::construct(Layout::class, [$theme_mods, [
            'context' => $context,
            'specific' => $specific,
            'more_specific' => $more_specific,
        ]], [
            'isPagelike' => $is_pagelike,
        ]);

        $this->assertSame($expected, $layout->get());
    }

    /**
     * @dataProvider isPagelikeProvider
     */
    public function testIsPagelike(
        string $context,
        string $specific,
        int $more_specific,
        array $post_types,
        bool $expected
    ) {
        FunctionMocker::replace('post_type_exists', function (
            string $post_type
        ) use ($post_types): bool {
            return \in_array($post_type, $post_types);
        });

        FunctionMocker::replace('taxonomy_exists', true);

        $theme_mods = Stub::makeEmpty(ThemeMods::class);
        $theme_mods->utilities = Stub::makeEmpty(Utilities::class);
        $theme_mods->utilities->page = Stub::makeEmpty(Page::class);
        $theme_mods->utilities->page->layout = Stub::makeEmpty(Layout::class, [
            'isPagelike' => true,
        ]);

        $layout = new Layout($theme_mods, [
            'context' => $context,
            'specific' => $specific,
            'more_specific' => $more_specific,
        ]);

        $this->assertSame($expected, $layout->isPagelike());
    }

    public function getIDProvider(): array
    {
        return [
            'context is home' => [
                'home',
                'post',
                4,
                ['post'],
                [],
                false,
                'post_post_type_layout',
            ],
            'context is author' => [
                'author',
                'post',
                5,
                ['post'],
                [],
                false,
                'author_layout',
            ],
            'context is category' => [
                'category',
                'post',
                0,
                ['post'],
                ['category'],
                false,
                'category_taxonomy_layout',
            ],
            'context is category' => [
                'category',
                'category',
                15,
                ['post'],
                ['category'],
                false,
                'category_15_taxonomy_layout',
            ],
            'context is date' => [
                'date',
                '',
                0,
                ['tutorial'],
                ['level'],
                false,
                'date_layout',
            ],
            'context is post type archive' => [
                'post_type_archive',
                'book',
                19,
                ['tutorial', 'book'],
                ['level', 'genre'],
                false,
                'book_post_type_layout',
            ],
            'context is tag' => [
                'tag',
                'post_tag',
                0,
                ['post', 'book'],
                ['post_tag', 'genre'],
                false,
                'post_tag_taxonomy_layout',
            ],
            'context is tag, with term' => [
                'tag',
                'post_tag',
                33,
                ['post', 'book'],
                ['post_tag', 'genre'],
                false,
                'post_tag_33_taxonomy_layout',
            ],
            'context is tax' => [
                'tax',
                'level',
                0,
                ['tutorial', 'post'],
                ['level', 'category', 'post_tag'],
                false,
                'level_taxonomy_layout',
            ],
            'context is tax, with term' => [
                'tax',
                'level',
                22,
                ['tutorial', 'post'],
                ['level', 'category', 'post_tag'],
                false,
                'level_22_taxonomy_layout',
            ],
            'context is 404' => [
                '404',
                '',
                99,
                [],
                [],
                false,
                'error_404_layout',
            ],
            'context is search' => [
                'search',
                'tutorial',
                45,
                ['tutorial', 'post'],
                ['level', 'category', 'post_tag'],
                false,
                'search_layout',
            ],
            'context is singular, pagelike' => [
                'singular',
                'page',
                21,
                ['page', 'post'],
                [],
                true,
                '_jentil-layout',
            ],
            'context is singular, not pagelike' => [
                'singular',
                'post',
                24,
                ['page', 'post'],
                [],
                false,
                'singular_post_24_layout',
            ],
            'context non-existent' => [
                'feed',
                'tutorial',
                11,
                ['tutorial', 'post'],
                ['level', 'category', 'post_tag'],
                false,
                '',
            ],
        ];
    }

    public function getProvider(): array
    {
        return [
            'context non-existent' => ['feed', 'tutorial', 1, false, ''],
            'context not singular' => ['home', 'post', 2, false, 'myMod'],
            'is pagelike' => ['singular', 'page', 3, true, 'myMeta'],
            'is not pagelike' => ['singular', 'post', 4, false, 'myMod'],
            'layout mod invalid' => [
                'singular',
                'tutorial',
                5,
                false,
                'content'
            ],
        ];
    }

    public function isPagelikeProvider(): array
    {
        return [
            'context is not singular' => [
                'category',
                'post',
                0,
                ['post', 'page'],
                false,
            ],
            'context is singular' => [
                'singular',
                'tutorial',
                22,
                ['post', 'page', 'tutorial'],
                true,
            ],
            'context non-existent' => [
                'feed',
                'page',
                111,
                ['post', 'page'],
                false,
            ],
        ];
    }
}
