<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use GrottoPress\Jentil\Setups\AbstractSetup;

final class Singular extends AbstractSetup
{
    public function run()
    {
        \add_filter('body_class', [$this, 'addBodyClasses']);
        \add_action('jentil_after_title', [$this, 'renderByline']);
        \add_action('jentil_after_content', [$this, 'renderRelatedPosts']);
        // \add_action(
        //     'jentil_before_before_title',
        //     [$this, 'renderParentLink']
        // );
        \add_filter(
            'jentil_singular_after_title',
            [$this, 'byline'],
            10,
            3
        );
    }

    /**
     * @filter body_class
     */
    public function addBodyClasses(array $classes): array
    {
        if (!$this->app->utilities->page->is('singular')) {
            return $classes;
        }

        $post = \get_post();

        if ($parent = $post->post_parent) {
            $classes[] = \sanitize_title("child-{$post->post_type}");

            for ($i = 1; $parent; ++$i) {
                $object = \get_post($parent);

                $classes[] = \sanitize_title(
                    "{$post->post_type}-parent-{$i}-{$object->ID}"
                );

                $parent = $object->post_parent;
            }
        }

        if ($page_template = $this->app->utilities->postTypeTemplate->slug(
            $post->ID
        )) {
            $classes[] = \sanitize_title($page_template);
        }

        if (\post_type_supports($post->post_type, 'comments')) {
            $classes[] = \get_option('thread_comments')
                ? 'threaded-comments' : 'unthreaded-comments';
            $classes[] = \comments_open($post->ID)
                ? 'comments-open' : 'comments-closed';
        }

        return $classes;
    }

    /**
     * @action jentil_before_before_title
     */
    public function renderParentLink()
    {
        if (!$this->app->utilities->page->is('singular')) {
            return;
        }

        if (!($parent = \get_post()->post_parent)) {
            return;
        }

        echo '<h4 class="parent entry-title">
            <a href="'.\get_permalink($parent).'">
                <span class="meta-nav">&laquo;</span> '.
                \get_the_title($parent)
           .'</a>
        </h4>';
    }

    /**
     * @filter jentil_singular_after_title
     */
    public function byline(
        string $output,
        int $id,
        string $separator
    ): string {
        if (!$this->app->utilities->page->is('singular', 'post')) {
            return $output;
        }

        return $this->_byline($id).'<div class="self-clear"></div>';
    }

    /**
     * @action jentil_after_title
     */
    public function renderByline()
    {
        if (!$this->app->utilities->page->is('singular', 'post')) {
            return;
        }

        echo '<aside class="entry-meta after-title self-clear">';
        echo $this->_byline(\get_post()->ID);
        echo '</aside>';
    }

    /**
     * @action jentil_after_content
     */
    public function renderRelatedPosts()
    {
        if (!$this->app->utilities->page->is('singular')) {
            return;
        }

        $related = $this->app->utilities->page->posts->related;

        if (!($posts = $related->posts()->render())) {
            return;
        }

        echo '<aside id="related-posts-wrap">';

        if ($heading = $related->themeMod('heading')->get()) {
            echo '<h3 class="widget-title posts-heading">'.$heading.'</h3>';
        }

        echo $posts.'</aside>';
    }

    private function _byline(int $id): string
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
            'types' => ['published_date', 'comments_link']
        ])->list().'</p>';

        return $output;
    }
}
