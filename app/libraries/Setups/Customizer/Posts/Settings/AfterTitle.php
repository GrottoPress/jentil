<?php

/**
 * Info After Title
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
 * Info After Title
 *
 * @since 0.1.0
 */
final class AfterTitle extends AbstractSetting
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

        $mod = $this->themeMod('after_title');

        $this->id = $mod->id;

        $this->args['default'] = $mod->default;
        $this->args['sanitize_callback'] = 'sanitize_text_field';

        $this->control['label'] = \esc_html__('After title', 'jentil');
        $this->control['description'] = \esc_html__(
            'Comma-separated',
            'jentil'
        );
        $this->control['type'] = 'text';
    }
}
