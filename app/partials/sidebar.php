<?php

/**
 * Sidebar Template
 *
 * This contains code that would be included in
 * other templates via the `\get_sidebar()` call.
 *
 * @package GrottoPress\Jentil
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

/**
 * Do not show sidebars if page layout is one column
 *
 * @since 0.1.0
 */
if ('one-column' === (
    $column = \Jentil()->utilities->page->layout->column()
)) {
    return;
}

/**
 * Primary Sidebar
 *
 * @since 0.1.0
 */
if (\is_active_sidebar('primary-widget-area')) { ?>
    <div id="primary-sidebar-wrap" class="sidebar-wrap">
        <aside id="primary-sidebar" class="site-sidebar widget-area" itemscope itemtype="http://schema.org/WPSideBar">
            <?php \dynamic_sidebar('primary-widget-area'); ?>
        </aside><!-- #primary -->
    </div>
<?php }

/**
 * Secondary sidebar
 *
 * @since 0.1.0
 */
if ('three-columns' === $column) {
    if (\is_active_sidebar('secondary-widget-area')) { ?>
        <div id="secondary-sidebar-wrap" class="sidebar-wrap">
            <aside id="secondary-sidebar" class="site-sidebar widget-area" itemscope itemtype="http://schema.org/WPSideBar">
                <?php \dynamic_sidebar('secondary-widget-area'); ?>
            </aside><!-- #secondary -->
        </div>
    <?php }
}
