<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer;

use GrottoPress\Jentil\IdentityTrait;
use WP_Customize_Manager as WPCustomizer;

abstract class AbstractControl
{
    use IdentityTrait;

    /**
     * @var AbstractCustomizer
     */
    protected $customizer;

    /**
     * @var \WP_Customize_Control
     */
    protected $object;

    /**
     * @var mixed[string]
     */
    protected $args = [];

    public function __construct(AbstractCustomizer $customizer)
    {
        $this->customizer = $customizer;
    }

    /**
     * Get control, if already added
     */
    public function get(WPCustomizer $wp_customizer)
    {
        if (!$this->id) {
            return;
        }

        return $wp_customizer->get_control($this->id);
    }

    public function add(WPCustomizer $wp_customizer)
    {
        if (!$this->id && !$this->object) {
            return;
        }

        $wp_customizer->add_control(($this->object ?: $this->id), $this->args);
    }

    /**
     * Remove control, if already added
     */
    public function remove(WPCustomizer $wp_customizer)
    {
        if (!$this->id) {
            return;
        }

        $wp_customizer->remove_control($this->id);
    }
}
