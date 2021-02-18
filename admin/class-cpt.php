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
      'add_new_item'          => __( 'Add New Social Link', 'gpalab-slo' ),
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
      'set_featured_image'    => __( 'Add image to the grid', 'gpalab-slo' ),
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
  public function slo_custom_meta() {
    add_meta_box(
      'gpalab_slo_link',
      __( 'Add a Link to This Social Post (required)', 'gpalab-slo' ),
      array( $this, 'add_link_input' ),
      'gpalab-social-link',
      'normal',
      'high'
    );

    add_meta_box(
      'gpalab_slo_mission',
      __( 'Select Mission (required)', 'gpalab-slo' ),
      array( $this, 'add_mission_select' ),
      'gpalab-social-link',
      'normal',
      'default'
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
   * Remove the custom metaboxes added by the MWP team.
   *
   * @since 1.1.0
   */
  public function remove_mwp_metaboxes() {
    remove_meta_box(
      'pp_enable_type',
      'gpalab-social-link',
      'advanced'
    );

    remove_meta_box(
      'expirationdatediv',
      'gpalab-social-link',
      'side'
    );

    remove_meta_box(
      'hide_featured',
      'gpalab-social-link',
      'side'
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

    if ( ! empty( $selected ) ) {
      $missions = get_option( 'gpalab-slo-settings' );

      // Search for selected mission among the mission sessions and return it's data.
      $settings_key = array_search( $selected, array_column( $missions, 'id' ), true );
      $settings     = is_numeric( $settings_key ) ? $missions[ $settings_key ] : array();

      /* translators: %s: the tile of the selected mission */
      $text  = __( 'Go to the %s page', 'gpalab-slo' );
      $link  = get_permalink( $settings['page'] );
      $title = $settings['title'];

      ?>
        <br>
        <div style="align-items:center;display:flex;margin-top:1rem;">
          <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="img" viewBox="0 0 512 512" height="15px" width="15px"><path fill="currentColor" d="M432,320H400a16,16,0,0,0-16,16V448H64V128H208a16,16,0,0,0,16-16V80a16,16,0,0,0-16-16H48A48,48,0,0,0,0,112V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48V336A16,16,0,0,0,432,320ZM488,0h-128c-21.37,0-32.05,25.91-17,41l35.73,35.73L135,320.37a24,24,0,0,0,0,34L157.67,377a24,24,0,0,0,34,0L435.28,133.32,471,169c15,15,41,4.5,41-17V24A24,24,0,0,0,488,0Z"/></svg>
          <?php printf( '<a href=' . esc_attr( $link ) . ' target="_blank" style="margin-left:0.5rem">' . esc_html( $text ) . '</a>', esc_html( $title ) ); ?>
        </div>
      <?php
    }
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
    $label = __( 'All Missions', 'gpalab-slo' );

    // Show and empty string as the default value if on a social link edit screen.
    if ( 'gpalab_slo_mission' === $meta ) {
      $label = '';
    }

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
          <?php echo esc_html( $label ); ?>
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
   * Add image dimensions helper text to the image meta box.
   *
   * @param string $content Admin post thumbnail HTML markup.
   * @return string         The metabox content with helper text.
   *
   * @since 0.0.1
   */
  public function gpalab_slo_image_meta_box_helper_text( $content ) {
    global $post_type;

    $is_social_link = 'gpalab-social-link' === $post_type;

    if ( ! $is_social_link ) {
      return $content;
    }

    $helper_text = '<p>' . esc_html__( 'For optimal resolution: image should be at least 1080 &times; 1080 (width &times; height) with an aspect ratio of 1:1 (square), 1.91:1 (landscape), and 4:5 (portrait).', 'gpalab-slo' ) . '</p>';

    return $helper_text . $content;
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
      1  => __( 'Social Link updated.', 'gpalab-slo' ),
      2  => __( 'Custom field updated.', 'gpalab-slo' ),
      3  => __( 'Custom field deleted.', 'gpalab-slo' ),
      4  => __( 'Social Link updated.', 'gpalab-slo' ),
      5  => $is_revision,
      6  => __( 'Social Link published.', 'gpalab-slo' ),
      7  => __( 'Social Link saved.', 'gpalab-slo' ),
      8  => __( 'Social Link submitted.', 'gpalab-slo' ),
      9  => sprintf( $scheduled, '<strong>' . $scheduled_date . '</strong>' ),
      10 => __( 'Social Link saved as draft.', 'gpalab-slo' ),
    );

    return $msg;
  }

  /**
   * Filters the default untrashed message.
   *
   * @param array $messages Array of messages.
   * @param array $counts   Array of item counts for each message.
   *
   * @since 0.0.1
   */
  public function social_link_untrashed_message( $messages, $counts ) {
    $messages['gpalab-social-link'] = array(
      /* translators: %s: count of untrashed social links */
      'untrashed' => _n( '%s social link restored from the Trash. Go to Edit Social Link to republish.', '%s social link restored from the Trash. Go to Edit Social Link to republish.', $counts['untrashed'] ),
    );

    return $messages;
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

  /**
   * Register the 'Archived' post status;
   *
   * @since 0.0.1
   */
  public function register_archive_status() {
    /* translators: %s: the number of archived items */
    $count = _n_noop( 'Archived <span class="count">(%s)</span>', 'Archived <span class="count">(%s)</span>', 'gpalab-slo' );

    register_post_status(
      'archived',
      array(
        'label'                     => __( 'Archived', 'gpalab-slo' ),
        'label_count'               => $count,
        'exclude_from_search'       => true,
        'public'                    => true,
        'show_in_admin_all_list'    => false,
        'show_in_admin_status_list' => true,
      )
    );
  }

  /**
   * Populate the status dropdown in the Publish metabox with an 'Archived' option.
   *
   * @since 0.0.1
   */
  public function add_archived_to_status_dropdown() {
    global $post;

    // Do not add the archive status unless the post is a gpalab social link.
    if ( 'gpalab-social-link' !== $post->post_type ) {
      return false;
    }

    echo '<script>';
    echo 'jQuery(document).ready( function() { jQuery( \'select[name="post_status"]\' ).append( \'<option value="archived">Archived</option>\' );';
    if ( 'archived' === $post->post_status ) {
      echo "jQuery( '#post-status-display' ).text( 'Archived' ); jQuery('select[name=\"post_status\"]' ).val('archived');";
    }
    echo ' }); </script>';
  }

  /**
   * Add the 'Archived' post status to display post states.
   *
   * @param array $states Post display states.
   * @return array        Post display states.
   *
   * @since 0.0.1
   */
  public function add_archived_to_display_post_states( $states ) {
    global $post;

    $post_type   = $post->post_type;
    $post_status = $post->post_status;

    // Return default states.
    if ( 'gpalab-social-link' !== $post_type || 'archived' !== $post_status ) {
      return $states;
    }

    // Add archived status and label to states array.
    $states['archived'] = __( 'Archived', 'gpalab-slo' );

    return $states;
  }
}
