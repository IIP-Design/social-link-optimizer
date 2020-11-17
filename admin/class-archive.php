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
    $is_gutenberg = get_current_screen()->is_block_editor();

    if ( $is_gutenberg ) {
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

  /**
   * Adds a legacy metabox to provide compatibility on sites not using the Gutenberg editor.
   *
   * @since 0.0.1
   */
  public function legacy_compat_metabox() {
    global $post;

    $is_slo_archive = 'archive-gpalab-social-link.php' === get_post_meta( $post->ID, '_wp_page_template', true );

    // Only show meta box on SLO page template && if Gutenberg is disabled.
    if ( $is_slo_archive ) {
      add_meta_box(
        'gpalab_slo_mission_select',
        __( 'Connect a Mission', 'gpalab-slo' ),
        array( $this, 'add_mission_select' ),
        'page',
        'side',
        'high',
        array(
          '__back_compat_meta_box' => true,
        )
      );
    }
  }

  /**
   * Renders the contents of the legacy metabox.
   *
   * @param object $post  WordPress post Object.
   *
   * @since 0.0.1
   */
  public function add_mission_select( $post ) {
    // Load in possible HTTP responses.
    include_once GPALAB_SLO_DIR . 'admin/class-cpt.php';
    $cpt = new CPT();

    wp_nonce_field( basename( __FILE__ ), 'gpalab_slo_legacy_nonce' );

    $selected = get_post_meta( $post->ID, '_gpalab_slo_mission_select', true );
    $missions = get_option( 'gpalab-slo-settings' );

    $cpt->populate_mission_select( $selected, $missions, '_gpalab_slo_mission_select' );
  }

  /**
   * Save mission value for legacy custom metabox.
   *
   * @param int $post_id   WordPress post id.
   *
   * @since 0.0.1
   */
  public function legacy_mission_meta_save( $post_id ) {
    // Check save status and validate nonce.
    $is_autosave    = wp_is_post_autosave( $post_id );
    $is_revision    = wp_is_post_revision( $post_id );
    $is_valid_nonce =
      isset( $_POST['gpalab_slo_legacy_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['gpalab_slo_legacy_nonce'] ) ), basename( __FILE__ ) )
      ? 'true'
      : 'false';

    if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
      return;
    }

    // Sanitize/save the post meta.
    if ( isset( $_POST['_gpalab_slo_mission_select'] ) ) {
      update_post_meta(
        $post_id,
        '_gpalab_slo_mission_select',
        sanitize_text_field( wp_unslash( $_POST['_gpalab_slo_mission_select'] ) )
      );
    }
  }
}
