<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class FooterTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $footer = new Footer(Stub::makeEmpty(AbstractTheme::class));

        $footer->run();

        $add_action->wasCalledTimes(3);

        $add_action->wasCalledWithOnce([
            'jentil_inside_footer',
            [$footer, 'renderWidgets']
        ]);

        $add_action->wasCalledWithOnce([
            'jentil_inside_footer',
            [$footer, 'renderColophon']
        ]);

        $add_action->wasCalledWithOnce([
            'jentil_after_footer',
            [$footer, 'closeWrapTag']
        ]);
    }
}
