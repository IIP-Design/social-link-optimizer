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

    // Generate a unique ID for the new mission.
    $mission_id = wp_generate_uuid4();

    // Create a corresponding SLO template page for the new mission.
    $slo_page_id = $this->generate_slo_page( $mission_id );

    // Initialize an empty array to populate with placeholder values.
    $new_mission = array();

    $new_mission['id']        = $mission_id;
    $new_mission['page']      = $slo_page_id;
    $new_mission['title']     = 'New';
    $new_mission['type']      = 'grid';
    $new_mission['facebook']  = '';
    $new_mission['flickr']    = '';
    $new_mission['instagram'] = '';
    $new_mission['linkedin']  = '';
    $new_mission['twitter']   = '';
    $new_mission['whatsapp']  = '';
    $new_mission['youtube']   = '';

    // Add new mission into array of existing missions.
    $slo_settings = get_option( 'gpalab-slo-settings' );
    $missions     = ! empty( $slo_settings ) ? $slo_settings : array();

    array_push( $missions, $new_mission );

    update_option( 'gpalab-slo-settings', $missions );
  }

  /**
   * Creates a new SLO page and associates it with the provided mission id.
   *
   * @param string $mission_id   The id of the mission the new page should be associated with.
   * @return int                 The id of the newly created page.
   *
   * @since 0.0.1
   */
  private function generate_slo_page( $mission_id ) {
    $slo_page_id = wp_insert_post(
      array(
        'ID'             => 0,
        'comment_status' => 'closed',
        'meta_input'     => array(
          '_gpalab_slo_mission_select' => $mission_id,
          '_wp_page_template'          => 'archive-gpalab-social-link.php',
        ),
        'ping_status'    => 'closed',
        'post_status'    => 'publish',
        'post_title'     => 'SLO ' . $mission_id,
        'post_type'      => 'page',
      )
    );

    return $slo_page_id;
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

    $id = null;

    if ( isset( $_POST['mission_id'] ) ) {
      $id = sanitize_text_field( wp_unslash( $_POST['mission_id'] ) );
    }
    // phpcs:enable

    $slo_settings = get_option( 'gpalab-slo-settings' );

    if ( empty( $slo_settings ) ) {
      return;
    }

    // Initialize the index of the selected mission.
    $index   = null;
    $page_id = 0;

    // Retrieve the index value of the selected mission and it's associated page id.
    foreach ( $slo_settings as $key => $setting ) {
      if ( $setting['id'] === $id ) {
        $index   = $key;
        $page_id = ! empty( $setting['page'] ) ? $setting['page'] : 0;
        break;
      }
    }

    // Remove the selected mission from missions array.
    unset( $slo_settings[ $index ] );

    // Re-index the array.
    $reindexed = array_values( $slo_settings );

    update_option( 'gpalab-slo-settings', $reindexed );
    wp_delete_post( $page_id, true );
  }

  /**
   * Update the permalink of a given SLO page.
   *
   * @since 0.0.1
   */
  public function handle_permalink_update() {
    // The following rules are handled by the slo_verify_nonce function and hence can be safely ignored.
    // phpcs:disable WordPress.Security.NonceVerification.Missing
    // phpcs:disable WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
    // phpcs:disable WordPress.Security.ValidatedSanitizedInput.MissingUnslash
    // phpcs:disable WordPress.Security.ValidatedSanitizedInput.InputNotValidated
    $this->slo_verify_nonce( $_POST['security'] );

    $post_id   = null;
    $post_name = null;

    if ( isset( $_POST['post_id'] ) ) {
      $post_id = sanitize_text_field( wp_unslash( $_POST['post_id'] ) );
    }

    if ( isset( $_POST['permalink'] ) ) {
      $post_name = sanitize_title_with_dashes( wp_unslash( $_POST['permalink'] ) );
    }
    // phpcs:enable

    $args = array(
      'ID'        => $post_id,
      'post_name' => $post_name,
    );

    wp_update_post( $args );
  }

  /**
   * Checks that a security nonce is set, valid, and from a permitted referrer.
   *
   * @param string $security   A nonce provided in the Ajax call.
   *
   * @since 0.0.1
   */
  private function slo_verify_nonce( $security ) {
    $nonce = null;

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
