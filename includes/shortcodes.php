<?php

/**
 * Display events only from today and in the future:
 * @param array $attr Shortcode attributes.
 * @since 1.0.0
 */
function mccain_events_callback( $attr ) {

	ob_start();
	$data = shortcode_atts(
		array(
			'posts_per_page' => '3',
		),
		$attr
	);

	global $post;

	/*
	* Set arguments for display events only from today and in the future:
	*/
	$args = array(
		'post_type'      	=> 'mccain-event',
        'meta_key' 			=> 'mccain_events_date_picker',
		'posts_per_page' 	=> '3',
		'meta_query'        => array(
			array(
				'key'           => 'mccain_events_date_picker',
				'value'         => date("Y-m-d"),
				'type'          => 'DATE'
			)
		)
	);

	$the_query = new WP_Query( $args );

	if ( $the_query->have_posts() ) : ?>

		<div class="events-block-wrapper">
			<?php
			while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

				<a href="<?php echo get_the_permalink(); ?>" class="events-block">
					<div <?php post_class( "event-block-content-wrapper" ); ?>>
						<h6><?php if( $date && $time ) {
							echo esc_html( $date ) . ' | ' . esc_html( $time ) . ' ' . esc_html( $time_zone );
						} ?></h6>
						<h5><?php echo get_the_title(); ?></h5>
					</div>
				</a>
			<?php endwhile; ?>
  		</div>
	<?php endif;
	wp_reset_postdata();
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}

add_shortcode( 'mccain_events', 'mccain_events_callback' );

/**
 * Shortcode for McCain Quotes.
 *
 * In McCain Qoutes, a special character "[" & "]" is making conflict with the current font family.
 * To overcome on this conflict, we create a span around special character and change font style for it.
 *
 * @param array $attr Shortcode attributes.
 * @since 1.0.0
 */
function mccain_quotes_callback( $attr ) {

	ob_start();
	$data = shortcode_atts(
		array(
			'post__in' => '',
		),
		$attr
	);

	/*
	* Set arguments for display quotes randomly:
	*/
	$args = array(
		'post_type'      			=> 'mccain-quote',
		'orderby' 					=> 'rand',
		'posts_per_page' 			=> -1,
		'fields'					=> 'ids',
	);

	if( !empty( $data['post__in'] ) ){
		$args['post__in'] = array( 421, 423, 431, 415 );
	}

	// With the help of $mccain_quote_transient we'll create 3 transient and call them w.r.t the lang cade.
	if( 'es' == ICL_LANGUAGE_CODE ){
		$mccain_quote_transient = 'es';
	} elseif( 'fr' == ICL_LANGUAGE_CODE ){
		$mccain_quote_transient = 'fr';
	} else {
		$mccain_quote_transient = 'en';
	}

	// The Query, pull from transient if exists
	if ( false === ( $quote_query = get_transient( 'mccain_random_quote_query_results_' . $mccain_quote_transient ) ) ) {
		// It wasn't there, so regenerate the data and save the transient
		$quote_query = new WP_Query( $args );
		set_transient( 'mccain_random_quote_query_results_' . $mccain_quote_transient , $quote_query, 10 * MINUTE_IN_SECONDS );
	}

	if ( $quote_query->have_posts() ) :

		$posts 			= $quote_query->posts;
		$id 			= array_rand( $posts );
		$value 			= $posts[$id];
		$content_post 	= get_post( $value );
		$getString 		= $content_post->post_content;

		// Display replaced string
		$char_replace = str_replace( "[", '<span style="font-family: sans-serif; font-weight: 500;">[</span>', $getString );
		$char_replace = str_replace( "]", '<span style="font-family: sans-serif; font-weight: 500;">]</span>', $char_replace );

		echo $char_replace;

		// wp_reset_postdata();
	endif;

	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}

add_shortcode( 'mccain_quotes', 'mccain_quotes_callback' );


/**
 * Shortcode for slider call on the resources page:
 *
 * Content retrive based on post type.
 * @param array $attr Shortcode attributes.
 * @since 1.0.0
 */
function mccain_archive_slider_callback( $attr ) {

	ob_start();
	$data = shortcode_atts(
		array(
			'post_type'			=> 'post',
			'posts_per_page' 	=> '10',
		),
		$attr
	);

	global $post;

	/**
	 * Set variable w.r.t the post types.
	 * @var int $posttype for passing Post Type name over the tag area.
	 * @var int $taxonomy for passing the taxonomy.
	 */
	if( 'mccain-podcast' == $data['post_type'] ){
		$posttype = __( 'Podcast', 'mccain' );
		$taxonomy = 'mccain-podcast-term';
	} else if( 'mccain-event' == $data['post_type'] ){
		$posttype = __( 'Events', 'mccain' );
		$taxonomy = 'mccain-event-tags';
	} else {
		$posttype = __( 'Blog', 'mccain' ) ;
		$taxonomy = 'mccain-term';
	}

	/*
	* Set arguments for the query based on the post type.
	*/
	if( 'mccain-event' == $data['post_type'] ){
		$args = array(
			'post_type'      	=> 'mccain-event',
			'posts_per_page' 	=> $data['posts_per_page'],
			'meta_query'        => array(
				array(
					'key'           => 'mccain_events_date_picker',
					'compare'       => '>',
					'value'         => date("Y-m-d"),
				)
			)
		);
	} else {
		$args = array(
			'post_type'      	=> $data['post_type'],
			'posts_per_page' 	=> $data['posts_per_page'],
		);
	}

	$the_query = new WP_Query( $args );

	if ( $the_query->have_posts() ) : ?>

		<div class="arrow-right fal fa-chevron-right"></div>
		<div class="arrow-left fal fa-chevron-left"></div>
		<div class="swiper-container resource-slider<?php echo mccain_slider_class( $the_query->found_posts ); ?>">
			<div class="swiper-wrapper">
				<?php while ( $the_query->have_posts() ) : $the_query->the_post();

					if( 'post' == get_post_type() ) {
						$terms = get_the_terms( $post->ID , 'category' );
					} else {
						$terms = false;
					}

					$mccain_term_id  = mccain_get_primary_taxonomy_id( $post->ID, $taxonomy ); // Display the Primary category by using the taxonomy name and post ID
					if ( ! empty( $mccain_term_id ) ) {
						$tag_term = get_term_by( 'ID', $mccain_term_id, $taxonomy );
					} else {
						$tag_term = false;
					} ?>
					<div <?php post_class( "swiper-slide" ); ?>>
						<a href="<?php echo get_the_permalink(); ?>" class="resource-img">
							<?php if ( has_post_thumbnail( $post->ID ) ) :

								/**
								 * 'thumbnail' Thumbnail (default 150px x 150px max)
								 * 'medium' Medium resolution (default 300px x 300px max)
								 * 'medium_large' Medium-large resolution (default 768px x no height limit max)
								 * 'large' Large resolution (default 1024px x 1024px max)
								 * 'full' Original image resolution (unmodified)
								 *
								 */

								$img_id 	= get_post_thumbnail_id( $post->ID );
								$image 		= wp_get_attachment_image_src( $img_id, 'medium_large' );
								$alt_text 	= get_post_meta( $img_id, '_wp_attachment_image_alt', true ); ?>
								<img src="<?php echo $image[0]; ?>" alt="<?php echo $alt_text; ?>">
							<?php endif; ?>
						</a>
						<div class="resource-content">
							<div class="tags">
								
							</div>
							<h5><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h5>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
			<div class="swiper-pagination"></div>
		</div>
	<?php endif;
	wp_reset_postdata();
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}

add_shortcode( 'mccain_archive_slider', 'mccain_archive_slider_callback' );

/**
 * Shortcode for slider call on the program single page:
 *
 * Content retrive based on term.
 * @param array $attr Shortcode attributes.
 * @since 1.0.0
 */
function mccain_program_slider_callback( $attr ) {

	ob_start();
	$data = shortcode_atts(
		array(
			'post_type'			=> 'post',
			'posts_per_page' 	=> '7',
			'term'				=> ''
		),
		$attr
	);

	global $post;

	/*
	* Set arguments for the query based on the post type.
	*/

	$args = array(
		'post_type'      	=> $data['post_type'],
		'posts_per_page' 	=> $data['posts_per_page'],
	);

	if( ! empty( $data['term'] ) ) {

		$terms = explode( ',', $data['term'] );

		$args['tax_query'] = array(
			'relation' => 'OR',
			array(
				'taxonomy' 	=> 'mccain-term',
				'terms' 	=> $terms,
				'operator' 	=> 'IN'
			)
		);
	}

	$the_query = new WP_Query( $args );

	if ( $the_query->have_posts() ) : ?>

		<div class="arrow-right fal fa-chevron-right"></div>
		<div class="arrow-left fal fa-chevron-left"></div>
		<div class="swiper-container resource-slider<?php echo mccain_slider_class( $the_query->post_count ); ?>">
			<div class="swiper-wrapper">
				<?php while ( $the_query->have_posts() ) : $the_query->the_post();
					$terms = get_the_terms( $post->ID , 'category' );
					$mccain_term_id  = mccain_get_primary_taxonomy_id( $post->ID, 'mccain-term' ); // Display the Primary category by using the taxonomy name and post ID
					if ( ! empty( $mccain_term_id ) ) {
						$cat_obj = get_term_by( 'ID', $mccain_term_id, 'mccain-term' );
					} else {
						$cat_obj = false;
					} ?>
					<div <?php post_class( "swiper-slide" ); ?>>
						<a href="<?php echo get_the_permalink(); ?>" class="resource-img">
							<?php if ( has_post_thumbnail( $post->ID ) ) :

								/**
								 * 'thumbnail' Thumbnail (default 150px x 150px max)
								 * 'medium' Medium resolution (default 300px x 300px max)
								 * 'medium_large' Medium-large resolution (default 768px x no height limit max)
								 * 'large' Large resolution (default 1024px x 1024px max)
								 * 'full' Original image resolution (unmodified)
								 *
								 */

								$img_id 	= get_post_thumbnail_id( $post->ID );
								$image 		= wp_get_attachment_image_src( $img_id, 'medium_large' );
								$alt_text 	= get_post_meta( $img_id, '_wp_attachment_image_alt', true ); ?>
								<img src="<?php echo $image[0]; ?>" alt="<?php echo $alt_text; ?>">
							<?php endif; ?>
						</a>
						<div class="resource-content">
							<div class="tags">
								<span class="tag">
									<?php if( $terms && !is_wp_error( $terms ) ) { echo $terms[0]->name; }
									if( $cat_obj ) { echo ': ' . $cat_obj->name; } ?>
								</span>
							</div>
							<h5><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h5>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
			<div class="swiper-pagination"></div>
		</div>
	<?php endif;
	wp_reset_postdata();
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}

add_shortcode( 'mccain_program_slider', 'mccain_program_slider_callback' );


/**
 * Shortcode to get current year.
 *
 * @return string
 */
function mccain_current_year_shortcode() {

	return date( "Y" );
}
add_shortcode( 'mccain_current_year', 'mccain_current_year_shortcode' );

/**
 * Display search filter for report tags on the report archive:
 * @param array $attr Shortcode attributes.
 * @since 1.0.0
 */
function mccain_report_archive_filter_callback( $attr ) {

	ob_start();

	$post_type = get_queried_object();
	$slug = '/' . $post_type->rewrite['slug'] . '/';

	echo mccain_archive_single_filter( 'mccain-report-type', $slug );

	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}

add_shortcode( 'mccain_report_archive_filter', 'mccain_report_archive_filter_callback' );


/**
 * Display search filter for podcast tags on the report archive:
 * @param array $attr Shortcode attributes.
 * @since 1.0.0
 */
function mccain_podcast_archive_filter_callback( $attr ) {

	ob_start();

	$post_type = get_queried_object();
	$slug = '/' . $post_type->rewrite['slug'] . '/';

	echo mccain_archive_single_filter( 'mccain-podcast-term', $slug );

	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}

add_shortcode( 'mccain_podcast_archive_filter', 'mccain_podcast_archive_filter_callback' );


/**
 * Display search filter for events tags on the events archive:
 * @param array $attr Shortcode attributes.
 * @since 1.0.0
 */
function mccain_event_archive_filter_callback( $attr ) {

	ob_start();

	$post_type = get_queried_object();
	$slug = '/' . $post_type->rewrite['slug'] . '/';

	echo mccain_event_archive_filter( $slug );

	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}

add_shortcode( 'mccain_event_archive_filter', 'mccain_event_archive_filter_callback' );


/**
 * Display staff block on the staff/leadership/counsils page:
 * @param array $attr Shortcode attributes.
 * @since 1.0.0
 */
function mccain_staff_block_callback( $attr ) {

	ob_start();
	$data = shortcode_atts(
		array(
			'term' => '',
			'posts_per_page' => -1,
		),
		$attr
	);

	global $post;

	/*
	* Set arguments for display events only from today and in the future:
	*/
	$args = array(
		'post_type' 		=> 'mccain-staff',
		'posts_per_page' 	=> $data['posts_per_page'],
		// 'meta_key'			=> 'mccain_staff_priority',
		'meta_query' => array(
			'relation' => 'AND',
			'last_name_clause' => array(
				'key' => 'mccain_staff_name_last_name',
				'compare' => 'EXISTS',
			),
			'priority_clause' => array(
				'key' => 'mccain_staff_priority',
				'value' => '',
				'compare' => 'NOT IN'
				
			), 
		),
		'orderby' => array(
			'last_name_clause' => 'ASC',
			'priority_clause' => 'meta_value_num',
		),
		// 'orderby'			=> 'meta_value_num',
		'order'				=> 'ASC'
	);

	if( ! empty( $data['term'] ) ) {

		$terms = explode( ',', $data['term'] );

		$args['tax_query'] = array(
			'relation' => 'OR',
			array(
				'taxonomy' 	=> 'mccain-staff-term',
				'field' 	=> 'slug',
				'terms' 	=> $terms,
				'operator' 	=> 'IN'
			)
		);
	}
	$the_query = new WP_Query( $args );

	if ( $the_query->have_posts() ) : ?>

		<div class="team-container">
			<?php while ( $the_query->have_posts() ) : $the_query->the_post();

				$postID = get_the_id();
				$staff_designation = get_field( 'mccain_staff_designation', $postID ); ?>

				<div class="team-block">
					<div class="team-bio">
						<div class="resource-img">
							<?php if( has_post_thumbnail( $postID ) ){
								echo get_the_post_thumbnail( $postID, 'medium_large' );	
							} ?>
						</div>
						<div class="resource-content">
							<h5><?php echo get_the_title(); ?></h5>
							<?php if( $staff_designation ){
								echo '<p>' . $staff_designation . '</p>';
							}?>
						</div>
					</div>
					<div class="team-popup">
						<span class="team-close"></span>
						<div class="team-popup-container">
							<div class="team-headshot">
								<?php if( has_post_thumbnail( $postID ) ){
									echo get_the_post_thumbnail( $postID, 'medium_large' );	
								} ?>
							</div>
							<div class="team-popup-bio">
								<h5><?php echo get_the_title(); ?></h5>
								<?php if( $staff_designation ){
									echo '<p>' . $staff_designation . '</p>';
								}?>
							</div>
							<div class="team-bio-discription">
								<?php echo wpautop( get_the_content() ); ?>
							</div>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
  		</div>
	<?php endif;
	wp_reset_postdata();
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}

add_shortcode( 'mccain_staff_block', 'mccain_staff_block_callback' );

/**
 * Display NGL block on the leadership page:
 * @param array $attr Shortcode attributes.
 * @since 1.0.0
 */
function mccain_ngl_block_callback( $attr ) {

	ob_start();
	$data = shortcode_atts(
		array(
			'term' => '',
			'posts_per_page' => -1,
			'sortby' => 'mccain_ngl_priority'
		),
		$attr
	);

	global $post;

	/*
	* Set arguments for display events only from today and in the future:
	*/
	$args = array(
		'post_type' 		=> 'mccain-ngl',
		'posts_per_page' 	=> $data['posts_per_page'],
	);

	if( ! empty( $data['term'] ) ) {

		$terms = explode( ',', $data['term'] );

		$args['tax_query'] = array(
			'relation' => 'OR',
			array(
				'taxonomy' 	=> 'mccain-ngl-term',
				'field' 	=> 'slug',
				'terms' 	=> $terms,
				'operator' 	=> 'IN'
			)
		);
	}

	if( 'last_name' == $data['sortby'] ) {

		$args['meta_key']	= 'last_name';
		$args['orderby']	= 'meta_value';
		$args['order']		= 'ASC';
	} else {

		$args['meta_key']	= 'mccain_ngl_priority';
		$args['orderby']	= 'meta_value_num';
		$args['order']		= 'ASC';
	}

	$the_query = new WP_Query( $args );

	if ( $the_query->have_posts() ) : ?>

		<div class="team-container">
			<?php while ( $the_query->have_posts() ) : $the_query->the_post();

				$postID = get_the_id();
				$country_designation = get_field( 'country', $postID );
				$staff_designation = get_field( 'mccain_staff_designation', $postID ); ?>

				<div <?php post_class( "team-block" ); ?>>
					<div class="team-bio">
						<div class="resource-img">
							<?php if( has_post_thumbnail( $postID ) ){
								echo get_the_post_thumbnail( $postID, 'medium_large' );	
							} ?>
						</div>
						<div class="resource-content">
							<h5><?php echo get_the_title(); ?></h5>
							<?php if( $country_designation ){
								echo '<p>' . $country_designation . '</p>';
							}?>
						</div>
					</div>
					<div class="team-popup">
						<span class="team-close"></span>
						<div class="team-popup-container">
							<div class="team-headshot">
								<?php if( has_post_thumbnail( $postID ) ) { 
									echo get_the_post_thumbnail( $postID, 'medium_large' );
								} ?>
							</div>
							<div class="team-popup-bio">
								<h5><?php echo get_the_title(); ?></h5>
								<?php if( $staff_designation ){
									echo '<p>' . $staff_designation . '</p>';
								}?>
							</div>
							<div class="team-bio-discription">
								<?php echo wpautop( get_the_content() ); ?>
							</div>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
  		</div>
	<?php endif;
	wp_reset_postdata();
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}

add_shortcode( 'mccain_ngl_block', 'mccain_ngl_block_callback' );

/**
 * Create featured issue slider.
 * show 2 posts of each category as a featured issue on /mccain-story/on-the-issues/ page.
 * @param array $attr Shortcode attributes.
 * @since 1.0.0
 */
function mccain_featured_issue_callback( $attr ) {

	ob_start();

	$mccain_issue_cat = get_terms( array(
		'taxonomy' => 'mccain-issue-category',
		'hide_empty' => false,
	) ); ?>

	<div class="arrow-right fal fa-chevron-right"></div>
	<div class="arrow-left fal fa-chevron-left"></div>
	<div class="swiper-container resource-slider">
		<div class="swiper-wrapper">
			<?php foreach ( $mccain_issue_cat as $issue_cat ) {
				$args = array(
					'post_type' 		=> 'mccain-on-the-issue', // the post type
					'posts_per_page' 	=> 2,
					'order'   			=> 'Date',
					'tax_query' 		=> array(
						array(
							'taxonomy' => 'mccain-issue-category', // the custom vocabulary
							'field'    => 'term_id', // term_id, slug or name  (Define by what you want to search the below term)
							'terms'    => $issue_cat->term_id,      // provide the term slugs
						),
					),
				);

				$mccain_issue_cat_query = new WP_Query( $args );

				$mccain_on_issue = get_post_type_archive_link( get_post_type( get_the_ID() ) );

				if ( $mccain_issue_cat_query->have_posts() ) {
					while ( $mccain_issue_cat_query->have_posts() ) : $mccain_issue_cat_query->the_post();

						$post_id = get_the_ID();
						$mccain_issue_cat_id  = mccain_get_primary_taxonomy_id( $post_id, 'mccain-issue-category' );

						if ( ! empty( $mccain_issue_cat_id ) ) {
							$issue_category = get_term_by( 'ID', $mccain_issue_cat_id, 'mccain-issue-category' );
						} else {
							$issue_category = false;
						} ?>

						<div <?php post_class( "swiper-slide" ); ?>>
							<a href="<?php echo get_the_permalink(); ?>" class="resource-img">
								<?php if ( has_post_thumbnail( $post_id ) ) :

									/**
									 * 'thumbnail' Thumbnail (default 150px x 150px max)
									 * 'medium' Medium resolution (default 300px x 300px max)
									 * 'medium_large' Medium-large resolution (default 768px x no height limit max)
									 * 'large' Large resolution (default 1024px x 1024px max)
									 * 'full' Original image resolution (unmodified)
									 *
									 */

									$img_id 	= get_post_thumbnail_id( $post_id );
									$image 		= wp_get_attachment_image_src( $img_id, 'medium_large' );
									$alt_text 	= get_post_meta( $img_id, '_wp_attachment_image_alt', true ); ?>
									<img src="<?php echo $image[0]; ?>" alt="<?php echo $alt_text; ?>">
								<?php endif; ?>
							</a>
							<div class="resource-content">
								<div class="tags">
									<span class="tag">
									<?php if( $issue_category ) { ?>
										<?php echo '<a href="' . $mccain_on_issue . $issue_category->slug .'/">' . $issue_category->name . '</a>'; ?>
									<?php } ?>
									</span>
								</div>
								<h5><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h5>
							</div>
						</div>
					<?php endwhile;
				}
			} ?>
		</div>
		<div class="swiper-pagination"></div>
	</div>
	<?php wp_reset_postdata();
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}

add_shortcode( 'mccain_featured_issue', 'mccain_featured_issue_callback' );

