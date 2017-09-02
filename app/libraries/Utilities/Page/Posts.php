<?php

/**
 * Posts
 *
 * @package GrottoPress\Jentil\Utilities\Page
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare ( strict_types = 1 );

namespace GrottoPress\Jentil\Utilities\Page;

if ( ! \defined( 'WPINC' ) ) {
    die;
}

/**
 * Posts
 * 
 * @since 0.1.0
 */
final class Posts {
    /**
     * Page
     *
     * @since 0.1.0
     * @access private
     * 
     * @var GrottoPress\Jentil\Utilities\Page\Page $page Page.
     */
    private $page;

    /**
     * Sticky posts enabled?
     *
     * @since 0.1.0
     * @access private
     * 
     * @var boolean $sticky_enabled Is sticky posts enabled?
     */
    private $sticky_enabled;

    /**
     * Sticky posts
     *
     * @since 0.1.0
     * @access private
     * 
     * @var array $sticky_posts Sticky posts IDs.
     */
    private $sticky_posts;

    /**
     * Post types
     *
     * @since 0.1.0
     * @access private
     * 
     * @var array $post_types Post type objects.
     */
    private $post_types;

    /**
     * Archive Post types
     *
     * @since 0.1.0
     * @access private
     * 
     * @var array $archive_post_types All post types with archive.
     */
    private $archive_post_types;
    
    /**
     * Constructor
     *
     * @param GrottoPress\Jentil\Utilities\Page\Page $page Page.
     *
     * @since 0.1.0
     * @access public
     */
    public function __construct( Page $page ) {
        $this->page = $page;

        $this->sticky_posts = $this->sticky_posts();
        $this->post_types = $this->post_types();
        $this->archive_post_types = $this->archive_post_types();
    }

    /**
     * Get Posts
     * 
     * @since 0.1.0
     * @access public
     * 
     * @return string Posts.
     */
    public function get(): string {
        $out = '';

        if (
            ! $this->page->is( 'singular' )
            && ! $this->page->is( 'paged' )
            && ( $this->sticky_enabled = $this->sticky_enabled() )
            && $this->sticky_posts
        ) {
            $out .= $this->page->utilities()->posts( $this->sticky_args() )->run();
        }

        $out .= $this->page->utilities()->posts( $this->args() )->run();

        return $out;
    }

    /**
     * Get sticky posts
     * 
     * @since 0.1.0
     * @access private
     * 
     * @return array Sticky posts
     */
    private function sticky_posts(): array {
        return \array_map( 'absint', \get_option( 'sticky_posts' ) );
    }

    /**
     * Post types
     * 
     * @since 0.1.0
     * @access private
     * 
     * @return array Post types
     */
    private function post_types(): array {
        return \get_post_types( [ 'public' => true ], 'objects' );
    }

    /**
     * Archive Post types
     * 
     * @since 0.1.0
     * @access private
     * 
     * @return array All post types with archive.
     */
    private function archive_post_types(): array {
        $archive_post_types = [];

        if ( ! $this->post_types ) {
            return $archive_post_types;
        }

        foreach ( $this->post_types as $post_type ) {
            if ( $post_type->has_archive || 'post' == $post_type->name ) {
                $archive_post_types[] = $post_type->name;
            }
        }

        return $archive_post_types;
    }

    /**
     * Sticky posts enabled?
     * 
     * @since 0.1.0
     * @access private
     * 
     * @return bool Do we have sticky posts enabled?
     */
    private function sticky_enabled(): bool {
        return ( bool ) $this->mod( 'sticky_posts' );
    }

    /**
     * Get Posts Query Args
     * 
     * @since 0.1.0
     * @access private
     * 
     * @return array Posts args.
     */
    private function args(): array {
        if ( $this->page->is( 'singular' ) ) {
            return $this->singular_args();
        }

        return $this->archives_args();
    }

    /**
     * Singular posts args.
     * 
     * @since 0.1.0
     * @access private
     * 
     * @return array Singular posts args.
     */
    private function singular_args(): array {
        global $post;

        return [
            'layout' => 'stack',
            'id' => 'main-query',
            'class' => 'singular-post',
            'excerpt' => [
                'length' => -2,
                'paginate' => 1,
                'more_text' => '',
            ],
            'title' => [
                'length' => -1,
                'position' => 'top',
                'tag' => 'h1',
                'link' => 0,
            ],
            'after_title' => [
                'info' => 'jentil_singular_after_title',
            ],
            'wp_query' => [
                'posts_per_page' => 1,
                'post_type' => $post->post_type,
                'p' => $post->ID,
                'ignore_sticky_posts' => 1,
            ],
        ];
    }

    /**
     * Archives Posts Args
     * 
     * @since 0.1.0
     * @access private
     * 
     * @return array Archives posts args.
     */
    private function archives_args(): array {
        global $wp_rewrite;

        $args = [
            // 'tag' => $this->mod( 'wrap_tag' ),
            'class' => $this->mod( 'wrap_class' ),
            'id' => 'main-query',
            'layout' => $this->mod( 'layout' ),
            'text_offset' => $this->mod( 'text_offset' ),
            'image' => [
                'size' => $this->mod( 'image' ),
                'align' => $this->mod( 'image_alignment' ),
            ],
            'after_title' => [
                'info' => $this->mod( 'after_title' ),
                'sep' => $this->mod( 'after_title_separator' ),
            ],
            'after_content' => [
                'info' => $this->mod( 'after_content' ),
                'sep' => $this->mod( 'after_content_separator' ),
            ],
            'before_title' => [
                'info' => $this->mod( 'before_title' ),
                'sep' => $this->mod( 'before_title_separator' ),
            ],
            'excerpt' => [
                'length' => $this->mod( 'excerpt' ),
                'paginate' => 0,
                'more_text' => $this->mod( 'more_link' ),
            ],
            'pagination' => [
                'type' => $this->mod( 'pagination' ),
                'max' => $this->mod( 'pagination_maximum' ),
                'key' => $wp_rewrite->pagination_base,
                'position' => $this->mod( 'pagination_position' ),
                'prev_text' => $this->mod( 'pagination_previous_label' ),
                'next_text' => $this->mod( 'pagination_next_label' ),
            ],
            'title' => [
                'length' => $this->mod( 'title_words' ),
                'position' => $this->mod( 'title_position' ),
                'tag' => 'h2',
                'link' => 1,
            ],
            'wp_query' => [
                'posts_per_page' => $this->mod( 'number' ),
                's' => \get_search_query(),
                'post__not_in' => ( $this->sticky_enabled ? $this->sticky_posts : null ),
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
            ],
        ];

        if (
            ( $post_type = \get_query_var( 'post_type' ) )
            || $this->page->is( 'home' )
            || $this->page->is( 'post_type_archive' )
        ) {
            $args['wp_query']['post_type'] = $post_type;
        } else {
            $args['wp_query']['post_type'] = $this->archive_post_types;
        }

        if ( $this->page->is( 'search' ) ) {
            if ( \function_exists( 'is_customize_preview' ) ) { // If WP >= 4.0
                $args['wp_query']['orderby']['all_time_views'] = 'DESC';
                $args['wp_query']['orderby']['comment_count'] = 'DESC';
            } else {
                $args['wp_query']['orderby'] = 'all_time_views';
                $args['wp_query']['order'] = 'DESC';
            }
        }

        if ( ( $taxonomy = \get_query_var( 'taxonomy' ) ) ) {
            $args['wp_query']['tax_query'] = [ 
                [
                    'taxonomy' => $taxonomy,
                    'terms' => \get_query_var( 'term' ),
                    'field' => 'slug',
                ],
            ];
        }

        if ( \get_query_var( 'year' ) || \get_query_var( 'monthnum' ) || \get_query_var( 'day' ) ) {
            $args['wp_query']['date_query'] = [
                [
                    'year' => \get_query_var( 'year' ),
                    'month' => \get_query_var( 'monthnum' ),
                    'day' => \get_query_var( 'day' ),
                ],
            ];
        }

        if ( ( $cat = \get_query_var( 'cat' ) ) ) {
            $args['wp_query']['cat']    = $cat;
        }

        if ( ( $cat_in = \get_query_var( 'category__in' ) ) ) {
            $args['wp_query']['category__in']   = $cat_in;
        }

        if ( ( $cat_not_in = \get_query_var( 'category__not_in' ) ) ) {
            $args['wp_query']['category__not_in']   = $cat_not_in;
        }

        if ( ( $cat_and = \get_query_var( 'category__and' ) ) ) {
            $args['wp_query']['category__and']  = $cat_and;
        }

        if ( ( $tag_id = \get_query_var( 'tag_id' ) ) ) {
            $args['wp_query']['tag_id'] = $tag_id;
        }

        if ( ( $tag_in = \get_query_var( 'tag__in' ) ) ) {
            $args['wp_query']['tag__in']    = $tag_in;
        }

        if ( ( $tag_not_in = \get_query_var( 'tag__not_in' ) ) ) {
            $args['wp_query']['tag__not_in']    = $tag_not_in;
        }

        if ( ( $tag_and = \get_query_var( 'tag__and' ) ) ) {
            $args['wp_query']['tag__and']   = $tag_and;
        }

        if ( ( $author_id = \get_query_var( 'author' ) ) ) {
            $args['wp_query']['author'] = $author_id;
        }

        if ( ( $author_in = \get_query_var( 'author__in' ) ) ) {
            $args['wp_query']['author__in'] = $author_in;
        }

        if ( ( $author_not_in = \get_query_var( 'author__not_in' ) ) ) {
            $args['wp_query']['author__not_in'] = $author_not_in;
        }

        return $args;
    }

    /**
     * Sticky Posts Args
     * 
     * @since 0.1.0
     * @access private
     * 
     * @return array Sticky posts args.
     */
    private function sticky_args(): array {
        $args = [
            // 'tag' => $this->sticky_mod( 'wrap_tag' ),
            'class' => $this->sticky_mod( 'wrap_class' ),
            'id' => 'main-query-sticky-posts',
            'layout' => $this->sticky_mod( 'layout' ),
            'text_offset' => $this->sticky_mod( 'text_offset' ),
            'image' => [
                'size' => $this->sticky_mod( 'image' ),
                'align' => $this->sticky_mod( 'image_alignment' ),
            ],
            'after_title' => [
                'info' => $this->sticky_mod( 'after_title' ),
                'sep' => $this->sticky_mod( 'after_title_separator' ),
            ],
            'after_content' => [
                'info' => $this->sticky_mod( 'after_content' ),
                'sep' => $this->sticky_mod( 'after_content_separator' ),
            ],
            'before_title' => [
                'info' => $this->sticky_mod( 'before_title' ),
                'sep' => $this->sticky_mod( 'before_title_separator' ),
            ],
            'excerpt' => [
                'length' => $this->sticky_mod( 'excerpt' ),
                'paginate' => 0,
                'more_text' => $this->sticky_mod( 'more_link' ),
            ],
            'title' => [
                'length' => $this->sticky_mod( 'title_words' ),
                'position' => $this->sticky_mod( 'title_position' ),
                'tag' => 'h2',
                'link' => 1,
            ],
            'wp_query' => [
                'posts_per_page'        => -1,
                'post__in'              => $this->sticky_posts,
                'post_status'           => 'publish',
                'ignore_sticky_posts'   => 1,
            ],
        ];

        $args['wp_query']['post_type'] = \get_query_var( 'post_type' );

        if ( ( $taxonomy = \get_query_var( 'taxonomy' ) ) ) {
            $args['wp_query']['tax_query'] = [ 
                [
                    'taxonomy'      => $taxonomy,
                    'terms'         => \get_query_var( 'term_id' ),
                    'field'         => 'term_id',
                ],
            ];
        }

        if ( \get_query_var( 'year' ) || \get_query_var( 'monthnum' ) || \get_query_var( 'day' ) ) {
            $args['wp_query']['date_query'] = [
                [
                    'year' => \get_query_var( 'year' ),
                    'month' => \get_query_var( 'monthnum' ),
                    'day' => \get_query_var( 'day' ),
                ],
            ];
        }

        if ( ( $cat = \get_query_var( 'cat' ) ) ) {
            $args['wp_query']['cat']    = $cat;
        }

        if ( ( $cat_in = \get_query_var( 'category__in' ) ) ) {
            $args['wp_query']['category__in']   = $cat_in;
        }

        if ( ( $cat_not_in = \get_query_var( 'category__not_in' ) ) ) {
            $args['wp_query']['category__not_in']   = $cat_not_in;
        }

        if ( ( $cat_and = \get_query_var( 'category__and' ) ) ) {
            $args['wp_query']['category__and']  = $cat_and;
        }

        if ( ( $tag_id = \get_query_var( 'tag_id' ) ) ) {
            $args['wp_query']['tag_id'] = $tag_id;
        }

        if ( ( $tag_in = \get_query_var( 'tag__in' ) ) ) {
            $args['wp_query']['tag__in']    = $tag_in;
        }

        if ( ( $tag_not_in = \get_query_var( 'tag__not_in' ) ) ) {
            $args['wp_query']['tag__not_in']    = $tag_not_in;
        }

        if ( ( $tag_and = \get_query_var( 'tag__and' ) ) ) {
            $args['wp_query']['tag__and']   = $tag_and;
        }

        if ( ( $author_id = \get_query_var( 'author' ) ) ) {
            $args['wp_query']['author'] = $author_id;
        }

        if ( ( $author_in = \get_query_var( 'author__in' ) ) ) {
            $args['wp_query']['author__in'] = $author_in;
        }

        if ( ( $author_not_in = \get_query_var( 'author__not_in' ) ) ) {
            $args['wp_query']['author__not_in'] = $author_not_in;
        }

        return $args;
    }

    /**
     * Sticky posts mod
     *
     * @param string $setting
     * 
     * @since 0.1.0
     * @access private
     * 
     * @return mixed Sticky posts mod.
     */
    private function sticky_mod( string $setting ) {
        $args = [
            'context' => 'sticky',
        ];

        if ( $this->page->is( 'home' ) ) {
            $args['specific'] = 'post';
        } elseif ( $this->page->is( 'post_type_archive' ) ) {
            $args['specific'] = \get_query_var( 'post_type' );
        }

        if ( \is_array( $args['specific'] ) ) {
            $args['specific'] = $args['specific'][0];
        }

        return $this->mod( $setting, $args );
    }

    /**
     * Posts mods
     *
     * @param string $setting
     * @param array $args
     * 
     * @since 0.1.0
     * @access private
     * 
     * @return mixed Posts mod.
     */
    private function mod( string $setting, array $args = [] ) {
        if ( ! empty( $args['context'] ) ) {
            return $this->page->utilities()->mods()->posts( $setting, $args )->get();
        }

        $page = $this->page->type();

        $specific = '';
        $more_specific = '';

        foreach ( $page as $type ) {
            if ( 'post_type_archive' == $type ) {
                $specific = \get_query_var( 'post_type' );
            } elseif ( 'tax' == $type ) {
                $specific = \get_query_var( 'taxonomy' );
            } elseif ( 'category' == $type ) {
                $specific = 'category';
            } elseif ( 'tag' == $type ) {
                $specific = 'post_tag';
            }

            if ( \is_array( $specific ) ) {
                $specific = $specific[0];
            }

            if ( \is_array( $more_specific ) ) {
                $more_specific = $more_specific[0];
            }

            $mod = $this->page->utilities()->mods()->posts( $setting, [
                'context' => $type,
                'specific' => $specific,
                'more_specific' => $more_specific,
            ] );

            if ( $mod->name() ) {
                return $mod->get();
            }
        }

        return $mod->default();
    }
}
