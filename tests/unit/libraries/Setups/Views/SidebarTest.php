<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\Utilities\Page\Page;
use GrottoPress\Jentil\AbstractTheme;
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
