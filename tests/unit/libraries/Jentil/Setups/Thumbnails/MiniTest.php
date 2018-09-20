<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Thumbnails;

use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class MiniTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $thumbnail = new Mini(Stub::makeEmpty(AbstractTheme::class));

        $thumbnail->run();

        $add_action->wasCalledTimes(1);

        $add_action->wasCalledWithOnce([
            'after_setup_theme',
            [$thumbnail, 'addSize']
        ]);
    }

    public function testAddSize()
    {
        $add_image_size = FunctionMocker::replace('add_image_size');

        $thumbnail = new Mini(Stub::makeEmpty(AbstractTheme::class));

        $thumbnail->addSize();

        $add_image_size->wasCalledOnce();
        $add_image_size->wasCalledWithOnce([$thumbnail->id, 100, 100, true]);
    }
}
