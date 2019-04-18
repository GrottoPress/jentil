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

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'meta' => ['text_domain' => 'jentil'],
        ]);

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

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
            'meta' => ['text_domain' => 'jentil', 'domain_path' => '/lang'],
        ]);

        $jentil->utilities->fileSystem = Stub::makeEmpty(FileSystem::class, [
            'dir' => function (string $type, $append) {
                return "/var/www/jentil${append}";
            }
        ]);

        $translation = new Core($jentil);

        $translation->loadTextDomain();

        $load->wasCalledOnce();
        $load->wasCalledWithOnce([
            $translation->textDomain,
            '/var/www/jentil/lang'
        ]);
    }
}
