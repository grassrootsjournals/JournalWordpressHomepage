<?php

// This function saves a new assessment in the database after some checks. 
// It does so as a pending post in case of normal users, editors can also immediately publish.
// These normal users need to have at least one accepted comment to avoid spam.
// Function based on https://wpshout.com/wordpress-submit-posts-from-frontend/
function grassroots_save_assessment_if_submitted() {
    // Stop running function if form wasn't submitted
    if ( !isset($_POST['title']) ) {
        return;
    }
    echo 'Passed title';

    // Check that the nonce was set and valid
    if( !wp_verify_nonce($_POST['_wpnonce'], 'grassroots-new-assessment') ) {
        echo 'Did not save because your form seemed to be invalid. Sorry';
        return;
    }
    echo 'Passed nonce';

    // Do some minor form validation to make sure there is content
    if (strlen($_POST['title']) < 3) {
        echo 'Please enter a title. Titles must be at least three characters long.';
        return;
    }
    echo 'Passed title length';
    /*
    if (strlen($_POST['content']) < 100) {
        echo 'Please enter content more than 100 characters in length';
        return;
    }
    */
    // Add the content of the form to $post as an array
    $post = array(
        'post_title'    => $_POST['title'],
        'post_content'  => 'No content for assessments.' // $_POST['content'],
        'post_category' => $_POST['cat'], 
        'tags_input'    => $_POST['post_tags'],
        'post_status'   => 'draft',     // Could be: publish or pending
        'post_type'     => 'page' // 'assessment' // Could be: `page`, assessment or your CPT 
    ); 
    echo 'Passed array';
    wp_insert_post($post);
    echo '<p>Saved your page successfully!</p>';
}
/*
doi
initiator
editor1, editor2, ...
title
reference
articleAbstract
givenNameauthor1. givenNameauthor2, ...
familyNameauthor1, familyNameauthor2, ...
titleAutomatic
fullJournalName
shortJournalName
year
volume
pages
messageHuman
submittedGrassroots
*/






/*
if(TRUE) {
    // This function saves the comment type into the WP database when the comment is posted.
    add_action( 'comment_post', 'grassroots_save_comment_type_form_field' );
    function grassroots_save_comment_type_form_field( $comment_ID ) {

    // Complete this later to add more security
    // if ( !isset($_POST['comment_ctype']) || !wp_verify_nonce($_POST['comment_ctype'], 'XXX') ) 
    //    return;

        if ( ( isset( $_POST['comment_ctype'] ) ) && ( $_POST['comment_ctype'] != '') )
          $comment_ctype = wp_filter_nohtml_kses($_POST['comment_ctype']); // https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data
        // Probably also needs a check on the size of the input.
        
        $valid_values = array('synthesis', 'review', 'general_comment', 'specific_comment', 'message', 'link');
        if( in_array( $comment_ctype, $valid_values ) ) {
            $commentarr = array();
            $commentarr['comment_ID'] = $comment_ID;
            $commentarr['comment_type'] = $comment_ctype;
            wp_update_comment($commentarr);
        }
    }
}
*/

?>
