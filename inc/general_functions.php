<?php 

function get_user_role( $user_id = 0 ) {
	$user = ( $user_id ) ? get_userdata( $user_id ) : wp_get_current_user();
	return current( $user->roles );
}





?>


