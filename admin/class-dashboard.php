<?php
/**
 * Registers the Dashboard class.
 *
 * @package SLO\Dashboard
 * @since 0.0.1
 */

namespace SLO;

/**
 * Adds a custom widget to the initial .
 *
 * The dashboard widget allows users to select their preferred mission and navigate
 * directly to that mission's list of social links.
 *
 * @package SLO\Dashboard
 * @since 0.0.1
 */
class Dashboard {

  /**
   * Initializes the class with the plugin name and version,
   * as well as the capability required to edit SLO archive pages.
   *
   * @param string $plugin     The plugin name.
   * @param string $version    The plugin version number.
   *
   * @since 0.0.1
   */
  public function __construct( $plugin, $version ) {
    $this->plugin  = $plugin;
    $this->version = $version;
  }

  /**
   * Adds a Social Link Optimizer widget to the user's dashboard.
   */
  public function slo_dashboard_widget() {
    // Only show the widget if user can edit social links.
    if ( ! current_user_can( 'gpalab_slo_edit_links' ) ) {
      return;
    }

    wp_add_dashboard_widget(
      'gpalab-slo-dashboard-widget',
      __( 'Social Link Optimizer', 'gpalab-slo' ),
      function () {
        return $this->widget_callback();
      },
      null,
      null,
      'normal',
      'high'
    );
  }

  /**
   * Populates the dashboard widget with it's content.
   */
  private function widget_callback() {
    // Retrieve the mission selected by the current user.
    $selected = get_user_meta( get_current_user_id(), 'gpalab_slo_preferred_mission', true );

    // Translated text strings used in the dashboard widget.
    $listing   = __( 'Go to the social links listing page.', 'gpalab-slo' );
    $preferred = __( 'You can use the below dropdown to identify your preferred mission', 'gpalab-slo' );

    // Build and escape the settings page URL.
    $query_params = array(
      'post_type' => 'gpalab-social-link',
      'mission'   => ! empty( $selected ) ? $selected : 'all',
    );

    $url = add_query_arg(
      $query_params,
      get_admin_url() . 'edit.php'
    );

    ?>
    <div class="inside">
      <a href="<?php echo esc_url( $url ); ?>">
        <?php echo esc_html( $listing ); ?>
      </a>
      <p><?php echo esc_html( $preferred ); ?></p>
      <form class="initial-form hide-if-no-js">
      <div style="margin:0.75rem 0;">
        <?php $this->add_mission_select( $selected ); ?>
      </div>
      <?php
        submit_button(
          __( 'Set Your Mission', 'gpalab-slo' ),
          'primary',
          'submit',
          true,
          array( 'id' => 'gpalab-slo-set-mission' )
        );
      ?>
      </form>
    </div> 
    <?php
  }

  /**
   * Renders the contents of the legacy metabox.
   *
   * @param string $selected   The unique identifier for the selected mission.
   *
   * @since 0.0.1
   */
  private function add_mission_select( $selected ) {
    // Load in possible HTTP responses.
    include_once GPALAB_SLO_DIR . 'admin/class-cpt.php';
    $cpt = new CPT( $this->plugin_name, $this->version );

    $missions = get_option( 'gpalab-slo-settings' );

    $cpt->populate_mission_select( $selected, $missions, 'gpalab_slo_preferred_mission' );
  }

  /**
   * Loads the JavaScript required by the SLO dashboard widget.
   *
   * @param string $hook   Name of the current page.
   *
   * @since 0.0.1
   */
  public function enqueue_widget_scripts( $hook ) {
    if ( 'index.php' === $hook ) {

      $script_asset = require GPALAB_SLO_DIR . 'admin/build/gpalab-slo-dashboard.asset.php';

      wp_enqueue_script(
        'gpalab-slo-dashboard-js',
        GPALAB_SLO_URL . 'admin/build/gpalab-slo-dashboard.js',
        plugin_dir_url( __FILE__ ) . 'path/to/script.js',
        $script_asset['dependencies'],
        $script_asset['version'],
        true
      );

      // Pass required PHP values as variables to admin JS.
      wp_localize_script(
        'gpalab-slo-dashboard-js',
        'gpalabSloDashboard',
        array(
          'ajaxUrl'          => admin_url( 'admin-ajax.php' ),
          'dashNonce'        => wp_create_nonce( 'gpalab_slo_dashboard_nonce' ),
          'currentUser'      => get_current_user_id(),
          'currentSelection' => get_user_meta( get_current_user_id(), 'gpalab_slo_preferred_mission', true ),
        )
      );
    }
  }
}
