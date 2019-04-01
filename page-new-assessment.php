<?php /* custom page to add a new assessment */
	get_header(); 

	if ( is_user_logged_in() ) {
		if ( isset($_POST['title']) ) {
			grassroots_save_assessment_if_submitted();
		}
	}

	if ( TRUE ) {
	    $post_title         = $_POST['title'];
	    $post_category      = $_POST['cat'];
	    $tags_input         = $_POST['post_tags'];

	    $article_doi        = $_POST['doi'];
	    $initiator          = $_POST['initiator'];
	    $article_reference  = $_POST['reference'];
	    $article_abstract   = $_POST['article_abstract'];
	    $title_automatic    = $_POST['title_automatic'];
	    $full_journal_name  = $_POST['full_journal_name'];
	    $short_journal_name = $_POST['short_journal_name'];
	    $publication_year   = $_POST['publication_year'];
	    $article_volume     = $_POST['volume'];
	    $article_pages      = $_POST['pages'];
	}

    $current_user = wp_get_current_user();

    if ( $current_user->exists() ) {
    	$userName = $current_user->display_name;
    	$userID   = $current_user->ID;
    } else {
        $userName = "Unknown";
        $userID   = 0;
    }

    echo 'Username: '          . $current_user->user_login     . '<br />';
    echo 'User email: '        . $current_user->user_email     . '<br />';
    echo 'User first name: '   . $current_user->user_firstname . '<br />';
    echo 'User last name: '    . $current_user->user_lastname  . '<br />';
    echo 'User display name: ' . $current_user->display_name   . '<br />';
    echo 'User ID: '           . $current_user->ID             . '<br />';
    // echo 'User roles: ';
    // print_r($current_user->roles);
    // echo('<br />');
    // echo(current_user_can( 'publish_pages', $post->ID )); 
?>

<!--
	## To Do
	DONE JS to add new editors, to allow for an unlimited number
	DONE JS to add new authors, to allow for an unlimited number
	DONE List all editors in the editor selection boxes
	Blend out editors already selected in new selection boxes. (And old ones, if done right, people can go back. Would need JS.)
	DONE Check for WordPress roles for which fields to show 	
	Check and save information in database
	Generate assessment page, publish as draft if creator is not an editor.
	Allow for replies to comments (changing comment type of the reply still missing)
	JS to automatically fill in the form based on CrossRef. 
	Add scripts to JS directory
	Insert paragraph breaks in abstracts if there are double line breaks.
	DONE Stop bots from indexing the staging server.
	Change the form into a function?
-->

<?php 
	// More information on sorting. https://wordpress.stackexchange.com/questions/206251/how-can-i-sort-get-users-by-any-value-last-name-user-defined-fields-and-more 
	// It is now sorted by last name and probably as second criterion the nicename, this will in most cases be the first name, but we could do this explicitly. Later, it will be rare given the limited number of editors and it will thus not be much of a problem if it does occur. 
	$allEditors = get_users( 'orderby=meta_value&meta_key=last_name&role=editor' ); 
?>

<script>
	// var counter = 1;
    var lastEditorNumber = 2;
    var limit = 200;
    // alert("Init " + counter + "  " + lastEditorNumber + "  " + limit );

    function addEditor(divName, counter) {
    	if (counter == limit) {
        	alert("You have reached the limit of adding " + counter + " inputs");
        } else {
        	// alert("counter: " + counter + "\nlastEditorNumber: " + lastEditorNumber + "\nlimit: " + limit )
        	if (counter == lastEditorNumber) { // Only if the last editor is changed/is assigned a new editor a new editor selector should appear.
	        	counter++; 
	        	lastEditorNumber = counter;

	            var newdiv = document.createElement('div');
	            <?php
	            	echo( 'var options = \'');
					foreach ( $allEditors as $user ) {					
						echo( '<option value="Editor_' . $user->ID . '">' . $user->display_name . '</option>\\' . PHP_EOL );
					}
					echo( '\';' );
				?>					
	            newdiv.innerHTML = '<p><label for="editor' + counter + '">Editor ' + counter + ': </label><br>\n\
	                <select name="editor' + counter + '" form="newAssessment" onChange="addEditor(\'newAssessmentEditor\', ' + counter + ');">\n\
	                \t<option value="">Select editor</option>\n' + options + 
	            '\t</select></p>\n';
	            // alert("2nd: " + newdiv);
	            document.getElementById(divName).appendChild(newdiv);
            }
        }
    }
</script>


<script>
    var lastAuthorNumber = 1;
    var limitAuthors = 1000;
    function addAuthor(divNameAuthor, counterAuthors) {    
    	// alert(divNameAuthor + "\ncounterAuthors " + counterAuthors + "\nlimitAuthors " + limitAuthors + "\nlastAuthorNumber " + lastAuthorNumber);
    	// alert("1DivName: " + divName + " counterAuthors: " + counterAuthors  + " lastAuthorNumber: " + lastAuthorNumber);	
    	if (counterAuthors == limitAuthors) {
        	alert("You have reached the limit of adding " + counterAuthors + " inputs");
        } else {
        	// alert("hallo2");
        	// alert("2DivName: " + divName + " counterAuthors: " + counterAuthors  + " lastAuthorNumber: " + lastAuthorNumber);
        	if (counterAuthors == lastAuthorNumber) { // Only if the last author is focussed create a new author box.
        		// alert("hallo3");
	        	counterAuthors++; 
	        	lastAuthorNumber = counterAuthors;

	            var newdivAuthor = document.createElement('div');
	            newdivAuthor.setAttribute("class", "OneAuthor");
	            // newdivAuthor.innerHTML = "Entry " + (counterAuthors + 1) + " <br><input type='text' name='myInputs[]'>";
	            newdivAuthor.innerHTML = '<div class="newAssessementAuthorNo">Author ' + counterAuthors + '</div>\n\
								<div class="newAssessementAuthorGivenName">\n\
			  						\t<input type="text" name="given_name_author' + counterAuthors + '" id="givenNameauthor" maxlength="100" placeholder="Given name of author" onfocus="addAuthor(\'newAssessementAuthorBox\', ' + counterAuthors + ')">\n\
			  					</div>\n\
								<div class="newAssessementAuthorFamilyName">\n\
			  						\t<input type="text" name="family_name_author' + counterAuthors + '" id="familyNameauthor" maxlength="100" placeholder="Family name of author" onfocus="addAuthor(\'newAssessementAuthorBox\', ' + counterAuthors + ')">\n</div>\n';
	            document.getElementById(divNameAuthor).appendChild(newdivAuthor);

	            // alert("hallo4");
        		// alert("3DivName: " + divName + " counterAuthors: " + counterAuthors  + " lastAuthorNumber: " + lastAuthorNumber);
            }
        }
    }
</script>


<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	        	<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>					
				</header>
				<div class="entry-content">
					<?php
						if ( is_user_logged_in() == FALSE ) { ?>
							<p>To propose a new assessment you need to be either an editor or a user who has previously made an approved comment/review. Thus you need to be <a href="https://homogenisation.viven.org/wp-login.php?action">logged in</a>.</p>
					<?php } else { 
						/*
						<?php the_post(); ?>
						<?php the_content(); ?> 
						*/
						// Include the new assessment form template.
						get_template_part( 'template-parts/new_assessment_form' );						
					} ?> <!-- if logged in -->	
				</div> <!-- content -->
			</article>
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->



<?php
	get_footer();
