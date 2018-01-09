<?php

/**
 * Colophon Section
 *
 * @package GrottoPress\Jentil\Setups\Customizer\Colophon
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Colophon;

use GrottoPress\Jentil\Setups\Customizer\Customizer;
use GrottoPress\WordPress\SUV\Setups\Customizer\AbstractSection;
use WP_Customize_Manager as WPCustomizer;

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
     * @param WPCustomizer $WPCustomizer
     *
     * @since 0.1.0
     * @access public
     */
    public function add(WPCustomizer $WPCustomizer)
    {
        $this->settings['Colophon'] = new Settings\Colophon($this);

        parent::add($WPCustomizer);
    }
}
