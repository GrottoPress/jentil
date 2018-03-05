<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups\Views;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\AbstractTestCase;
use GrottoPress\Jentil\Setups\Views\Archive;
use GrottoPress\Jentil\AbstractTheme;
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
            'jentil_before_content',
            [$archive, 'renderDescription']
        ]);
    }
}
