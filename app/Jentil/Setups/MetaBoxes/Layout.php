<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\MetaBoxes;

use GrottoPress\Jentil\AbstractTheme;
use WP_Post;

final class Layout extends AbstractMetaBox
{
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = "{$this->app->meta['slug']}-layout";
        $this->context = 'side';
    }

    public function run()
    {
        \add_action('add_meta_boxes', [$this, 'add'], 10, 2);
        \add_action('save_post', [$this, 'save']);
        \add_action('edit_attachment', [$this, 'save']);
    }

    /**
     * @return array<string, mixed>
     */
    protected function box(WP_Post $post): array
    {
        if (!\current_user_can('edit_theme_options')) {
            return [];
        }

        $utilities = $this->app->utilities;

        if (!($layouts = $utilities->page->layouts->IDs())) {
            return [];
        }

        if ($utilities->postTypeTemplate->isPageBuilder((int)$post->ID) ||
            $utilities->postTypeTemplate->isPageBuilderBlank((int)$post->ID)
        ) {
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
            'id' => $this->id,
            'context' => $this->context,
            'title' => \esc_html__('Layout', 'jentil'),
            'priority' => 'default',
            'callbackArgs' => ['__block_editor_compatible_meta_box' => true],
            'fields' => [
                [
                    'id' => $mod->id,
                    'type' => 'select',
                    'choices' => $layouts,
                    'label' => \esc_html__('Select layout', 'jentil'),
                    'labelPos' => 'before_field',
                    'layout' => 'block',
                ],
            ],
        ];
    }
}
