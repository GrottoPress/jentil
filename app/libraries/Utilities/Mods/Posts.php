<?php

/**
 * Posts
 *
 * @package GrottoPress\Jentil\Utilities\Mods
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Mods;

use GrottoPress\WordPress\SUV\Utilities\ThemeMods\AbstractThemeMod;

/**
 * Posts
 *
 * @since 0.1.0
 */
final class Posts extends AbstractThemeMod
{
    /**
     * Mods
     *
     * @since 0.1.0
     * @access protected
     *
     * @var Mods $mods Mods.
     */
    protected $mods;
    
    /**
     * Setting
     *
     * @since 0.1.0
     * @access private
     *
     * @var string $setting Post setting to retrieve
     */
    private $setting;

    /**
     * Context
     *
     * @since 0.1.0
     * @access private
     *
     * @var string $context Context
     */
    private $context;

    /**
     * Specific page type
     *
     * @since 0.1.0
     * @access private
     *
     * @var string $specific Post type or taxonomy name.
     */
    private $specific;

    /**
     * More specific page type
     *
     * @since 0.1.0
     * @access private
     *
     * @var mixed $more_specific Post ID or term ID/name.
     */
    private $more_specific;

    /**
     * Constructor
     *
     * @param Mods $mods
     * @param string $setting Setting to retrieve.
     * @param array $args Mod args.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Mods $mods, string $setting, array $args = [])
    {
        $this->mods = $mods;
        
        $this->setAttributes($setting, $args);
    }

    /**
     * Set attributes
     *
     * @since 0.1.0
     * @access private
     */
    private function setAttributes(string $setting, array $args = [])
    {
        $args = \wp_parse_args($args, [
            'context' => '',
            'specific' => '',
            'more_specific' => '',
        ]);

        $this->setting = \sanitize_key($setting);
        $this->context = \sanitize_key($args['context']);
        $this->specific = \sanitize_key($args['specific']);
        $this->more_specific = \sanitize_key($args['more_specific']);

        $names = $this->names();
        $this->name = isset($names[$this->context])
            ? \sanitize_key($names[$this->context]) : '';

        $defaults = $this->defaults();
        $this->default = isset($defaults[$this->setting])
            ? $defaults[$this->setting] : '';
    }

    /**
     * Get mod names
     *
     * @since 0.1.0
     * @access private
     *
     * @return string Mod names.
     */
    private function names(): array
    {
        $names = [
            'home' => 'post_post_type_posts',
            // 'singular' => 'singular_'.$this->specific.'_'.$this->more_specific.'_posts',
            'author' => 'author_posts',
            'category' => 'category_'.$this->more_specific.'_taxonomy_posts',
            'date' => 'date_posts',
            'post_type_archive' => $this->specific.'_post_type_posts',
            'tag' => 'post_tag_'.$this->more_specific.'_taxonomy_posts',
            'tax' => $this->specific.'_'.$this->more_specific.'_taxonomy_posts',
            'search' => 'search_posts',
            'sticky' => $this->specific.'_sticky_posts',
        ];

        $names = \array_map(function (string $value): string {
            $value .= '_'.$this->setting;
            $value = \str_replace('__', '_', $value);
            $value = \trim($value, '_');

            return $value;
        }, $names);

        return $names;
    }

    /**
     * Settings defaults
     *
     * @since 0.1.0
     * @access private
     *
     * @return array Mod defaults.
     */
    private function defaults(): array
    {
        $defaults = [
            'wrap_class' => 'archive-posts big',
            'wrap_tag' => 'div',
            'layout' => 'stack',
            'number' => (int)\get_option('posts_per_page'),
            'before_title' => '',
            'before_title_separator' => ' | ',
            'title_words' => -1,
            'title_position' => 'side',
            'after_title' => 'published_date, comments_link',
            'after_title_separator' => ' | ',
            'image' => 'mini-thumb',
            'image_alignment' => 'left',
            'image_margin' => '',
            'text_offset' => 0,
            'excerpt' => -1,
            'more_text' => \esc_html__('read more', 'jentil'),
            'after_content' => 'category, post_tag',
            'after_content_separator' => ' | ',
            'pagination' => '',
            'pagination_maximum' => -1,
            'pagination_position' => 'bottom',
            'pagination_previous_label' => \esc_html__(
                '&larr; Previous',
                'jentil'
            ),
            'pagination_next_label' => \esc_html__('Next &rarr;', 'jentil'),
            'sticky_posts' => 0,
        ];

        if ('search' === $this->context) {
            $defaults['wrap_class'] = 'archive-posts';
            $defaults['image'] = 'nano-thumb';
            $defaults['title_position'] = 'top';
            $defaults['after_title'] = 'post_type, comments_link';
            $defaults['excerpt'] = 40;
        }

        if ('sticky' === $this->context) {
            $defaults['wrap_class'] = 'sticky-posts big';

            unset($defaults['number']);
            unset($defaults['pagination']);
            unset($defaults['pagination_maximum']);
            unset($defaults['pagination_position']);
            unset($defaults['pagination_previous_label']);
            unset($defaults['pagination_next_label']);
        }

        if (!\in_array($this->context, [
            'post_type_archive',
            'home',
        ])) {
            unset($defaults['sticky_posts']);
        }

        if (\in_array($this->context, [
            'home',
        ])) {
            $defaults['sticky_posts'] = 1;
        }

        /**
         * @filter jentil_posts_mod_defaults
         *
         * @var string $defaults Posts mod defaults.
         *
         * @since 0.1.0
         */
        return \apply_filters(
            'jentil_posts_mod_defaults',
            $defaults,
            $this->setting,
            $this->context
        );
    }
}
