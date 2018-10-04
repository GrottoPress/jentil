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

        $style = new Core(Stub::makeEmpty(AbstractTheme::class, [
            'meta' => ['slug' => 'jentil'],
        ]));

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
    public function testEnqueue(bool $rtl)
    {
        $enqueue = FunctionMocker::replace('wp_enqueue_style');

        FunctionMocker::replace('is_rtl', $rtl);

        $test_css = \codecept_data_dir('styles/test.css');

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
            'setups' => ['Styles\Normalize' => new class {
                public $id;
            }],
            'meta' => ['slug' => 'jentil'],
        ]);

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
                $rtl ?
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
