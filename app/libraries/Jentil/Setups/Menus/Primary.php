<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Menus;

use GrottoPress\Jentil\AbstractTheme;

final class Primary extends AbstractMenu
{
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = "{$this->app->theme->stylesheet}-menu";
    }

    public function run()
    {
        \add_action('after_setup_theme', [$this, 'register']);
    }

    /**
     * @action after_setup_theme
     */
    public function register()
    {
        \register_nav_menus([
            $this->id => \esc_html__('Primary menu', 'jentil'),
        ]);
    }
}
