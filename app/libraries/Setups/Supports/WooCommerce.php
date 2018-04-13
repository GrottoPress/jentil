<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Supports;

use GrottoPress\Jentil\Setups\AbstractSetup;
use WooCommerce as WooCommercePlugin;
use WC_Template_Loader as WooCommerceLoader;
use WP_Customize_Manager as WPCustomizer;

final class WooCommerce extends AbstractSetup
{
    public function run()
    {
        \add_action('after_setup_theme', [$this, 'loadComments']);
        \add_action('customize_register', [$this, 'removeCustomizerItems'], 20);
    }

    /**
     * @action after_setup_theme
     */
    public function loadComments()
    {
        if (!\class_exists(WooCommerceLoader::class)) {
            return;
        }

        \add_filter(
            'comments_template',
            [WooCommerceLoader::class, 'comments_template_loader']
        );
    }

    /**
     * @action customize_register
     */
    public function removeCustomizerItems(WPCustomizer $WPCustomizer)
    {
        if (!\class_exists(WooCommercePlugin::class)) {
            return;
        }

        $taxes = ['product_tag', 'product_cat'];

        foreach ($taxes as $tax) {
            $this->app->setups['Customizer\Customizer']
                ->panels['Posts\Posts']->sections["Taxonomy_{$tax}"]
                ->remove($WPCustomizer);

            $this->app->setups['Customizer\Customizer']
                ->sections['Title\Title']->settings["Taxonomy_{$tax}"]
                ->remove($WPCustomizer);
        }
    }
}
