<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

<<<<<<< HEAD
	<!-- VVb Begin of new code to print comments. -->
	<?php if ( have_comments() ) : 
		$count = array(); 
    	$count = comments_type( $count);
		// echo('Var dump in comment loop.');
    	// var_dump($count);

    	// $comm = get_comments( 'status=approve&post_id=' . $id );
    	// var_dump($comm);

     	// SYNTHESIS
     	$noSyntheses = $count['synthesis']; 
       	if ( $noSyntheses > 0 ) : 
	    	echo('<h2 class="comments-title">Synthesis</h2>');
		 	the_comments_navigation(); 
         	// printf( '%1$s Synthesis', $noSyntheses);
         
		 	echo('<ol class="comment-list">');
				wp_list_comments(
					array(
                    'type'        => 'synthesis', // 'type=review&synthesis=twentyten_comment'
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 42,
					)
				);
		 	echo('</ol>'); 
		 	the_comments_navigation();
    	endif; // if noSynthesis larger than 0. 
	endif; // Check for have_comments(). 
	?>


	<?php if ( have_comments() ) : 
    	// REVIEWS
    	$noReviews = $count['review']; 
    	if ( $noReviews > 0 ) : 
			echo('<h2 class="comments-title">Reviews</h2>');
	        the_comments_navigation(); 
	        // printf( '%1$s Reviews', $noReviews);
	        echo('<ol class="comment-list">');
				wp_list_comments(
					array(
	                    'type'        => 'review', // 'type=review&callback=twentyten_comment'
=======
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">Comments</h2>

		<?php the_comments_navigation(); ?>
		Number of comments
		<?php 
		  $count = 0;
          printf( '%1$s Comments', comments_type( 'comment', $count)); 
        ?>
		<ol class="comment-list">
			<?php
				wp_list_comments(
					array(
                        'type'        => 'comment', // 'type=comment&callback=twentyten_comment'
>>>>>>> 00cadeab397a4942a357ceaea32c20e3eca8c700
						'style'       => 'ol',
						'short_ping'  => true,
						'avatar_size' => 42,
					)
				);
<<<<<<< HEAD
			echo('</ol><!-- .comment-list -->');
			the_comments_navigation();
	    endif; // if noReviews larger than 0. 
	endif; // Check for have_comments(). 
	?>


    <?php if ( have_comments() ) : 
    	// COMMENTS
    	$noComments = $count['general_comment']; 
    	if ( $noComments > 0 ) : 
			echo('<h2 class="comments-title">General comments</h2>');
        	the_comments_navigation(); 
        	// printf( '%1$s Comments', $noComments);
			echo('<ol class="comment-list">');
				wp_list_comments(
					array(
                        'type'        => 'general_comment', // 'type=comment&callback=twentyten_comment'
						'style'       => 'ol',
						'short_ping'  => true,
						'avatar_size' => 42,
					)
				);
			echo('</ol><!-- .comment-list -->');
			the_comments_navigation();
	    endif; // if noComment larger than 0.
    endif; // Check for have_comments(). 
    ?>


    <?php if ( have_comments() ) : 
    	// SPECIFIC COMMENTS
    	$noSpecifics = $count['specific_comment']; 
    	if ( $noSpecifics > 0 ) : 
			echo('<h2 class="comments-title">Specific comments</h2>');
            the_comments_navigation(); 
            // printf( '%1$s Specific comments', $noSpecifics );
			echo('<ol class="comment-list">');
				wp_list_comments(
					array(
                        'type'        => 'specific_comment', // 'type=specific&callback=twentyten_comment'
=======
			?>
		</ol><!-- .comment-list -->

		<?php the_comments_navigation(); ?>

	<?php endif; // Check for have_comments(). ?>
	
	
	
	
	<!-- VVb copy of the above section, this one for links -->
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">Links</h2>

		<?php the_comments_navigation(); ?>
		Number of callbacks
		<?php 
          $noLinks = comments_type( 'callback', $count);
		  printf( '%1$s Links', $noLinks );
        ?>
        <!-- <?php comments_type( 'callback' ); ?> -->
		<ol class="comment-list">
			<?php
				wp_list_comments(
					array(
                        'type'        => 'callback', // 'type=comment&callback=twentyten_comment'
>>>>>>> 00cadeab397a4942a357ceaea32c20e3eca8c700
						'style'       => 'ol',
						'short_ping'  => true,
						'avatar_size' => 42,
					)
				);
<<<<<<< HEAD
			echo('</ol> <!-- .comment-list -->');
		the_comments_navigation();
    	endif; // if noSpecifics larger than 0.
	endif; // Check for have_comments(). 
    ?>

	<?php if ( have_comments() ) : 
    	// LINKS
    	$noLinks = $count['link']; 
		if ( $noLinks > 0 ) : 
			echo('<h2 class="comments-title">Links</h2>');
        	the_comments_navigation(); 
	        // printf( '%1$s Links', $noLinks );
    		echo('<ol class="comment-list">');
			wp_list_comments(
				array(
                    'type'        => 'link', // 'type=comment&callback=twentyten_comment'
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 42,
				)
			);
			echo('</ol><!-- .comment-list -->');

			the_comments_navigation();
        endif; // if noLinks larger than 0.
	endif; // Check for have_comments(). 
	?>
	<!-- VVe End of new code to print comments. -->
	
=======
			?>
		</ol><!-- .comment-list -->

		<?php the_comments_navigation(); ?>

	<?php endif; // Check for have_comments(). ?>
	
	<!-- VVe links section -->
	
	

>>>>>>> 00cadeab397a4942a357ceaea32c20e3eca8c700
	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
	<p class="no-comments"><?php _e( 'Comments are closed.', 'twentysixteen' ); ?></p>
	<?php endif; ?>

	<?php
		comment_form(
			array(
				'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
				'title_reply_after'  => '</h2>',
			)
		);
	?>

</div><!-- .comments-area -->
