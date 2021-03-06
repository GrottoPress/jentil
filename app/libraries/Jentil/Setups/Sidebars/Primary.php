<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Sidebars;

use GrottoPress\Jentil\AbstractTheme;

final class Primary extends AbstractSidebar
{
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = "{$this->app->meta['slug']}-primary";
    }

    public function run()
    {
        \add_action('widgets_init', [$this, 'register']);
    }

    /**
     * @action widgets_init
     */
    public function register()
    {
        \register_sidebar([
            'id'            => $this->id,
            'name'          => \esc_html__('Primary', 'jentil'),
            'description'   => \esc_html__('Primary sidebar', 'jentil'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ]);
    }
}
