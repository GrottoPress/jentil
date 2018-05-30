<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\MetaBoxes;

use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\Jentil;
use WP_Post;

final class Layout extends AbstractMetaBox
{
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = 'jentil-layout';
        $this->context = 'side';
    }

    public function run()
    {
        \add_action('add_meta_boxes', [$this, 'add'], 10, 2);
        \add_action('save_post', [$this, 'save']);
        \add_action('edit_attachment', [$this, 'save']);
    }

    /**
     * @action add_meta_boxes
     */
    public function add(string $post_type, WP_Post $post)
    {
        if (!($box = $this->box($post))) {
            return;
        }

        $this->app->utilities->metaBox($box)->add();
    }

    /**
     * @action save_post
     * @action edit_attachment
     */
    public function save(int $post_id)
    {
        if (!($box = $this->box(\get_post($post_id)))) {
            return;
        }

        $this->app->utilities->metaBox($box)->save($post_id);
    }

    /**
     * @return mixed[string]
     */
    private function box(WP_Post $post): array
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
            'id' => $this->id,
            'title' => \esc_html__('Layout', 'jentil'),
            'context' => $this->context,
            'priority' => 'default',
            'callback' => '',
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
            'notes' => '<p>'.\sprintf(
                \__(
                    'Need help? Check out the <a href="%s" target="_blank" rel="noreferrer noopener nofollow">documentation</a>.',
                    'jentil'
                ),
                Jentil::DOCS_URI
            ).'</p>',
        ];
    }
}
