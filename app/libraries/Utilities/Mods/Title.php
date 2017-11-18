<?php

/**
 * Title
 *
 * @package GrottoPress\Jentil\Utilities\Mods
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Mods;

/**
 * Title
 *
 * @since 0.1.0
 */
class Title extends AbstractMod
{
    /**
     * Context
     *
     * @since 0.1.0
     * @access protected
     *
     * @var string $context Page type
     */
    protected $context;

    /**
     * Specific template
     *
     * @since 0.1.0
     * @access protected
     *
     * @var string $specific Post type name or taxonomy name
     */
    protected $specific;

    /**
     * More specific template
     *
     * @since 0.1.0
     * @access protected
     *
     * @var mixed $more_specific Post ID or term ID/name
     */
    protected $more_specific;

    /**
     * Constructor
     *
     * @param Mods $mods
     * @param array $args Mod args
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Mods $mods, array $args = [])
    {
        $this->setAttributes($args);

        parent::__construct($mods);
    }

    /**
     * Set attributes
     *
     * @since 0.1.0
     * @access protected
     */
    protected function setAttributes(array $args)
    {
        $args = \wp_parse_args($args, [
            'context' => '',
            'specific' => '',
            'more_specific' => '',
        ]);

        $this->context = \sanitize_key($args['context']);
        $this->more_specific = \sanitize_key($args['more_specific']);

        $this->specific = \post_type_exists($args['specific'])
            || \taxonomy_exists($args['specific']) ? $args['specific'] : '';

        $names = $this->names();
        $this->name = isset($names[$this->context])
            ? \sanitize_key($names[$this->context]) : '';

        $defaults = $this->defaults();
        $this->default = isset($defaults[$this->context])
            ? $defaults[$this->context] : '';
    }

    /**
     * Get mod names
     *
     * @since 0.1.0
     * @access protected
     *
     * @return array Mod names.
     */
    protected function names(): array
    {
        $names = [
            'home' => 'post_post_type_title',
            // 'singular' => 'singular_'.$this->specific.'_'.$this->more_specific.'_title',
            'author' => 'author_title',
            'category' => 'category_'.$this->more_specific.'_taxonomy_title',
            'date' => 'date_title',
            'post_type_archive' => $this->specific.'_post_type_title',
            'tag' => 'post_tag_'.$this->more_specific.'_taxonomy_title',
            'tax' => $this->specific.'_'.$this->more_specific.'_taxonomy_title',
            '404' => 'error_404_title',
            'search' => 'search_title',
        ];

        $names = \array_map(function (string $value): string {
            $value = \str_replace('__', '_', $value);
            $value = \trim($value, '_');

            return $value;
        }, $names);

        /**
         * @filter jentil_title_mod_names
         *
         * @var string $names Title mod names.
         *
         * @since 0.1.0
         */
        return \apply_filters(
            'jentil_title_mod_names',
            $names,
            $this->context,
            $this->specific,
            $this->more_specific
        );
    }

    /**
     * Get settings defaults
     *
     * @since 0.1.0
     * @access protected
     *
     * @return array Mod defaults.
     */
    protected function defaults(): array
    {
        $defaults = [
            'home' => \esc_html__('Latest Posts', 'jentil'),
            // 'singular' => '',
            'author' => '{{author_name}}',
            'category' => '{{category_name}}',
            'date' => '{{date}}',
            'post_type_archive' => '{{post_type_name}}',
            'tag' => '{{tag_name}}',
            'tax' => '{{term_name}}',
            '404' => \esc_html__('Not Found', 'jentil'),
            'search' => '&ldquo;{{search_query}}&rdquo;',
        ];

        /**
         * @filter jentil_title_mod_defaults
         *
         * @var string $defaults Posts mod defaults.
         *
         * @since 0.1.0
         */
        return \apply_filters(
            'jentil_title_mod_defaults',
            $defaults,
            $this->context,
            $this->specific,
            $this->more_specific
        );
    }

    /**
     * Get mod
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Mod.
     */
    public function get(): string
    {
        if (!$this->name) {
            return false;
        }

        return $this->replacePlaceholders(parent::get());
    }

    /**
     * Replace placeholders with actual info.
     *
     * @since 0.1.0
     * @access protected
     *
     * @return string Mod with placeholders replaced.
     */
    protected function replacePlaceholders(string $mod): string
    {
        return \str_ireplace(
            [
                '{{author_name}}',
                '{{category_name}}',
                '{{tag_name}}',
                '{{term_name}}',
                '{{taxonomy_name}}',
                '{{post_type_name}}',
                '{{date}}',
                '{{search_query}}',
            ],
            [
                \esc_attr(\get_the_author_meta('display_name')),
                \esc_attr(\single_cat_title('', false)),
                \esc_attr(\single_tag_title('', false)),
                \esc_attr(\single_term_title('', false)),
                \esc_attr(\get_query_var('taxonomy')),
                \esc_attr(\post_type_archive_title('', false)),
                \esc_attr(
                    \get_query_var('day') ? \get_the_date() : (
                        \get_query_var('monthnum')
                        ? \get_the_date('F Y')
                        : \get_the_date('Y')
                    )
                ),
                \esc_attr(\get_search_query()),
            ],
            $mod
        );
    }
}
