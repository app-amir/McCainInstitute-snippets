<?php
/**
 * The home template file
 *
 * This is the most generic template file in a WordPress theme
 * It is used to display a blog posts when nothing more specific matches a query.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @since 1.0.0
 */

get_header(); 

global $wp_query; 

$categories = get_categories(); 

$terms = get_terms( array(
    'taxonomy' => 'mccain-term',
    'hide_empty' => false,
) );
?>

<main class="site-main-container">
	<?php echo do_shortcode( '[elementor-template id="700"]' ); ?>
	<div class="posts-main-wrapper archive-categories-wrapper only-filter">
		<div class="filtr-wrapper">
			<div class="wpb-container">
				<form action="/resources/the-latest/" method="get" id="mccain-resources-filter">
					<div class="container">
						<span class="filter-by">Filter by</span>
						<!-- Start with filter-dropdown -->
						<div class="filter-dropdown">				
							<div class="select filter">
								<select name="type" id="" class="filter">
									<option value=""><?php esc_html_e( 'All Types', 'mccain' ); ?></option>
									<option value="all"<?php echo mccain_filter_selected_option( 'type' ); ?>><?php esc_html_e( 'All Types', 'mccain' ); ?></option>
									<?php foreach ($categories as $category) {
										echo '<option value="' . $category->slug .'"' . mccain_filter_selected_option( 'type', $category->slug ) . '>' . $category->name . '</option>';
									} ?>
								</select>
							</div>					
						</div> <!-- End of filter-dropdown -->

						<!-- Start with filter-dropdown -->
						<div class="filter-dropdown">
							<div class="select filter-location">
								<select name="topic" id="" class="filter">
									<option value=""><?php esc_html_e( 'All Topics', 'mccain' ); ?></option>
									<option value="all"<?php echo mccain_filter_selected_option( 'topic' ); ?>><?php esc_html_e( 'All Topics', 'mccain' ); ?></option>
									<?php foreach ($terms as $term) {
										if( 'feature' == $term->slug ){
											continue;
										}
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
		<?php if ( have_posts() ) { ?>
			<div class="posts-main vh-height">
				<?php // Load posts loop.
				while ( have_posts() ) {
					the_post(); 
					$terms = get_the_terms( $post->ID , 'category' );
					$mccain_term_id  = mccain_get_primary_taxonomy_id( $post->ID, 'mccain-term' ); // Display the Primary category by using the taxonomy name and post ID
					if ( ! empty( $mccain_term_id ) ) {
						$cat_obj = get_term_by( 'ID', $mccain_term_id, 'mccain-term' );
					} else {
						$cat_obj = false;
					}
					 ?>

					<div class="post-wrapper">
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
					</div><!-- /.post-wrapper -->

				<?php } ?>
			</div>
			<div class="mccain_pagination_wraper">
				<div class="mccain_pagination">	
					<?php 
					/**
					 * Query for Total Pages and Maximum number of Pages
					 * Checking the Condition greater than "1".
					 * 
					 * Set the Current Page.
					 * 
					 * Override this function you can find out the rest of function script at the bottom
					 */
					$total_pages = $wp_query->max_num_pages; 
					
					if ( $total_pages > 1 ) {
						
						$current_page = max( 1, get_query_var('paged'));
						echo mccain_paginate_links( array( 
							'mid_size'  => 1,
							'format'    => 'page/%#%/',
							'current'   => $current_page,
							'prev_text' => __('<i class="far fa-chevron-left"></i>'),
							'next_text' => __('<i class="far fa-chevron-right"></i>'),
							'total'     => $wp_query->max_num_pages,
							'end_size'  => 1,
						));

					} ?>
				</div>
			</div> <?php

		} else {

			// If no content, include the "No posts found" template.
			// get_template_part( 'template-parts/content/content-none' ); ?>

			<div class="no-result-found">
				<h2><?php esc_html_e( 'Nothing Found', 'mccain' ); ?></h2>
				<p><?php esc_html_e( 'Try a different selection to explore more content.', 'mccain' ); ?></p>
			</div>
		<?php } wp_reset_postdata();
		?>
	</div>
</main>
<?php get_footer(); ?>