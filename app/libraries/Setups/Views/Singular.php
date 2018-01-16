<?php

/**
 * Singular
 *
 * @package GrottoPress\Jentil\Setups\Views
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kusi Adusei
 */

declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use GrottoPress\WordPress\SUV\Setups\AbstractSetup;

/**
 * Singular
 *
 * @since 0.1.0
 */
final class Singular extends AbstractSetup
{
   /**
     * Run setup
     *
     * @since 0.1.0
     * @access public
     */
    public function run()
    {
        \add_filter('body_class', [$this, 'addBodyClasses']);
        // \add_action(
        //     'jentil_before_before_title',
        //     [$this, 'renderParentLink']
        // );
        \add_action('jentil_before_content', [$this, 'renderAttachment']);
        \add_filter(
            'jentil_singular_after_title',
            [$this, 'byline'],
            10,
            3
        );
        \add_action('jentil_after_title', [$this, 'renderByline']);
    }

    /**
     * Add <body> classes
     *
     * @since 0.1.0
     * @access public
     *
     * @filter body_class
     */
    public function addBodyClasses(array $classes): array
    {
        if (!$this->app->utilities->page->is('singular')) {
            return $classes;
        }

        global $post;

        if (\is_post_type_hierarchical($post->post_type)) {
            if ($post->post_parent) {
                $parent_id = $post->post_parent;

                while ($parent_id) {
                    $page = \get_post($parent_id);
                    $classes[] = \sanitize_title(
                        $post->post_type.'-parent-'.$page->ID
                    );
                    $parent_id = $page->post_parent;
                }
            }
        }

        $page_template = \get_page_template_slug($post->ID);

        if ($page_template) {
            $classes[] = \sanitize_title($page_template);
        }

        if (\post_type_supports($post->post_type, 'comments')) {
            $classes[] = \get_option('show_avatars')
                ? 'show-avatars' : 'hide-avatars';
            $classes[] = \get_option('thread_comments')
                ? 'threaded-comments' : 'unthreaded-comments';
            $classes[] = \comments_open($post->ID)
                ? 'comments-open' : 'comments-closed';
        }

        return $classes;
    }

    /**
     * Post parent link
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_before_before_title
     */
    public function renderParentLink()
    {
        if (!$this->app->utilities->page->is('singular')) {
            return;
        }

        global $post;

        if (!$post->post_parent) {
            return;
        }

        echo '<h4 class="parent entry-title">
            <a href="'.\get_permalink($post->post_parent).'">
                <span class="meta-nav">&laquo;</span> '.
                \get_the_title($post->post_parent)
           .'</a>
        </h4>';
    }

    /**
     * Attachment
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_before_content
     */
    public function renderAttachment()
    {
        if (!$this->app->utilities->page->is('attachment')) {
            return;
        }

        \remove_filter('the_content', 'prepend_attachment');

        global $post;

        if (\wp_attachment_is_image($post->ID)) {
            $this->app->utilities->loader->loadPartial(
                'attachment',
                'image'
            );
        } elseif (\wp_attachment_is('audio', $post->ID)) {
            $this->app->utilities->loader->loadPartial(
                'attachment',
                'audio'
            );
        } elseif (\wp_attachment_is('video', $post->ID)) {
            $this->app->utilities->loader->loadPartial(
                'attachment',
                'video'
            );
        } else {
            $this->app->utilities->loader->loadPartial('attachment');
        }
    }

    /**
     * Byline
     *
     * Used for single posts when using the `index.php` template.
     *
     * @since 0.1.0
     * @access public
     *
     * @filter jentil_singular_after_title
     *
     * @return string
     */
    public function byline(
        string $output,
        int $id,
        string $separator
    ): string {
        if (!$this->app->utilities->page->is('singular', 'post')) {
            return $output;
        }
        
        return $this->getByline($id).'<div class="self-clear"></div>';
    }

    /**
     * Render byline
     *
     * Replicates the functionality above for when
     * using the singular.php template
     *
     * @since 0.1.0
     * @access public
     *
     * @action jentil_after_title
     */
    public function renderByline()
    {
        if (!$this->app->utilities->page->is('singular', 'post')) {
            return;
        }

        global $post;

        echo '<aside class="entry-meta after-title self-clear">';
        echo $this->getByline($post->ID);
        echo '</aside>';
    }

    /**
     * Single post after title
     *
     * @param int $id Post ID.
     *
     * @since 0.1.0
     * @access public
     *
     * @return string
     */
    private function getByline(int $id): string
    {
        $jentil_post = $this->app->utilities->post($id);

        $output = '';

        if (($avatar = $jentil_post->info([
            'types' => ['avatar__40']
        ])->list())) {
            $output .= $avatar;
        }

        if (($author = $jentil_post->info([
            'types' => ['author_name']
        ])->list())) {
            $output .= '<p>'.$author.'</p>';
        }

        $output .= '<p>'.$jentil_post->info([
            'types' => ['published_date', 'published_time', 'comments_link']
        ])->list().'</p>';

        return $output;
    }
}
