<?php

/**
 * Pagination Position
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
 * Pagination Position
 *
 * @since 0.1.0
 */
final class PaginationPosition extends Setting
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

        $mod = $this->mod('pagination_position');

        $this->name = $mod->get('name');
        
        $this->args['default'] = $mod->get('default');
        $this->args['sanitize_callback'] = 'sanitize_key';

        $this->control['label'] = \esc_html__('Pagination position', 'jentil');
        $this->control['type'] = 'select';
        $this->control['choices'] = [
            'none' => \esc_html__('None', 'jentil'),
            'top' => \esc_html__('Top', 'jentil'),
            'bottom' => \esc_html__('Bottom', 'jentil'),
            'top_bottom' => \esc_html__('Top and bottom', 'jentil'),
        ];
    }
}
