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
	/**
	 * Do action before comments
	 * 
	 * @action		jentil_before_comments
	 *
	 * @since       Jentil 0.1.0
	 */
    do_action( 'jentil_before_comments' );

	if ( have_comments() ) {
		$total_pages = absint( get_comment_pages_count() );
		$comment_count = absint( get_comments_number() ); ?>

    	<div id="comments-list">
    		<h3 class="comments-title"><?php printf( _n(
    			'1 Comment',
    			'%1$s Comments',
    			$comment_count, 'jentil'
    		), number_format_i18n( $comment_count ) ); ?></h3>

    		<?php /** Top navigation */
    		if ( $total_pages > 1 && get_option( 'page_comments' ) ) { ?>
    			
    			<nav role="navigation" class="navigation top-nav self-clear comments-pagination"><?php
    				
                    /**
					 * Filter the previous and next labels.
					 * 
					 * @var         string          $prev_label         Previous label.
					 * @var         string          $next_label         Next label.
					 * 
					 * @filter		jentil_pagination_prev_label
					 * @filter		jentil_pagination_next_label
					 *
					 * @since       Jentil 0.1.0
					 */
    				$prev_label = sanitize_text_field( apply_filters( 'jentil_pagination_prev_label', __( '&larr; Previous', 'jentil' ), 'comments' ) );
    				$next_label = sanitize_text_field( apply_filters( 'jentil_pagination_next_label', __( 'Next &rarr;', 'jentil' ), 'comments' ) );
    				
    				paginate_comments_links( array(
    					'prev_text' => $prev_label,
    					'next_text' => $next_label,
    				) );
    			
    			?></nav>
    		
    		<?php }
    
    		/**
			 * Do action before title
			 * 
			 * @action		jentil_before_title
			 *
			 * @since       Jentil 0.1.0
			 */
			$comment_avatar_size = absint( apply_filters( 'jentil_comments_avatar_size', 40 ) );
    		
    		/** List our comments */
    		$comment_list_args = array(
    			'style' => 'ol',
    			'avatar_size' => $comment_avatar_size,
    		); ?>
    		
    		<ol class="commentlist"><?php wp_list_comments( $comment_list_args ); ?></ol>
    
    		<?php /** Bottom navigation */
    		if ( $total_pages > 1 && get_option( 'page_comments' ) ) { ?>
    		
    			<nav role="navigation" class="navigation bottom-nav self-clear comments-pagination">
    			
    				<?php paginate_comments_links( array(
    					'prev_text' => $prev_label,
    					'next_text' => $next_label,
    				) ); ?>
    		
    			</nav>
    			
    		<?php } ?>
    
    	</div><!-- #comments-list -->
    	
        <?php /** If comments are closed and there are comments, let's leave a little note, shall we? */
    	if ( ! comments_open() ) { ?>

    		<p class="comments-closed">

                <?php echo sanitize_text_field( apply_filters( 'magpack_comments_closed_text', esc_html__( 'Comments closed', 'jentil' ), get_comments_number() ) ); ?>
                
            </p>
            
    	<?php }
	}

	comment_form(); ?>

</div><!-- #comments -->