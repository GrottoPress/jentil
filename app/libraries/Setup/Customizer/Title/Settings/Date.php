<?php

/**
 * Date
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Title\Settings
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup\Customizer\Title\Settings;

use GrottoPress\Jentil\Setup\Customizer\Title\Title;

/**
 * Date
 *
 * @since 0.1.0
 */
class Date extends AbstractSetting
{
    /**
     * Constructor
     *
     * @param Title $title Title.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Title $title)
    {
        parent::__construct($title);

        $this->mod = $this->title->customizer->theme->utilities
            ->mods->title([
                'context' => 'date',
            ]);

        $this->name = $this->mod->name;
        
        $this->args['default'] = $this->mod->default;

        $this->control['label'] = \esc_html__('Date Archives', 'jentil');
        $this->control['active_callback'] = function (): bool {
            return $this->title->customizer->theme->utilities
                ->page->is('date');
        };
    }
}
