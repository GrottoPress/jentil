<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use tad\FunctionMocker\FunctionMocker;

class ShortTagsTest extends AbstractTestCase
{
    public function testReplace()
    {
        $add_action = FunctionMocker::replace('esc_attr', function (
            string $content
        ): string {
            return $content;
        });
        $get_bloginfo = FunctionMocker::replace('get_bloginfo', function (
            string $type
        ): string {
            if ('name' === $type) {
                return 'My Site';
            }

            if ('description' === $type) {
                return 'My awesome site';
            }

            return '';
        });
        $home_url = FunctionMocker::replace('home_url', 'http://my.site/');
        $current_time = FunctionMocker::replace('current_time', 1517759959);
        $get_the_author_meta = FunctionMocker::replace(
            'get_the_author_meta',
            'John Doe'
        );
        $single_cat = FunctionMocker::replace('single_cat_title', 'Bar');
        $single_tag = FunctionMocker::replace('single_tag_title', 'Foo');
        $single_term = FunctionMocker::replace('single_term_title', 'Baz');
        $get_query_var = FunctionMocker::replace('get_query_var', 'Level');
        $post_type_archive = FunctionMocker::replace(
            'post_type_archive_title',
            'Tutorial'
        );
        $get_the_date = FunctionMocker::replace('get_the_date', '10 Oct 2010');
        $get_search_query = FunctionMocker::replace('get_search_query', 'Bat');
        $apply_filters = FunctionMocker::replace('apply_filters', function (
            string $name,
            array $value
        ): array {
            return $value;
        });

        $content = '{{site_name}}, {{site_url}}, {{this_year}}, {{site_description}}, {{author_name}}, {{category_name}}, {{tag_name}}, {{term_name}}, {{taxonomy_name}}, {{post_type_name}}, {{date}}, {{search_query}}';

        $expected = 'My Site, http://my.site/, 2018, My awesome site, John Doe, Bar, Foo, Baz, Level, Tutorial, 10 Oct 2010, Bat';

        $shortTags = new ShortTags(Stub::makeEmpty(Utilities::class));

        $this->assertSame($expected, $shortTags->replace($content));
    }
}
