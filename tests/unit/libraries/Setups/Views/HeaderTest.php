<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups\Views;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\TestCase;
use GrottoPress\Jentil\Setups\Views\Header;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class HeaderTest extends TestCase
{
    public function testRun()
    {
        $header = new Header(Stub::makeEmpty(AbstractTheme::class));

        $add_action = FunctionMocker::replace('add_action');

        $header->run();

        $add_action->wasCalledTimes(2);

        $add_action->wasCalledWithOnce([
            'jentil_inside_header',
            [$header, 'renderMenuToggle']
        ]);

        $add_action->wasCalledWithOnce([
            'jentil_inside_header',
            [$header, 'renderMenu']
        ]);
    }

    public function testRenderMenu()
    {
        $header = new Header(Stub::makeEmpty(AbstractTheme::class));

        $get_search_form = FunctionMocker::replace('get_search_form');
        $esc_html = FunctionMocker::replace('esc_html__', 'some string');
        $wp_nav_menu = FunctionMocker::replace('wp_nav_menu');
        $sanitize_title = FunctionMocker::replace('sanitize_title');
        $sanitize_text_field = FunctionMocker::replace('sanitize_text_field');

        $header->renderMenu();

        $get_search_form->wasCalledOnce();
        $esc_html->wasCalledOnce();
        $wp_nav_menu->wasCalledOnce();
        $wp_nav_menu->wasCalledWithOnce([['theme_location' => 'primary-menu']]);
    }
}
