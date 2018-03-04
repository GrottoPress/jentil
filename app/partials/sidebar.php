<?php
declare (strict_types = 1);

if ('one-column' === (
    $column = \Jentil()->utilities->page->layout->column()
)) {
    return;
}

/**
 * Primary Sidebar
 */
if (\is_active_sidebar(
    $primary = \Jentil()->setups['Sidebars\Primary']->id
)) { ?>
    <div id="primary-sidebar-wrap" class="sidebar-wrap">
        <aside id="primary-sidebar" class="site-sidebar widget-area" itemscope itemtype="http://schema.org/WPSideBar">
            <?php \dynamic_sidebar($primary); ?>
        </aside><!-- #primary -->
    </div>
<?php }

/**
 * Secondary sidebar
 */
if ('three-columns' === $column) {
    if (\is_active_sidebar(
        $secondary = \Jentil()->setups['Sidebars\Secondary']->id
    )) { ?>
        <div id="secondary-sidebar-wrap" class="sidebar-wrap">
            <aside id="secondary-sidebar" class="site-sidebar widget-area" itemscope itemtype="http://schema.org/WPSideBar">
                <?php \dynamic_sidebar($secondary); ?>
            </aside><!-- #secondary -->
        </div>
    <?php }
}
