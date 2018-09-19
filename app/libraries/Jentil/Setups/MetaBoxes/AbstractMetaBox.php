<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\MetaBoxes;

use GrottoPress\Jentil\Setups\AbstractSetup;
use GrottoPress\Jentil\IdentityTrait;
use WP_Post;

abstract class AbstractMetaBox extends AbstractSetup
{
    use IdentityTrait;

    /**
     * @var string $context 'normal', 'side', or 'advanced'.
     */
    protected $context;

    protected function getContext(): string
    {
        return $this->context;
    }

    /**
     * @action add_meta_boxes
     */
    public function add(string $post_type, WP_Post $post)
    {
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
     * @return mixed[string]
     */
    abstract protected function box(WP_Post $post): array;
}
