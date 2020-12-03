<?php
/**
 * Renders a list of social link items for SLO page.
 *
 * @package GPALAB_SLO
 */

// phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_meta_key
// phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_meta_value
$args = array(
  'post_type'    => 'gpalab-social-link',
  'meta_key'     => 'gpalab_slo_mission',
  'meta_value'   => $selected_mission,
  'meta_compare' => '=',
);
// phpcs:enable

$the_query = new WP_Query( $args );

if ( $the_query->have_posts() ) {

  while ( $the_query->have_posts() ) {
    $the_query->the_post();

    // Retrieve the current link post id.
    $current_post = get_the_ID();

    // Skip archived items.
    if ( 'true' === get_post_meta( $current_post, 'gpalab_slo_archive', true ) ) {
      continue;
    }

    require 'social-link-item.php';
  }
} else {
  // Show fallback message if no links found.
  $no_links = __( 'No Social Bio Links', 'gpalab-slo' );

  echo '<p>' . esc_html( $no_links ) . '</p>';
}

wp_reset_postdata();
