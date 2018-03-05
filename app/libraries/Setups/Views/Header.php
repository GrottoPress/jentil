<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use GrottoPress\Jentil\Setups\AbstractSetup;

final class Header extends AbstractSetup
{
    public function run()
    {
        \add_action('jentil_inside_header', [$this, 'renderMenuToggle']);
        \add_action('jentil_inside_header', [$this, 'renderMenu']);
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
     * @action jentil_inside_header
     */
    public function renderMenu()
    {
        echo '<nav id="primary-menu" class="js-main-menu site-navigation '.
        $this->menuStatus().'">';
            \get_search_form();

            echo $this->menuSkipTo(
                'main',
                \esc_html__('Skip to content', 'jentil')
            );

            \wp_nav_menu([
                'theme_location' => $this->app->setups['Menus\Primary']->id,
            ]);
        echo '</nav>';
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
    private function menuStatus(): string
    {
        return (isset($_GET['menu']) ? \sanitize_key($_GET['menu']) : 'hide');
    }
}
