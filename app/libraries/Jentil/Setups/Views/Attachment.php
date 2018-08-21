<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use GrottoPress\Jentil\Setups\AbstractSetup;

final class Attachment extends AbstractSetup
{
    public function run()
    {
        \add_action('wp_head', [$this, 'removePrepended']);
        \add_action('jentil_before_content', [$this, 'renderAttachment']);
    }

    /**
     * @action wp_head
     */
    public function removePrepended()
    {
        if (!$this->app->utilities->page->is('attachment')) {
            return;
        }

        \remove_filter('the_content', 'prepend_attachment');
    }

    /**
     * @action jentil_before_content
     */
    public function renderAttachment()
    {
        if (!$this->app->utilities->page->is('attachment')) {
            return;
        }

        if (\wp_attachment_is_image($id = \get_post()->ID)) {
            $this->app->utilities->loader->loadPartial('attachment', 'image');
        } elseif (\wp_attachment_is('audio', $id)) {
            $this->app->utilities->loader->loadPartial('attachment', 'audio');
        } elseif (\wp_attachment_is('video', $id)) {
            $this->app->utilities->loader->loadPartial('attachment', 'video');
        } else {
            $this->app->utilities->loader->loadPartial('attachment');
        }
    }
}
