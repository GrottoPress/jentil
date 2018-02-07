<?php

/**
 * Layout
 *
 * @package GrottoPress\Jentil\Utilities\ThemeMods
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\ThemeMods;

/**
 * Layout
 *
 * @since 0.1.0
 */
class Layout extends AbstractThemeMod
{
    /**
     * ThemeMods
     *
     * @since 0.1.0
     * @access private
     *
     * @var ThemeMods $themeMods ThemeMods.
     */
    private $themeMods;
    
    /**
     * Context
     *
     * @since 0.1.0
     * @access private
     *
     * @var string $context Page type.
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
        $this->default = 'content-sidebar';

        $this->specific = \post_type_exists($args['specific']) ||
            \taxonomy_exists($args['specific']) ? $args['specific'] : '';

        $names = $this->names();
        $this->name = isset($names[$this->context])
            ? \sanitize_key($names[$this->context]) : '';
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
            'home' => 'post_post_type_layout',
            'singular' => (
                $this->isPagelike() ? 'layout' :
                'singular_'.$this->specific.'_'.$this->more_specific.'_layout'
            ),
            'author' => 'author_layout',
            'category' => 'category_'.$this->more_specific.'_taxonomy_layout',
            'date' => 'date_layout',
            'post_type_archive' => $this->specific.'_post_type_layout',
            'tag' => 'post_tag_'.$this->more_specific.'_taxonomy_layout',
            'tax' => $this->specific.'_'.
                $this->more_specific.'_taxonomy_layout',
            '404' => 'error_404_layout',
            'search' => 'search_layout',
        ];

        $names = \array_map(function (string $value): string {
            $value = \str_replace('__', '_', $value);
            $value = \trim($value, '_');

            return $value;
        }, $names);

        return $names;
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
            return '';
        }

        if ($this->isPagelike()) {
            if (($mod = \get_post_meta(
                $this->more_specific,
                $this->name,
                true
            ))) {
                return \sanitize_title($mod);
            }

            return $this->default;
        }

        return \sanitize_title(parent::get());
    }

    /**
     * Is post type pagelike?
     *
     * Determines if post type behaves like
     * the page post type.
     *
     * @since 0.1.0
     * @access public
     *
     * @return bool
     */
    public function isPagelike(): bool
    {
        if ('singular' !== $this->context) {
            return false;
        }

        $check = (
            \is_post_type_hierarchical($this->specific) &&
            !\get_post_type_archive_link($this->specific)
        );

        if ($check && $this->more_specific) {
            return ($this->more_specific !== \get_option('page_for_posts'));
        }

        return $check;
    }
}
