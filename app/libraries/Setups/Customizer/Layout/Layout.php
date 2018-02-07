<?php

/**
 * Page Layout Section
 *
 * @package GrottoPress\Jentil\Setups\Customizer\Layout
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Layout;

use GrottoPress\Jentil\Setups\Customizer\Customizer;
use GrottoPress\Jentil\Setups\Customizer\AbstractSection;
use WP_Customize_Manager as WPCustomizer;

/**
 * Page Layout Section
 *
 * @since 0.1.0
 */
final class Layout extends AbstractSection
{
    /**
     * Constructor
     *
     * @param Customizer $customizer Customizer.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct(Customizer $customizer)
    {
        parent::__construct($customizer);

        $this->name = 'layout';
        
        $this->args['title'] = \esc_html__('Layout', 'jentil');
        // $this->args['description'] = \esc_html__('Description here', 'jentil');
    }

    /**
     * Add section
     *
     * @param WPCustomizer $WPCustomizer
     *
     * @since 0.1.0
     * @access public
     */
    public function add(WPCustomizer $WPCustomizer)
    {
        $this->settings = $this->settings();

        parent::add($WPCustomizer);
    }

    /**
     * Settings
     *
     * @since 0.1.0
     * @access private
     *
     * @return Settings\AbstractSetting[] Settings.
     */
    private function settings(): array
    {
        $settings = [];

        $settings['Author'] = new Settings\Author($this);
        $settings['Date'] = new Settings\Date($this);
        $settings['Error404'] = new Settings\Error404($this);
        $settings['Search'] = new Settings\Search($this);

        if (($taxonomies = $this->customizer->app->utilities
            ->page->posts->taxonomies())
        ) {
            foreach ($taxonomies as $taxonomy) {
                $settings['Taxonomy_'.$taxonomy->name] = new Settings\Taxonomy(
                    $this,
                    $taxonomy
                );
            }
        }

        if (($post_types = $this->customizer->app->utilities
            ->page->posts->archive->postTypes())
        ) {
            foreach ($post_types as $post_type) {
                $settings['PostType_'.$post_type->name] =
                    new Settings\PostType($this, $post_type);
            }
        }

        if (($post_types = $this->customizer->app->utilities
            ->page->posts->postTypes())
        ) {
            foreach ($post_types as $post_type) {
                if (!$this->customizer->app->utilities->themeMods->layout([
                    'context' => 'singular',
                    'specific' => $post_type->name,
                ])->isPagelike()) {
                    $settings['Singular_'.$post_type->name] =
                        new Settings\Singular($this, $post_type);
                }
            }
        }

        return $settings;
    }
}
