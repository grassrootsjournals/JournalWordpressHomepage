<?php 
/* This file contains functions to add the custom post type assessment to the theme and remove the "post" post type. */


function assessment_custom_post_type_init() {
/* This function creates a new custom post type (other types are post and page) for the assessments.
   For more information: https://codex.wordpress.org/Function_Reference/register_post_type */
    $labels = array(
        'name'                  => _x( 'Assessments', 'Post type general name',  'twentysixteen-child' ),
        'singular_name'         => _x( 'Assessment',  'Post type singular name', 'twentysixteen-child' ),
        'menu_name'             => _x( 'Assessments', 'Admin menu',              'twentysixteen-child' ),
        'name_admin_bar'        => _x( 'Assessment',  'Add new on admin bar',    'twentysixteen-child' ),
        'add_new'               => _x( 'Add New',     'Add assessment',          'twentysixteen-child' ),
        'add_new_item'          => __( 'Add New Assessment',             'twentysixteen-child' ),
        'new_item'              => __( 'New Item',                       'twentysixteen-child' ),
        'edit_item'             => __( 'Edit Item',                      'twentysixteen-child' ),
        'view_item'             => __( 'View Item',                      'twentysixteen-child' ),
        'view_items'            => __( 'View Assessments',               'twentysixteen-child' ),
        'all_items'             => __( 'All Assessments',                'twentysixteen-child' ),
        'search_items'          => __( 'Search Asessments',              'twentysixteen-child' ),
        'not_found'             => __( 'No assessments found.',          'twentysixteen-child' ),
        'not_found_in_trash'    => __( 'No assessments found in Trash.', 'twentysixteen-child' ),
        'archives'              => __( 'Assessment Archives',            'twentysixteen-child' ),
        'atributes'             => __( 'Assessment Atributes',           'twentysixteen-child' ),
        'insert_into_item'      => __( 'Insert into Assessment',         'twentysixteen-child' ),
        'uploaded_to_this_item' => __( 'Uploaded to this assessment',    'twentysixteen-child' ),
        'atributes'             => __( 'Assessment Atributes',           'twentysixteen-child' )
    );
    /* For more information: https://codex.wordpress.org/Function_Reference/register_post_type
       Not set are: 'featured_image' - Default is Featured Image.
                    'set_featured_image' - Default is Set featured image.
                    'remove_featured_image' - Default is Remove featured image.
                    'use_featured_image' - Default is Use as featured image.
                    'menu_name' - Default is the same as `name`.
                    'filter_items_list' - String for the table views hidden heading.
                    'items_list_navigation' - String for the table pagination hidden heading.
                    'items_list' - String for the table hidden heading.
                    'name_admin_bar' - String for use in New in Admin menu bar. Default is the same as `singular_name`. */ 
    $args = array(
        'labels'              => $labels,
        'description'         => __( 'Assessments of scientific output.', 'twentysixteen-child' ),
        'public'              => true,
        /* this automatically sets
        'exclude_from_search' => false, 
        'publicly_queryable'  => true, 
        'show_ui'             => true,
        'show_in_menu'        => true, 
        'show_in_admin_bar'   => true, */
        'query_var'           => true,
        'rewrite'             => true, // array( 'slug' => 'assessment' ),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 2,
        'supports'            => array( 'title', 'editor', 'author', 'comments', 'revisions'),
        // 'menu_icon'           => get_template_directory_uri() . "/media/text.png",
        'taxonomies'          => array('category', 'post_tag'),
        'delete_with_user'    => false
    );
    /*  Several settings not used, possibly useful later:
        show_in_rest */
    register_post_type( 'assessment', $args );
    /* Maybe add later: 
        $screen->add_help_tab( $args ); 
    Currently not working is the icon in the back-end menu in front of the word Assessments.
        menu_icon */
}
add_action( 'init', 'assessment_custom_post_type_init' );
  
function assessment_custom_post_type_flush() {
    assessment_custom_post_type_init();
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'assessment_custom_post_type_flush' );

// Delete the "post" post type, later to be added as a switch.
// For more information: https://wordpress.stackexchange.com/questions/3820/deregister-custom-post-types
/*
function delete_post_type(){
    unregister_post_type( 'post' );
}
add_action('init','delete_post_type');
*/ 
function remove_post_post_type() {
    $args = array('show_in_menu', false);
     register_post_type( 'post', $args );
}
add_action( 'init', 'remove_post_post_type' );


// To be done: use the new assessment post type to select the type of comment system.
// Convert the current posts to assessements.
// Add templates for assessments.
?> 

