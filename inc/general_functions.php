<?php 

function get_user_role( $user_id = 0 ) {
	$user = ( $user_id ) ? get_userdata( $user_id ) : wp_get_current_user();
	return current( $user->roles );
}

/* Remove tracking possibilities  
 * For more information: https://wordpress.org/support/topic/remove-the-new-dns-prefetch-code/
 */
/* Removes the google fonts prefetching:
 * <link rel='dns-prefetch' href='//fonts.googleapis.com'>
 * <link rel='dns-prefetch' href='//s.w.org'>
 * The fonts themselves still need to be removed.
 */
remove_action( 'wp_head', 'wp_resource_hints', 2 );

/* Remove links to Wordpress.org for emojis */
add_filter( 'emoji_svg_url', '__return_false' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/* TN Dequeue Styles - Remove Google Fonts from Genesis Sample WordPress Theme
 * Taken from: https://technumero.com/remove-google-fonts-from-wordpress-theme/
 * Information on how to move Google fonts to your own server:
 * https://techstuffer.com/serve-google-fonts-from-your-own-server/
 * https://google-webfonts-helper.herokuapp.com/
 */
function grassroots_dequeue_google_fonts_style() {
      wp_dequeue_style( 'twentysixteen-fonts' );
}
add_action( 'wp_print_styles', 'grassroots_dequeue_google_fonts_style' );


/*
function custom_remove_help_tabs( $old_help, $screen_id, $screen ) { 
	$screen->remove_help_tabs(); 
	return $old_help; 
} 
add_filter( 'contextual_help', 'custom_remove_help_tabs', 999, 3 );
*/


/**
 * Remove dashboard widgets
 * Quick Draft and Getting started do not fit well to this theme without blog posts and with assessments.
 * The WordPress Events and News box can be used for tracking the use of the homepage.
 * The follow up function is to remove these three items from the help screen on the admin panel.
 * The gravatar in the first comment is still tracking us.
 * For more information: 
 * https://www.wpbeginner.com/wp-tutorials/how-to-remove-the-welcome-panel-in-wordpress-dashboard/
 * https://plugins.trac.wordpress.org/browser/disable-events-and-news-dashboard-widget/#trunk
 * Info for later, to add a metabox with statistics:
 * https://developer.wordpress.org/reference/functions/add_meta_box/
 **/
function grassrooots_change_dashboard_widgets() {
	// To update the help information, which still gives information on these boxes.
    remove_meta_box('dashboard_quick_press',     'dashboard', 'side');   // Quick Draft (Quick Press)
    remove_meta_box('dashboard_primary',         'dashboard', 'side');   // WordPress Events and News (WordPress blog)    
    remove_action('welcome_panel', 'wp_welcome_panel');                  // Welcome panel, getting started at the top

    /* This is supposed to move a metabox to the right (side), but somehow does not work.
    // Unset does work and the next line thus does add a box, but ignores the position.
    // Maybe because the position is drag-and-drop nowadays and this function is outdated?
	global $wp_meta_boxes;	
    $widget = $wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity'];
    unset(    $wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity'] );
    $wp_meta_boxes['dashboard']['side']['core']['dashboard_activity'] = $widget;
	*/

    // remove_meta_box('dashboard_right_now',       'dashboard', 'normal'); // Right Now
    // remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // Recent Comments
    // remove_meta_box('dashboard_incoming_links',  'dashboard', 'normal'); // Incoming Links
    // remove_meta_box('dashboard_plugins',         'dashboard', 'normal'); // Plugins    
    // remove_meta_box('dashboard_recent_drafts',   'dashboard', 'side');   // Recent Drafts
    // remove_meta_box('dashboard_secondary',       'dashboard', 'side');   // Other WordPress News
    // use 'dashboard-network' as the second parameter to remove widgets from a network dashboard.
    // remove_meta_box('dashboard_primary',         'dashboard-network', 'side');   // WordPress Events and News (WordPress blog)
}
add_action( 'wp_network_dashboard_setup', 'grassrooots_change_dashboard_widgets', 20 );
add_action( 'wp_user_dashboard_setup',    'grassrooots_change_dashboard_widgets', 20 );
add_action( 'wp_dashboard_setup',         'grassrooots_change_dashboard_widgets', 20 );


/* This function creates a new help tab for the content of the dashboard to replace the default content tab.
 * The default help tab explains the five default widgets, this one only the two remaining ones.
 * The original help tab was removed/made invisible with CSS in grassroots_admin.css.
 */
function grassrooots_add_context_menu_help() {
	//get the current screen object
	$current_screen = get_current_screen ();

	//define the content for help tab
	$help  = '<p>' . __( 'The boxes below on your Dashboard screen are:' ) . '</p>';
	if ( current_user_can( 'edit_posts' ) )
		$help .= '<p>' . __( '<strong>At A Glance</strong> &mdash; Displays a summary of the content on your site and identifies which theme and version of WordPress you are using.' ) . '</p>';
		$help .= '<p>' . __( '<strong>Activity</strong> &mdash; Shows the upcoming scheduled posts, recently published posts, and the most recent comments on your posts and allows you to moderate them.' ) . '</p>';
	//register the help tab with content defined
	$current_screen->add_help_tab (array (
		'id'       => 'help-content-alternative',
		'title'    => __( 'This screen' ),
		'content'  => $help,
		'callback' => false,
        'priority' => 100,
		) 
	);
}
add_action( 'wp_network_dashboard_setup', 'grassrooots_add_context_menu_help');
add_action( 'wp_user_dashboard_setup',    'grassrooots_add_context_menu_help');
add_action( 'wp_dashboard_setup',         'grassrooots_add_context_menu_help');


// Change the welcome text at the top right from "howdy, $Name", to "Welcome, $Name".
// And remove the Avatar, which can be used for tracking.
// Borrowed from:
// https://managewp.com/blog/spotless-wordpress-dashboard
function wp_admin_bar_my_custom_account_menu( $wp_admin_bar ) {
	$user_id = get_current_user_id();
	$current_user = wp_get_current_user();
	$profile_url = get_edit_profile_url( $user_id );

	if ( 0 != $user_id ) {
	/* Add the "My Account" menu */
	// $avatar = get_avatar( $user_id, 28 );
	$welcome_text = sprintf( __('Welcome, %1$s'), $current_user->display_name );
	$class = empty( $avatar ) ? '' : 'with-avatar';

	$wp_admin_bar->add_menu( array(
		'id'     => 'my-account',
		'parent' => 'top-secondary',
		'title'  => $welcome_text, // . $avatar,
		'href'   => $profile_url,
		'meta'   => array(
			'class' => $class,
			),
		) 
	);

	}
}
add_action( 'admin_bar_menu', 'wp_admin_bar_my_custom_account_menu', 11 );


// Remove the text "Thank you for creating with WordPress." at the bottom of the admin screen.
// I am grateful to use WordPress, but like less clutter.
// Borrowed from:
// https://managewp.com/blog/spotless-wordpress-dashboard
function remove_footer_admin () {
    // echo "Your own text";
} 
add_filter('admin_footer_text', 'remove_footer_admin');

?>


