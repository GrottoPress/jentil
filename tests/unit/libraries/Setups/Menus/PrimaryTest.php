<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups\Menus;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\AbstractTestCase;
use GrottoPress\Jentil\Setups\Menus\Primary;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class PrimaryTest extends AbstractTestCase
{
    public function testRegister()
    {
        $menu = new Primary(Stub::makeEmpty(AbstractTheme::class));

        $register = FunctionMocker::replace('register_nav_menus');
        $esc_html = FunctionMocker::replace('esc_html__', function (
            string $text
        ): string {
            return $text;
        });

        $menu->register();

        $register->wasCalledOnce();
        $register->wasCalledWithOnce([['primary-menu' => 'Primary menu']]);
    }
}
