<?php

/**
 * Abstract Panel
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
 * Abstract Panel
 *
 * @since 0.1.0
 */
abstract class AbstractPanel
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
    protected $args = [];

    /**
     * Sections
     *
     * @since 0.5.0
     * @access protected
     *
     * @var AbstractSection[] $sections Sections.
     */
    protected $sections = [];

    /**
     * Constructor
     *
     * @param AbstractCustomizer $customizer Customizer.
     *
     * @since 0.1.0
     * @access protected
     */
    protected function __construct(AbstractCustomizer $customizer)
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
     * Get sections
     *
     * @since 0.5.0
     * @access protected
     *
     * @return AbstractSection[] Sections.
     */
    protected function getSections(): array
    {
        return $this->sections;
    }

    /**
     * Add Panel
     *
     * Be sure to set $this->sections HERE, in the child class.
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
        
        $WPCustomizer->add_panel($this->name, $this->args);

        foreach ($this->sections as $section) {
            $section->add($WPCustomizer);
        }
    }

    /**
     * Remove panel
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
        
        $WPCustomizer->remove_panel($this->name);
    }
}
