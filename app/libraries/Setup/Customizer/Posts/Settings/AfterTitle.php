<?php

/**
 * Info After Title
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Posts\Settings
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup\Customizer\Posts\Settings;

use GrottoPress\Jentil\Setup\Customizer\Posts\Section;

/**
 * Info After Title
 *
 * @since 0.1.0
 */
final class AfterTitle extends Setting
{
    /**
     * Constructor
     *
     * @param Section $section Section.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Section $section)
    {
        parent::__construct($section);

        $mod = $this->mod('after_title');

        $this->name = $mod->name();
        
        $this->args['default'] = $mod->default();
        $this->args['sanitize_callback'] = 'sanitize_text_field';

        $this->control['label'] = \esc_html__('After title', 'jentil');
        $this->control['description'] = \esc_html__(
            'Comma-separated',
            'jentil'
        );
        $this->control['type'] = 'text';
    }
}