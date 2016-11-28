<?php

/**
 * Comments.
 *
 * The template for displaying comments; the area of the page
 * that contains both current comments and the comment form.
 *
 * @link			https://jentil.grotttopress.com
 * @package			jentil
 * @since			jentil 1.0.0
 */

if ( post_password_required() ) {
	return;
}

if ( ! comments_open() && ! have_comments() ) {
    return;
}

if ( ! post_type_supports( get_post_type(), 'comments' ) ) {
	return;
}

?>

<div id="comments" class="site-comments self-clear">
	    
    <?php
	
    do_action( 'jentil_before_comments' );

	if ( have_comments() ) {
		$total_pages = absint( get_comment_pages_count() );
		$comment_count = absint( get_comments_number() );
        
	?>

    	<div id="comments-list">
    		<h3 class="comments-title"><?php printf( _n( '1 Comment on &ldquo;%2$s&rdquo;', '%1$s Comments on &ldquo;%2$s&rdquo;', $comment_count, 'jentil' ), number_format_i18n( $comment_count ), '<span>' . get_the_title() . '</span>' ); ?></h3>
    
    		<?php /** Top navigation */
    		if ( $total_pages > 1 && get_option( 'page_comments' ) ) { ?>
    			
    			<nav role="navigation" class="navigation top-nav self-clear comments-pagination">
    				
    				<?php paginate_comments_links( array(
    					'prev_text' => wp_kses_post( apply_filters( 'jentil_comments_pagination_prev_label', '&larr; Previous' ) ),
    					'next_text' => wp_kses_post( apply_filters( 'jentil_comments_pagination_next_label', 'Next &rarr;' ) ),
    				) ); ?>
    			
    			</nav>
    		
    		<?php }
    
    		/** List our comments */
    		$comment_list_args = array(
    			'style' => 'ol',
    			'avatar_size' => absint( apply_filters( 'jentil_comments_avatar_size', 40 ) )
    		); ?>
    		
    		<ol class="commentlist"><?php wp_list_comments( $comment_list_args ); ?></ol>
    
    		<?php /** Bottom navigation */
    		if ( $total_pages > 1 && get_option( 'page_comments' ) ) { ?>
    		
    			<nav role="navigation" class="navigation bottom-nav self-clear comments-pagination">
    			
    				<?php paginate_comments_links( array(
    					'prev_text' => wp_kses_post( apply_filters( 'jentil_comments_pagination_prev_label', '&larr; Prev' ) ),
    					'next_text' => wp_kses_post( apply_filters( 'jentil_comments_pagination_next_label', 'Next &rarr;' ) ),
    				) ); ?>
    		
    			</nav>
    			
    		<?php } ?>
    
    	</div><!-- #comments-list -->
    	
        <?php /** If comments are closed and there are comments, let's leave a little note, shall we? */
    	if ( ! comments_open() ) { ?>
    		<p class="comments-closed"><?php echo wp_kses_post( apply_filters( 'magpack_comments_closed_text', esc_html__( 'Comments closed', 'jentil' ), get_comments_number() ) ); ?></p>
    	<?php }
	}

	comment_form();
	
	?>

</div><!-- #comments -->