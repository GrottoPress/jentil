<?php

/**
 * Page builder template
 *
 * @package GrottoPress\Jentil\Setups\PostTypeTemplates
 * @since 0.5.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\PostTypeTemplates;

use WP_Theme;

/**
 * Page builder template
 *
 * @since 0.5.0
 */
final class PageBuilder extends AbstractTemplate
{
    /**
     * Add template
     *
     * @param array $templates
     * @param WP_Theme $theme
     * @param \WP_Post $post
     * @param string $post_type
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
        WP_Theme $theme = null,
        $post,
        string $post_type
    ): array {
        $this->slug = 'page-builder.php';

        $templates[$this->slug] = \esc_html__('Page builder', 'jentil');

        return $templates;
    }
}
