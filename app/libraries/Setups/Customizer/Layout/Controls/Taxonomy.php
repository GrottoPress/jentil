<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Layout\Controls;

use GrottoPress\Jentil\Setups\Customizer\Layout\Layout;
use WP_Taxonomy;
use WP_Term;

final class Taxonomy extends AbstractControl
{
    public function __construct(
        Layout $layout,
        WP_Taxonomy $taxonomy,
        WP_Term $term = null
    ) {
        parent::__construct($layout);

        $this->id = $layout->settings["Taxonomy_{$taxonomy->name}"]->id;

        $this->setArgs($taxonomy, $term);
    }

    private function setArgs(WP_Taxonomy $taxonomy, WP_Term $term = null)
    {
        $this->args['active_callback'] = function () use (
            $taxonomy,
            $term
        ): bool {
            $page = $this->customizer->app->utilities->page;

            if ($term) {
                return (
                    $page->is('tag', $term->term_id) ||
                    $page->is('category', $term->term_id) ||
                    $page->is('tax', $taxonomy, $term->term_id)
                );
            }

            if ('post_tag' === $taxonomy->name) {
                return $page->is('tag');
            }

            if ('category' === $taxonomy->name) {
                return $page->is('category');
            }

            return $page->is('tax', $taxonomy->name);
        };

        if ($term) {
            $this->args['label'] = \sprintf(\esc_html__(
                '%1$s Archive: %2$s',
                'jentil'
            ), $taxonomy->labels->singular_name, $term->name);
        } else {
            $this->args['label'] = \sprintf(\esc_html__(
                '%1$s Archives',
                'jentil'
            ), $taxonomy->labels->singular_name);
        }
    }
}
