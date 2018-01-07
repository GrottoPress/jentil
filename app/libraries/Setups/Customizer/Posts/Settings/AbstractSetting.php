<?php

/**
 * Abstract Post Setting
 *
 * @package GrottoPress\Jentil\Setups\Customizer\Posts\Settings
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Settings;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;
use GrottoPress\Jentil\Utilities\ThemeMods\Posts as PostsMod;
use GrottoPress\WordPress\SUV\Setups\Customizer\AbstractSetting as Setting;

/**
 * Abstract Post Setting
 *
 * @since 0.1.0
 */
abstract class AbstractSetting extends Setting
{
    /**
     * Constructor
     *
     * @param Section $section Section.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $this->control['section'] = $this->section->name;
    }

    /**
     * Get mod
     *
     * @param string $setting Mod setting.
     *
     * @since 0.1.0
     * @access protected
     *
     * @return PostsMod Posts mod.
     */
    protected function themeMod(string $setting): PostsMod
    {
        return $this->section->panel->customizer->app->utilities
            ->themeMods->posts($setting, $this->section->modArgs);
    }
}
