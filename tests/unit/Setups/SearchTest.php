<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\TestCase;
use GrottoPress\Jentil\Setups\Search;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class SearchTest extends TestCase
{
    public function testRun()
    {
        $search = new Search(Stub::makeEmpty(AbstractTheme::class));

        $add_filter = FunctionMocker::replace('add_filter');

        $search->run();

        $add_filter->wasCalledOnce();
        $add_filter->wasCalledWithOnce([
            'get_search_form',
            [$search, 'form']
        ]);
    }
}
