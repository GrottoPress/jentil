<?php
namespace GrottoPress\Jentil\Setups\Customizer\Posts;

use GrottoPress\Jentil\Setups\Customizer\Customizer;
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
        $this->sections['Author'] = new Author($this);
        $this->sections['Date'] = new Date($this);
        $this->sections['Search'] = new Search($this);

        if ($taxonomies = $this->customizer->app->utilities
            ->page->posts->taxonomies()
        ) {
            foreach ($taxonomies as $taxonomy) {
                $this->sections["Taxonomy_{$taxonomy->name}"] = new Taxonomy(
                    $this,
                    $taxonomy
                );
            }
        }

        if ($post_types = $this->customizer->app->utilities
            ->page->posts->archive->postTypes()
        ) {
            foreach ($post_types as $post_type) {
                $this->sections["Sticky_{$post_type->name}"] = new Sticky(
                    $this,
                    $post_type
                );
                $this->sections["PostType_{$post_type->name}"] = new PostType(
                    $this,
                    $post_type
                );
            }
        }

        if ($post_types = $this->customizer->app->utilities
            ->page->posts->postTypes()
        ) {
            foreach ($post_types as $post_type) {
                $this->sections["Singular_{$post_type->name}"] =
                    new Singular($this, $post_type);
                $this->sections["Related_{$post_type->name}"] =
                    new Related($this, $post_type);
            }
        }
    }
}
