<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use GrottoPress\Jentil\Setups\Menus\AbstractMenu;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class HeaderTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $header = new Header(Stub::makeEmpty(AbstractTheme::class));

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
        $get_search_form = FunctionMocker::replace('get_search_form');
        $esc_html = FunctionMocker::replace('esc_html__', 'some string');
        $wp_nav_menu = FunctionMocker::replace('wp_nav_menu');
        $sanitize_title = FunctionMocker::replace('sanitize_title');
        $sanitize_text_field = FunctionMocker::replace('sanitize_text_field');

        $header = new Header(Stub::makeEmpty(AbstractTheme::class, [
            'setups' => ['Menus\Primary' => Stub::makeEmpty(AbstractMenu::class, [
                'id' => 'primary',
            ])],
        ]));

        $header->renderMenu();

        $get_search_form->wasCalledOnce();
        $esc_html->wasCalledOnce();
        $wp_nav_menu->wasCalledOnce();
        $wp_nav_menu->wasCalledWithOnce([[
            'theme_location' => 'primary',
            'fallback_cb' => false,
        ]]);
    }
}
