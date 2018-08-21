<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class ArchiveTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $archive = new Archive(Stub::makeEmpty(AbstractTheme::class));

        $archive->run();

        $add_action->wasCalledOnce();

        $add_action->wasCalledWithOnce([
            'jentil_after_title',
            [$archive, 'renderDescription']
        ]);
    }
}
