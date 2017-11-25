<?php

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities;

use Codeception\TestCase\WPTestCase;
use GrottoPress\Getter\Getter;

class FileSystemTest extends WPTestCase
{
    use Getter;

    private $fileSystem;
    
    public function _before()
    {
        $this->fileSystem = \Jentil()->utilities->fileSystem;
    }

    public function testThemeDirWhenFrameworkIsTheme()
    {
        $this->assertSame(
            $this->fileSystem->themeDir('path'),
            \get_template_directory()
        );
    }
}
