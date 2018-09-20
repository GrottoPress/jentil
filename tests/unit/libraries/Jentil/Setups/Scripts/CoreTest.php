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
        $add_action = FunctionMocker::replace('add_action');
        $add_filter = FunctionMocker::replace('add_filter');

        $jentil = new class extends AbstractTheme {
            function __construct()
            {
            }

            function get()
            {
                return new class {
                    public $stylesheet;
                };
            }
        };

        $script = new Core($jentil);

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

        $test_js = \codecept_data_dir('scripts/test.js');

        $jentil = new class extends AbstractTheme {
            function __construct()
            {
            }

            function get()
            {
                return new class {
                    public $stylesheet = 'jentil';
                };
            }
        };

        $jentil->utilities = Stub::makeEmpty(Utilities::class);
        $jentil->utilities->fileSystem = Stub::makeEmpty(FileSystem::class, [
            'dir' => function (
                string $type,
                string $append
            ) use ($test_js): string {
                return 'path' === $type ? $test_js : "http://my.url/test.js";
            },
        ]);

        $script = new Core($jentil);

        $script->enqueue();

        $enqueue->wasCalledOnce();
        $enqueue->wasCalledWithOnce([
            $script->id,
            'http://my.url/test.js',
            ['jquery'],
            \filemtime($test_js),
            true
        ]);
    }

    public function testAddBodyClasses()
    {
        $jentil = new class extends AbstractTheme {
            function __construct()
            {
            }

            function get()
            {
                return new class {
                    public $stylesheet;
                };
            }
        };

        $script = new Core($jentil);

        $this->assertSame(
            ['class-1', 'no-js'],
            $script->addBodyClasses(['class-1'])
        );
    }
}
