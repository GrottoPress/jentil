<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Sidebars;

use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class SecondaryTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $sidebar = new Secondary(Stub::makeEmpty(AbstractTheme::class));

        $sidebar->run();

        $add_action->wasCalledOnce();
        $add_action->wasCalledWithOnce([
            'widgets_init',
            [$sidebar, 'register']
        ]);
    }

    public function testRegister()
    {
        $register_sidebar = FunctionMocker::replace('register_sidebar');
        $esc_html = FunctionMocker::replace('esc_html__', 'Secondary');

        $sidebar = new Secondary(Stub::makeEmpty(AbstractTheme::class));

        $sidebar->register();

        $register_sidebar->wasCalledOnce();
        $esc_html->wasCalledTimes(2);
        $register_sidebar->wasCalledWithOnce([[
            'id'            => $sidebar->id,
            'name'          => 'Secondary',
            'description'   => 'Secondary',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ]]);
    }
}
