<?php
declare (strict_types = 1);

namespace GrottoPress\Jentil\Tests\Unit\Setups\Views;

use Codeception\Util\Stub;
use GrottoPress\Jentil\Tests\Unit\TestCase;
use GrottoPress\Jentil\Setups\Views\Singular;
use GrottoPress\Jentil\Utilities\Utilities;
use GrottoPress\Jentil\Utilities\Page\Page;
use GrottoPress\Jentil\Utilities\Page\Posts\Posts;
use GrottoPress\Jentil\Utilities\Page\Posts\Related;
use GrottoPress\Jentil\Utilities\Loader;
use GrottoPress\Jentil\Utilities\CustomTemplate;
use GrottoPress\Jentil\Utilities\ThemeMods\Posts as PostsMod;
use GrottoPress\WordPress\Post\Post;
use GrottoPress\WordPress\Posts\Posts as PostsPackage;
use GrottoPress\WordPress\SUV\AbstractTheme;
use tad\FunctionMocker\FunctionMocker;

class SingularTest extends TestCase
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
        $singular = new Singular(Stub::makeEmpty(AbstractTheme::class));

        $add_action = FunctionMocker::replace('add_action');
        $add_filter = FunctionMocker::replace('add_filter');

        $singular->run();

        $add_action->wasCalledTimes(3);
        $add_filter->wasCalledTimes(2);

        $add_action->wasCalledWithOnce([
            'jentil_before_content',
            [$singular, 'renderAttachment']
        ]);

        $add_action->wasCalledWithOnce([
            'jentil_after_content',
            [$singular, 'renderRelatedPosts']
        ]);

        $add_action->wasCalledWithOnce([
            'jentil_after_title',
            [$singular, 'renderByline']
        ]);

        $add_filter->wasCalledWithOnce([
            'body_class',
            [$singular, 'addBodyClasses']
        ]);

        $add_filter->wasCalledWithOnce([
            'jentil_singular_after_title',
            [$singular, 'byline'],
            10,
            3
        ]);
    }

    /**
     * @dataProvider addBodyClassesProvider
     */
    public function testAddBodyClasses(
        string $page,
        string $template,
        array $postTypeSupports,
        bool $commentsOpen,
        bool $show_avatars,
        bool $thread_comments,
        array $post,
        array $expected
    ) {
        $this->page = $page;

        $this->jentil->utilities->customTemplate = Stub::makeEmpty(
            CustomTemplate::class,
            [
                'slug' => $template,
            ]
        );

        $singular = new Singular($this->jentil);

        $sanitize_title = FunctionMocker::replace(
            'sanitize_title',
            function (string $content): string {
                return $content;
            }
        );

        $get_post = FunctionMocker::replace('get_post', function (
            $p = null
        ) use ($post) {
            if ($p) {
                return \json_decode(\json_encode($p));
            }

            return \json_decode(\json_encode($post));
        });

        $template_slug = FunctionMocker::replace(
            'get_page_template_slug',
            $template
        );

        $post_type_supports = FunctionMocker::replace(
            'post_type_supports',
            function (
                string $type,
                string $check
            ) use ($postTypeSupports): bool {
                return \in_array($check, $postTypeSupports);
            }
        );

        $get_option = FunctionMocker::replace(
            'get_option',
            function (string $option) use ($show_avatars, $thread_comments) {
                return ${$option};
            }
        );

        $comments_open = FunctionMocker::replace(
            'comments_open',
            $commentsOpen
        );

        $this->assertSame($expected, $singular->addBodyClasses(['class-1']));
    }

    /**
     * @dataProvider renderParentLinkProvider
     */
    public function testRenderParentLink(string $page, array $post)
    {
        $this->page = $page;

        $singular = new Singular($this->jentil);

        FunctionMocker::replace('get_post', \json_decode(\json_encode($post)));

        $get_permalink = FunctionMocker::replace('get_permalink');
        $get_the_title = FunctionMocker::replace('get_the_title');

        $singular->renderParentLink();

        if ('singular' === $page && !empty($post['post_parent'])) {
            $get_permalink->wasCalledOnce();
            $get_permalink->wasCalledWithOnce([$post['post_parent']]);

            $get_the_title->wasCalledOnce();
            $get_the_title->wasCalledWithOnce([$post['post_parent']]);
        } else {
            $get_permalink->wasNotCalled();
            $get_the_title->wasNotCalled();
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

        $this->jentil->utilities->loader = Stub::makeEmpty(Loader::class, [
            'loadPartial' => true,
        ]);

        $singular = new Singular($this->jentil);

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

        $singular->renderAttachment();

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
     * @dataProvider bylineProvider
     */
    public function testByline(string $page, string $subPage)
    {
        $this->page = $page;
        $this->subPage = $subPage;

        $this->jentil->utilities->post = Stub::makeEmpty(Post::class, [
            'info' => true,
        ]);

        $singular = new Singular($this->jentil);

        if ('singular' === $page && 'post' === $subPage) {
            $this->jentil->utilities->post
                ->expects($this->atLeastOnce())->method('info');
        } else {
            $this->jentil->utilities->post
                ->expects($this->never())->method('info');
        }

        $byline = $singular->byline('hello...', 1, '|');

        if ('singular' !== $page || 'post' !== $subPage) {
            $this->assertSame('hello...', $byline);
        }
    }

    /**
     * @dataProvider renderBylineProvider
     */
    public function testRenderByline(string $page, string $subPage)
    {
        $this->page = $page;

        $this->jentil->utilities->post = Stub::makeEmpty(Post::class, [
            'info' => true,
        ]);

        FunctionMocker::replace('get_post', new class {
            public $ID = 1;
        });

        $singular = new Singular($this->jentil);

        if ('singular' === $page && 'post' === $subPage) {
            $this->jentil->utilities->post
                ->expects($this->atLeastOnce())->method('info');
        } else {
            $this->jentil->utilities->post
                ->expects($this->never())->method('info');
        }

        $singular->renderByline();
    }

    /**
     * @dataProvider renderRelatedPostsProvider
     */
    public function testRenderRelatedPosts(string $page, string $posts)
    {
        $this->page = $page;

        $this->jentil->utilities->page->posts = Stub::makeEmpty(Posts::class);
        $this->jentil->utilities->page->posts->related = Stub::makeEmpty(
            Related::class,
            [
                'posts' => Stub::makeEmpty(PostsPackage::class, [
                    'render' => $posts,
                ]),
                'themeMod' => Stub::makeEmpty(PostsMod::class, [
                    'get' => 'Related Posts',
                ]),
            ]
        );

        $singular = new Singular($this->jentil);

        if ('singular' === $page) {
            $this->jentil->utilities->page->posts->related
                ->expects($this->once())->method('posts');

            if ($posts) {
                $this->jentil->utilities->page->posts->related
                    ->expects($this->once())->method('themeMod')
                    ->with($this->equalTo('heading'));
            }
        } else {
            $this->jentil->utilities->page->posts->related
                ->expects($this->never())->method('posts');

            $this->jentil->utilities->page->posts->related
                ->expects($this->never())->method('themeMod');
        }

        $singular->renderRelatedPosts();
    }

    public function addBodyClassesProvider(): array
    {
        return [
            'page is not singular' => [
                'home',
                'page-builder.php',
                ['comments'],
                true,
                true,
                true,
                ['ID' => 3, 'post_type' => 'page', 'post_parent' => [
                    'ID' => 1,
                    'post_type' => 'page',
                    'post_parent' => [],
                ]],
                ['class-1'],
            ],
            'post has no parent' => [
                'singular',
                'page-builder.php',
                ['comments'],
                true,
                true,
                true,
                ['ID' => 3, 'post_type' => 'page', 'post_parent' => []],
                [
                    'class-1',
                    'page-builder.php',
                    'show-avatars',
                    'threaded-comments',
                    'comments-open',
                ],
            ],
            'post has parent' => [
                'singular',
                'page-builder.php',
                ['comments'],
                true,
                true,
                true,
                ['ID' => 3, 'post_type' => 'page', 'post_parent' => [
                    'ID' => 1000,
                    'post_type' => 'page',
                    'post_parent' => [],
                ]],
                [
                    'class-1',
                    'child-page',
                    'page-parent-1-1000',
                    'page-builder.php',
                    'show-avatars',
                    'threaded-comments',
                    'comments-open',
                ],
            ],
            'post has grand parent' => [
                'singular',
                'page-builder.php',
                ['comments'],
                true,
                true,
                true,
                ['ID' => 3010, 'post_type' => 'tutorial', 'post_parent' => [
                    'ID' => 2010,
                    'post_type' => 'tutorial',
                    'post_parent' => [
                        'ID' => 1010,
                        'post_type' => 'tutorial',
                        'post_parent' => [],
                    ],
                ]],
                [
                    'class-1',
                    'child-tutorial',
                    'tutorial-parent-1-2010',
                    'tutorial-parent-2-1010',
                    'page-builder.php',
                    'show-avatars',
                    'threaded-comments',
                    'comments-open',
                ],
            ],
            'post has great grand parent' => [
                'singular',
                'page-builder.php',
                ['comments'],
                true,
                true,
                true,
                ['ID' => 4111, 'post_type' => 'tutorial', 'post_parent' => [
                    'ID' => 3111,
                    'post_type' => 'tutorial',
                    'post_parent' => [
                        'ID' => 2111,
                        'post_type' => 'tutorial',
                        'post_parent' => [
                            'ID' => 1111,
                            'post_type' => 'tutorial',
                            'post_parent' => [],
                        ],
                    ],
                ]],
                [
                    'class-1',
                    'child-tutorial',
                    'tutorial-parent-1-3111',
                    'tutorial-parent-2-2111',
                    'tutorial-parent-3-1111',
                    'page-builder.php',
                    'show-avatars',
                    'threaded-comments',
                    'comments-open',
                ],
            ],
            'comments not supported' => [
                'singular',
                'page-builder.php',
                ['automatic-feed-links'],
                true,
                true,
                true,
                ['ID' => 3222, 'post_type' => 'book', 'post_parent' => [
                    'ID' => 2222,
                    'post_type' => 'book',
                    'post_parent' => [],
                ]],
                [
                    'class-1',
                    'child-book',
                    'book-parent-1-2222',
                    'page-builder.php',
                ],
            ],
            'no avatars' => [
                'singular',
                'page-builder.php',
                ['comments'],
                true,
                false,
                true,
                ['ID' => 3222, 'post_type' => 'book', 'post_parent' => [
                    'ID' => 2222,
                    'post_type' => 'book',
                    'post_parent' => [],
                ]],
                [
                    'class-1',
                    'child-book',
                    'book-parent-1-2222',
                    'page-builder.php',
                    'hide-avatars',
                    'threaded-comments',
                    'comments-open',
                ],
            ],
            'comments not threaded' => [
                'singular',
                'page-builder.php',
                ['comments'],
                true,
                true,
                false,
                ['ID' => 3222, 'post_type' => 'book', 'post_parent' => [
                    'ID' => 2222,
                    'post_type' => 'book',
                    'post_parent' => [],
                ]],
                [
                    'class-1',
                    'child-book',
                    'book-parent-1-2222',
                    'page-builder.php',
                    'show-avatars',
                    'unthreaded-comments',
                    'comments-open',
                ],
            ],
            'comments closed' => [
                'singular',
                'page-builder.php',
                ['comments'],
                false,
                true,
                true,
                ['ID' => 3222, 'post_type' => 'book', 'post_parent' => [
                    'ID' => 2222,
                    'post_type' => 'book',
                    'post_parent' => [],
                ]],
                [
                    'class-1',
                    'child-book',
                    'book-parent-1-2222',
                    'page-builder.php',
                    'show-avatars',
                    'threaded-comments',
                    'comments-closed',
                ],
            ],
        ];
    }

    public function renderParentLinkProvider(): array
    {
        return [
            'page is singular' => ['singular', ['post_parent' => 555]],
            'page is not singular' => ['search', ['post_parent' => 555]],
            'post has no parent' => ['singular', ['post_parent' => 0]],
        ];
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

    public function bylineProvider(): array
    {
        return [
            'page is single post' => ['singular', 'post'],
            'page is not single post' => ['home', ''],
        ];
    }

    public function renderBylineProvider(): array
    {
        return [
            'page is single post' => ['singular', 'post'],
            'page is not single post' => ['home', ''],
        ];
    }

    public function renderRelatedPostsProvider(): array
    {
        return [
            'page is not singular' => ['home', 'related posts'],
            'page is singular, posts empty' => ['singular', ''],
            'page is singular, posts not empty' => [
                'singular',
                'related posts'
            ],
        ];
    }
}
