<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use GrottoPress\Jentil\Setups\AbstractSetup;

final class Post extends AbstractSetup
{
    public function run()
    {
        \add_action('jentil_after_title', [$this, 'renderByline']);
        \add_filter(
            'jentil_singular_after_title',
            [$this, 'byline'],
            10,
            3
        );
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

    private function _byline(int $id): string
    {
        $jentil_post = $this->app->utilities->post($id);

        $output = '';

        if ($avatar = $jentil_post->info([
            'types' => ['avatar__40']
        ])->list()) {
            $output .= $avatar;
        }

        if ($author = $jentil_post->info([
            'types' => ['author_name']
        ])->list()) {
            $output .= '<p>'.$author.'</p>';
        }

        $output .= '<p>'.$jentil_post->info([
            'types' => ['published_date', 'comments_link']
        ])->list().'</p>';

        return $output;
    }
}
