<?php
/**
 * Renders an identity logo for SLO page.
 *
 * @package GPALAB_SLO
 * @since 0.0.1
 */

$page_image = isset( $page_settings['avatar'] ) ? $page_settings['avatar'] : the_post_thumbnail();

/**
 * Check that the avatar image is set.
 * If the an image is saved and then removed the form will store the string undefined,
 * which is not a valid attachment id so we also check for this.
 */
if ( ! empty( $page_image ) && 'undefined' !== $page_image ) {
  ?>

  <div class="identity-logo">
    <?php echo wp_get_attachment_image( $page_image ); ?>
  </div>

  <?php
}
