<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Styles;

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

        $style = new Core($jentil);

        $style->run();

        $add_action->wasCalledOnce();
        $add_action->wasCalledWithOnce([
            'wp_enqueue_scripts',
            [$style, 'enqueue']
        ]);
    }

    /**
     * @dataProvider enqueueProvider
     */
    public function testEnqueue(bool $is_rtl)
    {
        $enqueue = FunctionMocker::replace('wp_enqueue_style');
        $rtl = FunctionMocker::replace('is_rtl', $is_rtl);

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

            function getSetups(): array
            {
                return ['Styles\Normalize' => new class {
                    public $id;
                }];
            }
        };

        $test_css = \codecept_data_dir('styles/test.css');

        $jentil->utilities = Stub::makeEmpty(Utilities::class);
        $jentil->utilities->fileSystem = Stub::makeEmpty(FileSystem::class, [
            'dir' => function (
                string $type,
                string $append
            ) use ($test_css): string {
                return 'path' === $type ? $test_css : "http://my.url{$append}";
            }
        ]);

        $style = new Core($jentil);

        $style->enqueue();

        $enqueue->wasCalledOnce();
        $enqueue->wasCalledWithOnce([
            $style->id,
            (
                $is_rtl ?
                'http://my.url/dist/styles/core-rtl.min.css' :
                'http://my.url/dist/styles/core.min.css'
            ),
            [$jentil->setups['Styles\Normalize']->id],
            \filemtime($test_css),
        ]);
    }

    public function enqueueProvider(): array
    {
        return [
            'is RTL' => [true],
            'is LTR' => [false],
        ];
    }
}
