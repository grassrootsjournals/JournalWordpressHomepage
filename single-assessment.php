<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */


/* TODO
editors stored as numbers, 
print function number to name
Store authors
Print reference based on details
Does the numerical assessment belong to the synthesis comment or the post?
Box to gives authors in bulk, parse authors, radio button
CSS for Assessment page
CSS for the form similar to contact form.
function to print reference, from manual reference or details.
Function to detect doi in manual reference and hotlink it.
JS to parse manual reference and fill in form
JS to ask crossref for details.
Robots file for Viven.org
Limits users of new_assessment form to editors and users with an approved comment.
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) :
			the_post();

			// The single post content template.			
			?>
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>				
			</header><!-- .entry-header -->
			<?php

			$post = get_post();
			$post_ID = $post->ID;
			$reference = get_post_meta( $post_ID, 'article_reference', TRUE );	
			echo('<div class="reference"><p>' . $reference . '</p></div>');

			$article_abstract = get_post_meta( $post_ID, 'article_abstract', TRUE );
			echo('<div class="article_abstract"><p><b>Abstract.</b> ' . $article_abstract . '</p></div>');

			echo('<div class="editors">Editors: ');
			$editors = get_post_meta( $post_ID, 'editors' );
			//var_dump($editors);
			foreach ( $editors as $editor ) {					
				echo( $editor . PHP_EOL );
			}
			echo('</div>');


			echo '<hr><br><pre>';
    		print_r(get_post_custom($post_ID));
    		echo '</pre>';

			//echo("<br><p></p>");
			var_dump($post);

			the_content();
			// End of the single post content template.


			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			// End of the loop.
		endwhile;
		?>

	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
