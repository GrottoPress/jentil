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
        \add_action('wp', [$this, 'removeSingularViews']);
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
    public function removeCustomizerItems(WPCustomizer $wp_customizer)
    {
        if (!\class_exists(WooCommercePlugin::class)) {
            return;
        }

        $taxes = ['product_tag', 'product_cat'];

        $related_page_active_cb = $this->app->setups['Customizer']
            ->panels['Posts']->sections['Related_page']
            ->get($wp_customizer)->active_callback;

        $single_page_active_cb = $this->app->setups['Customizer']
            ->panels['Posts']->sections['Singular_page']
            ->get($wp_customizer)->active_callback;

        foreach ($taxes as $tax) {
            $this->app->setups['Customizer']
                ->panels['Posts']->sections["Taxonomy_{$tax}"]
                ->remove($wp_customizer);

            $this->app->setups['Customizer']
                ->sections['Title']->settings["Taxonomy_{$tax}"]
                ->remove($wp_customizer);
        }

        $this->app->setups['Customizer']
            ->panels['Posts']->sections['Related_product']
            ->remove($wp_customizer);

        $this->app->setups['Customizer']
            ->panels['Posts']->sections['Singular_product']
            ->remove($wp_customizer);

        $this->app->setups['Customizer']
            ->panels['Posts']->sections['Singular_page']
            ->get($wp_customizer)->active_callback =
                function () use ($single_page_active_cb): bool {
                    return !$this->isWooCommercePage() &&
                        (bool)$single_page_active_cb();
                };

        $this->app->setups['Customizer']
            ->panels['Posts']->sections['Related_page']
            ->get($wp_customizer)->active_callback =
                function () use ($related_page_active_cb): bool {
                    return !$this->isWooCommercePage() &&
                        (bool)$related_page_active_cb();
                };
    }

    /**
     * @action wp
     */
    public function removeSingularViews()
    {
        if (!\class_exists(WooCommercePlugin::class)) {
            return;
        }

        if (!$this->isWooCommercePage()) {
            return;
        }

        \remove_action(
            'jentil_before_title',
            [$this->app->setups['Views\Singular'], 'renderPostsBeforeTitle']
        );

        \remove_action(
            'jentil_after_title',
            [$this->app->setups['Views\Singular'], 'renderPostsAfterTitle']
        );

        \remove_action(
            'jentil_after_content',
            [$this->app->setups['Views\Singular'], 'renderPostsAfterContent']
        );

        \remove_action(
            'jentil_after_content',
            [$this->app->setups['Views\Singular'], 'renderRelatedPosts']
        );
    }

    private function isWooCommercePage(): bool
    {
        return \is_product() ||
            \is_shop() ||
            \is_cart() ||
            \is_checkout() ||
            \is_account_page();
    }
}
