<?php

/**
 * Breadcrumbs
 *
 * @package GrottoPress\Jentil\Setups\Views
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use GrottoPress\WordPress\SUV\Setups\AbstractSetup;

/**
 * Breadcrumbs
 *
 * @since 0.1.0
 */
final class Breadcrumbs extends AbstractSetup
{
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        \add_action('jentil_before_before_title', [$this, 'render']);
    }

    /**
     * Render
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_before_before_title
     */
    public function render()
    {
        $page = $this->app->utilities->page;
        
        if ($page->is('front_page') && !$page->is('paged')) {
            return;
        }

        echo $this->app->utilities->breadcrumbs([
            'before' => \esc_html__('Path: ', 'jentil')
        ])->render();
    }
}
