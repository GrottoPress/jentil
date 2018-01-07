<?php

/**
 * Search
 *
 * @package GrottoPress\Jentil\Setups\Customizer\Title\Settings
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Title\Settings;

use GrottoPress\Jentil\Setups\Customizer\Title\Title;

/**
 * Search
 *
 * @since 0.1.0
 */
final class Search extends AbstractSetting
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

        $this->mod = $this->mod(['context' => 'search']);
            
        $this->name = $this->mod->name;

        $this->args['default'] = $this->mod->default;

        $this->control['label'] = \esc_html__('Search Results', 'jentil');
        $this->control['active_callback'] = function (): bool {
            return $this->section->customizer->app->utilities
                ->page->is('search');
        };
    }
}
