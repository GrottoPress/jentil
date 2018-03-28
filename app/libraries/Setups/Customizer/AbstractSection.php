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
     * @var array
     */
    protected $args = [];

    /**
     * @var AbstractSetting[]
     */
    protected $settings = [];

    public function __construct(AbstractCustomizer $customizer)
    {
        $this->customizer = $customizer;
    }

    protected function getCustomizer(): AbstractCustomizer
    {
        return $this->customizer;
    }

    /**
     * @return AbstractSetting[]
     */
    protected function getSettings(): array
    {
        return $this->settings;
    }

    /**
     * Be sure to set $this->settings here, in the child class.
     * Doing so in the constructor would be too early; it won't work.
     */
    public function add(WPCustomizer $wp_customizer)
    {
        if (!$this->id) {
            return;
        }

        $wp_customizer->add_section($this->id, $this->args);

        foreach ($this->settings as $setting) {
            $setting->add($wp_customizer);
        }
    }

    public function remove(WPCustomizer $wp_customizer)
    {
        if (!$this->id) {
            return;
        }

        $wp_customizer->remove_section($this->id);
    }
}
