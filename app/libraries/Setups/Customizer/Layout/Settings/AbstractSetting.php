<?php

/**
 * Abstract Layout Setting
 *
 * @package GrottoPress\Jentil\Setups\Customizer\Layout\Settings
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Layout\Settings;

use GrottoPress\Jentil\Setups\Customizer\AbstractSetting as Setting;
use GrottoPress\Jentil\Setups\Customizer\Layout\Layout;
use GrottoPress\Jentil\utilities\Mods\Layout as LayoutMod;

/**
 * Abstract Layout Setting
 *
 * @since 0.1.0
 */
abstract class AbstractSetting extends Setting
{
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
        parent::__construct($layout);

        $this->args['sanitize_callback'] = 'sanitize_title';

        $this->control['section'] = $this->section->name;
        $this->control['label'] = \esc_html__('Select layout', 'jentil');
        $this->control['type'] = 'select';
        $this->control['choices'] = $this->section->customizer->app
            ->utilities->page->layouts->IDNames();
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
            $this->section->customizer->app->utilities->mods->layout($args);
    }
}
