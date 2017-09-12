<?php

/**
 * Setting
 *
 * @package GrottoPress\Jentil\Setup\Customizer
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup\Customizer;

use \WP_Customize_Manager as WP_Customizer;

/**
 * Setting
 *
 * @since 0.1.0
 */
abstract class Setting
{
    /**
     * Setting name
     *
     * @since 0.1.0
     * @access protected
     *
     * @var string $name Setting name.
     */
    protected $name;

    /**
     * Setting arguments
     *
     * @since 0.1.0
     * @access protected
     *
     * @var array $args Setting arguments.
     */
    protected $args = [];

    /**
     * Setting control
     *
     * @since 0.1.0
     * @access protected
     *
     * @var array $control Setting control.
     */
    protected $control = [];

    /**
     * Add setting
     *
     * @since 0.1.0
     * @access public
     */
    public function add(WP_Customizer $wp_customize)
    {
        if (!$this->name) {
            return;
        }

        $wp_customize->add_setting($this->name, $this->args);
        $wp_customize->add_control($this->name, $this->control);
    }
}
