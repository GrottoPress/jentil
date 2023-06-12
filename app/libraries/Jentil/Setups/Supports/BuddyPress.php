<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Supports;

use GrottoPress\Jentil\Setups\AbstractSetup;
use BuddyPress as BuddyPressPlugin;
use WP_Customize_Manager as WPCustomizer;

final class BuddyPress extends AbstractSetup
{
    public function run()
    {
        \add_action('customize_register', [$this, 'removeCustomizerItems'], 20);
        \add_action('wp', [$this, 'removeSingularViews']);
    }

    /**
     * @action customize_register
     */
    public function removeCustomizerItems(WPCustomizer $wp_customizer)
    {
        if (!\class_exists(BuddyPressPlugin::class)) {
            return;
        }

        $related_page_active_cb = $this->app->setups['Customizer']
            ->panels['Posts']->sections['Related_page']
            ->get($wp_customizer)->active_callback;

        $single_page_active_cb = $this->app->setups['Customizer']
            ->panels['Posts']->sections['Singular_page']
            ->get($wp_customizer)->active_callback;

        $this->app->setups['Customizer']
            ->panels['Posts']->sections['Singular_page']
            ->get($wp_customizer)->active_callback =
                function () use ($single_page_active_cb): bool {
                    return !$this->isBuddyPressPage() &&
                        (bool)$single_page_active_cb();
                };

        $this->app->setups['Customizer']
            ->panels['Posts']->sections['Related_page']
            ->get($wp_customizer)->active_callback =
                function () use ($related_page_active_cb): bool {
                    return !$this->isBuddyPressPage() &&
                        (bool)$related_page_active_cb();
                };
    }

    /**
     * @action wp
     */
    public function removeSingularViews()
    {
        if (!\class_exists(BuddyPressPlugin::class)) {
            return;
        }

        if (!$this->isBuddyPressPage()) {
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

    private function isBuddyPressPage(): bool
    {
        return \is_buddypress();
    }
}
