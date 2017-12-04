<?php

/**
 * Main Menu
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
 * Main Menu
 *
 * @since 0.1.0
 */
final class Menu extends AbstractSetup
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
        \add_action('wp_enqueue_scripts', [$this, 'enqueueJS']);
        \add_action(
            'jentil_inside_header',
            [$this, 'renderToggle']
        );
        \add_action(
            'jentil_inside_header',
            [$this, 'render']
        );
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
     * Render header menu button
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_inside_header
     */
    public function renderToggle()
    {
        echo '<div class="menu-toggle">'
           .$this->skipTo('main-menu', \esc_html__('Skip to menu', 'jentil'))

           .'<a class="js-main-menu-button hamburger" href="'.\esc_url(
               \add_query_arg(
                   ['menu' => ($this->status() === 'off' ? 'on' : 'off')],
                   $this->theme->utilities->page->URL('full')
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
     * Render header menu
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_inside_header
     */
    public function render()
    {
        echo '<nav id="main-menu" class="js-main-menu site-navigation '.
        $this->status().'">'.
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
            $this->theme->utilities->fileSystem->scriptsDir(
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

    /**
     * Status
     *
     * @since 0.1.0
     * @access private
     *
     * @return string 'on' or 'off
     */
    private function status(): string
    {
        return (isset($_GET['menu']) ? \sanitize_key($_GET['menu']) : 'off');
    }
}
