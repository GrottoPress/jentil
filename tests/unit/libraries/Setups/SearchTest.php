<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\AbstractTestCase;
use GrottoPress\Jentil\Setups\Search;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class SearchTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_filter = FunctionMocker::replace('add_filter');

        $search = new Search(Stub::makeEmpty(AbstractTheme::class));

        $search->run();

        $add_filter->wasCalledOnce();
        $add_filter->wasCalledWithOnce([
            'get_search_form',
            [$search, 'form']
        ]);
    }
}
