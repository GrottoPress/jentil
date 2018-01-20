<?php

/**
 * Title
 *
 * @package GrottoPress\Jentil\Utilities\ThemeMods
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\ThemeMods;

use GrottoPress\WordPress\SUV\Utilities\ThemeMods\AbstractThemeMod;

/**
 * Title
 *
 * @since 0.1.0
 */
final class Title extends AbstractThemeMod
{
    /**
     * ThemeMods
     *
     * @since 0.1.0
     * @access protected
     *
     * @var ThemeMods $themeMods ThemeMods.
     */
    protected $themeMods;
    
    /**
     * Context
     *
     * @since 0.1.0
     * @access private
     *
     * @var string $context Page type
     */
    private $context;

    /**
     * Specific template
     *
     * @since 0.1.0
     * @access private
     *
     * @var string $specific Post type name or taxonomy name
     */
    private $specific;

    /**
     * More specific template
     *
     * @since 0.1.0
     * @access private
     *
     * @var mixed $more_specific Post ID or term ID/name
     */
    private $more_specific;

    /**
     * Constructor
     *
     * @param ThemeMods $themeMods
     * @param array $args Mod args
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(ThemeMods $themeMods, array $args = [])
    {
        $this->themeMods = $themeMods;
        
        $this->setAttributes($args);
    }

    /**
     * Set attributes
     *
     * @since 0.1.0
     * @access private
     */
    private function setAttributes(array $args)
    {
        $args = \wp_parse_args($args, [
            'context' => '',
            'specific' => '',
            'more_specific' => '',
        ]);

        $this->context = \sanitize_key($args['context']);
        $this->more_specific = \sanitize_key($args['more_specific']);

        $this->specific = \post_type_exists($args['specific']) ||
            \taxonomy_exists($args['specific']) ? $args['specific'] : '';

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
     * @access private
     *
     * @return array Mod names.
     */
    private function names(): array
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

        return $names;
    }

    /**
     * Get settings defaults
     *
     * @since 0.1.0
     * @access private
     *
     * @return array Mod defaults.
     */
    private function defaults(): array
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
     * @return string
     */
    public function get(): string
    {
        return $this->themeMods->utilities->shortTags->replace(parent::get());
    }
}
