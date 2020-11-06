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
 * The Settings class adds a settings page allowing site admins to configure the plugin.
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
    $labels = array(
      'name'                  => _x( 'Social Links', 'Post Type General Name', 'gpalab-slo' ),
      'singular_name'         => _x( 'Social Link', 'Post Type Singular Name', 'gpalab-slo' ),
      'menu_name'             => __( 'Social Links', 'gpalab-slo' ),
      'name_admin_bar'        => __( 'Social Links', 'gpalab-slo' ),
      'archives'              => __( 'Social Links', 'gpalab-slo' ),
      'attributes'            => __( 'Item Attributes', 'gpalab-slo' ),
      'parent_item_colon'     => __( 'Parent Item:', 'gpalab-slo' ),
      'all_items'             => __( 'All Items', 'gpalab-slo' ),
      'add_new_item'          => __( 'Add New Item', 'gpalab-slo' ),
      'add_new'               => __( 'Add New', 'gpalab-slo' ),
      'new_item'              => __( 'New Item', 'gpalab-slo' ),
      'edit_item'             => __( 'Edit Item', 'gpalab-slo' ),
      'update_item'           => __( 'Update Item', 'gpalab-slo' ),
      'view_item'             => __( 'View Item', 'gpalab-slo' ),
      'view_items'            => __( 'View Items', 'gpalab-slo' ),
      'search_items'          => __( 'Search Item', 'gpalab-slo' ),
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
      'capability_type'     => 'post',
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
      array( $this, 'gpalab_slo_meta_callback' ),
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
      'low'
    );
  }

  /**
   * Renders the custom metabox used to save the post redirect.
   *
   * @param object $post  WordPress post Object.
   *
   * @since 0.0.1
   */
  public function gpalab_slo_meta_callback( $post ) {
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

    $selected = get_post_meta( $post->ID, 'gpalab-slo-mission', true );
    $missions = get_option( 'gpalab-slo-settings' );

    ?>

    <label
      for="gpalab-slo-mission"
      style="margin-right: 0.5rem;"
    >
      <?php esc_html_e( 'Select a mission:', 'gpalab-slo' ); ?>
      <select
        id="gpalab-slo-mission"
        name="gpalab-slo-mission"
      >
        <option value="" <?php selected( $selected, $mission['id'] ); ?>></option>
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

    // Save status.
    $is_autosave    = wp_is_post_autosave( $post_id );
    $is_revision    = wp_is_post_revision( $post_id );
    $is_valid_nonce =
      isset( $_POST['gpalab_slo_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['gpalab_slo_nonce'] ) ), basename( __FILE__ ) )
      ? 'true'
      : 'false';

    if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
      return;
    }

    // Sanitize/save.
    if ( isset( $_POST['gpalab_slo_link'] ) ) {
      update_post_meta(
        $post_id,
        'gpalab_slo_link',
        sanitize_text_field( wp_unslash( $_POST['gpalab_slo_link'] ) )
      );
    }

    if ( isset( $_POST['gpalab-slo-mission'] ) ) {
      update_post_meta(
        $post_id,
        'gpalab-slo-mission',
        sanitize_text_field( wp_unslash( $_POST['gpalab-slo-mission'] ) )
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
      __( 'Featured Image' ),
      'post_thumbnail_meta_box',
      'gpalab-social-link',
      'normal', // move to normal from side.
      'low'
    );
  }

}
