<?php
declare (strict_types = 1);

if ('columns-1' === ($column = \Jentil()->utilities->page->layout->column()) &&
    !\Jentil()->utilities->page->is('customize_preview')
) {
    return;
}

/**
 * Primary Sidebar
 */
if (\is_active_sidebar($id = \Jentil()->setups['Sidebars\Primary']->id)) { ?>
    <aside id="primary-sidebar" class="site-sidebar widget-area" itemscope itemtype="http://schema.org/WPSideBar">
        <?php \dynamic_sidebar($id); ?>
    </aside><!-- #primary -->
<?php }

if ('columns-3' !== $column &&
    !\Jentil()->utilities->page->is('customize_preview')
) {
    return;
}

/**
 * Secondary sidebar
 */
if (\is_active_sidebar($id = \Jentil()->setups['Sidebars\Secondary']->id)) { ?>
    <aside id="secondary-sidebar" class="site-sidebar widget-area" itemscope itemtype="http://schema.org/WPSideBar">
        <?php \dynamic_sidebar($id); ?>
    </aside><!-- #secondary -->
<?php }
