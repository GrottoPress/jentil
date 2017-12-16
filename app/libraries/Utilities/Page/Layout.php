<?php

/**
 * Layout
 *
 * @package GrottoPress\Jentil\Utilities\Page
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities\Page;

use GrottoPress\Jentil\Utilities\Mods\Layout as LayoutMod;

/**
 * Layout
 *
 * @since 1.0.0
 */
final class Layout
{
    /**
     * Page
     *
     * @since 0.1.0
     * @access private
     *
     * @var Page $page Page.
     */
    private $page;
    
    /**
     * Constructor
     *
     * @param Page $page Page.
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
    public function mod(): LayoutMod
    {
        $page = $this->page->type;

        $specific = '';
        $more_specific = '';

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

                if (\is_post_type_hierarchical($post->post_type)) {
                    $more_specific = $post->ID;
                }
            }

            if (\is_array($specific)) {
                $specific = $specific[0];
            }

            if (\is_array($more_specific)) {
                $more_specific = $more_specific[0];
            }

            $mod = $this->page->utilities->mods->layout([
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
                if ($this->mod()->get() === $layout_id) {
                    return \sanitize_title($column_slug);
                }
            }
        }
    
        return '';
    }
}
