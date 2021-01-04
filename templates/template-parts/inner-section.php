<?php
/**
 * Renders a single social link item for SLO page.
 *
 * @package GPALAB_SLO
 * @since 0.0.1
 */

?>

<div class="section-inner stack">
  <?php

  wp_link_pages(
    array(
      'before'      => '<nav class="post-nav-links bg-light-background" aria-label="' . esc_attr__( 'Page', 'gpalab-slo' ) . '"><span class="label">' . __( 'Pages:', 'gpalab-slo' ) . '</span>',
      'after'       => '</nav>',
      'link_before' => '<span class="page-number">',
      'link_after'  => '</span>',
    )
  );

  edit_post_link();

  ?>

</div>
