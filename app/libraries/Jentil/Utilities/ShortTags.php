<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities;

use GrottoPress\Jentil\Utilities;

class ShortTags
{
    /**
     * @var Utilities
     */
    private $utilities;

    public function __construct(Utilities $utilities)
    {
        $this->utilities = $utilities;
    }

    public function replace(string $content): string
    {
        return \str_ireplace(
            \array_keys($this->get()),
            \array_values($this->get()),
            $content
        );
    }

    /**
     * @return string[string]
     */
    public function get(): array
    {
        $tags = [
            '{{site_name}}' => \esc_attr(\get_bloginfo('name')),
            '{{site_url}}' => \esc_attr(\home_url('/')),
            '{{this_year}}' => \esc_attr(
                \date('Y', \current_time('timestamp'))
            ),
            '{{site_description}}' => \esc_attr(\get_bloginfo('description')),
            '{{author_name}}' => \esc_attr(
                \get_the_author_meta('display_name')
            ),
            '{{category_name}}' => \esc_attr(\single_cat_title('', false)),
            '{{tag_name}}' => \esc_attr(\single_tag_title('', false)),
            '{{term_name}}' => \esc_attr(\single_term_title('', false)),
            '{{taxonomy_name}}' => \esc_attr(\get_query_var('taxonomy')),
            '{{post_type_name}}' => \esc_attr(
                \post_type_archive_title('', false)
            ),
            '{{date}}' => \esc_attr(
                \get_query_var('day') ? \get_the_date() : (
                    \get_query_var('monthnum')
                    ? \get_the_date('F Y')
                    : \get_the_date('Y')
                )
            ),
            '{{search_query}}' => \esc_attr(\get_search_query()),
        ];

        /**
         * @var string[string] $tags
         */
        return \apply_filters('jentil_short_tags', $tags);
    }
}
