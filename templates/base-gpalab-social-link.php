<?php
/**
 * Template Name: Social Link Page
 * Template Post Type: gpalab-social-link
 *
 * @package GPALAB_SLO
 * @since 1.1.0
 */

$current_type = get_post_type( get_the_ID() );

if ( 'gpalab-social-link' === $current_type ) {
  include GPALAB_SLO_DIR . 'templates/preview-gpalab-social-link.php';
} else {
  include GPALAB_SLO_DIR . 'templates/archive-gpalab-social-link.php';
}
