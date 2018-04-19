<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer;

use GrottoPress\Jentil\IdentityTrait;
use WP_Customize_Manager as WPCustomizer;

abstract class AbstractSetting
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
     * @var array
     */
    protected $control = [];

    public function __construct(AbstractCustomizer $customizer)
    {
        $this->customizer = $customizer;
    }

    public function add(WPCustomizer $wp_customizer)
    {
        if (!$this->id) {
            return;
        }

        $wp_customizer->add_setting($this->id, $this->args);
        $wp_customizer->add_control($this->id, $this->control);
    }

    public function remove(WPCustomizer $wp_customizer)
    {
        if (!$this->id) {
            return;
        }

        $wp_customizer->remove_setting($this->id);
        $wp_customizer->remove_control($this->id);
    }
}
