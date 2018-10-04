<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\MetaBoxes;

use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class LayoutTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $layout = new Layout(Stub::makeEmpty(AbstractTheme::class, [
            'meta' => ['slug' => 'jentil'],
        ]));

        $layout->run();

        $add_action->wasCalledWithOnce(['add_meta_boxes', [$layout, 'add']]);
        $add_action->wasCalledWithOnce(['save_post', [$layout, 'save']]);
        $add_action->wasCalledWithOnce(['edit_attachment', [$layout, 'save']]);
    }
}
