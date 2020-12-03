<?php
/**
 * Registers the CPT_List class.
 *
 * @package SLO\CPT_List
 * @since 0.0.1
 */

namespace SLO;

/**
 * Manages the appearance of the All Links page.
 *
 * The CPT_List class configures the listing page for the gpalab-social-link custom post type.
 *
 * @package SLO\CPT_List
 * @since 0.0.1
 */
class CPT_List {
  /**
   * Add custom columns to the list of social links posts.
   *
   * @param array $defaults  List of default columns.
   *
   * @since 0.0.1
   */
  public function add_custom_columns( $defaults ) {
    $defaults['gpalab_slo_archive'] = __( 'Archived', 'gpalab-slo' );
    $defaults['gpalab_slo_mission'] = __( 'Mission', 'gpalab-slo' );

    return $defaults;
  }

  /**
   * Make the social links custom post type's columns sortable.
   *
   * @param array $columns  List of default columns.
   *
   * @since 0.0.1
   */
  public function make_custom_columns_sortable( $columns ) {
    $columns['gpalab_slo_archive'] = __( 'Archived', 'gpalab-slo' );
    $columns['gpalab_slo_mission'] = __( 'Mission', 'gpalab-slo' );

    return $columns;
  }

  /**
   * Populate the content of the missions column.
   *
   * @param string $column_name   Name of the given column.
   * @param int    $post_id       List of default columns.
   *
   * @since 0.0.1
   */
  public function populate_custom_columns( $column_name, $post_id ) {
    // Populate the Archived column.
    if ( 'gpalab_slo_archive' === $column_name ) {
      $is_archive     = get_post_meta( $post_id, 'gpalab_slo_archive', true );
      $human_friendly = 'true' === $is_archive ? 'yes' : 'no';

      echo esc_html( $human_friendly );
    }

    // Populate the Mission column.
    if ( 'gpalab_slo_mission' === $column_name ) {
      // Get all missions.
      $slo_settings = get_option( 'gpalab-slo-settings' );

      // Get the id of the mission associated with the current post.
      $mission_id = get_post_meta( $post_id, 'gpalab_slo_mission', true );

      // Search for selected mission among the mission sessions and return it's data.
      $settings_key   = array_search( $mission_id, array_column( $slo_settings, 'id' ), true );
      $human_friendly = is_numeric( $settings_key ) ? $slo_settings[ $settings_key ]['title'] : '';

      echo esc_html( $human_friendly );
    }
  }

  /**
   * Filters the social links query by mission.
   *
   * @param array $query  WordPress query arguments.
   *
   * @since 0.0.1
   */
  public function filter_social_links_by_mission( $query ) {
    global $pagenow;

    // Get the post type.
    // phpcs:disable WordPress.Security.NonceVerification.Recommended
    $post_type = isset( $_GET['post_type'] ) ? sanitize_text_field( wp_unslash( $_GET['post_type'] ) ) : '';

    if (
      is_admin()
      && 'edit.php' === $pagenow
      && 'gpalab-social-link' === $post_type
      && isset( $_GET['mission'] )
      && 'all' !== $_GET['mission']
    ) {
      // phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_meta_key
      // phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_meta_value
      $query->query_vars['meta_key']     = 'gpalab_slo_mission';
      $query->query_vars['meta_value']   = sanitize_text_field( wp_unslash( $_GET['mission'] ) );
      $query->query_vars['meta_compare'] = '=';
      // phpcs:enable
    }
  }

  /**
   * Adds a post filter dropdown to the social links custom post type listing page.
   *
   * @since 0.0.1
   */
  public function add_mission_filter_dropdown() {
    global $typenow;

    if ( 'gpalab-social-link' === $typenow ) {
      // Get all missions.
      $missions     = array();
      $slo_settings = get_option( 'gpalab-slo-settings' );

      // Get title and id for each mission.
      foreach ( $slo_settings as $setting ) {
        $mission = array();

        $mission['label'] = $setting['title'];
        $mission['value'] = $setting['id'];

        array_push( $missions, $mission );
      }

      // Initialize the selected mission as empty (ie. all missions).
      $current_mission = '';

      // Update $current_mission if filter option has been selected.
      // phpcs:disable WordPress.Security.NonceVerification.Recommended
      if ( isset( $_GET['mission'] ) ) {
        $current_mission = sanitize_text_field( wp_unslash( $_GET['mission'] ) ); // Check if option has been selected.
      }
      // phpcs:enable

      // Render out the filter dropdown.
      ?>
        <select name="mission" id="mission">
          <option value="all" <?php selected( 'all', $current_mission ); ?>>
            <?php esc_html_e( 'All Missions', 'gpalab-slo' ); ?>
          </option>

          <?php
          foreach ( $missions as $mission ) {
            $value = $mission['value'];

            ?>
            <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $current_mission ); ?>>
              <?php echo esc_attr( $mission['label'] ); ?>
            </option>

            <?php
          }
          ?>
        </select>
      <?php
    }
  }
}
