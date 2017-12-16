<?php

/**
 * Posts Panel
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Posts
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

namespace GrottoPress\Jentil\Setup\Customizer\Posts;

use GrottoPress\Jentil\Setup\Customizer\AbstractPanel;
use GrottoPress\Jentil\Setup\Customizer\Customizer;
use WP_Customize_Manager as WP_Customizer;

/**
 * Posts Panel
 *
 * @since 0.1.0
 */
final class Posts extends AbstractPanel
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

        $this->name = 'posts';

        $this->args['title'] = \esc_html__('Posts', 'jentil');
        $this->args['description'] = \esc_html__('Description here', 'jentil');
    }

    /**
     * Add Panel
     *
     * @param WP_Customizer $wp_customize
     *
     * @since 0.1.0
     * @access public
     */
    public function add(WP_Customizer $wp_customize)
    {
        $this->sections = $this->sections();

        parent::add($wp_customize);
    }

    /**
     * Sections
     *
     * @since 0.1.0
     * @access private
     *
     * @return AbstractSection[] Sections.
     */
    private function sections(): array
    {
        $sections = [];

        $sections['author'] = new Author($this);
        $sections['date'] = new Date($this);
        $sections['search'] = new Search($this);

        if (($taxonomies = $this->customizer->theme->utilities
            ->page->posts->taxonomies())
        ) {
            foreach ($taxonomies as $taxonomy) {
                $sections['taxonomy_'.$taxonomy->name] = new Taxonomy(
                    $this,
                    $taxonomy
                );
            }
        }

        if (($post_types = $this->customizer->theme->utilities
            ->page->posts->archive->postTypes())
        ) {
            foreach ($post_types as $post_type) {
                $sections['sticky_'.$post_type->name] = new Sticky(
                    $this,
                    $post_type
                );
                $sections['post_type_'.$post_type->name] = new PostType(
                    $this,
                    $post_type
                );
            }
        }

        return $sections;
    }
}
