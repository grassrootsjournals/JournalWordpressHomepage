<?php  
// This function makes Wordpress print a dropdown list where the user can indicate what kind of comment is made.
// code inspired by: https://wordpress.stackexchange.com/questions/101579/add-a-drop-down-list-to-comment-form
add_filter( 'comment_form_field_comment', 'grassroots_add_comment_type_form_field' );
function grassroots_add_comment_type_form_field( $field ) {
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

    echo('comment_type ');
    var_dump($comment->comment_type);
    
    return $text;
}
add_filter( 'comment_text', 'grassroots_write_comment_type', 10, 2 );
?>


// Compute the number of comments by type (synthesis, assessment, general comment, ...)
<?php
function comments_type( $typestr, $count ) {  
    
    if ( ! is_admin() ) {
        global $id;
        $comments_by_type = separate_comments( get_comments( 'status=approve&post_id=' . $id ) );
        return count( $comments_by_type[$typestr] );
    } 
    //When in the WP-admin back end, do NOT filter comments (and pings) count.
    else {
        return $count;
    }
}
?>
 
