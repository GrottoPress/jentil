<?php

/**
 * Page Builder Templates
 *
 * We need this to be able to load the page builder
 * custom page/post templates.
 *
 * @see https://developer.wordpress.org/reference/functions/get_query_template/
 *
 * @package GrottoPress\Jentil\Setups
 * @since 0.5.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

use GrottoPress\WordPress\SUV\Setups\AbstractSetup;
use WP_Theme;

/**
 * Page Builder Templates
 *
 * @since 0.5.0
 */
final class PageBuilderTemplates extends AbstractSetup
{
    /**
     * Run setup
     *
     * @since 0.5.0
     * @access public
     */
    public function run()
    {
        \add_action('wp_loaded', [$this, 'load']);
    }

    /**
     * Load
     *
     * @since 0.5.0
     * @access public
     *
     * @action wp_loaded
     */
    public function load()
    {
        $post_types = \get_post_types(['public' => true, 'show_ui' => true]);
        
        foreach ($post_types as $post_type) {
            \add_action("theme_{$post_type}_templates", [$this, 'add'], 10, 4);
        }
    }

    /**
     * Add page builder templates
     *
     * @param array $templates
     * @param WP_Theme $theme
     * @param \WP_Post $post
     * @param string $post_type
     *
     * @see https://make.wordpress.org/core/2016/11/03/post-type-templates-in-4-7/
     *
     * @since 0.5.0
     * @access public
     *
     * @filter theme_{$post_type}_templates
     *
     * @return array
     */
    public function add(
        array $templates,
        WP_Theme $theme,
        $post,
        string $post_type
    ): array {
        $templates['page-builder.php'] = \esc_html__(
            'Page builder',
            'jentil'
        );

        $templates['page-builder-blank.php'] = \esc_html__(
            'Page builder (blank)',
            'jentil'
        );

        return $templates;
    }
}
