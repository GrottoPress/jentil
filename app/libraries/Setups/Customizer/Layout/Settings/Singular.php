<?php
namespace GrottoPress\Jentil\Setups\Customizer\Layout\Settings;

use GrottoPress\Jentil\Setups\Customizer\Layout\Layout;
use WP_Post_Type;
use WP_Post;

final class Singular extends AbstractSetting
{
    public function __construct(
        Layout $layout,
        WP_Post_Type $post_type,
        WP_Post $post = null
    ) {
        parent::__construct($layout);

        $this->setThemeMod($post_type, $post);

        $this->setControl($post_type, $post);
    }

    private function setThemeMod(WP_Post_Type $post_type, WP_Post $post = null)
    {
        if ($post) {
            $this->themeMod = $this->themeMod([
                'context' => 'singular',
                'specific' => $post_type->name,
                'more_specific' => $post->ID,
            ]);
        } else {
            $this->themeMod = $this->themeMod([
                'context' => 'singular',
                'specific' => $post_type->name,
            ]);
        }

        $this->id = $this->themeMod->id;

        $this->args['default'] = $this->themeMod->default;
    }

    private function setControl(WP_Post_Type $post_type, WP_Post $post = null)
    {
        $this->control['active_callback'] = function () use (
            $post_type,
            $post
        ): bool {
            $utilities = $this->section->customizer->app->utilities;

            if ($utilities->postTypeTemplate->isPageBuilder()) {
                return false;
            }

            if ($post) {
                return (
                    $utilities->page->is('page', $post->ID) ||
                    $utilities->page->is('single', $post->ID) ||
                    $utilities->page->is('attachment', $post->ID)
                );
            }

            return $utilities->page->is('singular', $post_type->name);
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
