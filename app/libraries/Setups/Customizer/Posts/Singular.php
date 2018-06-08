<?php
namespace GrottoPress\Jentil\Setups\Customizer\Posts;

use WP_Post_Type;
use WP_Post;

final class Singular extends AbstractSection
{
    public function __construct(
        Posts $posts,
        WP_Post_Type $post_type,
        WP_Post $post = null
    ) {
        parent::__construct($posts);

        $this->setID($post_type, $post);
        $this->setThemeModArgs($post_type, $post);
        $this->setArgs($post_type, $post);
    }

    private function setID(WP_Post_Type $post_type, WP_Post $post = null)
    {
        if ($post) {
            $this->id = \sanitize_key(
                "singular_{$post_type->name}_{$post->term_id}_posts"
            );
        } else {
            $this->id = \sanitize_key("singular_{$post_type->name}_posts");
        }
    }

    private function setThemeModArgs(
        WP_Post_Type $post_type,
        WP_Post $post = null
    ) {
        $this->themeModArgs['context'] = 'singular';
        $this->themeModArgs['specific'] = $post_type->name;
        $this->themeModArgs['more_specific'] = ($post ? $post->ID : 0);
    }

    private function setArgs(WP_Post_Type $post_type, WP_Post $post = null)
    {
        $this->args['active_callback'] = function () use (
            $post_type,
            $post
        ): bool {
            $utilities = $this->customizer->app->utilities;

            if ($utilities->postTypeTemplate->isPageBuilder()) {
                return false;
            }

            if ($post) {
                return (
                    $utilities->page->is('page', $post->ID) ||
                    $utilities->page->is('single', $post->ID) ||
                    $utilities->page->is('attachment', $post->ID)
                );
            }

            return $utilities->page->is('singular', $post_type->name);
        };

        if ($post) {
            $this->args['title'] = \sprintf(
                \esc_html__('Single %1$s: %2$s', 'jentil'),
                $post_type->labels->singular_name,
                $post->post_title
            );
        } else {
            $this->args['title'] = \sprintf(
                \esc_html__('Single %s', 'jentil'),
                $post_type->labels->singular_name
            );
        }
    }

    protected function setSettings()
    {
        parent::setSettings();

        unset(
            $this->settings['StickyPosts'],
            $this->controls['StickyPosts'],
            $this->settings['Heading'],
            $this->controls['Heading'],
            $this->settings['Number'],
            $this->controls['Number'],
            $this->settings['WrapClass'],
            $this->controls['WrapClass'],
            $this->settings['WrapTag'],
            $this->controls['WrapTag'],
            $this->settings['Layout'],
            $this->controls['Layout'],
            $this->settings['TitleWords'],
            $this->controls['TitleWords'],
            $this->settings['TitlePosition'],
            $this->controls['TitlePosition'],
            $this->settings['Excerpt'],
            $this->controls['Excerpt'],
            $this->settings['Image'],
            $this->controls['Image'],
            $this->settings['ImageAlignment'],
            $this->controls['ImageAlignment'],
            $this->settings['ImageMargin'],
            $this->controls['ImageMargin'],
            $this->settings['TextOffset'],
            $this->controls['TextOffset'],
            $this->settings['MoreText'],
            $this->controls['MoreText'],
            $this->settings['Pagination'],
            $this->controls['Pagination'],
            $this->settings['PaginationMaximum'],
            $this->controls['PaginationMaximum'],
            $this->settings['PaginationPosition'],
            $this->controls['PaginationPosition'],
            $this->settings['PaginationPreviousText'],
            $this->controls['PaginationPreviousText'],
            $this->settings['PaginationNextText'],
            $this->controls['PaginationNextText']
        );
    }
}
