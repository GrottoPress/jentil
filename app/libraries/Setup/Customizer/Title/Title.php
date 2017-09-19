<?php

/**
 * Title Section
 *
 * @package GrottoPress\Jentil\Setup\Customizer\Title
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setup\Customizer\Title;

use GrottoPress\Jentil\Setup\Customizer\Section;
use GrottoPress\Jentil\Setup\Customizer\Customizer;

/**
 * Title Section
 *
 * @since 0.1.0
 */
final class Title extends Section
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

        $this->name = 'title';
        $this->args = [
            'title' => \esc_html__('Title', 'jentil'),
            // 'description' => \esc_html__('Description here', 'jentil'),
        ];
    }

    /**
     * Get settings
     *
     * @since 0.1.0
     * @access protected
     *
     * @return array Settings.
     */
    protected function settings(): array
    {
        $settings = [];

        $settings['author'] = new Settings\Author($this);
        $settings['date'] = new Settings\Date($this);
        $settings['error_404'] = new Settings\Error404($this);
        $settings['search'] = new Settings\Search($this);

        if (($taxonomies = $this->customizer->jentil()->utilities()
            ->page()->posts()->taxonomies())
        ) {
            foreach ($taxonomies as $taxonomy) {
                $settings['taxonomy_'.$taxonomy->name] = new Settings\Taxonomy($this, $taxonomy);
            }
        }

        if (($post_types = $this->customizer->jentil()->utilities()
            ->page()->posts()->archive()->postTypes())
        ) {
            foreach ($post_types as $post_type) {
                $settings['post_type_'.$post_type->name] =
                    new Settings\PostType($this, $post_type);
            }
        }

        return $settings;
    }
}
