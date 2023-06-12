<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class SearchFormTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_filter = FunctionMocker::replace('add_filter');

        $form = new SearchForm(Stub::makeEmpty(AbstractTheme::class));

        $form->run();

        $add_filter->wasCalledOnce();
        $add_filter->wasCalledWithOnce([
            'get_search_form',
            [$form, 'render']
        ]);
    }
}
