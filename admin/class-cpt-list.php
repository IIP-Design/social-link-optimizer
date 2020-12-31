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
   * @return array           List of updated columns.
   *
   * @since 0.0.1
   */
  public function add_custom_columns( $defaults ) {
    $columns = array(
      'cb'                 => $defaults['cb'],
      'title'              => $defaults['title'],
      'gpalab_slo_mission' => __( 'Mission', 'gpalab-slo' ),
      'date'               => $defaults['date'],
    );

    return $columns;
  }

  /**
   * Make the social links custom post type's columns sortable.
   *
   * @param array $columns  List of default columns.
   * @return array          List of updated sortable columns.
   *
   * @since 0.0.1
   */
  public function make_custom_columns_sortable( $columns ) {
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
   * @param object $query  WordPress query arguments.
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

  /**
   * Add the ability to archive multiple links at once.
   *
   * @param array $bulk_actions   A list of available actions to apply to selected posts.
   * @return array                The list of available actions with an 'archive' option added.
   *
   * @since 0.0.1
   */
  public function add_custom_bulk_actions( $bulk_actions ) {
    if ( 'archived' !== get_query_var( 'post_status' ) && 'trash' !== get_query_var( 'post_status' ) ) {
      $bulk_actions['archive'] = __( 'Archive Links', 'gpalab-slo' );
    }

    return $bulk_actions;
  }

  /**
   * Archives the selected posts when the 'Archive Links' bulk action is selected.
   *
   * @param string $redirect_url  The URL the user will be sent to upon completion of the action.
   * @param string $action        The selected bulk action.
   * @param array  $post_ids      The list of selected posts.
   * @return string               The update redirect URL the user will go upon completion.
   *
   * @since 0.0.1
   */
  public function handle_bulk_archive( $redirect_url, $action, $post_ids ) {
    if ( 'archive' === $action ) {
      foreach ( $post_ids as $post_id ) {
        wp_update_post(
          array(
            'ID'          => $post_id,
            'post_status' => 'archived',
          )
        );
      }
      $redirect_url = add_query_arg( 'archived-links', count( $post_ids ), $redirect_url );
    }

    return $redirect_url;
  }

  /**
   * Shows a notification when social links are archived.
   *
   * @since 0.0.1
   */
  public function show_archive_notice() {
    /* translators: %d: the number of links that were archived */
    $notice = __( 'Archived %d links.', 'gpalab-slo' );

    // phpcs:disable WordPress.Security.NonceVerification.Recommended
    if ( ! empty( $_REQUEST['archived-links'] ) ) {
      $num_changed = (int) $_REQUEST['archived-links'];

      printf( '<div id="message" class="updated notice is-dismissable"><p>' . esc_html( $notice ) . '</p></div>', esc_html( $num_changed ) );
    }
    // phpcs:enable
  }

  /**
   * Removes the View and Quick Edit action buttons from social link posts.
   *
   * @param array  $actions  List of action links.
   * @param object $post     WordPress post Object.
   * @return array           The updated list of action links.
   *
   * @since 0.0.1
   */
  public function disable_link_actions( $actions = array(), $post = null ) {

    // If the page template is not an gpalab-social-link post, return all actions.
    if ( 'gpalab-social-link' !== $post->post_type ) {
      return $actions;
    }

    // Remove the View link - not terribly useful since it points to the redirect URL.
    if ( isset( $actions['view'] ) ) {
      unset( $actions['view'] );
    }

    // Remove the Quick Edit link - removes some unnecessary complexity.
    if ( isset( $actions['inline hide-if-no-js'] ) ) {
      unset( $actions['inline hide-if-no-js'] );
    }

    // Return the set of links without the Edit, Quick Edit, or Trash actions.
    return $actions;
  }

  /**
   * Modifies the main WordPress query to remove archived links from the all social links list.
   *
   * @param object $query  The main WordPress query.
   * @return object        An updated WP query excluding archived social links.
   *
   * @since 0.0.1
   */
  public function exclude_archived_links( $query ) {
    if ( ! is_admin() ) {
      return $query;
    }

    global $pagenow;

    if (
      'edit.php' === $pagenow &&
      get_query_var( 'post_type' ) &&
      'gpalab-social-link' === get_query_var( 'post_type' ) &&
      ! get_query_var( 'post_status' )
    ) {
      $query->set( 'post_status', array( 'draft', 'future', 'pending', 'publish' ) );
    }

    return $query;
  }
}
