<?php
/* Let WordPress know where to find the CSS and JS. */
function grassroots_theme_enqueue_styles() {

    $parent_style = 'twentysixteen-style'; // This is 'twentysixteen-style' for the Twenty Sixteen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/css/grassroots.css',
        array( $parent_style ),
        wp_get_theme()->get('Version'),
        'all'
    );
    wp_enqueue_script( 'child-js',
        get_stylesheet_directory_uri() . '/js/grassroots.js',
        array(),
        wp_get_theme()->get('Version'),
        true // Link to JS in the footer
    );
}
add_action( 'wp_enqueue_scripts', 'grassroots_theme_enqueue_styles' );
?> 

<?php
/* Let WordPress know where to find the CSS of the backend/admin. */
function grassroots_theme_enqueue_styles_admin() {
    wp_register_style( 'grassroots_admin_stylesheet', get_stylesheet_directory_uri() . '/css/grassroots_admin.css' );
    wp_enqueue_style( 'grassroots_admin_stylesheet' );
}
add_action( 'admin_enqueue_scripts', 'grassroots_theme_enqueue_styles_admin' );
?> 
     
<?php
    require_once( get_stylesheet_directory() . '/inc/comment_functions.php'       );
    require_once( get_stylesheet_directory() . '/inc/seo_functions.php'           );
    require_once( get_stylesheet_directory() . '/inc/post_type_functions.php'     ); 
    require_once( get_stylesheet_directory() . '/inc/toolbar_functions.php'       ); 
    require_once( get_stylesheet_directory() . '/inc/general_functions.php'       ); 
    require_once( get_stylesheet_directory() . '/new_assessment_functions.php');
// add_action( 'all', create_function( '', 'var_dump( current_filter());' ) );     
?>   

<?php
if ( (isset($_GET['action']) && $_GET['action'] != 'logout') || (isset($_POST['login_location']) && !empty($_POST['login_location'])) ) {
    
    function grassroots_login_redirect() {
        $location = $_SERVER['HTTP_REFERER'];
        wp_safe_redirect($location);
        exit();
    }
    add_filter('login_redirect', 'grassroots_login_redirect', 10, 3);
}
?>

<?php
/**
 * Setup My Child Theme's textdomain.
 *
 * Declare textdomain for this child theme.
 * Translations can be filed in the /languages/ directory.
 */
function my_child_theme_setup() {
    load_child_theme_textdomain( 'my-child-theme', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'my_child_theme_setup' );

/* For more information: https://codex.wordpress.org/I18n_for_WordPress_Developers
Example how to use this:
<?php
esc_html_e( 'Code is Poetry', 'my-child-theme' );
?>
*/
?>

<?php
/* A child theme can replace a PHP function of the parent by simply declaring it beforehand. 
if ( ! function_exists( 'theme_special_nav' ) ) {
    function theme_special_nav() {
        //  Do something.
    }
}
*/

/*
When you need to include files that reside within your child theme's directory structure, you will use get_stylesheet_directory(). Because the parent template's style.css is replaced by your child theme's style.css, and your style.css resides in the root of your child theme's subdirectory, get_stylesheet_directory() points to your child theme's directory (not the parent theme's directory).

Here's an example, using require_once, that shows how you can use get_stylesheet_directory when referencing a file stored within your child theme's directory structure.

require_once( get_stylesheet_directory() . '/my_included_file.php' );

*/

?>
