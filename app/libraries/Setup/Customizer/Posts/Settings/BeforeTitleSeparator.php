<?php

/**
 * Before Title Info Separator
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
 * Before Title Info Separator
 *
 * @since 0.1.0
 */
final class BeforeTitleSeparator extends Setting
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

        $mod = $this->mod('before_title_separator');

        $this->name = $mod->name();
        
        $this->args['default'] = $mod->default();
        $this->args['sanitize_callback'] = 'esc_attr';

        $this->control['label'] = \esc_html__(
            'Before title separator',
            'jentil'
        );
        $this->control['type'] = 'text';
    }
}