<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\TestCase;
use GrottoPress\Jentil\Setups\Menu;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\Utilities\FileSystem;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class MenuTest extends TestCase
{
    public function testRun()
    {
        $menu = new Menu(Stub::makeEmpty(AbstractTheme::class));

        $add_action = FunctionMocker::replace('add_action');

        $menu->run();

        $add_action->wasCalledTimes(2);

        $add_action->wasCalledWithOnce([
            'after_setup_theme',
            [$menu, 'register']
        ]);

        $add_action->wasCalledWithOnce([
            'wp_enqueue_scripts',
            [$menu, 'enqueueScript']
        ]);
    }

    public function testRegister()
    {
        $menu = new Menu(Stub::makeEmpty(AbstractTheme::class));

        $register = FunctionMocker::replace('register_nav_menus');
        $esc_html = FunctionMocker::replace('esc_html__', function (
            string $text
        ): string {
            return $text;
        });

        $menu->register();

        $register->wasCalledOnce();
        $register->wasCalledWithOnce([['primary-menu' => 'Primary menu']]);

        $esc_html->wasCalledOnce();
        $esc_html->wasCalledWithOnce(['Primary menu', 'jentil']);
    }

    public function testEnqueueScript()
    {
        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);
        $jentil->utilities->fileSystem = Stub::makeEmpty(FileSystem::class, [
            'dir' => 'http://my.url/dist/scripts/menu.js',
        ]);

        $menu = new Menu($jentil);

        $enqueue = FunctionMocker::replace('wp_enqueue_script');

        $menu->enqueueScript();

        $enqueue->wasCalledOnce();
        $enqueue->wasCalledWithOnce([
            'jentil-menu',
            'http://my.url/dist/scripts/menu.js',
            ['jquery'],
            '',
            true,
        ]);
    }
}
