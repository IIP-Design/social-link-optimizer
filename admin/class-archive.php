<?php
/**
 * Registers the Archive class.
 *
 * @package SLO\Archive
 * @since 0.0.1
 */

namespace SLO;

/**
 * Configures the admin interface for the social links archive page template.
 *
 * @package SLO\Archive
 * @since 0.0.1
 */
class Archive {
  /**
   * Adds custom settings fields to the Gutenberg Editor.
   *
   * @since 0.0.1
   */
  public function register_slo_gutenberg_plugins() {
    $script_asset = require GPALAB_SLO_DIR . 'admin/build/plugin-mission-select.asset.php';

    wp_register_script(
      'gpalab-slo-mission-archive',
      GPALAB_SLO_URL . 'admin/build/plugin-mission-select.js',
      $script_asset['dependencies'],
      $script_asset['version'],
      true
    );
  }

  /**
   * Enqueue the JavaScript required for customization of the Gutenberg Editor.
   *
   * @since 0.0.1
   */
  public function enqueue_slo_missions_plugin() {
    wp_enqueue_script( 'gpalab-slo-mission-archive' );
  }
}
