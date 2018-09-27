<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer;

use GrottoPress\Jentil\Setups\AbstractSetup;
use WP_Customize_Manager as WPCustomizer;

abstract class AbstractCustomizer extends AbstractSetup
{
    /**
     * @var AbstractPanel[string]
     */
    protected $panels = [];

    /**
     * @var AbstractSection[string]
     */
    protected $sections = [];

    /**
     * @var AbstractSetting[string]
     */
    protected $settings = [];

    /**
     * @var AbstractControl[string]
     */
    protected $controls = [];

    /**
     * @return AbstractPanel[string]
     */
    protected function getPanels(): array
    {
        return $this->panels;
    }

    /**
     * @return AbstractSection[string]
     */
    protected function getSections(): array
    {
        return $this->sections;
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
     * Be sure to set `$this->panels`, `$this->sections`,
     * `$this->settings`, `$this->controls` HERE, in the child class.
     * Doing so in the constructor may be too early; it mighty not work.
     *
     * @action customize_register
     */
    public function register(WPCustomizer $wp_customizer)
    {
        $this->addPanels($wp_customizer);
        $this->addSections($wp_customizer);
        $this->addSettings($wp_customizer);
        $this->addControls($wp_customizer);
    }

    private function addPanels(WPCustomizer $wp_customizer)
    {
        \array_walk(
            $this->panels,
            function (AbstractPanel $panel, string $key) use ($wp_customizer) {
                $panel->add($wp_customizer);
            }
        );
    }

    private function addSections(WPCustomizer $wp_customizer)
    {
        \array_walk(
            $this->sections,
            function (
                AbstractSection $section,
                string $key
            ) use ($wp_customizer) {
                $section->add($wp_customizer);
            }
        );
    }

    private function addSettings(WPCustomizer $wp_customizer)
    {
        \array_walk(
            $this->settings,
            function (
                AbstractSetting $setting,
                string $key
            ) use ($wp_customizer) {
                $setting->add($wp_customizer);
            }
        );
    }

    private function addControls(WPCustomizer $wp_customizer)
    {
        \array_walk(
            $this->controls,
            function (
                AbstractControl $control,
                string $key
            ) use ($wp_customizer) {
                $control->add($wp_customizer);
            }
        );
    }
}
