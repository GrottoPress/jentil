<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Mobile\Detector;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class MobileTest extends AbstractTestCase
{
    public function testRun()
    {
        $add_filter = FunctionMocker::replace('add_filter');

        $mobile = new Mobile(Stub::makeEmpty(AbstractTheme::class));

        $mobile->run();

        $add_filter->wasCalledOnce();
        $add_filter->wasCalledWithOnce([
            'body_class',
            [$mobile, 'addBodyClasses']
        ]);
    }

    /**
     * @dataProvider addBodyClassesProvider
     */
    public function testAddBodyClasses(
        bool $is_mobile,
        bool $is_phone,
        bool $is_tablet,
        string $os,
        string $browser,
        string $device,
        array $expected
    ) {
        $sanitize_title = FunctionMocker::replace(
            'sanitize_title',
            function (string $content): string {
                return $content;
            }
        );

        $jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);

        $jentil->utilities->mobileDetector = Stub::makeEmpty(Detector::class, [
            'isMobile' => $is_mobile,
            'isTablet' => $is_tablet,
            'isPhone' => $is_phone,
            'getOperatingSystem' => $os,
            'getBrowser' => $browser,
            'getDevice' => $device,
        ]);

        $mobile = new Mobile($jentil);

        $this->assertSame($expected, $mobile->addBodyClasses(['class-1']));

        if ($is_mobile && $os) {
            $sanitize_title->wasCalledWithOnce([$os]);
        }

        if ($is_mobile && $browser) {
            $sanitize_title->wasCalledWithOnce([$browser]);
        }

        if ($is_mobile && $device) {
            $sanitize_title->wasCalledWithOnce([$device]);
        }

        $sanitize_title->wasCalledTimes('<=3');
    }

    public function addBodyClassesProvider(): array
    {
        return [
            'class added if not mobile' => [
                false,
                false,
                false,
                'ios',
                'chrome',
                'hp-pavilion',
                ['class-1', 'desktop'],
            ],
            'class added if is phone' => [
                true,
                true,
                false,
                '',
                '',
                '',
                ['class-1', 'mobile', 'phone'],
            ],
            'class added if is tablet' => [
                true,
                false,
                true,
                '',
                '',
                '',
                ['class-1', 'mobile', 'tablet'],
            ],
            'class added if os identified' => [
                true,
                false,
                false,
                'androidos',
                '',
                '',
                ['class-1', 'mobile', 'androidos'],
            ],
            'class added if browser identified' => [
                true,
                false,
                false,
                '',
                'chrome',
                '',
                ['class-1', 'mobile', 'chrome'],
            ],
            'class added if device identified' => [
                true,
                false,
                false,
                '',
                '',
                'nexus',
                ['class-1', 'mobile', 'nexus'],
            ],
        ];
    }
}
