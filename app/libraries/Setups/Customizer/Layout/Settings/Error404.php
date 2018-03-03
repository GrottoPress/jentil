<?php

/**
 * Error 404 Layout Setting
 *
 * @package GrottoPress\Jentil\Setups\Customizer\Layout\Settings
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Layout\Settings;

use GrottoPress\Jentil\Setups\Customizer\Layout\Layout;

/**
 * Error 404 Layout Setting
 *
 * @since 0.1.0
 */
final class Error404 extends AbstractSetting
{
    /**
     * Constructor
     *
     * @param Layout $layout Layout section.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Layout $layout)
    {
        parent::__construct($layout);
        
        $this->mod = $this->themeMod(['context' => '404']);

        $this->id = $this->mod->id;

        $this->args['default'] = $this->mod->default;

        $this->control['label'] = \esc_html__('Error 404', 'jentil');
        $this->control['active_callback'] = function (): bool {
            return $this->section->customizer->app->utilities
                ->page->is('404');
        };
    }
}
