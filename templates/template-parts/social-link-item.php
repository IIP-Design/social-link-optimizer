<?php
/**
 * Renders a single social link item for SLO page.
 *
 * @package GPALAB_SLO
 */

// Check if function already exists to prevent re-declaration in the loop.
if ( ! function_exists( 'linkify' ) ) {
  /**
   * Wrap some string or HTML element in a link.
   *
   * @param string $element   The element to be placed within a link.
   * @param string $url       The wrapping url.
   */
  function linkify( $element, $url ) {
    return '<a href="' . esc_url( $url ) . '">' . $element . '</a>';
  }
}

// Retrieve the item title.
$item_title = 'list' === $layout
  ? linkify( get_the_title( $current_post ), get_permalink() )
  : get_the_title( $current_post );

// Retrieve the item photo.
$thumbnail = get_the_post_thumbnail(
  $current_post,
  'post-thumbnail',
  array( 'class' => 'gpalab-slo-thumbnail' )
);

$item_photo = linkify( $thumbnail, get_permalink() );

$hide_visually_class = 'grid' === $layout
  ? 'hide-visually'
  : '';

// Cobble together the HTML for a link item.
$item  = '<li>';
$item .= '<h3 class="title ' . $hide_visually_class . '">' . wp_kses( $item_title, 'post' ) . '</h3>';
$item .= 'grid' === $layout ? wp_kses( $item_photo, 'post' ) : '';
$item .= '</li>';

// Sanitize the HTML returned onto the page.
echo wp_kses( $item, 'post' );
