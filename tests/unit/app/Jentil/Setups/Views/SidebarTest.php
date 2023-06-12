<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use GrottoPress\Jentil\Utilities;
use GrottoPress\Jentil\Utilities\Page;
use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;
use Exception;

class SidebarTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $sidebar = new Sidebar(Stub::makeEmpty(AbstractTheme::class));

        $sidebar->run();

        $add_action->wasCalledTimes(3);

        $add_action->wasCalledWithOnce([
            'jentil_before_before_footer',
            [$sidebar, 'load']
        ]);

        $add_action->wasCalledWithOnce([
            'jentil_after_after_header',
            [$sidebar, 'openContentWrapTag']
        ]);

        $add_action->wasCalledWithOnce([
            'jentil_before_before_footer',
            [$sidebar, 'closeContentWrapTag']
        ]);
    }
}
