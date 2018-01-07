<?php

/**
 * Abstract Setting
 *
 * @package GrottoPress\Jentil\Setups\Customizer
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer;

use GrottoPress\WordPress\SUV\Setups\Customizer\AbstractSection;
use GrottoPress\Getter\Getter;
use WP_Customize_Manager as WPCustomizer;

/**
 * Abstract Setting
 *
 * @since 0.1.0
 */
abstract class AbstractSetting
{
    use Getter;
    
    /**
     * Section
     *
     * @since 0.1.0
     * @access protected
     *
     * @var AbstractSection
     */
    protected $section;
    
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
     * Constructor
     *
     * @param AbstractSection $section
     *
     * @since 0.1.0
     * @access protected
     */
    protected function __construct(AbstractSection $section)
    {
        $this->section = $section;
    }

    /**
     * Name
     *
     * @since 0.5.0
     * @access protected
     *
     * @return string Name.
     */
    protected function getName(): string
    {
        return $this->name;
    }

    /**
     * Add setting
     *
     * @param WPCustomizer $WPCustomizer
     *
     * @since 0.1.0
     * @access public
     */
    public function add(WPCustomizer $WPCustomizer)
    {
        if (!$this->name) {
            return;
        }

        $WPCustomizer->add_setting($this->name, $this->args);
        $WPCustomizer->add_control($this->name, $this->control);
    }

    /**
     * Remove setting
     *
     * @param WPCustomizer $WPCustomizer
     *
     * @since 0.1.0
     * @access public
     */
    public function remove(WPCustomizer $WPCustomizer)
    {
        if (!$this->name) {
            return;
        }
        
        $WPCustomizer->remove_setting($this->name);
        $WPCustomizer->remove_control($this->name);
    }
}
