<?php
/**
 * Renders a list of social link items for SLO page.
 *
 * @package GPALAB_SLO
 * @since 0.0.1
 */

// phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_meta_key
// phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_meta_value
$globals = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args    = array(
  'post_type'      => 'gpalab-social-link',
  'post_status'    => 'publish', // Skip archived items.
  'meta_key'       => 'gpalab_slo_mission',
  'meta_value'     => $selected_mission,
  'meta_compare'   => '=',
  'posts_per_page' => isset( $draft_preview ) && $draft_preview ? 17 : 18, // Adjust the query if previewing a draft link.
  'paged'          => $globals,
);
// phpcs:enable

$the_query = new WP_Query( $args );

if ( $the_query->have_posts() ) {

  while ( $the_query->have_posts() ) {
    $the_query->the_post();

    require 'social-link-item.php';
  }
} else {
  // Show fallback message if no links found.
  $no_links = __( 'No Social Bio Links', 'gpalab-slo' );

  echo '<p>' . esc_html( $no_links ) . '</p>';
}

wp_reset_postdata();
