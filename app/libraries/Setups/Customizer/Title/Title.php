<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Customizer\Title;

use GrottoPress\Jentil\Setups\Customizer\Customizer;
use GrottoPress\Jentil\Setups\Customizer\AbstractSection;
use WP_Customize_Manager as WPCustomizer;

final class Title extends AbstractSection
{
    public function __construct(Customizer $customizer)
    {
        parent::__construct($customizer);

        $this->id = 'title';

        $this->args['title'] = \esc_html__('Title', 'jentil');
        $this->args['description'] = \esc_html__('Description here', 'jentil');
    }

    public function add(WPCustomizer $wp_customizer)
    {
        $this->setSettings();

        parent::add($wp_customizer);
    }

    private function setSettings()
    {
        $this->settings['Author'] = new Settings\Author($this);
        $this->controls['Author'] = new Controls\Author($this);

        $this->settings['Date'] = new Settings\Date($this);
        $this->controls['Date'] = new Controls\Date($this);

        $this->settings['Error404'] = new Settings\Error404($this);
        $this->controls['Error404'] = new Controls\Error404($this);

        $this->settings['Search'] = new Settings\Search($this);
        $this->controls['Search'] = new Controls\Search($this);

        if ($taxonomies = $this->customizer->app->utilities
            ->page->posts->taxonomies()
        ) {
            foreach ($taxonomies as $taxonomy) {
                $this->settings["Taxonomy_{$taxonomy->name}"] =
                    new Settings\Taxonomy($this, $taxonomy);
                $this->controls["Taxonomy_{$taxonomy->name}"] =
                    new Controls\Taxonomy($this, $taxonomy);
            }
        }

        if ($post_types = $this->customizer->app->utilities
            ->page->posts->archive->postTypes()
        ) {
            foreach ($post_types as $post_type) {
                $this->settings["PostType_{$post_type->name}"] =
                    new Settings\PostType($this, $post_type);
                $this->controls["PostType_{$post_type->name}"] =
                    new Controls\PostType($this, $post_type);
            }
        }
    }
}
