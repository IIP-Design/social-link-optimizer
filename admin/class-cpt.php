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
   * Initializes the class with the plugin name and version.
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
   * Register social links custom post type.
   *
   * @since 0.0.1
   */
  public function gpalab_slo_cpt() {
    /**
     * Private post capabilities are disabled as we don't anticipate their use.
     * If eventually enabled, the corresponding change should be made in the
     * Activator and Uninstall classes found in the includes directory as well
     * as in the URE class found in this directory.
     */
    // phpcs:disable Squiz.PHP.CommentedOutCode.Found
    $capabilities = array(
      'edit_posts'             => 'gpalab_slo_edit_links',
      'edit_others_posts'      => 'gpalab_slo_edit_others_links',
      'edit_published_posts'   => 'gpalab_slo_edit_published_links',
      'delete_posts'           => 'gpalab_slo_delete_links',
      'delete_others_posts'    => 'gpalab_slo_delete_others_links',
      'delete_published_posts' => 'gpalab_slo_delete_published_links',
      'publish_posts'          => 'gpalab_slo_publish_links',
      // 'edit_private_posts'     => 'gpalab_slo_edit_private_links',
      // 'delete_private_posts'   => 'gpalab_slo_delete_private_links',
      // 'read_private_posts'     => 'gpalab_slo_read_private_links',
    );
    // phpcs:enable

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
      'add_new'               => __( 'Add New Link', 'gpalab-slo' ),
      'new_item'              => __( 'New Item', 'gpalab-slo' ),
      'edit_item'             => __( 'Edit Social Link', 'gpalab-slo' ),
      'update_item'           => __( 'Update Item', 'gpalab-slo' ),
      'view_item'             => __( 'View Link', 'gpalab-slo' ),
      'view_items'            => __( 'View Links', 'gpalab-slo' ),
      'search_items'          => __( 'Search Links', 'gpalab-slo' ),
      'not_found'             => __( 'Not found', 'gpalab-slo' ),
      'not_found_in_trash'    => __( 'Not found in Trash', 'gpalab-slo' ),
      'featured_image'        => __( 'Linked Image', 'gpalab-slo' ),
      'set_featured_image'    => __( 'Add an image to the grid', 'gpalab-slo' ),
      'remove_featured_image' => __( 'Remove image', 'gpalab-slo' ),
      'use_featured_image'    => __( 'Use as grid image', 'gpalab-slo' ),
      'insert_into_item'      => __( 'Insert into item', 'gpalab-slo' ),
      'uploaded_to_this_item' => __( 'Uploaded to this item', 'gpalab-slo' ),
      'items_list'            => __( 'Link list', 'gpalab-slo' ),
      'items_list_navigation' => __( 'Link list navigation', 'gpalab-slo' ),
      'filter_items_list'     => __( 'Filter link list', 'gpalab-slo' ),
    );

    $rewrite = array(
      'slug'       => 'gpalab-social-link',
      'with_front' => false,
      'pages'      => true,
      'feeds'      => false,
    );

    $args = array(
      'label'               => __( 'Social Link', 'gpalab-slo' ),
      'description'         => __( 'Links used to populate mission social link pages', 'gpalab-slo' ),
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
      'has_archive'         => false,
      'exclude_from_search' => true,
      'publicly_queryable'  => true,
      'rewrite'             => $rewrite,
      'capability_type'     => 'gpalab_slo_links',
      'capabilities'        => $capabilities,
      'map_meta_cap'        => true,
      'show_in_rest'        => false,
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
      'gpalab_slo_mission',
      __( 'Select Mission (required)', 'gpalab-slo' ),
      array( $this, 'add_mission_select' ),
      'gpalab-social-link',
      'normal',
      'high'
    );

    add_meta_box(
      'gpalab_slo_link',
      __( 'Add a Link to This Social Post (required)', 'gpalab-slo' ),
      array( $this, 'add_link_input' ),
      'gpalab-social-link',
      'normal',
      'default'
    );

    add_meta_box(
      'gpalab_slo_archive',
      __( 'Archive', 'gpalab-slo' ),
      array( $this, 'add_archive_checkbox' ),
      'gpalab-social-link',
      'side',
      'low'
    );

    /**
     * The following metaboxes are not used in editing the social link posts,
     * but can cause confusion for users unfamiliar with WordPress.
     */
    remove_meta_box(
      'postcustom',
      'gpalab-social-link',
      'normal'
    );

    remove_meta_box(
      'slugdiv',
      'gpalab-social-link',
      'normal'
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

    <p id="instructions"><?php echo esc_html( __( 'Example', 'gpalab-slo' ) . ': https://www.website.com' ); ?></p>
    <p style="display: flex; align-items: center;">
      <label
        for="gpalab_slo_link_field"
        class="gpa-lab-social-links-row-title"
        style="margin-right: 0.5rem;"
      >
        <?php esc_html_e( 'Link:', 'gpalab-slo' ); ?>
      </label>
      <input
        type="text"
        name="gpalab_slo_link"
        id="gpalab_slo_link_field"
        style="flex-grow: 1;"
        value="<?php echo esc_url( $link, array( 'http', 'https' ) ); ?>"
        required
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
      for="<?php echo esc_attr( $meta ) . '_field'; ?>"
      style="margin-right: 0.5rem;"
    >
      <?php esc_html_e( 'Select a mission:', 'gpalab-slo' ); ?>
      <select
        id="<?php echo esc_attr( $meta ) . '_field'; ?>"
        name="<?php echo esc_attr( $meta ); ?>"
        required
      >
        <option value="" <?php selected( $selected, '' ); ?>>
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
        for="gpalab_slo_archive_field"
        class="gpalab-slo-archive-meta-title"
        style="margin-right: 0.5rem;"
      >
        <?php esc_html_e( 'Set as archive:', 'gpalab-slo' ); ?>
      </label>
      <input
        type="checkbox"
        name="gpalab_slo_archive"
        id="gpalab_slo_archive_field"
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
      __( 'Add a Grid Image', 'gpalab-slo' ),
      'post_thumbnail_meta_box',
      'gpalab-social-link',
      'normal', // move to normal from side.
      'low'
    );
  }

  /**
   * When loading gpalab-social-link posts, load the post template provided by the plugin.
   *
   * @param string $single   The path to the appropriate single template.
   * @return string          If a social link, the path to our template, otherwise the default path.
   *
   * @since 0.0.1
   */
  public function preview_link_template( $single ) {
    global $post;

    /* Checks for single template by post type */
    if ( 'gpalab-social-link' === $post->post_type ) {
      if ( file_exists( GPALAB_SLO_DIR . '/templates/preview-gpalab-social-link.php' ) ) {
        return GPALAB_SLO_DIR . '/templates/preview-gpalab-social-link.php';
      }
    }

    return $single;
  }

  /**
   * Rewrite the preview urls for social links to simulated SLO aggregate page.
   *
   * @param string $link  The default preview url.
   * @return string       The preview url.
   *
   * @since 0.0.1
   */
  public function hijack_slo_preview( $link ) {
    global $post;

    if ( 'gpalab-social-link' === $post->post_type ) {
      return '/?post_type=gpalab-social-link&p=' . $post->ID . '&preview=true';
    } else {
      return $link;
    }
  }

  /**
   * Hides the permalink below the post title and the post visibility
   * settings on the social link edit screen to avoid confusion.
   *
   * @since 0.0.1
   */
  public function hide_unused_elements() {
    global $post_type;

    if ( 'gpalab-social-link' === $post_type ) {
      echo '<style type="text/css">#edit-slug-box, #visibility{display: none;}</style>';
    }
  }

  /**
   * Rewrite the messages in the growl notifications shown to users on updates.
   *
   * @param array $msg   List of messages shown to the user on update.
   * @return array       Updated list with custom messages for gpalab-social-links.
   *
   * @since 0.0.1
   */
  public function social_link_updated_messages( $msg ) {

    global $post;

    /* translators: %s: date and time of the revision */
    $revision = __( 'Social link restored to revision from %s.', 'gpalab-slo' );

    // phpcs:disable WordPress.Security.NonceVerification.Recommended
    $is_revision = isset( $_GET['revision'] )
                 ? sprintf( $revision, wp_post_revision_title( (int) $_GET['revision'], false ) )
                 : false;
    // phpcs:enable

    /* translators: %s: date and time for which publishing is scheduled */
    $scheduled = __( 'Social link publication scheduled for: %s.', 'gpalab-slo' );

    $scheduled_date = date_i18n( __( 'M j, Y @ H:i' ), strtotime( $post->post_date ) );

    $msg['gpalab-social-link'] = array(
      0  => '', // Unused. Messages start at index 1.
      1  => __( 'Social link updated.', 'gpalab-slo' ),
      2  => __( 'Custom field updated.', 'gpalab-slo' ),
      3  => __( 'Custom field deleted.', 'gpalab-slo' ),
      4  => __( 'Social link updated.', 'gpalab-slo' ),
      5  => $is_revision,
      6  => __( 'Social link published.', 'gpalab-slo' ),
      7  => __( 'Social link saved.', 'gpalab-slo' ),
      8  => __( 'Social link submitted.', 'gpalab-slo' ),
      9  => sprintf( $scheduled, '<strong>' . $scheduled_date . '</strong>' ),
      10 => __( 'Social link draft updated.', 'gpalab-slo' ),
    );

    return $msg;
  }

  /**
   * Remove the View link from the admin bar for social links.
   *
   * @param object $wp_admin_bar  List of nodes to appear in the admin bar.
   *
   * @since 0.0.1
   */
  public function remove_view_from_admin_bar( $wp_admin_bar ) {

    if ( is_admin() && 'gpalab-social-link' === get_current_screen()->post_type ) {
      $wp_admin_bar->remove_node( 'view' );
    }
  }
}
