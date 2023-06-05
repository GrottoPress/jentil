<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Translations;

use GrottoPress\Jentil\Utilities;
use GrottoPress\Jentil\Utilities\FileSystem;
use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class BreadcrumbsTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $translation = new Breadcrumbs(Stub::makeEmpty(AbstractTheme::class));

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
        ]);
        $jentil->utilities->fileSystem = Stub::makeEmpty(FileSystem::class, [
            'dir' => '/var/www/jentil/languages',
        ]);

        $translation = new Breadcrumbs($jentil);

        $translation->loadTextDomain();

        $load->wasCalledOnce();
        $load->wasCalledWithOnce([
            $translation->textDomain,
            '/var/www/jentil/languages'
        ]);
    }
}
