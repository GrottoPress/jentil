<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use GrottoPress\Jentil\Setups\AbstractSetup;

final class Footer extends AbstractSetup
{
    public function run()
    {
        \add_action('jentil_inside_footer', [$this, 'renderWidgets']);
        \add_action('jentil_inside_footer', [$this, 'renderColophon']);
    }

    /**
     * @action jentil_inside_footer
     */
    public function renderWidgets()
    {
        if (!\is_active_sidebar(
            $id = $this->app->setups['Sidebars\Footer']->id
        )) {
            return;
        } ?>

        <aside id="footer-widget-area" class="widget-area">
            <?php \dynamic_sidebar($id); ?>
        </aside><!-- .widget-area -->
    <?php }

    /**
     * @action jentil_inside_footer
     */
    public function renderColophon()
    {
        if (!($mod = $this->app->utilities->colophon->themeMod()->get()) &&
            !$this->app->utilities->page->is('customize_preview')
        ) {
            return;
        }

        echo '<div id="colophon"><small>'.$mod.'</small></div><!-- #colophon -->';
    }
}
