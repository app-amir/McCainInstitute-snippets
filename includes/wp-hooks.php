<?php

/**
 * This file contain the modified WP Hooks.
 * @since 1.0.0
 */


/**
 * Functions to add browser class in body
 */
function mccain_browser_body_class( $classes ) {

	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	if($is_lynx) $classes[] = 'lynx';

	elseif($is_opera) $classes[] = 'opera';

	elseif($is_NS4) $classes[] = 'ns4';

	elseif($is_safari) $classes[] = 'safari';

	elseif($is_chrome) $classes[] = 'chrome';
	
	elseif($is_gecko) $classes[] = 'gecko firefox';

	elseif($is_IE) {

		$classes[] = 'ie';
		if(preg_match('/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version))
		$classes[] = 'ie'.$browser_version[1];

	} else $classes[] = 'unknown';

	if($is_iphone) $classes[] = 'iphone';

	if ( stristr( $_SERVER['HTTP_USER_AGENT'],"mac") ) {
		$classes[] = 'osx';
	} elseif ( stristr( $_SERVER['HTTP_USER_AGENT'],"linux") ) {
		$classes[] = 'linux';
	} elseif ( stristr( $_SERVER['HTTP_USER_AGENT'],"windows") ) {
		$classes[] = 'windows';
	}
	return $classes;

}
add_filter('body_class','mccain_browser_body_class');

/**
 * Optimze the WordPress default query. 
 * Fires after the query variable object is created, but before the actual query is run.
 * 
 * @since 1.0.0
 */
function mccain_custom_get_posts_for_acrchive( $query ) {

	if ( is_admin() || ! $query->is_main_query() )
		return;

	/**
	 * Set the meta_query & tax_query for the mccain-event archive.
	 * @since 1.0.0
	 */
	if ( $query->is_archive() && is_post_type_archive( 'mccain-event' ) ) {
		// $query->set( 'posts_per_page', 1 );
		$query->set( 'meta_key', 'mccain_events_date_picker' );
		$query->set( 'orderby', 'meta_value_num' );
		

		if( isset( $_GET['type'] ) && ! empty( $_GET['type'] ) && ( 'all' == $_GET['type']  || 'previous-events' == $_GET['type'] ) ) {
			$query->set( 'order', 'DESC' );
		} else {
			$query->set( 'order', 'ASC' );
		}
		
		if( isset( $_GET['type'] ) && ! empty( $_GET['type'] ) && ( 'previous-events' == $_GET['type'] ) ) {
			$compare = '<';
		} else {
			$compare = '>=';
		}

		if( isset( $_GET['topic'] ) && !empty( $_GET['topic'] ) && ( 'all' != $_GET['topic'] ) ) {

			$query->set( 'tax_query', array(
				'relation' => 'OR',
				array(
					'taxonomy' => 'mccain-event-tags',
					'field' => 'slug',
					'terms' => $_GET['topic'],
					'operator' => 'IN'
				)
			) );
		}
	}

	
	/**
	 * Set the tax_query for the mccain-issue-category archive.
	 * @since 1.0.0
	 */
	if ( $query->is_tax( 'mccain-issue-category' ) && $query->is_main_query() ) {
		
		$category = array(
			'taxonomy' 	=> 'mccain-issue-category',
			'field' 	=> 'slug',
			'terms' 	=> $query->query['mccain-issue-category'],
			'operator' 	=> 'IN'
		);

		if( isset( $_GET['type'] ) && ! empty( $_GET['type'] ) && ( 'all' != $_GET['type'] ) ) {

			$type = array(
				'taxonomy' 	=> 'mccain-issue-type',
				'field' 	=> 'slug',
				'terms' 	=> $_GET['type'],
				'operator' 	=> 'IN'
			);
		} else {
			$type = '';
		}

		if( isset( $_GET['topic'] ) && !empty( $_GET['topic'] ) && ( 'all' != $_GET['topic'] ) ) {

			$topic = array(
				'taxonomy' => 'mccain-issue-topic',
				'field' => 'slug',
				'terms' => $_GET['topic'],
				'operator' => 'IN'
			);
		} else {
			$topic = '';
		}
		
	}

	return $query;
}

add_action( 'pre_get_posts', 'mccain_custom_get_posts_for_acrchive', 1 );

function mccain_admin_enqueue($hook) {

    /* Check if the post being added/edited is a Custom Post Type which you want */

    if ( ( 'post.php' == $hook || 'post-new.php' == $hook )  )
		add_action( 'admin_footer', 'mccain_change_posts_cat_type' );

}
add_action( 'admin_enqueue_scripts', 'mccain_admin_enqueue' );


// Remove tags support from posts
function mccain_unregister_tags() {
    unregister_taxonomy_for_object_type( 'post_tag', 'post' );
}
add_action( 'init', 'mccain_unregister_tags' );

 /*
 * Add Sortable columns to Events CPT
 */
function mccain_event_column_register_sortable( $columns ) {

	$columns['mccain_events_date_picker'] = 'mccain_events_date_picker';

	return $columns;
}
add_filter( 'manage_edit-mccain-event_sortable_columns', 'mccain_event_column_register_sortable' );



/*
 * Add columns to Staffs CPT
 */
function mccain_staff_custom_column ( $column, $post_id ) {
	switch ( $column ) {
	  case 'mccain_staff_priority':
		echo get_field( 'mccain_staff_priority', $post_id );
		break;
	}
}
add_action( 'manage_mccain-staff_posts_custom_column', 'mccain_staff_custom_column', 10, 2 );

 /*
 * Add Sortable columns to Staffs CPT
 */
function mccain_staff_column_register_sortable( $columns ) {

	$columns['mccain_staff_priority'] = 'mccain_staff_priority';

	return $columns;
}
add_filter( 'manage_edit-mccain-staff_sortable_columns', 'mccain_staff_column_register_sortable' );