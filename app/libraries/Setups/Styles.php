<?php

/**
 * Stylesheets
 *
 * @package GrottoPress\Jentil\Setups
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

use GrottoPress\WordPress\SUV\Setups\AbstractSetup;

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
        \add_action('wp_enqueue_scripts', [$this, 'enqueueFontAwesome']);
        \add_action('wp_enqueue_scripts', [$this, 'enqueuePosts']);
        \add_action('wp_enqueue_scripts', [$this, 'enqueue']);
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
            $style = 'jentil-rtl.min.css';
        } else {
            $style = 'jentil.min.css';
        }

        \wp_enqueue_style(
            'jentil',
            $this->app->utilities->fileSystem->dir(
                'url',
                "/dist/styles/{$style}"
            ),
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
            $this->app->utilities->fileSystem->dir(
                'url',
                '/assets/vendor/normalize.css/normalize.css'
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
            $this->app->utilities->fileSystem->dir(
                'url',
                '/assets/vendor/font-awesome/css/font-awesome.min.css'
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
            $this->app->utilities->fileSystem->dir(
                'url',
                '/assets/vendor/grottopress/wordpress-posts/dist/styles/posts.min.css'
            ),
            ['normalize']
        );
    }
}
