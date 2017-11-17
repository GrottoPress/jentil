<?php

/**
 * Section
 *
 * @package GrottoPress\Jentil\Setup\Customizer
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup\Customizer;

use WP_Customize_Manager as WP_Customizer;
use GrottoPress\Getter\Getter;

/**
 * Section
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
     * @var Customizer $customizer Customizer.
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
    protected $args;
    
    /**
     * Constructor
     *
     * @param Customizer $customizer Customizer.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Customizer $customizer)
    {
        $this->customizer = $customizer;
    }

    /**
     * Customizer
     *
     * @since 0.1.0
     * @access protected
     *
     * @return Customizer Customizer.
     */
    final protected function getCustomizer(): Customizer
    {
        return $this->customizer;
    }

    /**
     * Name
     *
     * @since 0.1.0
     * @access protected
     *
     * @return string Name.
     */
    final protected function getName(): string
    {
        return $this->name;
    }

    /**
     * Get settings
     *
     * @since 0.1.0
     * @access protected
     *
     * @return array Settings.
     */
    abstract protected function settings(): array;

    /**
     * Add section
     *
     * @since 0.1.0
     * @access public
     */
    final public function add(WP_Customizer $wp_customize)
    {
        if (!$this->name) {
            return;
        }

        $wp_customize->add_section($this->name, $this->args);

        if (!($settings = $this->settings())) {
            return;
        }

        foreach ($settings as $setting) {
            $setting->add($wp_customize);
        }
    }
}
