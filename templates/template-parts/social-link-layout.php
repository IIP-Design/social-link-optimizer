<?php
/**
 * Determines the social link list layout and returns the list heading.
 *
 * @package GPALAB_SLO
 */

 // Determine the page layout (i.e., grid or list).
 $layout  = ( isset( $page_settings['type'] ) && '' !== $page_settings['type'] )
 ? $page_settings['type']
 : 'grid';
 $is_grid = 'grid' === $layout;
?>

<!-- Set up list/grid of social links -->
<h2 id="instagram-posts" class="hide-visually" tabindex="-1">
 <?php esc_html_e( 'Instagram posts', 'gpalab-slo' ); ?>
</h2>
<div id="instructions">
 <p class="instructions <?php echo ( ! $is_grid ) ? 'hide-visually' : ''; ?>">
    <?php
      $item = $is_grid ? __( 'image', 'gpalab-slo' ) : __( 'item', 'gpalab-slo' );

      /* translators: %s: list item type (one of image or item) */
      printf( esc_html__( 'Select an %s to see more', 'gpalab-slo' ), esc_html( $item ) );
    ?>
 </p>
</div>
