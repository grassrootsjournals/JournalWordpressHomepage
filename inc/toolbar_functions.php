
<?php 
// update toolbar
// First version of this code by: https://www.sitepoint.com/customize-wordpress-toolbar/
function update_adminbar($wp_adminbar) {
    // remove unnecessary items
    $wp_adminbar->remove_node('wp-logo');   // Remove Wordpress log, which also links to Wordpress.org, which nearly no one will need.
    $wp_adminbar->remove_node('updates');   // Remove the update Wordpress button, which otherwise people may accidentally press.
    $wp_adminbar->remove_node('new-media'); // Remove the item "New media" in the New Item menu, which is not that important. I expect most assessments will be purely text.
}
// admin_bar_menu hook
add_action('admin_bar_menu', 'update_adminbar', 999);



/* I would like to switch the positions of the new page and the new assessment item in the new item menu of the toolbar. This code somehow does not work.
https://www.sitepoint.com/customize-wordpress-toolbar/
https://digwp.com/2011/04/admin-bar-tricks/
https://codex.wordpress.org/Function_Reference/add_menu
https://codex.wordpress.org/Function_Reference/get_nodes
https://codex.wordpress.org/Function_Reference/remove_node
https://stackoverflow.com/questions/25037162/how-to-change-the-edit-page-frontend-toolbar-text-in-wordpress-snippet
http://natko.com/custom-menu-item-position-in-wordpress-admin-bar-toolbar/
https://digwp.com/2016/06/remove-toolbar-items/


function all_toolbar_nodes( $wp_admin_bar ) {

    $all_toolbar_nodes = $wp_admin_bar->get_nodes();

    $i=0;
    foreach ( $all_toolbar_nodes as $node  ) {
        if ( isset($node->parent) && $node->parent ) {
            $i++;
            if( $node->id == "new-assessment" ) {
                $indexAssessment = $i;
                $AssessmentNode = $node;
            }
            if( $node->id == "new-page" ) {
                $indexPage = $i;
                $pageNode = $node;
            }
        }
    }
    /* 
    for( $i=0; $i < count($all_toolbar_nodes); $i++ ) {
        if( $all_toolbar_nodes->id[$i] == "new-assessment" ) {
            $indexAssessment = $i;
        }
        if( $all_toolbar_nodes->id[$i] == "new-page" ) {
            $indexPage = $i;
        }
    }
    */
/*    
    $args = $all_toolbar_nodes;
    $args[$indexAssessment] = $pageNode;
    $args[$indexPage] = $AssessmentNode;
    $wp_admin_bar->add_node( $args );
}
add_action( 'admin_bar_menu', 'all_toolbar_nodes', 999 );
?>
*/


/*
function all_toolbar_nodes( $wp_admin_bar ) {

    $all_toolbar_nodes = $wp_admin_bar->get_nodes();

    foreach ( $all_toolbar_nodes as $node ) {

        // use the same node's properties
        $args = $node;

        // put a span before the title
        $args->title = '<span class="my-class"></span>' . $node->title;

        // update the Toolbar node
        $wp_admin_bar->add_node( $args );
    }
}
add_action( 'admin_bar_menu', 'all_toolbar_nodes', 999 );
*/

/*
<?php
    // use 'wp_before_admin_bar_render' hook to also get nodes produced by plugins.
add_action( 'wp_before_admin_bar_render', 'add_all_node_ids_to_toolbar' );

function add_all_node_ids_to_toolbar() {

    global $wp_admin_bar;
    $all_toolbar_nodes = $wp_admin_bar->get_nodes();

    if ( $all_toolbar_nodes ) {

        // add a top-level Toolbar item called "Node Id's" to the Toolbar
        $args = array(
            'id'    => 'node_ids',
            'title' => 'Node ID\'s'
        );
        $wp_admin_bar->add_node( $args );

        // add all current parent node id's to the top-level node.
        foreach ( $all_toolbar_nodes as $node  ) {
            if ( isset($node->parent) && $node->parent ) {

                $args = array(
                    'id'     => 'node_id_'.$node->id, // prefix id with "node_id_" to make it a unique id
                    'title'  => $node->id,
                    'parent' => 'node_ids'
                    // 'href' => $node->href,
                );
                // add parent node to node "node_ids"
                $wp_admin_bar->add_node($args);
            }
        }

        // add all current Toolbar items to their parent node or to the top-level node
        foreach ( $all_toolbar_nodes as $node ) {

            $args = array(
                'id'      => 'node_id_'.$node->id, // prefix id with "node_id_" to make it a unique id
                'title'   => $node->id,
                // 'href' => $node->href,
            );

            if ( isset($node->parent) && $node->parent ) {
                $args['parent'] = 'node_id_'.$node->parent;
            } else {
                $args['parent'] = 'node_ids';
            }

            $wp_admin_bar->add_node($args);
        }
    }
}
?>  
*/


?>