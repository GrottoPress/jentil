<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use GrottoPress\Jentil\Setups\AbstractSetup;

final class Singular extends AbstractSetup
{
    public function run()
    {
        \add_filter('body_class', [$this, 'addBodyClasses']);
        \add_filter('jentil_byline', [$this, 'renderByline'], 10, 3);

        \add_action('jentil_before_title', [$this, 'renderPostsBeforeTitle']);
        \add_action('jentil_after_title', [$this, 'renderPostsAfterTitle']);
        \add_action('jentil_after_content', [$this, 'renderPostsAfterContent']);
        \add_action('jentil_after_content', [$this, 'renderRelatedPosts']);
        \add_action('jentil_after_after_content', [$this, 'loadComments']);
        // \add_action(
        //     'jentil_before_before_title',
        //     [$this, 'renderParentLink']
        // );
    }

    /**
     * @filter body_class
     * @param string[] $classes
     * @return string[]
     */
    public function addBodyClasses(array $classes): array
    {
        if (!$this->app->utilities->page->is('singular')) {
            return $classes;
        }

        $post = \get_post();

        if ($parent = $post->post_parent) {
            $classes[] = \sanitize_html_class("child-{$post->post_type}");

            for ($i = 1; $parent; ++$i) {
                $object = \get_post($parent);

                $classes[] = \sanitize_html_class(
                    "{$post->post_type}-parent-{$i}-{$object->ID}"
                );

                $parent = $object->post_parent;
            }
        }

        if ($page_template = $this->app->utilities->postTypeTemplate->slug(
            $post->ID
        )) {
            $classes[] = \sanitize_html_class("template-{$page_template}");
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
     * @action jentil_before_title
     */
    public function renderPostsBeforeTitle()
    {
        if (!$this->app->utilities->page->is('singular')) {
            return;
        }

        if ($info = $this->app->utilities->post()->info([
            'types' => \explode(
                ',',
                $this->app->utilities->page->posts->singular
                    ->themeMod('before_title')->get()
            ),
            'separator' => $this->app->utilities->page->posts->singular
                ->themeMod('before_title_separator')->get(),
        ])->list()) {
            echo '<div class="entry-meta before-title">'.$info.'</div>';
        }
    }

    /**
     * @action jentil_after_title
     */
    public function renderPostsAfterTitle()
    {
        if (!$this->app->utilities->page->is('singular')) {
            return;
        }

        if ($info = $this->app->utilities->post()->info([
            'types' => \explode(
                ',',
                $this->app->utilities->page->posts->singular
                    ->themeMod('after_title')->get()
            ),
            'separator' => $this->app->utilities->page->posts->singular
                ->themeMod('after_title_separator')->get(),
        ])->list()) {
            echo '<div class="entry-meta after-title">'.$info.'</div>';
        }
    }

    /**
     * @action jentil_after_content
     */
    public function renderPostsAfterContent()
    {
        if (!$this->app->utilities->page->is('singular')) {
            return;
        }

        if ($info = $this->app->utilities->post()->info([
            'types' => \explode(
                ',',
                $this->app->utilities->page->posts->singular
                    ->themeMod('after_content')->get()
            ),
            'separator' => $this->app->utilities->page->posts->singular
                ->themeMod('after_content_separator')->get(),
        ])->list()) {
            echo '<div class="entry-meta after-content">'.$info.'</div>';
        }
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
            echo '<h3 class="posts-heading">'.$heading.'</h3>';
        }

        echo $posts.'</aside>';
    }

    /**
     * @filter jentil_byline
     */
    public function renderByline(string $output, int $id, string $sep): string
    {
        $output = '';

        if (!$this->app->utilities->page->is('singular')) {
            return $output;
        }

        if (\get_post()->ID !== $id) {
            return $output;
        }

        $post = $this->app->utilities->post($id);

        if ($avatar = $post->info(['types' => ['avatar__40']])->list()) {
            $output .= "<p>{$avatar}</p>";
        }

        if ($author = $post->info(['types' => ['author_name']])->list()) {
            $output .= "<p>{$author}</p>";
        }

        $output .= "<p>{$post->info([
            'types' => ['published_date', 'comments_link'],
            'separator' => $sep,
        ])->list()}</p>";

        return $output;
    }

    /**
     * @action jentil_after_after_content
     */
    public function loadComments()
    {
        if (!$this->app->utilities->page->is('singular')) {
            return;
        }

        $this->app->utilities->loader->loadComments();
    }
}
