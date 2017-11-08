<?php

/**
 * Menus
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
 * Menus
 *
 * @since 0.1.0
 */
final class Menus extends AbstractSetup
{
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        \add_action('after_setup_theme', [$this, 'register']);
        \add_action(
            'jentil_inside_header',
            [$this, 'renderHorizontalHeaderMenu']
        );
        \add_action(
            'jentil_inside_header',
            [$this, 'renderVerticalHeaderMenuToggle']
        );
        \add_action(
            'jentil_inside_header',
            [$this, 'renderVerticalHeaderMenu']
        );
        \add_action('wp_enqueue_scripts', [$this, 'enqueueJS']);
    }

    /**
     * Menus
     *
     * Register navigation menus
     *
     * @since 0.1.0
     * @access public
     *
     * @action after_setup_theme
     */
    public function register()
    {
        \register_nav_menus([
            'primary-menu' => \esc_html__('Primary menu', 'jentil'),
        ]);
    }

    /**
     * Header menu
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_inside_header
     */
    public function renderHorizontalHeaderMenu()
    {
        echo '<nav class="site-navigation horizontal">'.
            $this->skipTo('content', \esc_html__('Skip to content', 'jentil'));

            \wp_nav_menu(['theme_location' => 'primary-menu']);
        echo '</nav>';
    }

    /**
     * Header menu button
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_inside_header
     */
    public function renderVerticalHeaderMenuToggle()
    {
        $status = isset($_GET['menu']) ? \sanitize_key($_GET['menu']) : 'off';
        
        echo '<div class="menu-toggle vertical">'
           .$this->skipTo('menu-vertical', \esc_html__('Skip to menu', 'jentil'))

           .'<a class="js-mobile-menu-button hamburger" href="'.\esc_url(
               \add_query_arg(
                   ['menu' => ($status == 'off' ? 'on' : 'off')],
                   $this->jentil->utilities()->page()->URL('full')
               )
           ).'" rel="nofollow">
                <span class="fa fa fa-bars" aria-hidden="true"></span>
                <span class="menu-button-text icon-text">'.
                    \esc_html__('Menu', 'jentil').
                '</span>
            </a>
        </div>';
    }

    /**
     * Mobile header menu
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_inside_header
     */
    public function renderVerticalHeaderMenu()
    {
        $status = isset($_GET['menu']) ? \sanitize_key($_GET['menu']) : 'off';
        
        echo '<nav id="menu-vertical" class="js-mobile-menu site-navigation vertical"'.
            ($status == 'off' ? ' style="display:none;"' : '').
        '>'.
            $this->skipTo('content', \esc_html__('Skip to content', 'jentil'));
            \get_search_form();
            \wp_nav_menu(['theme_location' => 'primary-menu']);
        echo '</nav>';
    }

    /**
     * Enqueue JS
     *
     * @since 0.1.0
     * @access public
     *
     * @action wp_enqueue_scripts
     */
    public function enqueueJS()
    {
        \wp_enqueue_script(
            'jentil-menu',
            $this->jentil->utilities()->fileSystem()->scriptsDir(
                'url',
                '/menu.min.js'
            ),
            ['jquery'],
            '',
            true
        );
    }

    /**
     * Skip to some location
     *
     * For screen readers
     *
     * @param string $location ID of element to skip to.
     * @param string $title Anchor link text
     *
     * @since 0.1.0
     * @access private
     *
     * @action jentil_inside_header
     */
    private function skipTo(string $location, string $title = ''): string
    {
        return '<a class="screen-reader-text skip-link" href="#'.
            \sanitize_title($location).
        '">'.
           \sanitize_text_field($title).
        '</a>';
    }
}
