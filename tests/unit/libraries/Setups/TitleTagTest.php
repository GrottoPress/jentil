<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class TitleTagTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $title = new TitleTag(Stub::makeEmpty(AbstractTheme::class));

        $title->run();

        $add_action->wasCalledOnce();

        $add_action->wasCalledWithOnce([
            'after_setup_theme',
            [$title, 'addSupport']
        ]);
    }

    public function testAddSupport()
    {
        $add_support = FunctionMocker::replace('add_theme_support');

        $title = new TitleTag(Stub::makeEmpty(AbstractTheme::class));

        $title->addSupport();

        $add_support->wasCalledOnce();
        $add_support->wasCalledWithOnce(['title-tag']);
    }
}
