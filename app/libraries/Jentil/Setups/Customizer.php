<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

use GrottoPress\Jentil\Setups\Customizer\AbstractCustomizer;
use WP_Customize_Manager as WPCustomizer;

final class Customizer extends AbstractCustomizer
{
    public function run()
    {
        \add_action('customize_register', [$this, 'register']);
        \add_action('after_setup_theme', [$this, 'enableSelectiveRefresh']);
    }

    /**
     * @action customize_register
     */
    public function register(WPCustomizer $wp_customizer)
    {
        $this->sections['Title'] = new Customizer\Title($this);
        $this->sections['Layout'] = new Customizer\Layout($this);
        $this->sections['Footer'] = new Customizer\Footer($this);

        $this->panels['Posts'] = new Customizer\Posts($this);

        parent::register($wp_customizer);
    }

    /**
     * @see https://make.wordpress.org/core/2016/03/22/implementing-selective-refresh-support-for-widgets/
     *
     * @action after_setup_theme
     */
    public function enableSelectiveRefresh()
    {
        \add_theme_support('customize-selective-refresh-widgets');
    }
}
