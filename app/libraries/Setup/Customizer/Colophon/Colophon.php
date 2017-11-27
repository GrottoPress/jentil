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
        
        $this->args = ['title' => \esc_html__('Colophon', 'jentil')];
    }

    /**
     * Get settings
     *
     * @since 0.1.0
     * @access protected
     *
     * @return array Settings.
     */
    protected function getSettings(): array
    {
        $settings = [];

        $settings['colophon'] = new Settings\Colophon($this);

        return $settings;
    }
}
