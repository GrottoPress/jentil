<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\AbstractTestCase;
use GrottoPress\Jentil\Setups\Menu;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\Utilities\FileSystem;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class MenuTest extends AbstractTestCase
{
    public function testRun()
    {
        $menu = new Menu(Stub::makeEmpty(AbstractTheme::class));

        $add_action = FunctionMocker::replace('add_action');

        $menu->run();

        $add_action->wasCalledOnce();

        $add_action->wasCalledWithOnce([
            'after_setup_theme',
            [$menu, 'register']
        ]);
    }

    public function testRegister()
    {
        $menu = new Menu(Stub::makeEmpty(AbstractTheme::class));

        $register = FunctionMocker::replace('register_nav_menus');
        $esc_html = FunctionMocker::replace('esc_html__', function (
            string $text
        ): string {
            return $text;
        });

        $menu->register();

        $register->wasCalledOnce();
        $register->wasCalledWithOnce([['primary-menu' => 'Primary menu']]);

        $esc_html->wasCalledOnce();
        $esc_html->wasCalledWithOnce(['Primary menu', 'jentil']);
    }
}
