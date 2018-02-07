<?php

/**
 * Layout
 *
 * @package GrottoPress\Jentil\Utilities\Page
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page;

use GrottoPress\Jentil\Utilities\ThemeMods\Layout as LayoutMod;

/**
 * Layout
 *
 * @since 1.0.0
 */
class Layout
{
    /**
     * Page
     *
     * @since 0.1.0
     * @access private
     *
     * @var Page
     */
    private $page;
    
    /**
     * Constructor
     *
     * @param Page $page
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    /**
     * Get mod
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Layout mod.
     */
    public function themeMod(): LayoutMod
    {
        $page = $this->page->type;

        $specific = '';
        $more_specific = 0;

        foreach ($page as $type) {
            if ('post_type_archive' === $type) {
                $specific = \get_query_var('post_type');
            } elseif ('tax' === $type) {
                $specific = \get_query_var('taxonomy');
            } elseif ('category' === $type) {
                $specific = 'category';
            } elseif ('tag' === $type) {
                $specific = 'post_tag';
            } elseif ('singular' === $type) {
                global $post;

                $specific = $post->post_type;

                if ($this->isPagelike($post->post_type, $post->ID)) {
                    $more_specific = $post->ID;
                }
            }

            if (\is_array($specific)) {
                $specific = $specific[0];
            }

            if (\is_array($more_specific)) {
                $more_specific = $more_specific[0];
            }

            $mod = $this->page->utilities->themeMods->layout([
                'context' => $type,
                'specific' => $specific,
                'more_specific' => $more_specific
            ]);

            if ($mod->name) {
                return $mod;
            }
        }

        return $mod;
    }

    /**
     * Get current layout's column
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Layout column name.
     */
    public function column(): string
    {
        foreach ($this->page->layouts->get() as $column_slug => $layouts) {
            foreach ($layouts as $layout_id => $layout_name) {
                if ($this->themeMod()->get() === $layout_id) {
                    return \sanitize_title($column_slug);
                }
            }
        }

        return '';
    }

    /**
     * Is post type pagelike?
     *
     * Determines if post type behaves like
     * the page post type.
     *
     * @param string $post_type
     * @param int $post_id
     *
     * @since 0.1.0
     * @access public
     *
     * @return bool
     */
    public function isPagelike(string $post_type = '', int $post_id = 0): bool
    {
        $post_type = $post_type ?: $this->postType();

        $check = (
            \is_post_type_hierarchical($post_type) &&
            !\get_post_type_archive_link($post_type)
        );

        if ($check && $post_id) {
            return ($post_id !== (int)\get_option('page_for_posts'));
        }

        return $check;
    }
}
