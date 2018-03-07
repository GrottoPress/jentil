<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class FooterTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $footer = new Footer(Stub::makeEmpty(AbstractTheme::class));

        $footer->run();

        $add_action->wasCalledTimes(2);

        $add_action->wasCalledWithOnce([
            'jentil_inside_footer',
            [$footer, 'renderWidgets']
        ]);

        $add_action->wasCalledWithOnce([
            'jentil_inside_footer',
            [$footer, 'renderColophon']
        ]);
    }
}
