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
  public function activate() {

    // Ensure user has the proper permissions.
    if ( ! current_user_can( 'activate_plugins' ) ) {
      return;
    }

    self::initialize_options();
  }

  /**
   * Add the plugin's default options values to the options table in the database.
   *
   * @since 0.0.1
   */
  private static function initialize_options() {
    add_option( 'gpalab-slo-settings', array() );
  }
}
