<?php
namespace GrottoPress\Jentil\Setups\Customizer\Layout\Controls;

use GrottoPress\Jentil\Setups\Customizer\Layout\Layout;
use WP_Post_Type;
use WP_Post;

final class Singular extends AbstractControl
{
    public function __construct(
        Layout $layout,
        WP_Post_Type $post_type,
        WP_Post $post = null
    ) {
        parent::__construct($layout);

        $this->id = $layout->settings["Singular_{$post_type->name}"]->id;

        $this->setArgs($post_type, $post);
    }

    private function setArgs(WP_Post_Type $post_type, WP_Post $post = null)
    {
        $this->args['active_callback'] = function () use (
            $post_type,
            $post
        ): bool {
            $utilities = $this->customizer->app->utilities;

            if ($utilities->postTypeTemplate->isPageBuilder() ||
                $utilities->postTypeTemplate->isPageBuilderBlank()
            ) {
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
            $this->args['label'] = \sprintf(
                \esc_html__('Single %1$s: %2$s', 'jentil'),
                $post_type->labels->singular_name,
                $post->post_title
            );
        } else {
            $this->args['label'] = \sprintf(
                \esc_html__('Single %1$s', 'jentil'),
                $post_type->labels->name
            );
        }
    }
}
