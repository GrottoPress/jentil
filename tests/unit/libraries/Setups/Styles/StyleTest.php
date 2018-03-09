<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Styles;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\Utilities\FileSystem;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class StyleTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $style = new Style(Stub::makeEmpty(AbstractTheme::class));

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
    public function testEnqueue(bool $isRTL)
    {
        $enqueue = FunctionMocker::replace('wp_enqueue_style');
        $rtl = FunctionMocker::replace('is_rtl', $isRTL);

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
            'setups' => ['Styles\Normalize' => new class {
                public $id;
            }],
        ]);
        $jentil->utilities->fileSystem = Stub::makeEmpty(FileSystem::class, [
            'dir' => function (
                string $type,
                string $append
            ): string {
                return "http://my.url{$append}";
            }
        ]);

        $style = new Style($jentil);

        $style->enqueue();

        $enqueue->wasCalledOnce();
        $enqueue->wasCalledWithOnce([
            $style->id,
            (
                $isRTL ?
                'http://my.url/dist/styles/jentil-rtl.min.css' :
                'http://my.url/dist/styles/jentil.min.css'
            ),
            [$jentil->setups['Styles\Normalize']->id],
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
