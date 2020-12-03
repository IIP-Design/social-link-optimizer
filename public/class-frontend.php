<?php
/**
 * Registers the Frontend class.
 *
 * @package SLO\Frontend
 * @since 0.0.1
 */

namespace SLO;

/**
 * Registers the scripts and styles for the frontend template.
 *
 * @package SLO\Frontend
 * @since 0.0.1
 */
class Frontend {

  /**
   * Initializes the class with the plugin name and version.
   *
   * @param string $plugin     The plugin name.
   * @param string $version    The plugin version number.
   *
   * @since 0.0.1
   */
  public function __construct( $plugin, $version ) {
    $this->plugin  = $plugin;
    $this->version = $version;
  }

  /**
   * Enqueue styles plugin's scripts and styles.
   *
   * @since 0.0.1
   */
  public function gpalab_slo_stylesheets() {
    $wp_styles       = wp_styles();
    $is_slo_template = is_page_template( 'archive-gpalab-social-link.php' );

    if ( $is_slo_template ) {
      foreach ( $wp_styles->registered as $wp_style ) {
        $handle              = $wp_style->handle;
        $src                 = $wp_style->src;
        $is_theme_stylesheet = is_int( strpos( $src, '/themes/' ) );

        if ( ! $is_theme_stylesheet ) {
          continue;
        }

        wp_dequeue_style( $handle );
      }

      wp_enqueue_style(
        'social-bio-links',
        GPALAB_SLO_URL . 'public/css/gpalab-slo-front.css',
        array(),
        $this->version
      );
    }
  }
}
