<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups\Views;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\TestCase;
use GrottoPress\Jentil\Setups\Views\Archive;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class ArchiveTest extends TestCase
{
    public function testRun()
    {
        $archive = new Archive(Stub::makeEmpty(AbstractTheme::class));

        $add_action = FunctionMocker::replace('add_action');

        $archive->run();

        $add_action->wasCalledOnce();

        $add_action->wasCalledWithOnce([
            'jentil_before_content',
            [$archive, 'renderDescription']
        ]);
    }
}
