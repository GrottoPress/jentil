<?php

/**
 * Customizer
 *
 * @package GrottoPress\Jentil\Setups\Customizer
 * @since 0.1.0
 *
 * @see https://code.tutsplus.com/series/a-guide-to-the-wordpress-theme-customizer--wp-33722
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer;

use GrottoPress\WordPress\SUV\Setups\Customizer\AbstractCustomizer;
use WP_Customize_Manager as WPCustomizer;

/**
 * Customizer
 *
 * @since 0.1.0
 */
final class Customizer extends AbstractCustomizer
{
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        parent::run();
        
        \add_action('customize_preview_init', [$this, 'enqueueJS']);
        \add_action('customize_preview_init', [$this, 'enqueueInlineJS']);
        \add_action('after_setup_theme', [$this, 'enableSelectiveRefresh']);
    }

    /**
     * Register theme customizer
     *
     * @param WPCustomizer $WPCustomizer
     *
     * @action customize_register
     *
     * @since 0.5.0
     * @access public
     */
    public function register(WPCustomizer $WPCustomizer)
    {
        $this->sections['Title\Title'] = new Title\Title($this);
        $this->sections['Layout\Layout'] = new Layout\Layout($this);
        $this->sections['Colophon\Colophon'] = new Colophon\Colophon($this);
        
        $this->panels['Posts\Posts'] = new Posts\Posts($this);
        
        parent::register($WPCustomizer);
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
            $this->app->utilities->fileSystem->scriptsDir(
                'url',
                '/customize-preview.min.js'
            ),
            ['jquery', 'customize-preview'],
            '',
            true
        );
    }

    /**
     * Enqueue Inlne JavaScript
     *
     * @action customize_preview_init
     *
     * @since 0.1.0
     * @access public
     *
     * @todo Find out how to get page type in customizer.
     */
    public function enqueueInlineJS()
    {
        $script = 'var shortTags = '.\json_encode(
            $this->app->utilities->shortTags->get()
        ).';
        var colophonModName = "'.$this->sections['Colophon\Colophon']
            ->settings['Colophon']->name.'";';

        $titles = [];

        foreach ($this->sections['Title\Title']->settings as $setting) {
            $titles[] = $setting->name;
        }

        $script .= 'var titleModNames = '.\json_encode($titles).';';

        \wp_add_inline_script('jentil-customizer', $script, 'before');
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
}
