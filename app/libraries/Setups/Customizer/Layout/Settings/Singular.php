<?php

/**
 * Singular Layout Setting
 *
 * @package GrottoPress\Jentil\Setups\Customizer\Layout\Settings
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

namespace GrottoPress\Jentil\Setups\Customizer\Layout\Settings;

use GrottoPress\Jentil\Setups\Customizer\Layout\Layout;
use WP_Post_Type;
use WP_Post;

/**
 * Singular Layout Setting
 *
 * @since 0.1.0
 */
final class Singular extends AbstractSetting
{
    /**
     * Constructor
     *
     * @param Layout $layout Layout.
     * @param WP_Post_Type $post_type Post type.
     * @param WP_Post $post Post.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(
        Layout $layout,
        WP_Post_Type $post_type,
        WP_Post $post = null
    ) {
        parent::__construct($layout);
        
        $this->setMod($post_type, $post);

        $this->setControl($post_type, $post);
    }

    /**
     * Set Mod
     *
     * @since 0.1.0
     * @access private
     */
    private function setMod(WP_Post_Type $post_type, WP_Post $post = null)
    {
        if ($post) {
            $this->mod = $this->themeMod([
                'context' => 'singular',
                'specific' => $post_type->name,
                'more_specific' => $post->ID,
            ]);
        } else {
            $this->mod = $this->themeMod([
                'context' => 'singular',
                'specific' => $post_type->name,
            ]);
        }

        $this->name = $this->mod->name;

        $this->args['default'] = $this->mod->default;
    }

    /**
     * Set Mod
     *
     * @since 0.1.0
     * @access private
     */
    private function setControl(WP_Post_Type $post_type, WP_Post $post = null)
    {
        $this->control['active_callback'] = function () use (
            $post_type,
            $post
        ): bool {
            $page = $this->section->customizer->app->utilities->page;

            if ($post) {
                return ($page->is('page', $post->ID)
                    || $page->is('single', $post->ID)
                    || $page->is('attachment', $post->ID));
            }

            return $page->is('singular', $post_type->name);
        };

        if ($post) {
            $this->control['label'] = \sprintf(\esc_html__(
                'Single %1$s: %2$s',
                'jentil'
            ), $post_type->labels->singular_name, $post->post_title);
        } else {
            $this->control['label'] = \sprintf(\esc_html__(
                'Single %1$s',
                'jentil'
            ), $post_type->labels->name);
        }
    }
}
