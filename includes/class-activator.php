<?php
/**
 * Registers the Activator class.
 *
 * @package SLO\Activator
 * @since 0.0.1
 */

namespace SLO;

/**
 * Register all hooks to be run when the plugin is activated.
 *
 * @package SLO/Activator
 * @since 0.0.1
 */
class Activator {

  /**
   * Run all actions required to start using the plugin.
   *
   * @since 0.0.1
   */
  public static function activate() {

    // Ensure user has the proper permissions.
    if ( ! current_user_can( 'activate_plugins' ) ) {
      return;
    }

    self::initialize_options();
    self::add_capabilities();
  }

  /**
   * Add the plugin's default options values to the options table in the database.
   *
   * @since 0.0.1
   */
  private static function initialize_options() {
    add_option( 'gpalab-slo-settings', array() );
    add_option( 'gpalab-slo-pages', array() );
  }

  /**
   * Add a custom capabilities which permits a user to access certain plugin actions.
   *
   * @since 0.0.1
   */
  private static function add_capabilities() {
    // Define capabilities.
    $manage_settings_cap = 'gpalab_slo_manage_settings';
    $add_page_cap        = 'gpalab_slo_add_slo_page';
    $edit_page_cap       = 'gpalab_slo_edit_slo_page';

    $default_admin_cap  = 'manage_options';
    $default_editor_cap = 'edit_pages';
    $grant              = true;

    $editable = get_editable_roles();

    // Iterate through all roles, and add custom capabilities to each role that has the default minimum capability.
    foreach ( wp_roles()->role_objects as $key => $role ) {
      // Grant settings and SLO page permissions to admin users.
      if ( isset( $editable[ $key ] ) && $role->has_cap( $default_admin_cap ) ) {
        $role->add_cap( $manage_settings_cap, $grant );
        $role->add_cap( $add_page_cap, $grant );
        $role->add_cap( $edit_page_cap, $grant );
      }

      /**
       * Grant social link permissions to editor users.
       *
       * Private post capabilities are disabled as we don't anticipate their use.
       * If eventually enabled, the corresponding change should be made in the
       * CPT and URE classes found in the admin directory as well as in the
       * Uninstall class found in this directory.
       */
      // phpcs:disable Squiz.PHP.CommentedOutCode.Found
      if ( isset( $editable[ $key ] ) && $role->has_cap( $default_editor_cap ) ) {
        $role->add_cap( 'gpalab_slo_edit_links', $grant );
        $role->add_cap( 'gpalab_slo_edit_others_links', $grant );
        $role->add_cap( 'gpalab_slo_edit_published_links', $grant );
        $role->add_cap( 'gpalab_slo_delete_links', $grant );
        $role->add_cap( 'gpalab_slo_delete_others_links', $grant );
        $role->add_cap( 'gpalab_slo_delete_published_links', $grant );
        $role->add_cap( 'gpalab_slo_publish_links', $grant );
        // $role->add_cap( 'gpalab_slo_read_private_links', $grant );
        // $role->add_cap( 'gpalab_slo_edit_private_links', $grant );
        // $role->add_cap( 'gpalab_slo_delete_private_links', $grant );
      }
      // phpcs:enable
    }

    unset( $role );
  }
}
