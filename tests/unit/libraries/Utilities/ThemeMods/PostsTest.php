<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Utilities\ThemeMods;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\AbstractTestCase;
use GrottoPress\Jentil\Utilities\ThemeMods\ThemeMods;
use GrottoPress\Jentil\Utilities\ThemeMods\Posts;
use tad\FunctionMocker\FunctionMocker;

class PostsTest extends AbstractTestCase
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

        FunctionMocker::replace('apply_filters', function (
            string $name,
            $value
        ) {
            return $value;
        });

        FunctionMocker::replace('esc_html__', function (string $text) {
            return $text;
        });
    }

    /**
     * @dataProvider getNameProvider
     */
    public function testGetName(
        string $setting,
        string $context,
        string $specific,
        int $more_specific,
        array $post_types,
        array $taxonomies,
        string $expected
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

        FunctionMocker::replace('get_option');

        $posts = new Posts(Stub::makeEmpty(ThemeMods::class), $setting, [
            'context' => $context,
            'specific' => $specific,
            'more_specific' => $more_specific,
        ]);

        $this->assertSame($expected, $posts->id);
    }

    public function getNameProvider(): array
    {
        return [
            'context is home' => [
                'wrap_class',
                'home',
                'post',
                4,
                ['post'],
                [],
                'post_post_type_posts_wrap_class',
            ],
            'context is author' => [
                'wrap_tag',
                'author',
                'post',
                5,
                ['post'],
                [],
                'author_posts_wrap_tag',
            ],
            'context is category' => [
                'layout',
                'category',
                'post',
                0,
                ['post'],
                ['category'],
                'category_taxonomy_posts_layout',
            ],
            'context is category' => [
                'number',
                'category',
                'category',
                15,
                ['post'],
                ['category'],
                'category_15_taxonomy_posts_number',
            ],
            'context is date' => [
                'before_title',
                'date',
                '',
                0,
                ['tutorial'],
                ['level'],
                'date_posts_before_title',
            ],
            'context is post type archive' => [
                'before_title_separator',
                'post_type_archive',
                'book',
                19,
                ['tutorial', 'book'],
                ['level', 'genre'],
                'book_post_type_posts_before_title_separator',
            ],
            'context is tag' => [
                'title_words',
                'tag',
                'post_tag',
                0,
                ['post', 'book'],
                ['post_tag', 'genre'],
                'post_tag_taxonomy_posts_title_words',
            ],
            'context is tag, with term' => [
                'title_position',
                'tag',
                'post_tag',
                33,
                ['post', 'book'],
                ['post_tag', 'genre'],
                'post_tag_33_taxonomy_posts_title_position',
            ],
            'context is tax' => [
                'after_title',
                'tax',
                'level',
                0,
                ['tutorial', 'post'],
                ['level', 'category', 'post_tag'],
                'level_taxonomy_posts_after_title',
            ],
            'context is tax, with term' => [
                'after_title_separator',
                'tax',
                'level',
                22,
                ['tutorial', 'post'],
                ['level', 'category', 'post_tag'],
                'level_22_taxonomy_posts_after_title_separator',
            ],
            'context is search' => [
                'image',
                'search',
                'tutorial',
                45,
                ['tutorial', 'post'],
                ['level', 'category', 'post_tag'],
                'search_posts_image',
            ],
            'context non-existent' => [
                'image_alignment',
                '404',
                'tutorial',
                11,
                ['tutorial', 'post'],
                ['level', 'category', 'post_tag'],
                '',
            ],
        ];
    }
}
