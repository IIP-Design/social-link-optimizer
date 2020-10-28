<?php
/**
 * Plugin Name:       Social Link Optimizer
 * Plugin URI:        https://github.com/IIP-Design/social-link-optimizer
 * Description:       Adds a Social Link custom post type, custom meta box, and Social Link Optimizer page template
 * Version:           0.0.1
 * Author:            U.S. Department of State, Bureau of Global Public Affairs Digital Lab <gpa-lab@america.gov>
 * Author URI:        https://lab.america.gov
 * License:           GNU General Public License v2.0
 * License URI:       https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * Text Domain:       gpalab-slo
 *
 * @package GPALAB_SLO
 */

/**
 * The current plugin version.
 *
 * @var array $version
 */
$version = '0.0.1';

/**
 * 1. Register custom post type
 */
function gpa_lab_social_link_optimizer() {
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
    'slug'       => 'gpa-lab-social-link',
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

  register_post_type( 'social_link', $args );

}

add_action( 'init', 'gpa_lab_social_link_optimizer', 0 );


/**
 * 2. Add custom meta box
 */
function gpa_lab_social_link_optimizer_custom_meta() {
  add_meta_box(
    'gpa_lab_meta',
    __( 'Link this social post to', 'gpalab-slo' ),
    'gpa_lab_social_link_optimizer_meta_callback',
    'social_link'
  );
}
add_action( 'add_meta_boxes', 'gpa_lab_social_link_optimizer_custom_meta' );

/**
 * 2.1 Display the meta box
 *
 * @param object $post    WordPress post Object.
 */
function gpa_lab_social_link_optimizer_meta_callback( $post ) {
  wp_nonce_field( basename( __FILE__ ), 'gpa_lab_social_link_optimizer_nonce' );

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
      value="<?php isset( $slo_meta ) ? $slo_meta[0] : ''; ?>" 
    />
  </p>

  <?php
}

/**
 * 2.2 Save the custom meta data
 *
 * @param int $post_id   WordPress post id.
 */
function gpa_lab_social_link_optimizer_meta_save( $post_id ) {
  // Save status.
  $is_autosave    = wp_is_post_autosave( $post_id );
  $is_revision    = wp_is_post_revision( $post_id );
  $is_valid_nonce = ( isset( $_POST['gpa_lab_social_link_optimizer_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['gpa_lab_social_link_optimizer_nonce'] ) ), basename( __FILE__ ) ) ) ? 'true' : 'false';

  if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
    return;
  }

  // Sanitize/save.
  if ( isset( $_POST['gpa-lab-social-links-meta-text'] ) ) {
    update_post_meta( $post_id, 'gpa-lab-social-links-meta-text', sanitize_text_field( wp_unslash( $_POST['gpa-lab-social-links-meta-text'] ) ) );
  }
}
add_action( 'save_post', 'gpa_lab_social_link_optimizer_meta_save' );

/**
 * 3. Filter the Social Link permalink
 *
 * @param string $url     Social media link.
 * @param object $post    WordPress post Object.
 */
function prefix_filter_social_links_permalink( $url, $post ) {
  $custom_link = get_post_field( 'gpa-lab-social-links-meta-text', $post->ID );

  if ( $custom_link && 'social_link' === get_post_type( $post->ID ) ) {
    $url = $custom_link;
  }

  return $url;
}
add_filter( 'post_type_link', 'prefix_filter_social_links_permalink', 10, 2 );

/**
 * 4. enqueue styles
 */
function prefix_filter_social_links_stylesheets() {
  wp_enqueue_style(
    'social-bio-links',
    plugin_dir_url( __FILE__ ) . 'css/social-link-optimizer-styles.css',
    array(),
    $version
  );
}
add_action( 'wp_enqueue_scripts', 'prefix_filter_social_links_stylesheets' );

/**
 * 5. Add page template
 *
 * @see https://www.wpexplorer.com/wordpress-page-templates-plugin/
 */
class GPASocialLinkOptimizerTemplate {

  /**
   * A reference to an instance of this class.
   *
   * @var GPASocialLinkOptimizerTemplate $instance
   */
  private static $instance;

  /**
   * The array of templates that this plugin tracks.
   *
   * @var array $templates
   */
  protected $templates;

  /**
   * Returns an instance of this class.
   */
  public static function get_instance() {

    if ( null === self::$instance ) {
      self::$instance = new GPASocialLinkOptimizerTemplate();
    }

    return self::$instance;

  }

  /**
   * Initializes the plugin by setting filters and administration functions.
   */
  private function __construct() {

    $this->templates = array();

    // Add a filter to the attributes metabox to inject template into the cache.
    if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {

      // 4.6 and older
      add_filter(
        'page_attributes_dropdown_pages_args',
        array( $this, 'register_project_templates' )
      );

    } else {

      // Add a filter to the wp 4.7 version attributes metabox.
      add_filter(
        'theme_page_templates',
        array( $this, 'add_new_template' )
      );

    }

    // Add a filter to the save post to inject out template into the page cache.
    add_filter(
      'wp_insert_post_data',
      array( $this, 'register_project_templates' )
    );

    // Add a filter to the template include to determine if the page has our
    // template assigned and return it's path.
    add_filter(
      'template_include',
      array( $this, 'view_project_template' )
    );

    // Add your templates to this array.
    $this->templates = array(
      '/templates/template-social-link-optimizer.php' => 'Social Link Optimizer',
    );

  }

  /**
   * Adds our template to the page dropdown for v4.7+
   *
   * @param array $posts_templates   List of available post templates.
   */
  public function add_new_template( $posts_templates ) {
    $posts_templates = array_merge( $posts_templates, $this->templates );

    return $posts_templates;
  }

  /**
   * Adds our template to the pages cache in order to trick WordPress
   * into thinking the template file exists where it doesn't really exist.
   *
   * @param array $atts   List of attributes.
   */
  public function register_project_templates( $atts ) {

    // Create the key used for the themes cache.
    $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

    // Retrieve the cache list.
    // If it doesn't exist, or it's empty prepare an array.
    $templates = wp_get_theme()->get_page_templates();
    if ( empty( $templates ) ) {
      $templates = array();
    }

    // New cache, therefore remove the old one.
    wp_cache_delete( $cache_key, 'themes' );

    // Now add our template to the list of templates by merging our templates
    // with the existing templates array from the cache.
    $templates = array_merge( $templates, $this->templates );

    // Add the modified cache to allow WordPress to pick it up for listing.
    // available templates.
    wp_cache_add( $cache_key, $templates, 'themes', 1800 );

    return $atts;
  }

  /**
   * Checks if the template is assigned to the page
   *
   * @param $template
   */
  public function view_project_template( $template ) {
    // Return the search template if we're searching (instead of the template for the first result).
    if ( is_search() ) {
      return $template;
    }

    // Get global post.
    global $post;

    // Return template if post is empty.
    if ( ! $post ) {
      return $template;
    }

    // Return default template if we don't have a custom one defined.
    if ( ! isset(
      $this->templates[ get_post_meta(
        $post->ID,
        '_wp_page_template',
        true
      ) ]
    ) ) {
      return $template;
    }

    // Allows filtering of file path.
    $filepath = apply_filters( 'page_templater_plugin_dir_path', plugin_dir_path( __FILE__ ) );

    $file = $filepath . get_post_meta(
      $post->ID,
      '_wp_page_template',
      true
    );

    // Just to be safe, we check if the file exist first.
    if ( file_exists( $file ) ) {
      return $file;
    } else {
      echo $file;
    }

    // Return template.
    return $template;

  }

}
add_action( 'plugins_loaded', array( 'GPASocialLinkOptimizerTemplate', 'get_instance' ) );
