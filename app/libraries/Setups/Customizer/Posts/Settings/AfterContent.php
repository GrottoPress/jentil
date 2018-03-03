<?php

/**
 * Info After Content
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
 * Info After Content
 *
 * @since 0.1.0
 */
final class AfterContent extends AbstractSetting
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

        $mod = $this->themeMod('after_content');

        $this->id = $mod->id;
        
        $this->args['default'] = $mod->default;
        $this->args['sanitize_callback'] = 'sanitize_text_field';

        $this->control['type'] = 'text';
        $this->control['label'] = \esc_html__('After content', 'jentil');
        $this->control['description'] = \esc_html__(
            'Comma-separated',
            'jentil'
        );
    }
}
