<?php
/**
 * Plugin Name: Social Link Optimizer
 * Plugin URI: https://github.com/IIP-Design/social-link-optimizer
 * Description: Adds a Social Link custom post type, custom meta box, and Social Link Optimizer page template
 * Version: v1.0.0
 * Author: U.S. Department of State, Bureau of Global Public Affairs Digital Lab <gpa-lab@america.gov>
 * Author URI: https://lab.america.gov
 * License: GNU General Public License v2.0
 * License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * Text Domain: gpalab-slo
 *
 * @package GPALAB_SLO
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

// Define constants.
define( 'GPALAB_SLO_DIR', plugin_dir_path( dirname( __FILE__ ) ) . 'social-link-optimizer/' );
define( 'GPALAB_SLO_URL', plugin_dir_url( dirname( __FILE__ ) ) . 'social-link-optimizer/' );

/**
 * Run functions needed at startup when plugin is installed.
 */
function gpalab_social_link_optimizer_activate() {
  require_once plugin_dir_path( __FILE__ ) . 'includes/class-activator.php';

  SLO\Activator::activate();
}
register_activation_hook( __FILE__, 'gpalab_social_link_optimizer_activate' );

/**
 * Clean up site when the plugin is uninstalled.
 */
function gpalab_social_link_optimizer_uninstall() {
  require_once plugin_dir_path( __FILE__ ) . 'includes/class-uninstall.php';

  SLO\Uninstall::uninstall();
}
register_uninstall_hook( __FILE__, 'gpalab_social_link_optimizer_uninstall' );

// Imports SLO class.
require plugin_dir_path( __FILE__ ) . 'includes/class-slo.php';

/**
 * Begin execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 */
function run_gpalab_slo() {
  $plugin = new SLO();
  $plugin->run();
}

run_gpalab_slo();
