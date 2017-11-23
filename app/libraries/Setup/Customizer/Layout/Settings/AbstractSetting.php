<?php

/**
 * Abstract Layout Setting
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Layout\Settings
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup\Customizer\Layout\Settings;

use GrottoPress\Jentil\Setup\Customizer\AbstractSetting as Setting;
use GrottoPress\Jentil\Setup\Customizer\Layout\Layout;
use GrottoPress\Jentil\utilities\Mods\Layout as LayoutMod;

/**
 * Abstract Layout Setting
 *
 * @since 0.1.0
 */
abstract class AbstractSetting extends Setting
{
    /**
     * Layout section
     *
     * @since 0.1.0
     * @access protected
     *
     * @var Layout $section Layout section.
     */
    protected $section;

    /**
     * Layout Mod
     *
     * @since 0.1.0
     * @access protected
     *
     * @var Layout $mod Layout mod.
     */
    protected $mod;

    /**
     * Constructor
     *
     * @param Layout $layout Layout section.
     *
     * @since 0.1.0
     * @access protected
     */
    protected function __construct(Layout $layout)
    {
        $this->section = $layout;

        $this->args = ['sanitize_callback' => 'sanitize_title'];

        $this->control = [
            'section' => $this->section->name,
            'label' => \esc_html__('Select layout', 'jentil'),
            'type' => 'select',
            'choices' => $this->section->customizer->theme->utilities
                ->page->layouts->IDNames(),
        ];
    }

    /**
     * Get mod
     *
     * @param array
     *
     * @since 0.5.0
     * @access protected
     *
     * @return LayoutMod
     */
    protected function mod(array $args): LayoutMod
    {
        return
            $this->section->customizer->theme->utilities->mods->layout($args);
    }
}
