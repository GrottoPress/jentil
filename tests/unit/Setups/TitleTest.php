<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\TestCase;
use GrottoPress\Jentil\Setups\Title;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class TitleTest extends TestCase
{
    public function testRun()
    {
        $title = new Title(Stub::makeEmpty(AbstractTheme::class));

        $add_action = FunctionMocker::replace('add_action');

        $title->run();

        $add_action->wasCalledOnce();

        $add_action->wasCalledWithOnce([
            'after_setup_theme',
            [$title, 'addSupport']
        ]);
    }

    public function testAddSupport()
    {
        $title = new Title(Stub::makeEmpty(AbstractTheme::class));

        $add_support = FunctionMocker::replace('add_theme_support');

        $title->addSupport();

        $add_support->wasCalledOnce();
        $add_support->wasCalledWithOnce(['title-tag']);
    }
}
