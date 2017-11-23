<?php

/**
 * Taxonomy Layout Setting
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Layout\Settings
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup\Customizer\Layout\Settings;

use GrottoPress\Jentil\Setup\Customizer\Layout\Layout;
use WP_Taxonomy;
use WP_Term;

/**
 * Taxonomy Layout Setting
 *
 * @since 0.1.0
 */
final class Taxonomy extends AbstractSetting
{
    /**
     * Constructor
     *
     * @param Layout $layout Layout.
     * @param WP_Taxonomy $taxonomy Taxonomy.
     * @param WP_Term $term Term.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(
        Layout $layout,
        WP_Taxonomy $taxonomy,
        WP_Term $term = null
    ) {
        parent::__construct($layout);
        
        $this->setMod($taxonomy, $term);

        $this->name = $this->mod->name;

        $this->args['default'] = $this->mod->default;

        $this->setControl($taxonomy, $term);
    }

    /**
     * Set Mod
     *
     * @since 0.1.0
     * @access private
     */
    private function setMod(WP_Taxonomy $taxonomy, WP_Term $term = null)
    {
        $mod_context = 'tax';
        
        if ('post_tag' == $taxonomy->name) {
            $mod_context = 'tag';
        } elseif ('category' == $taxonomy->name) {
            $mod_context = 'category';
        }

        if ($term) {
            $this->mod = $this->mod([
                'context' => $mod_context,
                'specific' => $taxonomy->name,
                'more_specific' => $term->term_id,
            ]);
        } else {
            $this->mod = $this->mod([
                'context' => $mod_context,
                'specific' => $taxonomy->name,
            ]);
        }
    }

    /**
     * Set Mod
     *
     * @since 0.1.0
     * @access private
     */
    private function setControl(WP_Taxonomy $taxonomy, WP_Term $term = null)
    {
        $this->control['active_callback'] = function () use (
            $taxonomy,
            $term
        ): bool {
            $page = $this->section->customizer->theme->utilities->page;

            if ($term) {
                return ($page->is('tag', $term->term_id)
                    || $page->is('category', $term->term_id)
                    || $page->is('tax', $taxonomy, $term->term_id));
            }

            if ('post_tag' == $taxonomy->name) {
                return $page->is('tag');
            }

            if ('category' == $taxonomy->name) {
                return $page->is('category');
            }

            return $page->is('tax', $taxonomy->name);
        };

        if ($term) {
            $this->control['label'] = \sprintf(\esc_html__(
                '%1$s Archive: %2$s',
                'jentil'
            ), $taxonomy->labels->singular_name, $term->name);
        } else {
            $this->control['label'] = \sprintf(\esc_html__(
                '%1$s Archives',
                'jentil'
            ), $taxonomy->labels->singular_name);
        }
    }
}
