<?php

/**
 * Customizer
 *
 * @package GrottoPress\Jentil\Setups\Customizer
 * @since 0.1.0
 *
 * @see https://code.tutsplus.com/series/a-guide-to-the-wordpress-theme-customizer--wp-33722
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer;

use WP_Customize_Manager as WPCustomizer;

/**
 * Customizer
 *
 * @since 0.1.0
 */
final class Customizer extends AbstractCustomizer
{
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        parent::run();

        \add_action('after_setup_theme', [$this, 'enableSelectiveRefresh']);
    }

    /**
     * Register theme customizer
     *
     * @param WPCustomizer $WPCustomizer
     *
     * @action customize_register
     *
     * @since 0.5.0
     * @access public
     */
    public function register(WPCustomizer $WPCustomizer)
    {
        $this->sections['Title\Title'] = new Title\Title($this);
        $this->sections['Layout\Layout'] = new Layout\Layout($this);
        $this->sections['Colophon\Colophon'] = new Colophon\Colophon($this);

        $this->panels['Posts\Posts'] = new Posts\Posts($this);

        parent::register($WPCustomizer);
    }

    /**
     * Selective refresh
     *
     * Add selective refresh support to elements
     * in the customizer.
     *
     * @see https://make.wordpress.org/core/2016/03/22/implementing-selective-refresh-support-for-widgets/
     *
     * @since 0.1.0
     * @access public
     *
     * @action after_setup_theme
     */
    public function enableSelectiveRefresh()
    {
        \add_theme_support('customize-selective-refresh-widgets');
    }
}
