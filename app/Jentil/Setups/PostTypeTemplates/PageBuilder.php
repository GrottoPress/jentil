<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\PostTypeTemplates;

use GrottoPress\Jentil\AbstractTheme;
use WP_Theme;

final class PageBuilder extends AbstractTemplate
{
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->slug = 'post-type/page-builder.php';
    }

    public function run()
    {
        \add_action('wp_loaded', [$this, 'load']);
    }

    /**
     * @action wp_loaded
     */
    public function load()
    {
        $post_types = \get_post_types(['public' => true, 'show_ui' => true]);

        foreach ($post_types as $post_type) {
            \add_filter("theme_{$post_type}_templates", [$this, 'add'], 10, 4);
        }
    }

    /**
     * @param \WP_Post $post
     * @param array<string, string> $templates
     *
     * @filter theme_{$post_type}_templates
     *
     * @return array<string, string>
     */
    public function add(
        array $templates,
        WP_Theme $theme = null,
        $post,
        string $post_type
    ): array {
        $templates[$this->slug] = \esc_html__('Page builder', 'jentil');

        return $templates;
    }
}
