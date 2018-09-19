<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Scripts;

use GrottoPress\Jentil\Utilities;
use GrottoPress\Jentil\Utilities\FileSystem;
use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class CoreTest extends AbstractTestCase
{
    public function testRun()
    {
        $script = new Core(Stub::makeEmpty(AbstractTheme::class));

        $add_action = FunctionMocker::replace('add_action');
        $add_filter = FunctionMocker::replace('add_filter');

        $script->run();

        $add_action->wasCalledOnce();
        $add_action->wasCalledWithOnce([
            'wp_enqueue_scripts',
            [$script, 'enqueue']
        ]);

        $add_filter->wasCalledOnce();
        $add_filter->wasCalledWithOnce([
            'body_class',
            [$script, 'addBodyClasses']
        ]);
    }

    public function testEnqueue()
    {
        $enqueue = FunctionMocker::replace('wp_enqueue_script');

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);
        $jentil->utilities->fileSystem = Stub::makeEmpty(FileSystem::class, [
            'dir' => 'http://my.url/dist/scripts/jentil.js',
        ]);

        $script = new Core($jentil);

        $script->enqueue();

        $enqueue->wasCalledOnce();
        $enqueue->wasCalledWithOnce([
            $script->id,
            'http://my.url/dist/scripts/jentil.js',
            ['jquery'],
            '',
            true
        ]);
    }

    public function testAddBodyClasses()
    {
        $script = new Core(Stub::makeEmpty(AbstractTheme::class));

        $this->assertSame(
            ['class-1', 'no-js'],
            $script->addBodyClasses(['class-1'])
        );
    }
}
