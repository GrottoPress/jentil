<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups\CustomTemplates;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\TestCase;
use GrottoPress\Jentil\Setups\CustomTemplates\AbstractTemplate;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class AbstractTemplatesTest extends TestCase
{
    /**
     * @var AbstractTemplates
     */
    private $templates;

    public function _before()
    {
        $this->templates = Stub::construct(
            AbstractTemplate::class,
            [Stub::makeEmpty(AbstractTheme::class)],
            ['add' => false]
        );
    }

    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $this->templates->run();

        $add_action->wasCalledOnce();

        $add_action->wasCalledWithOnce([
            'wp_loaded',
            [$this->templates, 'load']
        ]);
    }

    public function testload()
    {
        $post_types = ['post', 'page', 'tutorial'];

        $add_action = FunctionMocker::replace('add_action');
        $get_post_types = FunctionMocker::replace(
            'get_post_types',
            $post_types
        );

        $this->templates->load();

        $add_action->wasCalledTimes(\count($post_types));

        foreach ($post_types as $post_type) {
            $add_action->wasCalledWithOnce([
                "theme_{$post_type}_templates",
                [$this->templates, 'add'],
                10,
                4
            ]);
        }
    }
}
