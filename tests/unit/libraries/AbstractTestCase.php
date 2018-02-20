<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit;

use Codeception\Test\Unit;
use tad\FunctionMocker\FunctionMocker;

abstract class AbstractTestCase extends Unit
{
    public function _before()
    {
        FunctionMocker::setUp();
    }

    public function _after()
    {
        FunctionMocker::tearDown();
    }
}
