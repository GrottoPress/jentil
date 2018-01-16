<?php

/**
 * Primary sidebar
 *
 * @package GrottoPress\Jentil\Setups\Sidebars
 * @since 0.6.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Sidebars;

use GrottoPress\WordPress\SUV\Setups\AbstractSetup;

/**
 * Primary sidebar
 *
 * @since 0.6.0
 */
final class Primary extends AbstractSetup
{
    /**
     * Run setup
     *
     * @since 0.6.0
     * @access public
     */
    public function run()
    {
        \add_action('widgets_init', [$this, 'register']);
    }

    /**
     * Register widget area
     *
     * @since 0.6.0
     * @access public
     *
     * @action widgets_init
     */
    public function register()
    {
        \register_sidebar([
            'name'          => \esc_html__('Primary', 'jentil'),
            'id'            => 'primary-widget-area',
            'description'   => \esc_html__('Primary widget area', 'jentil'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ]);
    }
}
