<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer;

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
        $this->sections['Title\Title'] = new Title\Title($this);
        $this->sections['Layout\Layout'] = new Layout\Layout($this);
        $this->sections['Colophon\Colophon'] = new Colophon\Colophon($this);

        $this->panels['Posts\Posts'] = new Posts\Posts($this);

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
