<?php
/**
 * Registers the Admin class.
 *
 * @package SLO\Admin
 * @since 0.0.1
 */

namespace SLO;

/**
 * Registers social link optimizer admin scripts.
 *
 * @package SLO\Admin
 * @since 0.0.1
 */
class Admin {

  /**
   * Initializes the class with the plugin name and version.
   *
   * @param string $plugin     The plugin name.
   * @param string $version    The plugin version number.
   */
  public function __construct( $plugin, $version ) {
    $this->plugin  = $plugin;
    $this->version = $version;
  }

  /**
   * Register the scripts for the plugin's admin interface.
   */
  public function register_admin_scripts_styles() {
    $script_asset = require GPALAB_SLO_DIR . 'admin/build/gpalab-slo-admin.asset.php';

    wp_register_script(
      'gpalab-slo-admin-js',
      GPALAB_SLO_URL . 'admin/build/gpalab-slo-admin.js',
      $script_asset['dependencies'],
      $script_asset['version'],
      true
    );

    wp_register_style(
      'gpalab-slo-admin-css',
      GPALAB_SLO_URL . 'admin/css/admin.css',
      array(),
      $this->version
    );
  }

  /**
   * Pass required PHP values as variables to admin JS.
   */
  public function localize_admin_script_globals() {
    wp_localize_script(
      'gpalab-slo-admin-js',
      'gpalabSloAdmin',
      array(
        'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
        'sloNonce' => wp_create_nonce( 'gpalab-slo-nonce' ),
      )
    );
  }
}
