<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\TestCase;
use GrottoPress\Jentil\Setups\Scripts;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\Utilities\FileSystem;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class ScriptsTest extends TestCase
{
    public function testRun()
    {
        $scripts = new Scripts(Stub::makeEmpty(AbstractTheme::class));

        $add_action = FunctionMocker::replace('add_action');
        $add_filter = FunctionMocker::replace('add_filter');

        $scripts->run();

        $add_filter->wasCalledOnce();
        $add_filter->wasCalledWithOnce([
            'body_class',
            [$scripts, 'addBodyClasses']
        ]);

        $add_action->wasCalledOnce();
        $add_action->wasCalledWithOnce([
            'wp_enqueue_scripts',
            [$scripts, 'enqueue']
        ]);
    }

    public function testEnqueue()
    {
        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);
        $jentil->utilities->fileSystem = Stub::makeEmpty(FileSystem::class, [
            'dir' => 'http://my.url/dist/scripts/jentil.js',
        ]);
        
        $scripts = new Scripts($jentil);

        $enqueue = FunctionMocker::replace('wp_enqueue_script');

        $scripts->enqueue();

        $enqueue->wasCalledOnce();
        $enqueue->wasCalledWithOnce([
            'jentil',
            'http://my.url/dist/scripts/jentil.js',
            ['jquery'],
            '',
            true
        ]);
    }

    public function testAddBodyClasses()
    {
        $scripts = new Scripts(Stub::makeEmpty(AbstractTheme::class));

        $this->assertSame(
            ['class-1', 'no-js'],
            $scripts->addBodyClasses(['class-1'])
        );
    }
}
