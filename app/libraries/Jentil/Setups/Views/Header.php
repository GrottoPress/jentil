<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use GrottoPress\Jentil\Setups\AbstractSetup;
use stdClass;

final class Header extends AbstractSetup
{
    public function run()
    {
        \add_action('jentil_before_header', [$this, 'openWrapTag']);
        \add_action('jentil_inside_header', [$this, 'renderMenuToggle']);
        \add_action('jentil_inside_header', [$this, 'renderMenu']);

        \add_filter('wp_nav_menu', [$this, 'renderSearchForm'], 10, 2);
    }

    /**
     * @action jentil_before_header
     * @see Footer::closeWrapTag()
     */
    public function openWrapTag()
    {
        echo '<div id="wrap" class="site hfeed">';
    }

    /**
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
                    ['menu' => $this->toggleMenu()],
                    $this->app->utilities->page->URL('full')
                )
            ).'" rel="nofollow">
                <span class="fas fa-bars" aria-hidden="true"></span>
                <span class="menu-button-text icon-text">'.
                    \esc_html__('Menu', 'jentil').
                '</span>
            </a>
        </div>';
    }

    /**
     * @action jentil_inside_header
     */
    public function renderMenu()
    {
        echo '<div id="primary-menu" class="js-main-menu site-navigation '.
            $this->menuStatus().
        '">';
            echo $this->menuSkipTo(
                'main',
                \esc_html__('Skip to content', 'jentil')
            );

            \wp_nav_menu([
                'theme_location' => $this->app->setups['Menus\Primary']->id,
                'fallback_cb' => false,
                'container' => 'nav',
            ]);
        echo '</div>';
    }

    /**
     * @filter wp_nav_menu
     */
    public function renderSearchForm(string $menu, stdClass $args): string
    {
        if ($args->theme_location !== $this->app->setups['Menus\Primary']->id) {
            return $menu;
        }

        return \get_search_form(false).$menu;
    }

    private function menuSkipTo(string $location, string $title = ''): string
    {
        return '<a class="screen-reader-text skip-link" href="#'.
            \sanitize_title($location).
        '">'.
           \sanitize_text_field($title).
        '</a>';
    }

    /**
     * @return string 'show' or 'hide'
     */
    private function toggleMenu(): string
    {
        return ($this->menuStatus() === 'hide' ? 'show' : 'hide');
    }

    /**
     * @return string 'show' or 'hide'
     */
    private function menuStatus(): string
    {
        return \sanitize_key($_GET['menu'] ?? 'hide');
    }
}
