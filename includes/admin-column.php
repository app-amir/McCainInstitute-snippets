<?php


/**
 *	ACF Admin Columns
 *
 */

 function mccain_staff_priority_columns ( $columns ) {
   return array_merge ( $columns, array ( 
     'mccain_staff_priority' => __ ( 'Priority' ),
   ) );
 }
 add_filter ( 'manage_mccain-staff_posts_columns', 'mccain_staff_priority_columns' );

  /*
 * Add columns to mccain-staff CPT
 */
 function mccain_staff_custom_column ( $column, $post_id ) {
   switch ( $column ) {
     case 'mccain_staff_priority':
       echo get_post_meta( $post_id, 'mccain_staff_priority', true );
       break;
   }
}
add_action ( 'manage_mccain-staff_posts_custom_column', 'mccain_staff_custom_column', 10, 2 );

/*
 * Add Sortable columns
 */

function mccain_staff_column_register_sortable( $columns ) {
	$columns['mccain_staff_priority'] = 'mccain_staff_priority';
	return $columns;
}
add_filter('manage_edit-mccain-staff_sortable_columns', 'mccain_staff_column_register_sortable' );