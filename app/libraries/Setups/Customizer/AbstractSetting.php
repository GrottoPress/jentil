<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer;

use GrottoPress\Jentil\IdentityTrait;
use WP_Customize_Manager as WPCustomizer;

abstract class AbstractSetting
{
    use IdentityTrait;

    /**
     * @var AbstractSection
     */
    protected $section;

    /**
     * @var array
     */
    protected $args = [];

    /**
     * @var array
     */
    protected $control = [];

    public function __construct(AbstractSection $section)
    {
        $this->section = $section;
    }

    public function add(WPCustomizer $WPCustomizer)
    {
        if (!$this->id) {
            return;
        }

        $WPCustomizer->add_setting($this->id, $this->args);
        $WPCustomizer->add_control($this->id, $this->control);
    }

    public function remove(WPCustomizer $WPCustomizer)
    {
        if (!$this->id) {
            return;
        }

        $WPCustomizer->remove_setting($this->id);
        $WPCustomizer->remove_control($this->id);
    }
}
