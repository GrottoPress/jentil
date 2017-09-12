<?php

/**
 * Panel
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
 * Panel
 *
 * @since 0.1.0
 */
abstract class Panel
{
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
     * Name
     *
     * @since 0.1.0
     * @access protected
     *
     * @var string $name Panel name.
     */
    protected $name;

    /**
     * Arguments
     *
     * @since 0.1.0
     * @access protected
     *
     * @var array $args Panel arguments.
     */
    protected $args;

    /**
     * Constructor
     *
     * @param Customizer $customizer Customizer.
     *
     * @since 0.1.0
     * @access protected
     */
    protected function __construct(Customizer $customizer)
    {
        $this->customizer = $customizer;
    }

    /**
     * Customizer
     *
     * @since 0.1.0
     * @access public
     *
     * @return Customizer Customizer.
     */
    public function customizer(): Customizer
    {
        return $this->customizer;
    }

    /**
     * Name
     *
     * @since 0.1.0
     * @access public
     *
     * @return string Name.
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Get sections
     *
     * @since 0.1.0
     * @access protected
     *
     * @return array Sections.
     */
    abstract protected function sections(): array;

    /**
     * Add Panel
     *
     * @param WP_Customizer $wp_customize
     *
     * @since 0.1.0
     * @access public
     */
    final public function add(WP_Customizer $wp_customize)
    {
        if (!$this->name) {
            return;
        }
        
        $wp_customize->add_panel($this->name, $this->args);

        if (!($sections = $this->sections())) {
            return;
        }

        foreach ($sections as $section) {
            $section->add($wp_customize);
        }
    }
}
