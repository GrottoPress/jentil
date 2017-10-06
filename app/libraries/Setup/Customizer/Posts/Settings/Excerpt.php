<?php

/**
 * Excerpt Length (number of words)
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Posts\Settings
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup\Customizer\Posts\Settings;

use GrottoPress\Jentil\Setup\Customizer\Posts\AbstractSection;

/**
 * Excerpt Length (number of words)
 *
 * @since 0.1.0
 */
final class Excerpt extends AbstractSetting
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

        $mod = $this->mod('excerpt');

        $this->name = $mod->name();
        
        $this->args['default'] = $mod->default();
        $this->args['sanitize_callback'] = function ($value): int {
            return \intval($value);
        };

        $this->control['label'] = \esc_html__('Excerpt', 'jentil');
        $this->control['type'] = 'number';
    }
}
