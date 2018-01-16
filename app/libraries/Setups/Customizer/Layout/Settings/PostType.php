<?php

/**
 * Post Type Layout Setting
 *
 * @package GrottoPress\Jentil\Setups\Customizer\Layout\Settings
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Layout\Settings;

use GrottoPress\Jentil\Setups\Customizer\Layout\Layout;
use WP_Post_Type;

/**
 * Post Type Layout Setting
 *
 * @since 0.1.0
 */
final class PostType extends AbstractSetting
{
    /**
     * Constructor
     *
     * @param Layout $layout Layout section.
     * @param WP_Post_Type $post_type Post type.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Layout $layout, WP_Post_Type $post_type)
    {
        parent::__construct($layout);

        $mod_context = (
            'post' === $post_type->name ? 'home' : 'post_type_archive'
        );

        $this->mod = $this->themeMod([
            'context' => $mod_context,
            'specific' => $post_type->name,
        ]);

        $this->name = $this->mod->name;

        $this->args['default'] = $this->mod->default;

        $this->control['label'] = \sprintf(\esc_html__(
            '%s Archive',
            'jentil'
        ), $post_type->labels->name);

        $this->control['active_callback'] = function () use ($post_type): bool {
            $page = $this->section->customizer->app->utilities->page;

            if ('post' === $post_type->name) {
                return $page->is('home');
            }

            return $page->is('post_type_archive', $post_type->name);
        };
    }
}
