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

        $this->setName($post_type, $post);
        $this->setThemeModArgs($post_type, $post);
        $this->setArgs($post_type, $post);
    }

    private function setName(WP_Post_Type $post_type, WP_Post $post = null)
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

    /**
     * @return Settings\AbstractSetting[string]
     */
    protected function settings(): array
    {
        $settings = parent::settings();

        unset(
            $settings['StickyPosts'],
            $settings['Heading'],
            $settings['Number'],
            $settings['WrapClass'],
            $settings['WrapClass'],
            $settings['Layout'],
            $settings['TitleWords'],
            $settings['TitlePosition'],
            $settings['Excerpt'],
            $settings['Image'],
            $settings['ImageAlignment'],
            $settings['ImageMargin'],
            $settings['TextOffset'],
            $settings['MoreText'],
            $settings['Pagination'],
            $settings['PaginationMaximum'],
            $settings['PaginationPosition'],
            $settings['PaginationPreviousText'],
            $settings['PaginationNextText']
        );

        return $settings;
    }
}
