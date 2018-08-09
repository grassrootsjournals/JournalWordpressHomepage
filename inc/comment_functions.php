<?php  
// This function makes Wordpress print a dropdown list where the user can indicate what kind of comment is made.
// code inspired by: https://wordpress.stackexchange.com/questions/101579/add-a-drop-down-list-to-comment-form
add_filter( 'comment_form_field_comment', 'grassroots_add_comment_type_form_field' );
function grassroots_add_comment_type_form_field( $field ) {
<<<<<<< HEAD
//	echo('Echo reply to com:');
//	echo($_GET['replytocom']);
	// global $id;
    // get_comment( $id, $comm );
    // var_dump($comm);
    // comment_parent
    // if( '0' != ){ }
    global $comment;
    global $comment_depth;
    // var_dump($comment);
    echo($comment_depth);
    // echo( $comment->comment_parent );
    if ($comment->comment_parent == 0) :
	// if ( isset($_GET['replytocom']) ) :
		
		// comment_parent > 0
	    // To change the label of the submit button Inside your comment_form, add this:
	    // 'label_submit' => isset($_GET['replytocom']) ? __('Leave a reply', 'wpse') : __('Leave a comment', 'wpse'),

	    // $field contains the html for the main text comment field of the form.
	    // $select contains the html for the selection button after passing this function.
	    // By combining them in the return statement first the selection button is printed and then the comment field.

	    // Write selection box html
	    $select = '<p><label for="typeselect">Comment type:</label> 
	    <select name="comment_ctype" id="comment_ctype">
	    <option value="">Comment type</option>'; // The first line write text above the select button. name and id can be used to refer to this button in the processing. The text between the option tags is shown on the select button.

	    // Write html for the selection options
	    $select .= '<option value="synthesis">Synthesis</option>';
	    $select .= '<option value="review">Review</option>';
	    $select .= '<option value="general_comment">General comment</option>';
	    $select .= '<option value="specific_comment">Specific comment</option>';
	    $select .= '<option value="message">Unpublished message</option>';
	    $select .= '<option value="link">Related URL</option>';
	    // Also replies should be a comment type    
	    // Last line selection box html:
	    $select .= '</select></p>';
	    
	    // echo($field);
	    // echo($select);

	    // return $select . $field;
	    $field = $select . $field;
	endif;

	return $field;
=======
    // $field contains the html for the main text comment field of the form.
    // $select contains the html for the selection button after passing this function.
    // By combining them in the return statement first the selection button is printed and then the comment field.

    // Write selection box html
    $select = '<p><label for="typeselect">Comment type:</label> 
    <select name="comment_ctype" id="comment_ctype">
    <option value="">Comment type</option>'; // The first line write text above the select button. name and id can be used to refer to this button in the processing. The text between the option tags is shown on the select button.

    // Write html for the selection options
    $select .= '<option value="synthesis">Synthesis</option>';
    $select .= '<option value="review">Assessment</option>';
    $select .= '<option value="comment">General comment</option>';
    $select .= '<option value="specific">Specific comment</option>';
    $select .= '<option value="message">Unpublished message</option>';
    $select .= '<option value="linkback">Related URL</option>';
    // Also replies should be a comment type    
    // Last line selection box html:
    $select .= '</select></p>';
    
    // echo($field);
    // echo($select);

    return $select . $field;
>>>>>>> 00cadeab397a4942a357ceaea32c20e3eca8c700
}

// This function saves the comment type into the WP database when the comment is posted.
add_action( 'comment_post', 'grassroots_save_comment_type_form_field' );
function grassroots_save_comment_type_form_field( $comment_ID ) {

    if ( ( isset( $_POST['comment_ctype'] ) ) && ( $_POST['comment_ctype'] != '') )
      $comment_ctype = wp_filter_nohtml_kses($_POST['comment_ctype']);
    // Probably also needs a check on the size of the input.
    
    $commentarr = array();
    $commentarr['comment_ID'] = $comment_ID;
    $commentarr['comment_type'] = $comment_ctype;
    wp_update_comment($commentarr);
}


// This function writes out the comment content. 
// What is echoed in this function is written out in the comment body and you can modify $text, which is written afterwards.
// It should write out the comment type, just to see its value during development.
function grassroots_write_comment_type( $text, $comment) {

<<<<<<< HEAD
    // echo('comment_type ');
    // var_dump($comment->comment_type);
=======
    echo('comment_type ');
    var_dump($comment->comment_type);
>>>>>>> 00cadeab397a4942a357ceaea32c20e3eca8c700
    
    return $text;
}
add_filter( 'comment_text', 'grassroots_write_comment_type', 10, 2 );
?>


<<<<<<< HEAD
<?php
// Compute the number of comments by type (synthesis, assessment, general comment, ...)
function comments_type( $count ) {  
    
    // echo('Dump of count in function comments_type.');
    // $count['synthesis']  = 9;
    // var_dump($count);

    if ( ! is_admin() ) {
    	global $id;
        $comments_by_type = separate_comments( get_comments( 'status=approve&post_id=' . $id ) );        
		$count['synthesis']        = sizeof($comments_by_type['synthesis']);
	    $count['review']           = sizeof($comments_by_type['review']);
	    $count['general_comment']  = sizeof($comments_by_type['general_comment']);
	    $count['specific_comment'] = sizeof($comments_by_type['specific_comment']);
	    $count['message']          = sizeof($comments_by_type['message']);
	    $count['link']             = sizeof($comments_by_type['link']);

	    // echo('Dump of count at the end of function comments_type.');
 	    // var_dump($count);
        return $count;
=======
// Compute the number of comments by type (synthesis, assessment, general comment, ...)
<?php
function comments_type( $typestr, $count ) {  
    
    if ( ! is_admin() ) {
        global $id;
        $comments_by_type = separate_comments( get_comments( 'status=approve&post_id=' . $id ) );
        return count( $comments_by_type[$typestr] );
>>>>>>> 00cadeab397a4942a357ceaea32c20e3eca8c700
    } 
    //When in the WP-admin back end, do NOT filter comments (and pings) count.
    else {
        return $count;
    }
}
?>
<<<<<<< HEAD
 
=======
 
>>>>>>> 00cadeab397a4942a357ceaea32c20e3eca8c700
