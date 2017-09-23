<?php

/**
 * Settings
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Posts\Settings
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup\Customizer\Posts\Settings;

use GrottoPress\Jentil\Setup\Customizer\AbstractSetting as Setting;
use GrottoPress\Jentil\Setup\Customizer\Posts\AbstractSection;
use GrottoPress\Jentil\Utilities\Mods\Posts as Mod;

/**
 * Settings
 *
 * @since 0.1.0
 */
abstract class AbstractSetting extends Setting
{
    /**
     * Section
     *
     * @since 0.1.0
     * @access protected
     *
     * @var Section $section Section.
     */
    protected $section;
    
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
        $this->section = $section;

        $this->control['section'] = $this->section->name();
    }

    /**
     * Get mod
     *
     * @param string $setting Mod setting.
     *
     * @since 0.1.0
     * @access protected
     *
     * @return Mods Posts mod.
     */
    final protected function mod(string $setting): Mod
    {
        return $this->section->posts()->customizer()->jentil()->utilities()
            ->mods()->posts($setting, $this->section->modArgs());
    }
}
