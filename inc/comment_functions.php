<?php  
// This function makes Wordpress print a dropdown list where the user can indicate what kind of comment is made.
// code inspired by: https://wordpress.stackexchange.com/questions/101579/add-a-drop-down-list-to-comment-form
add_filter( 'comment_form_field_comment', 'grassroots_add_comment_type_form_field' );
function grassroots_add_comment_type_form_field( $field ) {
    if ( is_single() ) :
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
        // echo($comment_depth);
        // echo( $comment->comment_parent );
        // if ($comment->comment_parent == 0) :
    	// if ( isset($_GET['replytocom']) ) :
    		
    		// comment_parent > 0
    	    // To change the label of the submit button Inside your comment_form, add this:
    	    // 'label_submit' => isset($_GET['replytocom']) ? __('Leave a reply', 'wpse') : __('Leave a comment', 'wpse'),

    	    // $field contains the html for the main text comment field of the form.
    	    // $select contains the html for the selection button after passing this function.
    	    // By combining them in the return statement first the selection button is printed and then the comment field.

    	    // Write selection box html
    	    //$select = '<p><label for="typeselect">Comment type:</label> 
    	    $select = '<p><label for="comment_ctype">Comment type:</label> 
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
    	// endif;
    endif;
	return $field;
}

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

// Why doesn't the function below function on my page? 
if(FALSE) {
    add_action('comment_post', 'grassroots_comment_tut_insert_comment', 10, 1);
    function grassroots_comment_tut_insert_comment($comment_id)
    {
        if(isset($_POST['comment_ctype']))
            update_comment_meta($comment_id, 'comment_ctype', esc_attr($_POST['comment_ctype']));
    }
}

// This function writes out the comment content. 
// What is echoed in this function is written out in the comment body and you can modify $text, which is written afterwards.
// It should write out the comment type, just to see its value during development.
function grassroots_write_comment_type( $text, $comment) {

    // echo('comment_type ');
    // var_dump($comment->comment_type);
    
    return $text;
}
add_filter( 'comment_text', 'grassroots_write_comment_type', 10, 2 );


// Compute the number of comments by type (synthesis, assessment, general comment, ...)
function comments_type( $count ) {  
    
    // echo('Dump of count in function comments_type.');
    // $count['synthesis']  = 9;
    // var_dump($count);

    if ( ! is_admin() ) {
    	global $id;
    	if (FALSE) {
            $count['synthesis']        = 1;
            $count['review']           = 1;
            $count['general_comment']  = 1;
            $count['specific_comment'] = 1;
            $count['message']          = 1;
            $count['link']             = 1;
    	}
    	if (TRUE) {
    		$categorized_comments = get_comments( 'status=approve&post_id=' . $id ); 
            $comments_by_type = separate_comments( $categorized_comments );        
            // echo( $comments_by_type['synthesis'] );            
            $count['synthesis']        = ( empty($comments_by_type['synthesis'])        ? 0 : sizeof($comments_by_type['synthesis']) );
            $count['review']           = ( empty($comments_by_type['review'])           ? 0 : sizeof($comments_by_type['review']) );
            $count['general_comment']  = ( empty($comments_by_type['general_comment'])  ? 0 : sizeof($comments_by_type['general_comment']) );            
            $count['specific_comment'] = ( empty($comments_by_type['specific_comment']) ? 0 : sizeof($comments_by_type['specific_comment']) );            
            $count['message']          = ( empty($comments_by_type['message'])          ? 0 : sizeof($comments_by_type['message']) );
            $count['link']             = ( empty($comments_by_type['link'])             ? 0 : sizeof($comments_by_type['link']) );
        }
	    // echo('Dump of count at the end of function comments_type.');
 	    // var_dump($count);
        return $count;
    } 
    //When in the WP-admin back end, do NOT filter comments (and pings) count.
    else {
        return $count;
    }
}

// The basis of the following three functions to change the registration type in bulk in the back end comes from http://wpengineer.com/2803/create-your-own-bulk-actions/
add_filter('bulk_actions-edit-comments', 'register_my_bulk_actions');
function register_my_bulk_actions($bulk_actions) {
    $bulk_actions['Dummynull'] = __( '== Change comment type ==', 'my-child-theme');
    $bulk_actions['Synthesis'] = __( 'Change to Synthesis',       'my-child-theme');
    $bulk_actions['Review']    = __( 'Change to Review',          'my-child-theme');
    $bulk_actions['General']   = __( 'Change to General Comment', 'my-child-theme');
    $bulk_actions['Specific']  = __( 'Change to Specific Comment','my-child-theme');
    $bulk_actions['Message']   = __( 'Change to Message',         'my-child-theme');
    // $bulk_actions['Link']      = __( 'Change to Link',            'my-child-theme');
    return $bulk_actions;
}

add_filter( 'handle_bulk_actions-edit-comments', 'my_bulk_action_handler', 10, 3 );
function my_bulk_action_handler( $redirect_to, $action_name, $comment_IDs ) { 
    if ( 'Dummynull' === $action_name ) { 
        return $redirect_to; 
    }
    
    if ( 'Synthesis' === $action_name ) { 
        $returnstr = 'synthesis' ;
        foreach ( $comment_IDs as $comment_ID ) {
            // No idea why the next line does not work and get_comment() needs to be used.
            // $comment_type = get_comment_meta($comment_ID, 'comment_type', TRUE);
            $comment = get_comment( $comment_ID);
            $comment_type = $comment->comment_type;
            if ( ! $comment_type == 'link') {
                $commentarr = array();
                $commentarr['comment_ID'] = $comment_ID;
                $commentarr['comment_type'] = 'synthesis';
                wp_update_comment($commentarr);
                // $returnstr .= $comment_type;
            } else {
                $returnstr = 'Error (cannot change link to synthesis)';
            }
        }        
        $redirect_to = add_query_arg( 'change_to_processed', $returnstr, $redirect_to );
        return $redirect_to; 
    }
    
    if ( 'Review' === $action_name ) { 
        $returnstr = 'review' ;
        foreach ( $comment_IDs as $comment_ID ) { 
            $comment = get_comment( $comment_ID);
            $comment_type = $comment->comment_type;
            if ( ! $comment_type == 'link') {
                $commentarr = array();
                $commentarr['comment_ID'] = $comment_ID;
                $commentarr['comment_type'] = 'review';
                wp_update_comment($commentarr);
            } else {
                $returnstr = 'Error (cannot change link to review)';
            }
        }
        $redirect_to = add_query_arg( 'change_to_processed', $returnstr, $redirect_to );
        return $redirect_to; 
    }    

    if ( 'General' === $action_name ) { 
        $returnstr = 'general_comment' ;
        foreach ( $comment_IDs as $comment_ID ) { 
            $comment = get_comment( $comment_ID);
            $comment_type = $comment->comment_type;
            if ( ! $comment_type == 'link') {
                $commentarr = array();
                $commentarr['comment_ID'] = $comment_ID;
                $commentarr['comment_type'] = 'general_comment';
                wp_update_comment($commentarr);
            } else {
                $returnstr = 'Error (cannot change link to general_comment)';
            }
        }
        $redirect_to = add_query_arg( 'change_to_processed', $returnstr, $redirect_to );
        return $redirect_to; 
    }
    
    if ( 'Specific' === $action_name ) { 
        $returnstr = 'specific_comment' ;    
        foreach ( $comment_IDs as $comment_ID ) { 
            $comment = get_comment( $comment_ID);
            $comment_type = $comment->comment_type;
            if ( ! $comment_type == 'link') {
                $commentarr = array();
                $commentarr['comment_ID'] = $comment_ID;
                $commentarr['comment_type'] = 'specific_comment';
                wp_update_comment($commentarr);
            } else {
                $returnstr = 'Error (cannot change link to specific_comment)';
            }
        }
        $redirect_to = add_query_arg( 'change_to_processed', 'specific_comment', $redirect_to );
        return $redirect_to; 
    }   

    if ( 'Message' === $action_name ) { 
        $returnstr = 'message' ;   
        foreach ( $comment_IDs as $comment_ID ) { 
            $comment = get_comment( $comment_ID);
            $comment_type = $comment->comment_type;
            if ( ! $comment_type == 'link') {
                $commentarr = array();
                $commentarr['comment_ID'] = $comment_ID;
                $commentarr['comment_type'] = 'message';
                wp_update_comment($commentarr);
            } else {
                $returnstr = 'Error cannot change link to message';
            }
        }
        $redirect_to = add_query_arg( 'change_to_processed', 'message', $redirect_to );
        return $redirect_to; 
    }
    
    if (FALSE) {
        if ( 'Link' === $action_name ) { 
            foreach ( $comment_IDs as $comment_ID ) { 
                $commentarr = array();
                $commentarr['comment_ID'] = $comment_ID;
                $commentarr['comment_type'] = 'link';
                wp_update_comment($commentarr);
            }
            $redirect_to = add_query_arg( 'change_to_processed', 'link', $redirect_to );
            return $redirect_to; 
        }   
    }    
    return $redirect_to; 
} 
    
add_action( 'admin_notices', 'my_bulk_action_admin_notice' );
function my_bulk_action_admin_notice() { 
    // echo('Bulk action admin notice');
    if ( ! empty( $_REQUEST['change_to_processed'] ) ) { 
        $comment_type_changed = $_REQUEST['change_to_processed']; 
        echo('<h3>Bulk Actions changed comment type to ' . $comment_type_changed . '.</h3>');
    } 
}    

// Add a selection to the page were comments can be edited for the comment type.
// Basis comes from Christopher Davis at https://www.pmg.com/blog/adding-extra-fields-to-wordpress-comments/?cn-reloaded=1
add_action('add_meta_boxes_comment', 'grassroots_comment_type_add_meta_box');
function grassroots_comment_type_add_meta_box() {
    $comment = get_comment( $comment_ID);
    $comment_type = $comment->comment_type;
    $valid_values = array('synthesis', 'review', 'general_comment', 'specific_comment', 'message', 'link');
    if( in_array( $comment_type, $valid_values ) ) {
        add_meta_box('grassroots-comment-type-id', __('Comment type'), 'grassroots_comment_type_meta_box_cb', 'comment', 'normal', 'high');
    }
    
    # Old version:
    # add_meta_box('grassroots-comment-type-id', __('Comment type'), 'grassroots_comment_type_meta_box_cb', 'comment', 'normal', 'high');
}

function grassroots_comment_type_meta_box_cb($comment) {
    $comment = get_comment( $comment_ID);
    $comment_type = $comment->comment_type;

    $select  = '<p>';
    $select .= '<label for="typeselect">Comment type:</label>';
    $select .= '<select name="comment_ctype" id="comment_ctype">';
    // $select .= '<option value="">Comment type</option>';
    
    if ( $comment_type == 'synthesis')
        $select .= '<option value="synthesis" selected="selected">Synthesis</option>';
    else
        $select .= '<option value="synthesis">Synthesis</option>';

    if ( $comment_type == 'review')
        $select .= '<option value="review" selected="selected">Review</option>';
    else
        $select .= '<option value="review">Review</option>';
    
    if ( $comment_type == 'general_comment')
        $select .= '<option value="general_comment" selected="selected">General comment</option>';
    else        
        $select .= '<option value="general_comment">General comment</option>';
    
    if ( $comment_type == 'specific_comment')
        $select .= '<option value="specific_comment" selected="selected">Specific comment</option>';
    else
        $select .= '<option value="specific_comment">Specific comment</option>';
    
    if ( $comment_type == 'message')
        $select .= '<option value="message" selected="selected">Unpublished message to editors</option>';
    else
        $select .= '<option value="message">Unpublished message to editors</option>';
    
    $select .= '</select>';
    $select .= '</p>';

    echo($select);

//    $comment_type = get_comment_meta($comment->comment_ID, 'comment_type', true);
//    // wp_nonce_field('grassroots_type_update', 'grassroots_type_update', false);
//   ?>
<!--    <p>
        <label for="comment_ctype">Comment type:</label> 
        <select name="comment_ctype" id="comment_ctype">
#        <option value="">Comment type</option>'
#        <option value="synthesis">Synthesis</option>'
#        <option value="review">Review</option>'
#        <option value="general_comment">General comment</option>'
#        <option value="specific_comment">Specific comment</option>'
#        <option value="message">Unpublished message</option>'
#        <option value="link">Related URL</option>'
#        </select>
#    </p>
-->
//    <?php
}


add_action('edit_comment', 'grassroots_save_comment_type_form_field');
// function grassroots_comment_tut_edit_comment($comment_id)
// {
//     if ( !isset($_POST['comment_ctype']) || !wp_verify_nonce($_POST['grassroots_type_update'], 'grassroots_type_update') ) 
//         return;
//     if ( isset($_POST['comment_ctype']) )
//         update_comment_meta($comment_id, 'comment_type', esc_attr($_POST['comment_ctype']));
// }

?>
