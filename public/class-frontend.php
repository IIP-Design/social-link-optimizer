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
    wp_enqueue_style(
      'social-bio-links',
      GPALAB_SLO_URL . 'css/social-link-optimizer-styles.css',
      array(),
      $version
    );
  }
}
