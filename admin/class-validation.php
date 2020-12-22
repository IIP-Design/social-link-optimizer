<?php
/**
 * Registers the Validation class.
 *
 * @package SLO\Validation
 * @since 0.0.1
 */

namespace SLO;

/**
 * Registers social link optimizer admin scripts.
 *
 * @package SLO\Validation
 * @since 0.0.1
 */
class Validation {

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
   * Register the scripts for the plugin's required fields validation.
   *
   * @since 0.0.1
   */
  public function register_validation_scripts_styles() {
    $script_asset = require GPALAB_SLO_DIR . 'admin/build/gpalab-slo-validation.asset.php';

    wp_register_script(
      'gpalab-slo-validation-js',
      GPALAB_SLO_URL . 'admin/build/gpalab-slo-validation.js',
      $script_asset['dependencies'],
      $script_asset['version'],
      true
    );

    wp_register_style(
      'gpalab-slo-validation-css',
      GPALAB_SLO_URL . 'admin/css/gpalab-slo-validation.css',
      array(),
      $this->version
    );
  }

  /**
   * Enqueue the validation script if on the edit social link.
   *
   * @param string $hook   Name of the current page.
   *
   * @since 0.0.1
   */
  public function enqueue_slo_validation( $hook ) {
    global $post_type;

    $is_social_link = 'gpalab-social-link' === $post_type;
    $is_post_screen = 'post.php' === $hook || 'post-new.php' === $hook;

    if ( $is_social_link && $is_post_screen ) {
      wp_enqueue_script( 'gpalab-slo-validation-js' );
      wp_enqueue_style( 'gpalab-slo-validation-css' );
    }
  }
}
