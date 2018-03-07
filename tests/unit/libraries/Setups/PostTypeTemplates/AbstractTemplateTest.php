<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\PostTypeTemplates;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class AbstractTemplatesTest extends AbstractTestCase
{
    /**
     * @var AbstractTemplate
     */
    private $template;

    public function _before()
    {
        $this->template = Stub::construct(
            AbstractTemplate::class,
            [Stub::makeEmpty(AbstractTheme::class)],
            ['add' => false]
        );
    }

    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $this->template->run();

        $add_action->wasCalledOnce();

        $add_action->wasCalledWithOnce([
            'wp_loaded',
            [$this->template, 'load']
        ]);
    }

    public function testload()
    {
        $post_types = ['post', 'page', 'tutorial'];

        $add_filter = FunctionMocker::replace('add_filter');
        $get_post_types = FunctionMocker::replace(
            'get_post_types',
            $post_types
        );

        $this->template->load();

        $add_filter->wasCalledTimes(\count($post_types));

        foreach ($post_types as $post_type) {
            $add_filter->wasCalledWithOnce([
                "theme_{$post_type}_templates",
                [$this->template, 'add'],
                10,
                4
            ]);
        }
    }
}
