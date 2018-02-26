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

/**
 * Primary sidebar
 *
 * @since 0.6.0
 */
final class Primary extends AbstractSidebar
{
    /**
     * Constructor
     *
     * @since 0.6.0
     * @access public
     */
    public function __construct()
    {
        $this->id = 'primary-widget-area';
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
            'id'            => $this->id,
            'description'   => \esc_html__('Primary widget area', 'jentil'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ]);
    }
}
