<?php

declare (strict_types = 1);

namespace GrottoPress\Jentil\Utilities;

use Codeception\TestCase\WPTestCase;
use GrottoPress\Getter\Getter;

class LoaderTest extends WPTestCase
{
    use Getter;

    private $loader;
    
    public function _before()
    {
        $this->loader = \Jentil()->utilities->loader;
    }

    public function testLoadPartialWhenFrameworkIsTheme()
    {
        
    }
}
