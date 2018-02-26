<?php

/**
 * Footer
 *
 * @package GrottoPress\Jentil\Setups\Sidebars
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Sidebars;

/**
 * Footer
 *
 * @since 0.1.0
 */
final class Footer extends AbstractSidebar
{
    /**
     * Constructor
     *
     * @since 0.6.0
     * @access public
     */
    public function __construct()
    {
        $this->id = 'footer-widget-area';
    }

    /**
     * Register widget area
     *
     * @since 0.1.0
     * @access public
     *
     * @action widgets_init
     */
    public function register()
    {
        \register_sidebar([
            'name'          => \esc_html__('Footer', 'jentil'),
            'id'            => $this->id,
            'description'   => \esc_html__('Footer widget area', 'jentil'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ]);
    }
}
