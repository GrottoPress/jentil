<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Setups\Views;

use Codeception\Util\Stub;
use GrottoPress\Jentil\AbstractTestCase;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\Utilities\Page\Page;
use GrottoPress\Jentil\Utilities\Loader;
use GrottoPress\Jentil\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class AttachmentTest extends AbstractTestCase
{
    /**
     * @var AbstractTheme
     */
    private $jentil;

    /**
     * @var string
     */
    private $page;

    /**
     * @var string
     */
    private $subPage = '';

    public function _before()
    {
        $this->jentil = Stub::makeEmpty(AbstractTheme::class, [
            'utilities' => Stub::makeEmpty(Utilities::class),
        ]);

        $this->jentil->utilities->page = Stub::makeEmpty(Page::class, [
            'is' => function (string $type, string $subtype = ''): bool {
                if ($subtype) {
                    return $this->page === $type && $this->subPage === $subtype;
                }

                return ($this->page === $type);
            }
        ]);
    }

    public function testRun()
    {
        $add_action = FunctionMocker::replace('add_action');

        $attachment = new Attachment(Stub::makeEmpty(AbstractTheme::class));

        $attachment->run();

        $add_action->wasCalledTimes(2);

        $add_action->wasCalledWithOnce([
            'wp_head',
            [$attachment, 'removePrepended']
        ]);

        $add_action->wasCalledWithOnce([
            'jentil_before_content',
            [$attachment, 'renderAttachment']
        ]);
    }

    /**
     * @dataProvider removePrependedProvider
     */
    public function testRemovePrepended(string $page)
    {
        $this->page = $page;

        $remove_filter = FunctionMocker::replace('remove_filter');

        $attachment = new Attachment($this->jentil);

        $attachment->removePrepended();

        if ('attachment' === $page) {
            $remove_filter->wasCalledOnce();
            $remove_filter->wasCalledWithOnce([
                'the_content',
                'prepend_attachment'
            ]);
        } else {
            $remove_filter->wasNotCalled();
        }
    }

    /**
     * @dataProvider renderAttachmentProvider
     */
    public function testRenderAttachment(
        string $page,
        array $post,
        string $type
    ) {
        $this->page = $page;

        FunctionMocker::replace('get_post', \json_decode(\json_encode($post)));

        $remove_filter = FunctionMocker::replace('remove_filter');
        $get_the_title = FunctionMocker::replace('get_the_title');

        $is_image = FunctionMocker::replace(
            'wp_attachment_is_image',
            'image' === $type
        );

        $is = FunctionMocker::replace('wp_attachment_is', function (
            string $at_type,
            int $postId
        ) use ($type): bool {
            return ($at_type === $type);
        });

        $this->jentil->utilities->loader = Stub::makeEmpty(Loader::class, [
            'loadPartial' => true,
        ]);

        $attachment = new Attachment($this->jentil);

        if ('attachment' === $page) {
            if (\in_array($type, ['image', 'audio', 'video'])) {
                $this->jentil->utilities->loader
                    ->expects($this->once())->method('loadPartial')
                    ->with($this->equalTo($page), $this->equalTo($type));
            } else {
                $this->jentil->utilities->loader
                    ->expects($this->once())->method('loadPartial')
                    ->with($this->equalTo($page));
            }
        } else {
            $this->jentil->utilities->loader->expects($this->never())->method(
                'loadPartial'
            );
        }

        $attachment->renderAttachment();
    }

    public function renderAttachmentProvider(): array
    {
        return [
            'page is not attachment' => ['404', ['ID' => 44], ''],
            'attachment is image' => ['attachment', ['ID'=> 99], 'image'],
            'attachment is audio' => ['attachment', ['ID' => 55], 'audio'],
            'attachment is video' => ['attachment', ['ID' => 55], 'video'],
            'attachment is pdf' => ['attachment', ['ID' => 66], 'pdf']
        ];
    }

    public function removePrependedProvider()
    {
        return [
            'page is attachment' => ['attachment'],
            'page is not attachment' => ['search'],
        ];
    }
}
