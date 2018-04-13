<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\PostTypeTemplates;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class PageBuildersBlankTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $template = new PageBuilderBlank(Stub::makeEmpty(AbstractTheme::class));

        $template->run();

        $add_action->wasCalledOnce();
        $add_action->wasCalledWithOnce([
            'wp_loaded',
            [$template, 'load']
        ]);
    }

    public function testLoad()
    {
        $post_types = ['post', 'page', 'tutorial'];

        $add_filter = FunctionMocker::replace('add_filter');
        $get_post_types = FunctionMocker::replace(
            'get_post_types',
            $post_types
        );

        $template = new PageBuilderBlank(Stub::makeEmpty(AbstractTheme::class));

        $template->load();

        $add_filter->wasCalledTimes(\count($post_types));

        foreach ($post_types as $post_type) {
            $add_filter->wasCalledWithOnce([
                "theme_{$post_type}_templates",
                [$template, 'add'],
                10,
                4
            ]);
        }
    }

    public function testAdd()
    {
        FunctionMocker::replace('esc_html__', 'Page builder (blank)');

        $template = new PageBuilderBlank(Stub::makeEmpty(AbstractTheme::class));

        $this->assertSame(
            [
                'my-template.php' => 'My template',
                $template->slug => 'Page builder (blank)',
            ],
            $template->add([
                'my-template.php' => 'My template',
            ], null, null, '')
        );
    }
}
