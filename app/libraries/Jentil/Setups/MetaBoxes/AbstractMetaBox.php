<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\MetaBoxes;

use GrottoPress\WordPress\SUV\Setups\MetaBoxes\AbstractMetaBox as Metabox;
use WP_Post;

abstract class AbstractMetaBox extends Metabox
{
    /**
     * @action add_meta_boxes
     */
    public function add(string $post_type, $post)
    {
        if (!\is_a($post, 'WP_Post')) return;

        if (!($box = $this->box($post))) {
            return;
        }

        $this->app->utilities->metaBox($box)->add();
    }

    /**
     * @action save_post
     * @action edit_attachment
     */
    public function save(int $post_id)
    {
        if (!($box = $this->box(\get_post($post_id)))) {
            return;
        }

        $this->app->utilities->metaBox($box)->save($post_id);
    }

    /**
     * @return array<string, mixed>
     */
    abstract protected function box(WP_Post $post): array;
}
