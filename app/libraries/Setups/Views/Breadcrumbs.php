<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use GrottoPress\Jentil\Setups\AbstractSetup;

final class Breadcrumbs extends AbstractSetup
{
    public function run()
    {
        \add_action('jentil_before_before_title', [$this, 'render']);
    }

    /**
     * @action jentil_before_before_title
     */
    public function render()
    {
        $utilities = $this->app->utilities;

        if ($utilities->page->is('front_page') &&
            !$utilities->page->is('paged')
        ) {
            return;
        }

        echo $utilities->breadcrumbs([
            'before' => \esc_html__('Path: ', 'jentil')
        ])->render();
    }
}
