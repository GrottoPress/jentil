<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups\Sidebars;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\AbstractTestCase;
use GrottoPress\Jentil\Setups\Sidebars\AbstractSidebar;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class AbstractSidebarTest extends AbstractTestCase
{
    public function testRun()
    {
        $sidebar = Stub::make(AbstractSidebar::class);

        $add_action = FunctionMocker::replace('add_action');

        $sidebar->run();

        $add_action->wasCalledOnce();

        $add_action->wasCalledWithOnce([
            'widgets_init',
            [$sidebar, 'register']
        ]);
    }
}
