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

        $this->args = [
            'title' => \esc_html__('Posts', 'jentil'),
            // 'description' => \esc_html__('Description here', 'jentil'),
        ];
    }

    /**
     * Get sections
     *
     * @since 0.1.0
     * @access protected
     *
     * @return array Sections.
     */
    protected function sections(): array
    {
        $sections = [];

        $sections['author'] = new Author($this);
        $sections['date'] = new Date($this);
        $sections['search'] = new Search($this);

        if (($taxonomies = $this->customizer->jentil()->utilities()
            ->page()->posts()->taxonomies())
        ) {
            foreach ($taxonomies as $taxonomy) {
                $sections['taxonomy_'.$taxonomy->name] = new Taxonomy(
                    $this,
                    $taxonomy
                );
            }
        }

        if (($post_types = $this->customizer->jentil()->utilities()
            ->page()->posts()->archive()->postTypes())
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
