<?php

/**
 * Stylesheets
 *
 * @package GrottoPress\Jentil\Setup
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup;

/**
 * Stylesheets
 *
 * @since 0.1.0
 */
final class Styles extends AbstractSetup
{
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        \add_action('wp_enqueue_scripts', [$this, 'enqueue']);
        \add_action('wp_enqueue_scripts', [$this, 'enqueueFontAwesome']);
    }
    
    /**
     * Enqueue Styles
     *
     * @since 0.1.0
     * @access public
     *
     * @action wp_enqueue_scripts
     */
    public function enqueue()
    {
        \wp_enqueue_style(
            'normalize',
            $this->jentil->utilities()->fileSystem()->themeDir(
                'url',
                '/node_modules/normalize.css/normalize.css'
            )
        );
        
        if (\is_rtl()) {
            \wp_enqueue_style(
                'jentil',
                $this->jentil->utilities()->fileSystem()->stylesDir(
                    'url',
                    '/jentil-rtl.min.css'
                ),
                ['normalize']
            );
        } else {
            \wp_enqueue_style(
                'jentil',
                $this->jentil->utilities()->fileSystem()->stylesDir(
                    'url',
                    '/jentil.min.css'
                ),
                ['normalize']
            );
        }
    }

    /**
     * Enqueue font awesome
     *
     * @since 0.1.0
     * @access public
     *
     * @action wp_enqueue_scripts
     */
    public function enqueueFontAwesome()
    {
        \wp_enqueue_style(
            'font-awesome',
            $this->jentil->utilities()->fileSystem()->themeDir(
                'url',
                '/node_modules/font-awesome/css/font-awesome.min.css'
            ),
            ['normalize']
        );
    }
}
