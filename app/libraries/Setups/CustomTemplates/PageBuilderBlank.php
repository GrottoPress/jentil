<?php

/**
 * Page builder blank template
 *
 * @package GrottoPress\Jentil\Setups\CustomTemplates
 * @since 0.5.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\CustomTemplates;

use WP_Theme;

/**
 * Page builder blank template
 *
 * @since 0.5.0
 */
final class PageBuilderBlank extends AbstractTemplate
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
        $templates['page-builder-blank.php'] = \esc_html__(
            'Page builder (blank)',
            'jentil'
        );

        return $templates;
    }
}
