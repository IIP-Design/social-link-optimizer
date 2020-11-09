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
    $script_asset = require GPALAB_SLO_DIR . 'admin/build/gpalab-slo-mission-plugin.asset.php';

    wp_register_script(
      'gpalab-slo-mission-plugin',
      GPALAB_SLO_URL . 'admin/build/gpalab-slo-mission-plugin.js',
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
    wp_enqueue_script( 'gpalab-slo-mission-plugin' );

    $missions = get_option( 'gpalab-slo-settings', array() );

    wp_localize_script(
      'gpalab-slo-mission-plugin',
      'gpalabSloPlugin',
      array(
        'missions' => $missions,
      )
    );
  }
}
