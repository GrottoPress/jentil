<?php

/**
 * Sticky Posts
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
 * Sticky Posts
 *
 * @since 0.1.0
 */
final class StickyPosts extends AbstractSetting
{
    /**
     * Constructor
     *
     * @param AbstractSection $section Section.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(AbstractSection $section)
    {
        parent::__construct($section);

        $mod = $this->mod('sticky_posts');
      
        $this->name = $mod->name;
        
        $this->args['default'] = $mod->default;
        $this->args['sanitize_callback'] = 'absint';

        $this->control['label'] = \esc_html__('Show sticky posts?', 'jentil');
        $this->control['type'] = 'checkbox';
    }
}
