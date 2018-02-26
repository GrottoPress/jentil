<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups\Styles;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\AbstractTestCase;
use GrottoPress\Jentil\Setups\Styles\AbstractStyle;
use tad\FunctionMocker\FunctionMocker;

class AbstractStyleTest extends AbstractTestCase
{
    public function testRun()
    {
        $style = Stub::make(AbstractStyle::class);

        $add_action = FunctionMocker::replace('add_action');

        $style->run();

        $add_action->wasCalledOnce();

        $add_action->wasCalledWithOnce([
            'wp_enqueue_scripts',
            [$style, 'enqueue']
        ]);
    }
}
