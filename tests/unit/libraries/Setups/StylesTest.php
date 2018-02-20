<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\AbstractTestCase;
use GrottoPress\Jentil\Setups\Styles;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\Utilities\FileSystem;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class StylesTest extends AbstractTestCase
{
    public function testRun()
    {
        $styles = new Styles(Stub::makeEmpty(AbstractTheme::class));

        $add_action = FunctionMocker::replace('add_action');

        $styles->run();

        $add_action->wasCalledTimes(4);

        $add_action->wasCalledWithOnce([
            'wp_enqueue_scripts',
            [$styles, 'enqueueNormalize']
        ]);

        $add_action->wasCalledWithOnce([
            'wp_enqueue_scripts',
            [$styles, 'enqueueFontAwesome']
        ]);

        $add_action->wasCalledWithOnce([
            'wp_enqueue_scripts',
            [$styles, 'enqueuePosts']
        ]);

        $add_action->wasCalledWithOnce([
            'wp_enqueue_scripts',
            [$styles, 'enqueue']
        ]);
    }

    /**
     * @dataProvider enqueueProvider
     */
    public function testEnqueue(bool $isRTL)
    {
        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);
        $jentil->utilities->fileSystem = Stub::makeEmpty(FileSystem::class, [
            'dir' => function (
                string $type,
                string $append
            ): string {
                return "http://my.url{$append}";
            }
        ]);

        $styles = new Styles($jentil);

        $enqueue = FunctionMocker::replace('wp_enqueue_style');
        $rtl = FunctionMocker::replace('is_rtl', $isRTL);

        $styles->enqueue();

        $enqueue->wasCalledOnce();
        $enqueue->wasCalledWithOnce([
            'jentil',
            (
                $isRTL ?
                'http://my.url/dist/styles/jentil-rtl.min.css' :
                'http://my.url/dist/styles/jentil.min.css'
            ),
            ['normalize'],
        ]);
    }

    public function testEnqueueNormalize()
    {
        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);
        $jentil->utilities->fileSystem = Stub::makeEmpty(FileSystem::class, [
            'dir' => 'http://my.url/dist/styles/normalize.css'
        ]);

        $styles = new Styles($jentil);

        $enqueue = FunctionMocker::replace('wp_enqueue_style');

        $styles->enqueueNormalize();

        $enqueue->wasCalledOnce();
        $enqueue->wasCalledWithOnce([
            'normalize',
            'http://my.url/dist/styles/normalize.css',
        ]);
    }

    public function testEnqueueFontAwesome()
    {
        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);
        $jentil->utilities->fileSystem = Stub::makeEmpty(FileSystem::class, [
            'dir' => 'http://my.url/dist/styles/fa.css'
        ]);

        $styles = new Styles($jentil);

        $enqueue = FunctionMocker::replace('wp_enqueue_style');

        $styles->enqueueFontAwesome();

        $enqueue->wasCalledOnce();
        $enqueue->wasCalledWithOnce([
            'font-awesome',
            'http://my.url/dist/styles/fa.css',
        ]);
    }

    public function testEnqueuePosts()
    {
        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);
        $jentil->utilities->fileSystem = Stub::makeEmpty(FileSystem::class, [
            'dir' => 'http://my.url/dist/styles/posts.css'
        ]);

        $styles = new Styles($jentil);

        $enqueue = FunctionMocker::replace('wp_enqueue_style');

        $styles->enqueuePosts();

        $enqueue->wasCalledOnce();
        $enqueue->wasCalledWithOnce([
            'wordpress-posts',
            'http://my.url/dist/styles/posts.css',
            ['normalize'],
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
