<?php

/**
 * This file contain the general methods of the theme.
 * @since 1.0.0
 */

/**
 * Get Primary Category of the post.
 * @param int $post_id
 * @param string $taxonomy
 * 
 * @since 1.0.0
 * @return int Term ID
 */
if ( ! function_exists( 'mccain_get_primary_taxonomy_id' ) ) {

	function mccain_get_primary_taxonomy_id( $post_id, $taxonomy ) {

		$prm_term = '';

		if (class_exists('WPSEO_Primary_Term')):
			
			$wpseo_primary_term = new WPSEO_Primary_Term( $taxonomy, $post_id );
			$prm_term = $wpseo_primary_term->get_primary_term();

		endif;
		
		if ( !is_object($wpseo_primary_term) || empty( $prm_term ) ):

			$term = wp_get_post_terms( $post_id, $taxonomy );

			if (isset( $term ) && !empty( $term ) && !is_wp_error( $term ) ):

				return $term[0]->term_id;

			else:

				return '';

			endif;

		endif;

		return $wpseo_primary_term->get_primary_term();
	}
}

/**
 * Return string of 'selected' for dropdown filter options.
 * 
 * @param string $slug Get method type name. [type | topic]
 * @param string $value value of the type name.
 * 
 * @since 1.0.0
 * @return string $string
 */
function mccain_filter_selected_option( $slug, $value = '' ) {

	if( isset( $_GET[$slug] ) && !empty( $_GET[$slug] ) && $value == $_GET[$slug] ) {
		$string = ' selected';
	} else {
		$string = '';
	}

	return $string;

}

/**
 * Create HTML structure for event fitler, used on the report/events archive.
 * @param string $action
 * 
 * @since 1.0.0 
 * @return HTML
 */
function mccain_event_archive_filter( $action = '' ) { 
	$event_terms = get_terms( array(
		'taxonomy' 		=> 'mccain-event-tags',
		'hide_empty' 	=> false,
	) ); 

	// Set condition for showing Upcoming Event option selected on page load.
	if( ! isset( $_GET['type'] ) ) {
		$up_event_select = ' selected';
	} else {
		$up_event_select = mccain_filter_selected_option( 'type', 'upcoming-events' );
	}?>

	<div class="posts-main-wrapper archive-categories-wrapper only-filter">
		<div class="filtr-wrapper">
			<div class="wpb-container">
				<form action="<?php echo $action; ?>" method="get" id="mccain-resources-filter">
					<div class="container">
						<span class="filter-by"><?php esc_html_e( 'Filter by', 'mccain' ); ?></span>
						<!-- Start with filter-dropdown -->
						<div class="filter-dropdown">				
							<div class="select filter">
								<select name="type" id="" class="filter">
									<option value=""><?php esc_html_e( 'All Events', 'mccain' ); ?></option>
									<option value="all"<?php echo mccain_filter_selected_option( 'type' ); ?>><?php esc_html_e( 'All Events', 'mccain' ); ?></option>
									<option value="upcoming-events"<?php echo $up_event_select; ?>><?php esc_html_e( 'Upcoming Events', 'mccain' ); ?></option>
									<option value="previous-events"<?php echo mccain_filter_selected_option( 'type', 'previous-events' ); ?>><?php esc_html_e( 'Previous Events', 'mccain' ); ?></option>
								</select>
							</div>					
						</div> <!-- End of filter-dropdown -->

						<!-- Start with filter-dropdown -->
						<div class="filter-dropdown">
							<div class="select filter-location">
								<select name="topic" id="" class="filter">
									<option value=""><?php esc_html_e( 'All Topics', 'mccain' ); ?></option>
									<option value="all"<?php echo mccain_filter_selected_option( 'topic' ); ?>><?php esc_html_e( 'All Topics', 'mccain' ); ?></option>
									<?php foreach ( $event_terms as $term ) {
										echo '<option value="' . $term->slug .'"' . mccain_filter_selected_option( 'topic', $term->slug ) . '>' . $term->name . '</option>';
									} ?>
								</select>
							</div>
						</div> <!-- End of filter-dropdown -->
						<input type="submit" value="Search" />
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php
}



/**
 * Query for fetching a single post from $post_type w.r.t the $tax2
 * 
 * @param string $post_type
 * @param string $taxonomy
 * @param string $tax2 2nd taxonomy
 * @param string $term2
 * 
 * @since 1.0.0
 * @return void
 */
function mccain_the_latest_query( $post_type, $taxonomy = '', $tax2 = '', $term2 = '' ){

	global $post;

	/*
	* Set arguments for display featured tag posts only on HP:
	*/
	$feature_blog_args = array(
		'post_type' 		=> $post_type,
		'posts_per_page' 	=> '1'
	);

	if( !empty( $tax2 ) && !empty( $term2 ) ){
		
		$feature_blog_args['tax_query'] = array(
			array(
				'taxonomy' => $tax2, //'category',
				'field'    => 'slug',
				'terms'    => $term2, //'blog',
			),
		);
	}

	$feature_blog_query = new WP_Query( $feature_blog_args );

	if ( $feature_blog_query->have_posts() ) : ?>

			<?php while ( $feature_blog_query->have_posts() ) : $feature_blog_query->the_post(); 
			
				if( 'post' == $post_type ) {
					$terms = get_the_terms( $post->ID , 'category' );
				} else {
					$terms = false;
				}

				$mccain_term_id  = mccain_get_primary_taxonomy_id( $post->ID, $taxonomy ); // Display the Primary category by using the taxonomy name and post ID
				if ( ! empty( $mccain_term_id ) ) {
					$tag_term = get_term_by( 'ID', $mccain_term_id, $taxonomy );
				} else {
					$tag_term = false;
				}

				echo mccain_featured_blog_post_html( $post->ID, $terms, $tag_term );

			endwhile; ?>
		
	<?php endif;
	wp_reset_postdata();
}


/**
 * Add a class in wrapper of the silder for managing the arrow and dots.
 * 
 * @param number $posts_found number of posts that found in query.
 * 
 * @since 1.0.0
 * @return string $class name of the class.
 */

function mccain_slider_class( $posts_found ){

	$class = ( $posts_found < 4 ) ? ' mccain_slide_off' : '';
	return $class;
}


/**
 * Remove width and height attributes from the returning html
 */
add_filter( 'post_thumbnail_html', 'mccain_remove_thumbnail_width_height', 10, 5 );
 
function mccain_remove_thumbnail_width_height( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
	
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}