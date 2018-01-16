<?php

/**
 * Footer
 *
 * @package GrottoPress\Jentil\Setups\Views
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use GrottoPress\WordPress\SUV\Setups\AbstractSetup;

/**
 * Footer
 *
 * @since 0.1.0
 */
final class Footer extends AbstractSetup
{
    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        \add_action('jentil_inside_footer', [$this, 'renderWidgets']);
        \add_action('jentil_inside_footer', [$this, 'renderColophon']);
    }

    /**
     * Render widgets
     *
     * Render the footer widget area
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_inside_footer
     */
    public function renderWidgets()
    {
        if (!\is_active_sidebar('footer-widget-area')) {
            return;
        } ?>

        <aside id="footer-widget-area" class="widget-area">
            <?php \dynamic_sidebar('footer-widget-area'); ?>
        </aside><!-- .widget-area -->
    <?php }

    /**
     * Render colophon
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_inside_footer
     */
    public function renderColophon()
    {
        if (!($mod = $this->app->utilities->colophon->themeMod()->get())
            && !$this->app->utilities->page->is('customize_preview')
        ) {
            return;
        }

        echo '<div id="colophon"><small>'.$mod.'</small></div><!-- #colophon -->';
    }
}
