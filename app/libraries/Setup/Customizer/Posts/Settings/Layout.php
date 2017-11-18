<?php

/**
 * Posts Layout
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
 * Posts Layout
 *
 * @since 0.1.0
 */
class Layout extends AbstractSetting
{
    /**
     * Constructor
     *
     * @param AbstractSection $section Section.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $mod = $this->mod('layout');
        
        $this->name = $mod->name;
        
        $this->args['default'] = $mod->default;
        $this->args['sanitize_callback'] = 'sanitize_key';

        $this->control['label'] = \esc_html__('Layout', 'jentil');
        $this->control['type'] = 'select';
        $this->control['choices'] = [
            'stack' => \esc_html__('Stack', 'jentil'),
            'grid' => \esc_html__('Grid', 'jentil'),
        ];
    }
}
