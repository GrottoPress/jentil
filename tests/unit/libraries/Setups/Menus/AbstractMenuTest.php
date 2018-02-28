<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups\Menus;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\AbstractTestCase;
use GrottoPress\Jentil\Setups\Menus\AbstractMenu;
use tad\FunctionMocker\FunctionMocker;

class AbstractMenuTest extends AbstractTestCase
{
    public function testRun()
    {
        $menu = Stub::make(AbstractMenu::class);

        $add_action = FunctionMocker::replace('add_action');

        $menu->run();

        $add_action->wasCalledOnce();

        $add_action->wasCalledWithOnce([
            'after_setup_theme',
            [$menu, 'register']
        ]);
    }
}
