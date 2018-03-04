<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Sidebars;

final class Secondary extends AbstractSidebar
{
    public function __construct()
    {
        $this->id = 'secondary-widget-area';
    }

    /**
     * @action widgets_init
     */
    public function register()
    {
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
