<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Utilities\ThemeMods;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\AbstractTestCase;
use GrottoPress\Jentil\Utilities\ThemeMods\ThemeMods;
use GrottoPress\Jentil\Utilities\ThemeMods\Title;
use tad\FunctionMocker\FunctionMocker;

class TitleTest extends AbstractTestCase
{
    /**
     * @dataProvider getNameProvider
     */
    public function testGetName(
        string $context,
        string $specific,
        int $more_specific,
        array $post_types,
        array $taxonomies,
        string $expected_name
    ) {
        FunctionMocker::replace('esc_html__', function (string $text) {
            return $text;
        });

        FunctionMocker::replace('apply_filters', function (
            string $filter,
            array $content
        ): array {
            return $content;
        });

        FunctionMocker::replace('wp_parse_args', function (
            array $args,
            array $default
        ): array {
            return $args;
        });

        FunctionMocker::replace('sanitize_key', function (string $key): string {
            return $key;
        });

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

        $title = new Title(Stub::makeEmpty(ThemeMods::class), [
            'context' => $context,
            'specific' => $specific,
            'more_specific' => $more_specific,
        ]);

        $this->assertSame($expected_name, $title->id);
        // $this->assertSame($expected_default, $title->default);
    }

    public function getNameProvider(): array
    {
        return [
            'context is home' => [
                'home',
                'post',
                4,
                ['post'],
                [],
                'post_post_type_title',
            ],
            'context is author' => [
                'author',
                'post',
                5,
                ['post'],
                [],
                'author_title',
            ],
            'context is category' => [
                'category',
                'post',
                0,
                ['post'],
                ['category'],
                'category_taxonomy_title',
            ],
            'context is category' => [
                'category',
                'category',
                15,
                ['post'],
                ['category'],
                'category_15_taxonomy_title',
            ],
            'context is date' => [
                'date',
                '',
                0,
                ['tutorial'],
                ['level'],
                'date_title',
            ],
            'context is post type archive' => [
                'post_type_archive',
                'book',
                19,
                ['tutorial', 'book'],
                ['level', 'genre'],
                'book_post_type_title',
            ],
            'context is tag' => [
                'tag',
                'post_tag',
                0,
                ['post', 'book'],
                ['post_tag', 'genre'],
                'post_tag_taxonomy_title',
            ],
            'context is tag, with term' => [
                'tag',
                'post_tag',
                33,
                ['post', 'book'],
                ['post_tag', 'genre'],
                'post_tag_33_taxonomy_title',
            ],
            'context is tax' => [
                'tax',
                'level',
                0,
                ['tutorial', 'post'],
                ['level', 'category', 'post_tag'],
                'level_taxonomy_title',
            ],
            'context is tax, with term' => [
                'tax',
                'level',
                22,
                ['tutorial', 'post'],
                ['level', 'category', 'post_tag'],
                'level_22_taxonomy_title',
            ],
            'context is 404' => [
                '404',
                '',
                99,
                [],
                [],
                'error_404_title',
            ],
            'context is search' => [
                'search',
                'tutorial',
                45,
                ['tutorial', 'post'],
                ['level', 'category', 'post_tag'],
                'search_title',
            ],
            'context non-existent' => [
                'singular',
                'tutorial',
                11,
                ['tutorial', 'post'],
                ['level', 'category', 'post_tag'],
                '',
            ],
        ];
    }
}
