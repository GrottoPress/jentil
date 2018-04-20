<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer;

use GrottoPress\Jentil\Setups\AbstractSetup;
use WP_Customize_Manager as WPCustomizer;

abstract class AbstractCustomizer extends AbstractSetup
{
    /**
     * @var AbstractPanel[]
     */
    protected $panels = [];

    /**
     * @var AbstractSection[]
     */
    protected $sections = [];

    /**
     * @var AbstractSetting[]
     */
    protected $settings = [];

    /**
     * @return AbstractPanel[]
     */
    protected function getPanels(): array
    {
        return $this->panels;
    }

    /**
     * @return AbstractSection[]
     */
    protected function getSections(): array
    {
        return $this->sections;
    }

    /**
     * @return AbstractSetting[]
     */
    protected function getSettings(): array
    {
        return $this->settings;
    }

    /**
     * Be sure to set `$this->panels`, `$this->sections` and
     * `$this->settings` HERE, in the child class. Doing so
     * in the constructor may be too early; it mighty not work.
     *
     * @action customize_register
     */
    public function register(WPCustomizer $wp_customizer)
    {
        $this->addPanels($wp_customizer);
        $this->addSections($wp_customizer);
        $this->addSettings($wp_customizer);
    }

    private function addPanels(WPCustomizer $wp_customizer)
    {
        foreach ($this->panels as $panel) {
            $panel->add($wp_customizer);
        }
    }

    private function addSections(WPCustomizer $wp_customizer)
    {
        foreach ($this->sections as $section) {
            $section->add($wp_customizer);
        }
    }

    private function addSettings(WPCustomizer $wp_customizer)
    {
        foreach ($this->settings as $setting) {
            $setting->add($wp_customizer);
        }
    }
}
