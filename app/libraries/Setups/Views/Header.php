<?php

/**
 * Header
 *
 * @package GrottoPress\Jentil\Setups\Views
 * @since 0.6.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use GrottoPress\WordPress\SUV\Setups\AbstractSetup;

/**
 * Header
 *
 * @since 0.6.0
 */
final class Header extends AbstractSetup
{
    /**
     * Run setup
     *
     * @since 0.6.0
     * @access public
     */
    public function run()
    {
        \add_action(
            'jentil_inside_header',
            [$this, 'renderMenuToggle']
        );
        \add_action(
            'jentil_inside_header',
            [$this, 'renderMenu']
        );
    }

    /**
     * Render header menu button
     *
     * @since 0.6.0
     * @access public
     *
     * @action jentil_inside_header
     */
    public function renderMenuToggle()
    {
        echo '<div class="menu-toggle">'.
            $this->menuSkipTo(
                'primary-menu',
                \esc_html__('Skip to menu', 'jentil')
            ).

            '<a class="js-main-menu-button hamburger" href="'.\esc_url(
                \add_query_arg(
                    [
                        'menu' => (
                            $this->menuStatus() === 'hide' ? 'show' : 'hide'
                        )
                    ],
                    $this->app->utilities->page->URL('full')
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
     * @since 0.6.0
     * @access public
     *
     * @action jentil_inside_header
     */
    public function renderMenu()
    {
        echo '<nav id="primary-menu" class="js-main-menu site-navigation '.
        $this->menuStatus().'">'.
            $this->menuSkipTo('main', \esc_html__('Skip to content', 'jentil'));
            \get_search_form();
            \wp_nav_menu(['theme_location' => 'primary-menu']);
        echo '</nav>';
    }

    /**
     * Skip to some location
     *
     * For screen readers
     *
     * @param string $location ID of element to skip to.
     * @param string $title Anchor link text
     *
     * @since 0.6.0
     * @access private
     *
     * @action jentil_inside_header
     */
    private function menuSkipTo(string $location, string $title = ''): string
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
     * @since 0.6.0
     * @access private
     *
     * @return string 'show' or 'hide'
     */
    private function menuStatus(): string
    {
        return (isset($_GET['menu']) ? \sanitize_key($_GET['menu']) : 'hide');
    }
}
