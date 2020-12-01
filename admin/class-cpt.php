<?php
/**
 * Registers the CPT class.
 *
 * @package SLO\CPT
 * @since 0.0.1
 */

namespace SLO;

/**
 * Registers the social links custom post type.
 *
 * The CPT class adds a custom post type that is used to add social link data.
 *
 * @package SLO\CPT
 * @since 0.0.1
 */
class CPT {
  /**
   * Register social links custom post type.
   *
   * @since 0.0.1
   */
  public function gpalab_slo_cpt() {
    $capabilities = array(
      'edit_posts'             => 'gpalab_slo_edit_links',
      'edit_others_posts'      => 'gpalab_slo_edit_others_links',
      'edit_private_posts'     => 'gpalab_slo_edit_private_links',
      'edit_published_posts'   => 'gpalab_slo_edit_published_links',
      'delete_posts'           => 'gpalab_slo_delete_links',
      'delete_others_posts'    => 'gpalab_slo_delete_others_links',
      'delete_private_posts'   => 'gpalab_slo_delete_private_links',
      'delete_published_posts' => 'gpalab_slo_delete_published_links',
      'read_private_posts'     => 'gpalab_slo_read_private_links',
      'publish_posts'          => 'gpalab_slo_delete_links',
    );

    $labels = array(
      'name'                  => _x( 'Social Links', 'Post Type General Name', 'gpalab-slo' ),
      'singular_name'         => _x( 'Social Link', 'Post Type Singular Name', 'gpalab-slo' ),
      'menu_name'             => __( 'Social Links', 'gpalab-slo' ),
      'name_admin_bar'        => __( 'Social Link', 'gpalab-slo' ),
      'archives'              => __( 'Social Links', 'gpalab-slo' ),
      'attributes'            => __( 'Item Attributes', 'gpalab-slo' ),
      'parent_item_colon'     => __( 'Parent Item:', 'gpalab-slo' ),
      'all_items'             => __( 'All Links', 'gpalab-slo' ),
      'add_new_item'          => __( 'Add New Link', 'gpalab-slo' ),
      'add_new'               => __( 'Add New', 'gpalab-slo' ),
      'new_item'              => __( 'New Item', 'gpalab-slo' ),
      'edit_item'             => __( 'Edit Item', 'gpalab-slo' ),
      'update_item'           => __( 'Update Item', 'gpalab-slo' ),
      'view_item'             => __( 'View Item', 'gpalab-slo' ),
      'view_items'            => __( 'View Links', 'gpalab-slo' ),
      'search_items'          => __( 'Search Link', 'gpalab-slo' ),
      'not_found'             => __( 'Not found', 'gpalab-slo' ),
      'not_found_in_trash'    => __( 'Not found in Trash', 'gpalab-slo' ),
      'featured_image'        => __( 'Featured Image', 'gpalab-slo' ),
      'set_featured_image'    => __( 'Set featured image', 'gpalab-slo' ),
      'remove_featured_image' => __( 'Remove featured image', 'gpalab-slo' ),
      'use_featured_image'    => __( 'Use as featured image', 'gpalab-slo' ),
      'insert_into_item'      => __( 'Insert into item', 'gpalab-slo' ),
      'uploaded_to_this_item' => __( 'Uploaded to this item', 'gpalab-slo' ),
      'items_list'            => __( 'Items list', 'gpalab-slo' ),
      'items_list_navigation' => __( 'Items list navigation', 'gpalab-slo' ),
      'filter_items_list'     => __( 'Filter items list', 'gpalab-slo' ),
    );

    $rewrite = array(
      'slug'       => 'gpalab-social-link',
      'with_front' => true,
      'pages'      => true,
      'feeds'      => true,
    );

    $args = array(
      'label'               => __( 'Social Link', 'gpalab-slo' ),
      'description'         => __( 'Post Type Description', 'gpalab-slo' ),
      'labels'              => $labels,
      'supports'            => array( 'title', 'thumbnail', 'custom-fields' ),
      'taxonomies'          => array(),
      'hierarchical'        => false,
      'public'              => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'menu_position'       => 5,
      'menu_icon'           => 'dashicons-admin-links',
      'show_in_admin_bar'   => true,
      'show_in_nav_menus'   => true,
      'can_export'          => true,
      'has_archive'         => true,
      'exclude_from_search' => false,
      'publicly_queryable'  => true,
      'rewrite'             => $rewrite,
      'capability_type'     => 'gpalab_slo_links',
      'capabilities'        => $capabilities,
      'map_meta_cap'        => true,
      'show_in_rest'        => true,
    );

    register_post_type( 'gpalab-social-link', $args );
  }

  /**
   * Add custom meta box.
   *
   * @since 0.0.1
   */
  public function gpalab_slo_custom_meta() {
    add_meta_box(
      'gpalab_slo_link',
      __( 'Link this social post to', 'gpalab-slo' ),
      array( $this, 'add_link_input' ),
      'gpalab-social-link',
      'normal',
      'high'
    );

    add_meta_box(
      'gpalab_slo_mission',
      __( 'Select Mission', 'gpalab-slo' ),
      array( $this, 'add_mission_select' ),
      'gpalab-social-link',
      'side',
      'high'
    );

    add_meta_box(
      'gpalab_slo_archive',
      __( 'Archive', 'gpalab-slo' ),
      array( $this, 'add_archive_checkbox' ),
      'gpalab-social-link',
      'side',
      'high'
    );
  }

  /**
   * Renders the custom metabox used to save the post redirect.
   *
   * @param object $post  WordPress post Object.
   *
   * @since 0.0.1
   */
  public function add_link_input( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'gpalab_slo_nonce' );

    $link = get_post_meta( $post->ID, 'gpalab_slo_link', true );

    ?>

    <p style="display: flex; align-items: center;">
      <label
        for="gpalab_slo_link"
        class="gpa-lab-social-links-row-title"
        style="margin-right: 0.5rem;"
      >
        <?php esc_html_e( 'Link:', 'gpalab-slo' ); ?>
      </label>
      <input
        type="text"
        name="gpalab_slo_link" 
        id="gpalab_slo_link"
        style="flex-grow: 1;"
        value="<?php echo esc_url( $link, array( 'http', 'https' ) ); ?>"
      />
    </p>

    <?php
  }

  /**
   * Renders the custom metabox used to save associate post with a given mission.
   *
   * @param object $post  WordPress post Object.
   *
   * @since 0.0.1
   */
  public function add_mission_select( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'gpalab_slo_nonce' );

    $selected = get_post_meta( $post->ID, 'gpalab_slo_mission', true );
    $missions = get_option( 'gpalab-slo-settings' );

    $this->populate_mission_select( $selected, $missions, 'gpalab_slo_mission' );
  }

  /**
   * Populates the add mission select with a list of mission options.
   *
   * @param string $selected   The mission id of the selected mission.
   * @param array  $missions   A list of available missions.
   * @param string $meta       The key of the post meta to be saved.
   *
   * @since 0.0.1
   */
  public function populate_mission_select( $selected, $missions, $meta ) {
    // Show 'All Posts' as the default option for the SLO page template dropdown.
    $empty_label = '_gpalab_slo_mission_select' === $meta ? __( 'All Posts', 'gpalab-slo' ) : '';

    ?>

    <label
      for="<?php echo esc_attr( $meta ); ?>"
      style="margin-right: 0.5rem;"
    >
      <?php esc_html_e( 'Select a mission:', 'gpalab-slo' ); ?>
      <select
        id="<?php echo esc_attr( $meta ); ?>"
        name="<?php echo esc_attr( $meta ); ?>"
      >
        <option value="" <?php selected( $selected, $mission['id'] ); ?>>
          <?php echo esc_html( $empty_label ); ?>
        </option>
        <?php
        foreach ( $missions as $mission ) {

          $option  = '<option value=' . esc_attr( $mission['id'] );
          $option .= ' ' . selected( $selected, $mission['id'] ) . '>';
          $option .= esc_html( $mission['title'] ) . '</option>';

          $elements = array(
            'option' => array(
              'selected' => array(),
              'value'    => array(),
            ),
          );

          echo wp_kses( $option, $elements );
        }
        ?>
      </select>
    </label>

    <?php
  }

  /**
   * Renders the custom metabox used to indicate that a link should be archived.
   *
   * @param object $post  WordPress post Object.
   *
   * @since 0.0.1
   */
  public function add_archive_checkbox( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'gpalab_slo_nonce' );

    $is_archived    = get_post_meta( $post->ID, 'gpalab_slo_archive', true );
    $checkbox_value = ( isset( $is_archived ) && 'true' === $is_archived ) ? 'true' : 'false';

    ?>

    <p>
      <?php
      echo wp_kses(
        __( 'Archive this item if you do <strong>not</strong> want it displayed on the social bio page.', 'gpalab-slo' ),
        array( 'strong' => array() )
      );
      ?>
    </p>

    <p style="display: flex; align-items: center;">
      <label
        for="gpalab_slo_archive"
        class="gpalab-slo-archive-meta-title"
        style="margin-right: 0.5rem;"
      >
        <?php esc_html_e( 'Set as archive:', 'gpalab-slo' ); ?>
      </label>
      <input
        type="checkbox"
        name="gpalab_slo_archive"
        id="gpalab_slo_archive"
        value="true"
        <?php checked( $checkbox_value, 'true' ); ?>
      />
    </p>

    <?php
  }

  /**
   * Save the custom meta data.
   *
   * @param int $post_id   WordPress post id.
   *
   * @since 0.0.1
   */
  public function gpalab_slo_meta_save( $post_id ) {
    global $post;

    if ( 'gpalab-social-link' !== $post->post_type ) {
      return;
    }

    // Check save status and validate nonce.
    $is_autosave    = wp_is_post_autosave( $post_id );
    $is_revision    = wp_is_post_revision( $post_id );
    $is_valid_nonce =
      isset( $_POST['gpalab_slo_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['gpalab_slo_nonce'] ) ), basename( __FILE__ ) )
      ? 'true'
      : 'false';

    if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
      return;
    }

    // Sanitize/save the post meta.
    if ( isset( $_POST['gpalab_slo_link'] ) ) {
      update_post_meta(
        $post_id,
        'gpalab_slo_link',
        sanitize_text_field( wp_unslash( $_POST['gpalab_slo_link'] ) )
      );
    }

    if ( isset( $_POST['gpalab_slo_mission'] ) ) {
      update_post_meta(
        $post_id,
        'gpalab_slo_mission',
        sanitize_text_field( wp_unslash( $_POST['gpalab_slo_mission'] ) )
      );
    }

    if ( isset( $_POST['gpalab_slo_archive'] ) ) {
      update_post_meta(
        $post_id,
        'gpalab_slo_archive',
        sanitize_text_field( wp_unslash( $_POST['gpalab_slo_archive'] ) )
      );
    } else {
      delete_post_meta( $post_id, 'gpalab_slo_archive' );
    }
  }

  /**
   * Filter the Social Link permalink
   *
   * @param string $url     Social media link.
   * @param object $post    WordPress post Object.
   *
   * @since 0.0.1
   */
  public function gpalab_slo_filter_permalink( $url, $post ) {
    $custom_link = get_post_field( 'gpalab_slo_link', $post->ID );

    if ( $custom_link && 'gpalab-social-link' === get_post_type( $post->ID ) ) {
      $url = $custom_link;
    }

    return $url;
  }

  /**
   * Relocate featured image metabox to the principal section.
   *
   * @since 0.0.1
   */
  public function gpalab_slo_image_meta_box() {
    remove_meta_box( 'postimagediv', 'gpalab-social-link', 'side' );

    add_meta_box(
      'postimagediv',
      __( 'Featured Image' ),
      'post_thumbnail_meta_box',
      'gpalab-social-link',
      'normal', // move to normal from side.
      'low'
    );
  }

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
