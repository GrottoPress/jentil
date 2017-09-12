<?php

/**
 * After Content Info Separator
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
 * After Content Info Separator
 *
 * @since 0.1.0
 */
final class AfterContentSeparator extends Setting
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

        $mod = $this->mod('after_content_separator');

        $this->name = $mod->name();
        
        $this->args['default'] = $mod->default();
        $this->args['sanitize_callback'] = 'esc_attr';

        $this->control['label'] = \esc_html__(
            'After content separator',
            'jentil'
        );
        $this->control['type'] = 'text';
    }
}
