<?php

/**
 * Primary Menu
 *
 * @package GrottoPress\Jentil\Setups\Menus
 * @since 0.6.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Menus;

use GrottoPress\Jentil\AbstractTheme;

/**
 * Primary Menu
 *
 * @since 0.6.0
 */
final class Primary extends AbstractMenu
{
    /**
     * Constructor
     *
     * @param AbstractTheme $jentil
     *
     * @since 0.6.0
     * @access public
     */
    public function __construct(AbstractTheme $jentil)
    {
        parent::__construct($jentil);

        $this->id = 'primary-menu';
    }

    /**
     * Menus
     *
     * Register navigation menus
     *
     * @since 0.6.0
     * @access public
     *
     * @action after_setup_theme
     */
    public function register()
    {
        \register_nav_menus([
            $this->id => \esc_html__('Primary menu', 'jentil'),
        ]);
    }
}
