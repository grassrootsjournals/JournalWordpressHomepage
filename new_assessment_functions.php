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
    // echo '<p>Passed title</p>';

    // Check that the nonce was set and valid
    if( !wp_verify_nonce($_POST['_wpnonce'], 'grassroots-new-assessment') ) {
        echo 'Did not save because your form seemed to be invalid. Sorry';
        return;
    }
    // echo '<p>Passed nonce</p>';

    // Do some minor form validation to make sure there is content
    if (strlen($_POST['title']) < 3) {
        echo 'Please enter a title. Titles must be at least three characters long.';
        return;
    }
    // echo '<p>Passed title length</p>';
    /*
    if (strlen($_POST['content']) < 100) {
        echo 'Please enter content more than 100 characters in length';
        return;
    }
    */

    // Add the content of the form to $post as an array

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
 

    $meta_input = array(
        'article_doi'        => $article_doi,
        'initiator'          => $initiator,
        'article_reference'  => $article_reference,
        'article_abstract'   => $article_abstract,
        'title_automatic'    => $title_automatic,
        'full_journal_name'  => $full_journal_name,
        'short_journal_name' => $short_journal_name,
        'publication_year'   => $publication_year,
        'article_volume'     => $article_volume,
        'article_pages'      => $article_pages
    );
    
    $post = array(
        'post_title'    => $post_title,
        'post_content'  => 'Assessments have no content.', // $_POST['content'],
        'post_category' => $post_category, 
        'tags_input'    => $tags_input,
        'post_status'   => 'pending',    // Could be: publish, draft or pending
        'post_type'     => 'assessment', // 'assessment' // Could be: `page`, assessment or your CPT 
        'meta_input'    => $meta_input
    ); 
    // echo '<p>Passed array</p>';
    $post_ID = wp_insert_post($post);

    
    $editors = array($_POST['editor1'], 
                     $_POST['editor2']);
    // $post = get_post();
    // $post_ID = $post->ID;
    // $editors = [ 'red', 'yellow', 'blue', 'pink' ];
    foreach ( $editors as $editor ) {   
        // $postarr = array();
        // $postarr['post_ID'] = $post_ID;
        // $postarr['editors'] = $editor;       
        // wp_update_post($postarr); 
        add_post_meta($post_ID, 'editors', $editor);
    }
    echo '<pre>';
    print_r(get_post_custom($post_ID));
    echo '</pre>';

    //echo("<br><p></p>");
    var_dump($post);
    var_dump($editors);
    var_dump($postarr);

    echo '<p>Saved your assessment successfully!</p>';
}
/*
, // 'assessment' // Could be: `page`, assessment or your CPT 
        'meta_input'    => $meta_input

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
