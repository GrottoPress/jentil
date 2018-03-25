<?php
declare (strict_types = 1);

\Jentil()->utilities->loader->loadPartial('header-shop'); ?>

<header class="woocommerce-products-header">
    <?php if (\apply_filters('woocommerce_show_page_title', true)) { ?>
        <h1 class="woocommerce-products-header__title page-title"><?php
            \woocommerce_page_title();
        ?></h1>
    <?php }

    \do_action('woocommerce_archive_description'); ?>
</header>

<?php if (\have_posts() || 'products' !== \woocommerce_get_loop_display_mode()) {
    \do_action('woocommerce_before_shop_loop');

    \woocommerce_product_loop_start();

    if (\wc_get_loop_prop('total')) {
        while (\have_posts()) {
            \the_post();

            \do_action('woocommerce_shop_loop');

            \wc_get_template_part('content', 'product');
        }
    }

    \woocommerce_product_loop_end();

    \do_action('woocommerce_after_shop_loop');
} else {
    \do_action('woocommerce_no_products_found');
}

\Jentil()->utilities->loader->loadPartial('footer-shop');
