<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\TestCase;
use GrottoPress\Jentil\Setups\Language;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\Utilities\FileSystem;
use GrottoPress\WordPress\SUV\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class LanguageTest extends TestCase
{
    public function testRun()
    {
        $language = new Language(Stub::makeEmpty(AbstractTheme::class));

        $add_action = FunctionMocker::replace('add_action');

        $language->run();

        $add_action->wasCalledOnce();
        $add_action->wasCalledWithOnce([
            'after_setup_theme',
            [$language, 'loadTextDomain']
        ]);
    }

    public function testLoadTextDomain()
    {
        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);
        $jentil->utilities->fileSystem = Stub::makeEmpty(FileSystem::class, [
            'dir' => '/var/www/jentil/languages',
        ]);
    
        $language = new Language($jentil);

        $load = FunctionMocker::replace('load_theme_textdomain');

        $language->loadTextDomain();

        $load->wasCalledOnce();
        $load->wasCalledWithOnce(['jentil', '/var/www/jentil/languages']);
    }
}
