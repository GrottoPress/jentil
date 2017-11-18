<?php

/**
 * Customizer
 *
 * @package GrottoPress\Jentil\Setup\Customizer
 * @since 0.1.0
 *
 * @see https://code.tutsplus.com/series/a-guide-to-the-wordpress-theme-customizer--wp-33722
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup\Customizer;

use GrottoPress\Jentil\Setup\AbstractSetup;
use WP_Customize_Manager as WP_Customizer;

/**
 * Customizer
 *
 * @since 0.1.0
 */
class Customizer extends AbstractSetup
{
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        \add_action('customize_register', [$this, 'register']);
        \add_action('customize_preview_init', [$this, 'enqueueJS']);
        \add_action('after_setup_theme', [$this, 'enableSelectiveRefresh']);
    }

    /**
     * Register theme customizer
     *
     * @param WP_Customizer $wp_customize
     *
     * @action customize_register
     *
     * @since 0.1.0
     * @access public
     */
    public function register(WP_Customizer $wp_customize)
    {
        $this->addPanels($wp_customize);
        $this->addSections($wp_customize);
    }

    /**
     * Enqueue JS
     *
     * @action customize_preview_init
     *
     * @since 0.1.0
     * @access public
     */
    public function enqueueJS()
    {
        \wp_enqueue_script(
            'jentil-customizer',
            $this->jentil->utilities->fileSystem->scriptsDir(
                'url',
                '/customize-preview.min.js'
            ),
            ['jquery', 'customize-preview'],
            '',
            true
        );
    }

    /**
     * Selective refresh
     *
     * Add selective refresh support to elements
     * in the customizer.
     *
     * @see https://make.wordpress.org/core/2016/03/22/implementing-selective-refresh-support-for-widgets/
     *
     * @since 0.1.0
     * @access public
     *
     * @action after_setup_theme
     */
    public function enableSelectiveRefresh()
    {
        \add_theme_support('customize-selective-refresh-widgets');
    }

    /**
     * Get panels
     *
     * Panels comprise sections which, in turn,
     * comprise settings.
     *
     * @since 0.1.0
     * @access protected
     *
     * @return array Panels.
     */
    protected function panels(): array
    {
        $panels = [];

        $panels['posts'] = new Posts\Posts($this);

        return $panels;
    }

    /**
     * Get sections
     *
     * These sections come under no panel. Each section
     * comprises its settings.
     *
     * @since 0.1.0
     * @access protected
     *
     * @return array Sections.
     */
    protected function sections(): array
    {
        $sections = [];

        $sections['title'] = new Title\Title($this);
        $sections['layout'] = new Layout\Layout($this);
        $sections['colophon'] = new Colophon\Colophon($this);

        return $sections;
    }
    
    /**
     * Add panels
     *
     * @param WP_Customizer $wp_customize
     *
     * @since 0.1.0
     * @access protected
     */
    protected function addPanels(WP_Customizer $wp_customize)
    {
        if (!($panels = $this->panels())) {
            return;
        }

        foreach ($panels as $panel) {
            $panel->add($wp_customize);
        }
    }

    /**
     * Add sections
     *
     * @param WP_Customizer $wp_customize
     *
     * @since 0.1.0
     * @access protected
     */
    protected function addSections(WP_Customizer $wp_customize)
    {
        if (!($sections = $this->sections())) {
            return;
        }

        foreach ($sections as $section) {
            $section->add($wp_customize);
        }
    }
}
