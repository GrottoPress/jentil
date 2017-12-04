<?php

/**
 * Colophon Section
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Colophon
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup\Customizer\Colophon;

use GrottoPress\Jentil\Setup\Customizer\Customizer;
use GrottoPress\Jentil\Setup\Customizer\AbstractSection;
use WP_Customize_Manager as WP_Customizer;

/**
 * Colophon Section
 *
 * @since 0.1.0
 */
final class Colophon extends AbstractSection
{
    /**
     * Constructor
     *
     * @param Customizer $customizer Customizer.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Customizer $customizer)
    {
        parent::__construct($customizer);

        $this->name = 'colophon';
        
        $this->args['title'] = \esc_html__('Colophon', 'jentil');
    }

    /**
     * Add section
     *
     * @param WP_Customizer $wp_customizer
     *
     * @since 0.1.0
     * @access public
     */
    public function add(WP_Customizer $wp_customize)
    {
        $this->settings['colophon'] = new Settings\Colophon($this);

        parent::add($wp_customize);
    }
}
