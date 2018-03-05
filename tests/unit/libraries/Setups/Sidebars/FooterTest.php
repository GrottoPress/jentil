<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups\Sidebars;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\AbstractTestCase;
use GrottoPress\Jentil\Setups\Sidebars\Footer;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class FooterTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $sidebar = new Footer(Stub::makeEmpty(AbstractTheme::class));

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
        $esc_html = FunctionMocker::replace('esc_html__', 'Footer');

        $sidebar = new Footer(Stub::makeEmpty(AbstractTheme::class));

        $sidebar->register();

        $register_sidebar->wasCalledOnce();
        $esc_html->wasCalledTimes(2);
        $register_sidebar->wasCalledWithOnce([[
            'name'          => 'Footer',
            'id'            => 'footer-widget-area',
            'description'   => 'Footer',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ]]);
    }
}
