<?php
/**
 * Registers the Ajax class.
 *
 * @package SLO\Ajax
 * @since 0.0.1
 */

namespace SLO;

/**
 * Handles AJAX calls needed to persist data on the server.
 *
 * @package SLO\Ajax
 * @since 0.0.1
 */
class Ajax {
  /**
   * Adds a blank mission to the list of missions in the plugin settings.
   */
  public function handle_mission_addition() {
    $nonce;

    // Make sure nonce is set.
    if ( ! isset( $_POST['security'] ) ) {
      return;
    } else {
      $nonce = sanitize_text_field( wp_unslash( $_POST['security'] ) );
    }

    // Verify the nonce.
    if (
      wp_verify_nonce( $nonce, 'gpalab-slo-nonce' ) === false ||
      check_ajax_referer( 'gpalab-slo-nonce', 'security', false ) === false
    ) {
      return;
    }

    $slo_settings = get_option( 'gpalab-slo-settings' );
    $missions     = ! empty( $slo_settings ) ? $slo_settings : array();

    // Initialize an empty array to populate with placeholder values.
    $new_mission = array();

    $new_mission['title']     = 'New';
    $new_mission['facebook']  = '';
    $new_mission['instagram'] = '';
    $new_mission['linkedin']  = '';
    $new_mission['twitter']   = '';
    $new_mission['youtube']   = '';

    // Add new mission into array of existing missions.
    array_push( $missions, $new_mission );

    update_option( 'gpalab-slo-settings', $missions );
  }
}
