<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\PostTypeTemplates;

use WP_Theme;

final class PageBuilderBlank extends AbstractTemplate
{
    public function __construct()
    {
        $this->slug = 'page-builder-blank.php';
    }

    /**
     * @param \WP_Post $post
     *
     * @filter theme_{$post_type}_templates
     */
    public function add(
        array $templates,
        WP_Theme $theme = null,
        $post,
        string $post_type
    ): array {
        $templates[$this->slug] = \esc_html__('Page builder (blank)', 'jentil');

        return $templates;
    }
}
