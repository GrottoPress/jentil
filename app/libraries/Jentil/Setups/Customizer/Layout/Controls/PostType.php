<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Layout\Controls;

use GrottoPress\Jentil\Setups\Customizer\Layout;
use WP_Post_Type;

final class PostType extends AbstractControl
{
    public function __construct(Layout $layout, WP_Post_Type $post_type)
    {
        parent::__construct($layout);

        $this->id = $layout->settings["PostType_{$post_type->name}"]->id;

        $this->args['label'] = \sprintf(
            \esc_html__('%s Archive', 'jentil'),
            $post_type->labels->name
        );

        $this->args['active_callback'] = function () use ($post_type): bool {
            $page = $this->customizer->app->utilities->page;

            if ('post' === $post_type->name) {
                return $page->is('home');
            }

            return $page->is('post_type_archive', $post_type->name);
        };
    }
}
