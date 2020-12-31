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
    <div>
      <a href="<?php echo esc_url( $url ); ?>">
        <p><?php echo esc_html( $listing ); ?></p>
      </a>
      <p><?php echo esc_html( $preferred ); ?></p>
    </div> 
    <?php
  }
}
