<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer;

use GrottoPress\Jentil\IdentityTrait;
use WP_Customize_Manager as WPCustomizer;

abstract class AbstractSection
{
    use IdentityTrait;

    /**
     * @var AbstractCustomizer
     */
    protected $customizer;

    /**
     * @var \WP_Customize_Section
     */
    protected $object;

    /**
     * @var mixed[string]
     */
    protected $args = [];

    /**
     * @var AbstractSetting[string]
     */
    protected $settings = [];

    /**
     * @var AbstractControl[string]
     */
    protected $controls = [];

    public function __construct(AbstractCustomizer $customizer)
    {
        $this->customizer = $customizer;
    }

    protected function getCustomizer(): AbstractCustomizer
    {
        return $this->customizer;
    }

    /**
     * @return AbstractSetting[string]
     */
    protected function getSettings(): array
    {
        return $this->settings;
    }

    /**
     * @return AbstractControl[string]
     */
    protected function getControls(): array
    {
        return $this->controls;
    }

    /**
     * Get section, if already added
     */
    public function get(WPCustomizer $wp_customizer)
    {
        return $wp_customizer->get_section($this->id);
    }

    /**
     * Be sure to set $this->settings, $this->controls, here,
     * in the child class. Doing so in the constructor may be too early;
     * it mighty not work.
     */
    public function add(WPCustomizer $wp_customizer)
    {
        if (!$this->id && !$this->object) {
            return;
        }

        $wp_customizer->add_section(($this->object ?: $this->id), $this->args);

        foreach ($this->settings as $setting) {
            $setting->add($wp_customizer);
        }

        foreach ($this->controls as $control) {
            $control->add($wp_customizer);
        }
    }

    /**
     * Remove section, if already added
     */
    public function remove(WPCustomizer $wp_customizer)
    {
        $wp_customizer->remove_section($this->id);
    }
}
