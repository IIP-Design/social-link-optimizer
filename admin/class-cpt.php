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
      'taxonomies'          => array( 'category', 'post_tag' ),
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
   */
  public function gpalab_slo_custom_meta() {
    add_meta_box(
      'gpa_lab_meta',
      __( 'Link this social post to', 'gpalab-slo' ),
      function( $post ) {
        return $this->gpalab_slo_meta_callback( $post );
      },
      'gpalab-social-link',
      'normal',
      'high'
    );
  }

  /**
   * Display the meta box.
   *
   * @param object $post    WordPress post Object.
   */
  public function gpalab_slo_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'gpalab_slo_nonce' );

    $post_meta = get_post_meta( $post->ID );
    $slo_meta  = $post_meta['gpa-lab-social-links-meta-text'];
    ?>

    <p style="display: flex; align-items: center;">
      <label
        for="gpa-lab-social-links-meta-text"
        class="gpa-lab-social-links-row-title"
        style="margin-right: 0.5rem;"
      >
        <?php esc_html_e( 'Link:', 'gpalab-slo' ); ?>
      </label>
      <input
        type="text"
        name="gpa-lab-social-links-meta-text" 
        id="gpa-lab-social-links-meta-text"
        style="flex-grow: 1;"
        value="<?php echo isset( $slo_meta ) ? $slo_meta[0] : ''; ?>" 
      />
    </p>

    <?php
  }

  /**
   * Save the custom meta data.
   *
   * @param int $post_id   WordPress post id.
   */
  public function gpalab_slo_meta_save( $post_id ) {
    // Save status.
    $is_autosave    = wp_is_post_autosave( $post_id );
    $is_revision    = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST['gpalab_slo_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['gpalab_slo_nonce'] ) ), basename( __FILE__ ) ) ) ? 'true' : 'false';

    if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
      return;
    }

    // Sanitize/save.
    if ( isset( $_POST['gpa-lab-social-links-meta-text'] ) ) {
      update_post_meta( $post_id, 'gpa-lab-social-links-meta-text', sanitize_text_field( wp_unslash( $_POST['gpa-lab-social-links-meta-text'] ) ) );
    }
  }

  /**
   * Add archive metabox
   */
  public function gpalab_slo_archive_meta() {
    add_meta_box(
      'gpalab_slo_archive_meta',
      __( 'Archive', 'gpalab-slo' ),
      function( $post ) {
        return $this->gpalab_slo_archive_meta_callback( $post );
      },
      'gpalab-social-link',
      'side',
      'high'
    );
  }

  /**
   * Display the archive meta box
   *
   * @param object $post    WordPress post Object.
   */
  public function gpalab_slo_archive_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'gpalab_slo_archive_nonce' );

    $post_meta = get_post_meta( $post->ID );
    $slo_meta  = $post_meta['gpalab-slo-archive-meta'];
    $is_set = isset( $slo_meta[0] );
    $is_checked = 'true' === $slo_meta[0];
    $checkbox_value = ( $is_set && $is_checked ) ? 'true' : 'false';
    ?>

    <p>Archive this item if you do <strong>not</strong> want it displayed on the social bio page.</p>

    <p style="display: flex; align-items: center;">
      <label
        for="gpalab-slo-archive-meta"
        class="gpalab-slo-archive-meta-title"
        style="margin-right: 0.5rem;"
      >
        <?php esc_html_e( 'Set as archive:', 'gpalab-slo' ); ?>
      </label>
      <input
        type="checkbox"
        name="gpalab-slo-archive-meta" 
        id="gpalab-slo-archive-meta"
        value="true"
        <?php checked( $checkbox_value, 'true' ); ?>
      />
    </p>

    <?php
  }

  /**
   * Save the archive meta data
   *
   * @param int $post_id   WordPress post id.
   */
  public function gpalab_slo_archive_meta_save( $post_id ) {
    // Save status.
    $is_autosave    = wp_is_post_autosave( $post_id );
    $is_revision    = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST['gpalab_slo_archive_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['gpalab_slo_archive_nonce'] ) ), basename( __FILE__ ) ) ) ? 'true' : 'false';

    if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
      return;
    }

    // Save.
    $is_set = isset( $_POST['gpalab-slo-archive-meta'] );
    $is_checked = 'true' === $_POST['gpalab-slo-archive-meta'];
    $checkbox_value = ( $is_set && $is_checked ) ? 'true' : 'false';
    update_post_meta( $post_id, 'gpalab-slo-archive-meta', $checkbox_value );
  }

  /**
   * Filter the Social Link permalink
   *
   * @param string $url     Social media link.
   * @param object $post    WordPress post Object.
   */
  public function gpalab_slo_filter_permalink( $url, $post ) {
    $custom_link = get_post_field( 'gpa-lab-social-links-meta-text', $post->ID );

    if ( $custom_link && 'gpalab-social-link' === get_post_type( $post->ID ) ) {
      $url = $custom_link;
    }

    return $url;
  }

  /**
   * 4. Relocate featured image meta box
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
   * Add sortable Archived admin column
   */
  public function gpalab_slo_archive_admin_column( $defaults ) {
    $defaults['gpalab_slo_archive'] = __( 'Archived', 'gpalab-slo' );
    return $defaults;
  }

  public function gpalab_slo_archive_sortable_admin_column( $columns ) {
    $columns['gpalab_slo_archive'] = __( 'Archived', 'gpalab-slo' );
    return $columns;
  }

  public function gpalab_slo_archive_admin_column_content( $column_name, $post_id ) {
    if ( 'gpalab_slo_archive' === $column_name ) {
      $is_archive = get_post_meta( $post_id, 'gpalab-slo-archive-meta', true );
      $human_friendly_value = 'true' === $is_archive ? 'yes' : 'no';
      echo '<p>' . $human_friendly_value . '</p>';
    }
  }

}
