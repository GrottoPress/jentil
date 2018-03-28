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
     * @var array
     */
    protected $args = [];

    /**
     * @var AbstractSection[]
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
     * @return AbstractSection[]
     */
    protected function getSections(): array
    {
        return $this->sections;
    }

    /**
     * Be sure to set $this->sections HERE, in the child class.
     * Doing that in the constructor would be too early; it won't work.
     */
    public function add(WPCustomizer $wp_customizer)
    {
        if (!$this->id) {
            return;
        }

        $wp_customizer->add_panel($this->id, $this->args);

        foreach ($this->sections as $section) {
            $section->add($wp_customizer);
        }
    }

    public function remove(WPCustomizer $wp_customizer)
    {
        if (!$this->id) {
            return;
        }

        $wp_customizer->remove_panel($this->id);
    }
}
