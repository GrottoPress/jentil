<?php

/**
 * Customizer
 *
 * @package GrottoPress\Jentil\Setup\Customizer
 * @since 0.1.0
 *
 * @see https://code.tutsplus.com/series/a-guide-to-the-wordpress-theme-customizer--wp-33722
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup\Customizer;

use GrottoPress\Jentil\Setup\Setup;
use GrottoPress\Jentil\Jentil;
use \WP_Customize_Manager as WP_Customizer;

/**
 * Customizer
 *
 * @since 0.1.0
 */
final class Customizer extends Setup
{
    /**
     * Post types
     *
     * @since 0.1.0
     * @access private
     *
     * @var array $post_types Post types.
     */
    private $post_types = null;

    /**
     * Archive Post types
     *
     * @since 0.1.0
     * @access private
     *
     * @var array $archive_post_types All post types with archive.
     */
    private $archive_post_types = null;

    /**
     * Taxonomies
     *
     * @since 0.1.0
     * @access private
     *
     * @var array $taxonomies Taxonomies.
     */
    private $taxonomies = null;

    /**
     * Jentil
     *
     * @since 0.1.0
     * @access public
     *
     * @return Jentil Jentil.
     */
    public function jentil(): Jentil
    {
        return $this->jentil;
    }

    /**
     * Get post types
     *
     * @since 0.1.0
     * @access public
     *
     * @return array Public post types.
     */
    public function postTypes(): array
    {
        if (null === $this->post_types) {
            $this->post_types = \get_post_types(['public' => true], 'objects');
        }

        return $this->post_types;
    }

    /**
     * Get taxonomies
     *
     * @since 0.1.0
     * @access public
     *
     * @return array Public taxonomies.
     */
    public function taxonomies(): array
    {
        if (null === $this->taxonomies) {
            $this->taxonomies = \get_taxonomies(['public' => true], 'objects');
        }

        return $this->taxonomies;
    }

    /**
     * Get archive post types
     *
     * @since 0.1.0
     * @access public
     *
     * @return array All post types with archive.
     */
    public function archivePostTypes(): array
    {
        if (null === $this->archive_post_types) {
            if (($post_types = $this->postTypes())) {
                foreach ($post_types as $post_type) {
                    if (\get_post_type_archive_link($post_type->name)) {
                        $this->archive_post_types[$post_type->name] = $post_type;
                    }
                }
            }
        }

        return $this->archive_post_types;
    }

    /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        \add_action('customize_register', [$this, 'register']);
        \add_action('customize_preview_init', [$this, 'enqueueJS']);
        \add_action('after_setup_theme', [$this, 'enableSelectiveRefresh']);
    }

    /**
     * Register theme customizer
     *
     * @param WP_Customizer $wp_customize
     *
     * @action customize_register
     *
     * @since 0.1.0
     * @access public
     */
    public function register(WP_Customizer $wp_customize)
    {
        $this->addPanels($wp_customize);
        $this->addSections($wp_customize);
    }

    /**
     * Enqueue JS
     *
     * @action customize_preview_init
     *
     * @since 0.1.0
     * @access public
     */
    public function enqueueJS()
    {
        \wp_enqueue_script(
            'jentil-customizer',
            $this->jentil->utilities()->filesystem()->scriptsDir(
                'url',
                '/customize-preview.min.js'
            ),
            ['jquery', 'customize-preview'],
            '',
            true
        );
    }

    /**
     * Selective refresh
     *
     * Add selective refresh support to elements
     * in the customizer.
     *
     * @see https://make.wordpress.org/core/2016/03/22/implementing-selective-refresh-support-for-widgets/
     *
     * @since 0.1.0
     * @access public
     *
     * @action after_setup_theme
     */
    public function enableSelectiveRefresh()
    {
        \add_theme_support('customize-selective-refresh-widgets');
    }

    /**
     * Get panels
     *
     * Panels comprise sections which, in turn,
     * comprise settings.
     *
     * @since 0.1.0
     * @access private
     *
     * @return array Panels.
     */
    private function panels(): array
    {
        $panels = [];

        $panels['posts'] = new Posts\Posts($this);

        return $panels;
    }

    /**
     * Get sections
     *
     * These sections come under no panel. Each section
     * comprises its settings.
     *
     * @since 0.1.0
     * @access private
     *
     * @return array Sections.
     */
    private function sections(): array
    {
        $sections = [];

        $sections['title'] = new Title\Title($this);
        $sections['layout'] = new Layout\Layout($this);
        $sections['colophon'] = new Colophon\Colophon($this);

        return $sections;
    }
    
    /**
     * Add panels
     *
     * @param WP_Customizer $wp_customize
     *
     * @since 0.1.0
     * @access private
     */
    private function addPanels(WP_Customizer $wp_customize)
    {
        if (!($panels = $this->panels())) {
            return;
        }

        foreach ($panels as $panel) {
            $panel->add($wp_customize);
        }
    }

    /**
     * Add sections
     *
     * @param WP_Customizer $wp_customize
     *
     * @since 0.1.0
     * @access private
     */
    private function addSections(WP_Customizer $wp_customize)
    {
        if (!($sections = $this->sections())) {
            return;
        }

        foreach ($sections as $section) {
            $section->add($wp_customize);
        }
    }
}
