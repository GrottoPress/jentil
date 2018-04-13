<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer;

use GrottoPress\Jentil\Setups\AbstractSetup;
use WP_Customize_Manager as WPCustomizer;

abstract class AbstractCustomizer extends AbstractSetup
{
    /**
     * Panels comprise sections which, in turn,
     * comprise settings.
     *
     * @var AbstractPanel[]
     */
    protected $panels = [];

    /**
     * Use this ONLY if sections come under no panel.
     * Each section comprises its settings.
     *
     * @var AbstractSection[]
     */
    protected $sections = [];

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
     * Be sure to set `$this->panels` and `$this->sections` HERE,
     * in the child class. Doing so in the constructor would be too
     * early; it won't work.
     *
     * @action customize_register
     */
    public function register(WPCustomizer $wp_customizer)
    {
        $this->addPanels($wp_customizer);
        $this->addSections($wp_customizer);
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
}
