<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Thumbnails;

use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class MicroTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $thumbnail = new Micro(Stub::makeEmpty(AbstractTheme::class, [
            'meta' => ['slug' => 'jentil'],
        ]));

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

        $thumbnail = new Micro(Stub::makeEmpty(AbstractTheme::class, [
            'meta' => ['slug' => 'jentil'],
        ]));

        $thumbnail->addSize();

        $add_image_size->wasCalledOnce();
        $add_image_size->wasCalledWithOnce([$thumbnail->id, 75, 75, true]);
    }
}
