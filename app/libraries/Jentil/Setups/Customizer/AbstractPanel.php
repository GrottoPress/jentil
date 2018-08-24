<?php
namespace GrottoPress\Jentil\Setups\Customizer;

use GrottoPress\Jentil\IdentityTrait;
use WP_Customize_Manager as WPCustomizer;

abstract class AbstractPanel
{
    use IdentityTrait;

    /**
     * @var AbstractCustomizer
     */
    protected $customizer;

    /**
     * @var \WP_Customize_Panel
     */
    protected $object;

    /**
     * @var mixed[string]
     */
    protected $args = [];

    /**
     * @var AbstractSection[string]
     */
    protected $sections = [];

    public function __construct(AbstractCustomizer $customizer)
    {
        $this->customizer = $customizer;
    }

    protected function getCustomizer(): AbstractCustomizer
    {
        return $this->customizer;
    }

    /**
     * @return AbstractSection[string]
     */
    protected function getSections(): array
    {
        return $this->sections;
    }

    /**
     * Get panel, if already added
     */
    public function get(WPCustomizer $wp_customizer)
    {
        return $wp_customizer->get_panel($this->id);
    }

    /**
     * Be sure to set $this->sections HERE, in the child class.
     * Doing that in the constructor may be too early; it mighty
     * not work.
     */
    public function add(WPCustomizer $wp_customizer)
    {
        if (!$this->id && !$this->object) {
            return;
        }

        $wp_customizer->add_panel(($this->object ?: $this->id), $this->args);

        foreach ($this->sections as $section) {
            $section->add($wp_customizer);
        }
    }

    /**
     * Remove panel, if already added
     */
    public function remove(WPCustomizer $wp_customizer)
    {
        $wp_customizer->remove_panel($this->id);
    }
}
