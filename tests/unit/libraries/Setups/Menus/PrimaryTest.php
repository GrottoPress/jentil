<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Menus;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class PrimaryTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $menu = new Primary(Stub::makeEmpty(AbstractTheme::class));

        $menu->run();

        $add_action->wasCalledOnce();

        $add_action->wasCalledWithOnce([
            'after_setup_theme',
            [$menu, 'register']
        ]);
    }

    public function testRegister()
    {
        $register = FunctionMocker::replace('register_nav_menus');
        $esc_html = FunctionMocker::replace('esc_html__', function (
            string $text
        ): string {
            return $text;
        });

        $menu = new Primary(Stub::makeEmpty(AbstractTheme::class));

        $menu->register();

        $register->wasCalledOnce();
        $register->wasCalledWithOnce([[$menu->id => 'Primary menu']]);
    }
}
