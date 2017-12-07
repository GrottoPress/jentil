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
        \add_action('wp_enqueue_scripts', [$this, 'enqueueNormalize']);
        \add_action('wp_enqueue_scripts', [$this, 'enqueue']);
        \add_action('wp_enqueue_scripts', [$this, 'enqueueFontAwesome']);
        \add_action('wp_enqueue_scripts', [$this, 'enqueuePosts']);
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
        if (\is_rtl()) {
            $style = '/jentil-rtl.min.css';
        } else {
            $style = '/jentil.min.css';
        }
        
        \wp_enqueue_style(
            'jentil',
            $this->theme->utilities->fileSystem->stylesDir('url', $style),
            ['normalize']
        );
    }

    /**
     * Enqueue normalize css
     *
     * @since 0.1.0
     * @access public
     *
     * @action wp_enqueue_scripts
     */
    public function enqueueNormalize()
    {
        \wp_enqueue_style(
            'normalize',
            $this->theme->utilities->fileSystem->dir(
                'url',
                '/dist/vendor/normalize.css/normalize.css'
            )
        );
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
            $this->theme->utilities->fileSystem->dir(
                'url',
                '/dist/vendor/font-awesome/css/font-awesome.min.css'
            ),
            ['normalize']
        );
    }

    /**
     * Enqueue posts package styles
     *
     * @since 0.1.0
     * @access public
     *
     * @action wp_enqueue_scripts
     */
    public function enqueuePosts()
    {
        \wp_enqueue_style(
            'wordpress-posts',
            $this->theme->utilities->fileSystem->themeDir(
                'url',
                '/vendor/grottopress/wordpress-posts/dist/styles/posts.min.css'
            ),
            ['normalize']
        );
    }
}
