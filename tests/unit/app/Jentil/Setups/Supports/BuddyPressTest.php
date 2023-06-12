<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Supports;

use GrottoPress\Jentil\AbstractTheme;
use GrottoPress\Jentil\Setups\Customizer\AbstractCustomizer;
use GrottoPress\Jentil\Setups\Customizer\AbstractPanel;
use GrottoPress\Jentil\Setups\Customizer\AbstractSection;
use GrottoPress\Jentil\Utilities;
use GrottoPress\Jentil\AbstractTestCase;
use Codeception\Util\Stub;
use tad\FunctionMocker\FunctionMocker;

class BuddyPressTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $buddypress = new BuddyPress(Stub::makeEmpty(AbstractTheme::class));

        $buddypress->run();

        $add_action->wasCalledTimes(2);

        $add_action->wasCalledWithOnce([
            'customize_register',
            [$buddypress, 'removeCustomizerItems'],
            20
        ]);

        $add_action->wasCalledWithOnce([
            'wp',
            [$buddypress, 'removeSingularViews']
        ]);
    }

    public function testRemoveCustomizerItems()
    {
        $this->getMockBuilder('BuddyPress')->getMock();

        $wp_customizer = $this->getMockBuilder('WP_Customize_Manager')
            ->getMock();

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'setups' => ['Customizer' => Stub::makeEmpty(
                AbstractCustomizer::class,
                [
                    'panels' => ['Posts' => Stub::makeEmpty(
                        AbstractPanel::class,
                        ['sections' => [
                            'Related_page' => Stub::makeEmpty(
                                AbstractSection::class,
                                ['get' => function () {
                                    return new class {
                                        public $active_callback = true;
                                    };
                                }]
                            ),
                            'Singular_page' => Stub::makeEmpty(
                                AbstractSection::class,
                                ['get' => function () {
                                    return new class {
                                        public $active_callback = true;
                                    };
                                }]
                            ),
                        ]]
                    )],
                ]
            )]
        ]);

        $buddypress = new BuddyPress($jentil);

        $buddypress->removeCustomizerItems($wp_customizer);
    }

    public function testRemoveSingularViews()
    {
        $this->getMockBuilder('BuddyPress')->getMock();

        $remove_action = FunctionMocker::replace('remove_action');
        FunctionMocker::replace('is_buddypress', true);

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'setups' => ['Views\Singular' => true],
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);

        $buddypress = new BuddyPress($jentil);

        $buddypress->removeSingularViews();

        $remove_action->wasCalledTimes(4);

        $remove_action->wasCalledWithOnce([
            'jentil_before_title',
            [$jentil->setups['Views\Singular'], 'renderPostsBeforeTitle'],
        ]);

        $remove_action->wasCalledWithOnce([
            'jentil_after_title',
            [$jentil->setups['Views\Singular'], 'renderPostsAfterTitle'],
        ]);

        $remove_action->wasCalledWithOnce([
            'jentil_after_content',
            [$jentil->setups['Views\Singular'], 'renderPostsAfterContent'],
        ]);

        $remove_action->wasCalledWithOnce([
            'jentil_after_content',
            [$jentil->setups['Views\Singular'], 'renderRelatedPosts'],
        ]);
    }
}
