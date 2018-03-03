<?php

/**
 * Title Position
 *
 * @package GrottoPress\Jentil\Setups\Customizer\Posts\Settings
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Settings;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

/**
 * Title Position
 *
 * @since 0.1.0
 */
final class TitlePosition extends AbstractSetting
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

        $mod = $this->themeMod('title_position');

        $this->id = $mod->id;

        $this->args['default'] = $mod->default;
        $this->args['sanitize_callback'] = 'sanitize_key';

        $this->control['label'] = \esc_html__('Title position', 'jentil');
        $this->control['description'] = \esc_html__(
            'Relative to image',
            'jentil'
        );
        $this->control['type'] = 'select';
        $this->control['choices'] = [
            'side' => \esc_html__('Side', 'jentil'),
            'top' => \esc_html__('Top', 'jentil'),
        ];
    }
}
