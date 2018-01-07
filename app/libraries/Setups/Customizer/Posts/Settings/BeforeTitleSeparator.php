<?php

/**
 * Before Title Info Separator
 *
 * @package GrottoPress\Jentil\Setups\Customizer\Posts\Settings
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Posts\Settings;

use GrottoPress\Jentil\Setups\Customizer\Posts\AbstractSection;

/**
 * Before Title Info Separator
 *
 * @since 0.1.0
 */
final class BeforeTitleSeparator extends AbstractSetting
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

        $mod = $this->themeMod('before_title_separator');

        $this->name = $mod->name;
        
        $this->args['default'] = $mod->default;
        $this->args['sanitize_callback'] = 'esc_attr';

        $this->control['label'] = \esc_html__(
            'Before title separator',
            'jentil'
        );
        $this->control['type'] = 'text';
    }
}
