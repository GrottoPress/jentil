<?php

/**
 * Secondary sidebar
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
 * Secondary sidebar
 *
 * @since 0.6.0
 */
final class Secondary extends AbstractSidebar
{
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
        $this->id = 'secondary-widget-area';

        \register_sidebar([
            'name'          => \esc_html__('Secondary', 'jentil'),
            'id'            => $this->id,
            'description'   => \esc_html__('Secondary widget area', 'jentil'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ]);
    }
}
