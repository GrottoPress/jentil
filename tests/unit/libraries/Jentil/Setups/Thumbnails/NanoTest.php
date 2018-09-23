<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Thumbnails;

use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class NanoTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $thumbnail = new Nano(Stub::makeEmpty(AbstractTheme::class, [
            'theme' => new class {
                public $stylesheet;
            },
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

        $thumbnail = new Nano(Stub::makeEmpty(AbstractTheme::class, [
            'theme' => new class {
                public $stylesheet;
            },
        ]));

        $thumbnail->addSize();

        $add_image_size->wasCalledOnce();
        $add_image_size->wasCalledWithOnce([$thumbnail->id, 50, 50, true]);
    }
}
