<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

use GrottoPress\Jentil\Jentil;
use WP_Post;

final class Metaboxes extends AbstractSetup
{
    use MetaboxesTrait;

    public function run()
    {
        $this->setup();
    }

    private function metaboxes(WP_Post $post): array
    {
        $boxes = [];

        if (($layout = $this->layoutMetabox($post))) {
            $boxes[] = $layout;
        }

        /**
         * @var Metaboxes[] $boxes Metaboxes.
         * @var WP_Post $post Post.
         */
        return \apply_filters('jentil_metaboxes', $boxes, $post);
    }

    private function layoutMetabox(WP_Post $post): array
    {
        if (!\current_user_can('edit_theme_options')) {
            return [];
        }

        $utilities = $this->app->utilities;

        if (!($layouts = $utilities->page->layouts->IDs())) {
            return [];
        }

        if ($utilities->postTypeTemplate->isPageBuilder((int)$post->ID)) {
            return [];
        }

        if (!($mod = $utilities->themeMods->layout([
            'context' => 'singular',
            'specific' => $post->post_type,
            'more_specific' => $post->ID,
        ]))->get()) {
            return [];
        }

        if (!$mod->isPagelike()) {
            return [];
        }

        return [
            'id' => 'jentil-layout',
            'title' => \esc_html__('Layout', 'jentil'),
            'context' => 'side',
            'priority' => 'default',
            'callback' => '',
            'fields' => [
                [
                    'id' => $mod->id,
                    'type' => 'select',
                    'choices' => $layouts,
                    'label' => \esc_html__('Select layout', 'jentil'),
                    'label_pos' => 'before_field',
                ],
            ],
            'notes' => '<p>'.\sprintf(
                \__(
                    'Need help? Check out the <a href="%s" target="_blank" rel="noreferrer noopener nofollow">documentation</a>.',
                    'jentil'
                ),
                Jentil::DOCUMENTATION
            ).'</p>',
        ];
    }
}
