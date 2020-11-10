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
   *
   * @since 0.0.1
   */
  public function handle_mission_addition() {
    // The following rules are handled by the slo_verify_nonce function and hence can be safely ignored.
    // phpcs:disable WordPress.Security.NonceVerification.Missing
    // phpcs:disable WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
    // phpcs:disable WordPress.Security.ValidatedSanitizedInput.MissingUnslash
    // phpcs:disable WordPress.Security.ValidatedSanitizedInput.InputNotValidated
    $this->slo_verify_nonce( $_POST['security'] );
    // phpcs:enable

    $slo_settings = get_option( 'gpalab-slo-settings' );
    $missions     = ! empty( $slo_settings ) ? $slo_settings : array();

    // Initialize an empty array to populate with placeholder values.
    $new_mission = array();

    $new_mission['id']        = wp_generate_uuid4();
    $new_mission['title']     = 'New';
    $new_mission['type']      = 'grid';
    $new_mission['facebook']  = '';
    $new_mission['instagram'] = '';
    $new_mission['linkedin']  = '';
    $new_mission['twitter']   = '';
    $new_mission['youtube']   = '';
    $new_mission['flick']     = '';
    $new_mission['wechat']    = '';

    // Add new mission into array of existing missions.
    array_push( $missions, $new_mission );

    update_option( 'gpalab-slo-settings', $missions );
  }

  /**
   * Removes a specified mission from the list of missions in the plugin settings.
   *
   * @since 0.0.1
   */
  public function handle_mission_removal() {
    // The following rules are handled by the slo_verify_nonce function and hence can be safely ignored.
    // phpcs:disable WordPress.Security.NonceVerification.Missing
    // phpcs:disable WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
    // phpcs:disable WordPress.Security.ValidatedSanitizedInput.MissingUnslash
    // phpcs:disable WordPress.Security.ValidatedSanitizedInput.InputNotValidated
    $this->slo_verify_nonce( $_POST['security'] );

    $id;

    if ( isset( $_POST['mission_id'] ) ) {
      $id = sanitize_text_field( wp_unslash( $_POST['mission_id'] ) );
    }
    // phpcs:enable

    $slo_settings = get_option( 'gpalab-slo-settings' );

    if ( empty( $slo_settings ) ) {
      return;
    }

    // Initialize the index of the selected mission.
    $index;

    // Retrieve the index value of the selected mission.
    foreach ( $slo_settings as $key => $setting ) {
      if ( $setting['id'] === $id ) {
        $index = $key;
        break;
      }
    }

    // Remove the selected mission from missions array.
    unset( $slo_settings[ $index ] );

    // Re-index the array.
    $reindexed = array_values( $slo_settings );

    update_option( 'gpalab-slo-settings', $reindexed );
  }

  /**
   * Checks that a security nonce is set, valid, and from a permitted referrer.
   *
   * @param string $security   A nonce provided in the Ajax call.
   *
   * @since 0.0.1
   */
  private function slo_verify_nonce( $security ) {
    $nonce;

    // Make sure nonce is set.
    if ( ! isset( $security ) ) {
      return;
    } else {
      $nonce = sanitize_text_field( wp_unslash( $security ) );
    }

    // Verify the nonce.
    if (
      wp_verify_nonce( $nonce, 'gpalab-slo-nonce' ) === false ||
      check_ajax_referer( 'gpalab-slo-nonce', 'security', false ) === false
    ) {
      return;
    }
  }
}
