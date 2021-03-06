<?php
namespace GrottoPress\Jentil\Setups\Customizer;

use GrottoPress\Jentil\Setups\Customizer;
use GrottoPress\Jentil\Setups\Customizer\AbstractPanel;
use WP_Customize_Manager as WPCustomizer;

final class Posts extends AbstractPanel
{
    public function __construct(Customizer $customizer)
    {
        parent::__construct($customizer);

        $this->id = 'posts';

        $this->args['title'] = \esc_html__('Posts', 'jentil');
        // $this->args['description'] = \esc_html__('Description here', 'jentil');
    }

    public function add(WPCustomizer $wp_customizer)
    {
        $this->setSections();

        parent::add($wp_customizer);
    }

    private function setSections()
    {
        $this->sections['Author'] = new Posts\Author($this);
        $this->sections['Date'] = new Posts\Date($this);
        $this->sections['Search'] = new Posts\Search($this);

        if ($taxonomies = $this->customizer->app->utilities
            ->page->posts->taxonomies()
        ) {
            foreach ($taxonomies as $taxonomy) {
                $this->sections["Taxonomy_{$taxonomy->name}"] =
                    new Posts\Taxonomy($this, $taxonomy);
            }
        }

        if ($post_types = $this->customizer->app->utilities
            ->page->posts->archive->postTypes()
        ) {
            foreach ($post_types as $post_type) {
                $this->sections["Sticky_{$post_type->name}"] =
                    new Posts\Sticky($this, $post_type);
                $this->sections["PostType_{$post_type->name}"] =
                    new Posts\PostType($this, $post_type);
            }
        }

        if ($post_types = $this->customizer->app->utilities
            ->page->posts->postTypes()
        ) {
            foreach ($post_types as $post_type) {
                $this->sections["Singular_{$post_type->name}"] =
                    new Posts\Singular($this, $post_type);
                $this->sections["Related_{$post_type->name}"] =
                    new Posts\Related($this, $post_type);
            }
        }
    }
}
