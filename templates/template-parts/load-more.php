<?php
/**
 * Renders a load more button for SLO page.
 *
 * @package GPALAB_SLO
 * @since 0.0.1
 */

if ( $the_query->max_num_pages > 1 ) {
  $load_more = __( 'Load more', 'gpalab-slo' );

  echo '<div class="load-more-container"><button id="load-more" type="button">' . esc_html( $load_more ) . '</button></div>';
}
