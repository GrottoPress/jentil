<?php

/**
 * Title Length (number of words)
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
 * Title Length (number of words)
 *
 * @since 0.1.0
 */
final class TitleWords extends AbstractSetting
{
    /**
     * Constructor
     *
     * @var Section $section Section.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $mod = $this->themeMod('title_words');
        
        $this->name = $mod->name;
        
        $this->args['default'] = $mod->default;
        $this->args['sanitize_callback'] = function ($value): int {
            return \intval($value);
        };

        $this->control['label'] = \esc_html__('Title length', 'jentil');
        $this->control['description'] = \esc_html__(
            'Number of words',
            'jentil'
        );
        $this->control['type'] = 'number';
    }
}
