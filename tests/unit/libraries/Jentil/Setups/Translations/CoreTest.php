<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Translations;

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
                    function get()
                    {
                        return 'jentil';
                    }
                };
            }
        };

        $translation = new Core($jentil);

        $translation->run();

        $add_action->wasCalledOnce();
        $add_action->wasCalledWithOnce([
            'after_setup_theme',
            [$translation, 'loadTextDomain']
        ]);
    }

    public function testLoadTextDomain()
    {
        $load = FunctionMocker::replace('load_theme_textdomain');

        $jentil = new class extends AbstractTheme {
            function __construct()
            {
            }

            function get()
            {
                return new class {
                    function get()
                    {
                        return 'jentil';
                    }
                };
            }
        };

        $jentil->utilities = Stub::makeEmpty(Utilities::class);
        $jentil->utilities->fileSystem = Stub::makeEmpty(FileSystem::class, [
            'dir' => '/var/www/jentil/languages',
        ]);

        $translation = new Core($jentil);

        $translation->loadTextDomain();

        $load->wasCalledOnce();
        $load->wasCalledWithOnce([
            $translation->textDomain,
            '/var/www/jentil/languages'
        ]);
    }
}
