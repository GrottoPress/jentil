<?php

/**
 * Abstract Section
 *
 * @package GrottoPress\Jentil\Setups\Customizer
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer;

use WP_Customize_Manager as WPCustomizer;
use GrottoPress\Getter\Getter;

/**
 * Abstract Section
 *
 * @since 0.1.0
 */
abstract class AbstractSection
{
    use Getter;
    
    /**
     * Customizer
     *
     * @since 0.1.0
     * @access protected
     *
     * @var AbstractCustomizer $customizer Customizer.
     */
    protected $customizer;

    /**
     * Section name
     *
     * @since 0.1.0
     * @access protected
     *
     * @var string $name Section name.
     */
    protected $name;

    /**
     * Section arguments
     *
     * @since 0.1.0
     * @access protected
     *
     * @var array $args Section arguments.
     */
    protected $args = [];

    /**
     * Settings
     *
     * @since 0.5.0
     * @access protected
     *
     * @var AbstractSetting[] $settings Settings.
     */
    protected $settings = [];
    
    /**
     * Constructor
     *
     * @param AbstractCustomizer $customizer Customizer.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(AbstractCustomizer $customizer)
    {
        $this->customizer = $customizer;
    }

    /**
     * Customizer
     *
     * @since 0.1.0
     * @access protected
     *
     * @return AbstractCustomizer Customizer.
     */
    final protected function getCustomizer(): AbstractCustomizer
    {
        return $this->customizer;
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
     * Get settings
     *
     * @since 0.5.0
     * @access protected
     *
     * @return AbstractSetting[] Settings.
     */
    protected function getSettings(): array
    {
        return $this->settings;
    }

    /**
     * Add section
     *
     * Be sure to set $this->settings here, in the child class.
     * Doing that in the constructor would be too early; it won't work.
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

        $WPCustomizer->add_section($this->name, $this->args);

        foreach ($this->settings as $setting) {
            $setting->add($WPCustomizer);
        }
    }

    /**
     * Remove section
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
        
        $WPCustomizer->remove_section($this->name);
    }
}
