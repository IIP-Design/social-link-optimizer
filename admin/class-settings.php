<?php
/**
 * Registers the Settings class.
 *
 * @package SLO\Settings
 * @since 0.0.1
 */

namespace SLO;

/**
 * Add plugin settings.
 *
 * The Settings class adds a settings page allowing site admins to configure the plugin.
 *
 * @package SLO\Settings
 * @since 0.0.1
 */
class Settings {
  /**
   * Adds a settings page to social links sub-menu where the plugin can be configured.
   *
   * @since 0.0.1
   */
  public function add_settings_page() {
    add_submenu_page(
      'edit.php?post_type=gpalab-social-link',
      __( 'Social Links Settings', 'gpalab-slo' ),
      __( 'Settings', 'gpalab-slo' ),
      'manage_options',
      'gpalab-slo-settings',
      function() {
        return $this->create_admin_page();
      },
      null
    );

    register_setting(
      'gpalab-slo',
      'gpalab-slo-settings'
    );
  }

  /**
   * Enqueue the admin scripts if on the SLO settings page.
   *
   * @param string $hook   Name of the current page.
   *
   * @since 0.0.1
   */
  public function enqueue_slo_admin( $hook ) {
    if ( 'gpalab-social-link_page_gpalab-slo-settings' !== $hook ) {
      return;
    }

    wp_enqueue_script( 'gpalab-slo-admin-js' );
    wp_enqueue_style( 'gpalab-slo-admin-css' );
  }

  /**
   * Generates the markup for the plugin's settings page.
   *
   * @since 0.0.1
   */
  private function create_admin_page() {
    ?>
    <div class="wrap">
      <h1><?php esc_html_e( 'Social Link Settings', 'gpalab-slo' ); ?></h1>
      <?php
      settings_errors();

      $missions = get_option( 'gpalab-slo-settings' );
      $title    = __( 'Manage Mission Social Link Pages:', 'gpalab-slo' );

      // Create the tabs for the tabbed container.
      if ( isset( $missions ) ) {
        echo '<h2>' . esc_html( $title ) . '</h2>';
        echo '<ul class="gpalab-slo-tab-container" role="tablist">';

        foreach ( $missions as $key => $mission ) {
          $tab  = '<li class="gpalab-slo-tab" ';
          $tab .= 'role="presentation" >';
          $tab .= '<button class="gpalab-slo-tab-button" ';
          $tab .= 'id="gpalab-slo-tab-' . $key . '" ';
          $tab .= 'data-id="' . $key . '" ';
          $tab .= 'role="tab">' . esc_html( $mission['title'] ) . '</button>';
          $tab .= '</li>';

          echo wp_kses( $tab, 'post' );
        }

        echo '</ul>';
      }
      ?>
    <form method="post" action="options.php">
        <?php
          settings_fields( 'gpalab-slo' );
          $this->custom_do_settings_sections( 'gpalab-slo' );
        ?>
        <button class="button button-secondary" id="slo-add-mission" type="button" >
          Add Mission
        </button>
        <?php
          submit_button();
        ?>
      </form>
    </div>
    <?php
  }

  /**
   * Adds the mission settings.
   *
   * @since 0.0.1
   */
  public function populate_settings_page() {
    $missions = get_option( 'gpalab-slo-settings' );

    $populate = $this->generate_tab_panels();

    if ( isset( $missions ) ) {

      foreach ( $missions as $key => $mission ) {
        register_setting(
          'gpalab-slo',
          'gpalab-slo-settings-' . $key,
          array(
            'sanitize_callback' => 'sanitize_text_field',
          )
        );

        add_settings_section(
          'gpalab-slo-settings-' . $key,
          __( 'Manage Mission Social Link Pages:', 'gpalab-slo' ),
          function() {
            return $populate;
          },
          'gpalab-slo'
        );
      }
    }
  }

  /**
   * Adds a tabbed interface to the mission settings section.
   *
   * @since 0.0.1
   */
  private function generate_tab_panels() {
    $missions = get_option( 'gpalab-slo-settings' );

    // Create the contents of the tabbed container.
    if ( isset( $missions ) ) {
      foreach ( $missions as $key => $mission ) {

        $title_id = 'title_' . $key;

        add_settings_field(
          $title_id,
          __( 'Mission name:', 'gpalab-slo' ),
          array( $this, 'add_input' ),
          'gpalab-slo',
          'gpalab-slo-settings-' . $key,
          array(
            'label_for' => $title_id,
            'key'       => $key,
            'field'     => 'title',
            'option'    => $mission,
          )
        );

        $website_id = 'website_' . $key;

        add_settings_field(
          $website_id,
          __( 'Mission website:', 'gpalab-slo' ),
          array( $this, 'add_input' ),
          'gpalab-slo',
          'gpalab-slo-settings-' . $key,
          array(
            'label_for' => $website_id,
            'key'       => $key,
            'field'     => 'website',
            'option'    => $mission,
          )
        );

        $type_id = 'type_' . $key;

        add_settings_field(
          $type_id,
          __( 'Display links as a:', 'gpalab-slo' ),
          array( $this, 'add_type_toggle' ),
          'gpalab-slo',
          'gpalab-slo-settings-' . $key,
          array(
            'label_for' => $type_id,
            'key'       => $key,
            'field'     => 'type',
            'option'    => $mission,
          )
        );

        $facebook_id = 'facebook_' . $key;

        add_settings_field(
          $facebook_id,
          __( 'Facebook profile:', 'gpalab-slo' ),
          array( $this, 'add_input' ),
          'gpalab-slo',
          'gpalab-slo-settings-' . $key,
          array(
            'label_for' => $facebook_id,
            'key'       => $key,
            'field'     => 'facebook',
            'option'    => $mission,
          )
        );

        $flickr_id = 'flickr_' . $key;

        add_settings_field(
          $flickr_id,
          __( 'Flickr profile:', 'gpalab-slo' ),
          array( $this, 'add_input' ),
          'gpalab-slo',
          'gpalab-slo-settings-' . $key,
          array(
            'label_for' => $flickr_id,
            'key'       => $key,
            'field'     => 'flickr',
            'option'    => $mission,
          )
        );

        $instagram_id = 'instagram_' . $key;

        add_settings_field(
          $instagram_id,
          __( 'Instagram profile:', 'gpalab-slo' ),
          array( $this, 'add_input' ),
          'gpalab-slo',
          'gpalab-slo-settings-' . $key,
          array(
            'label_for' => $instagram_id,
            'key'       => $key,
            'field'     => 'instagram',
            'option'    => $mission,
          )
        );

        $linkedin_id = 'linkedin_' . $key;

        add_settings_field(
          $linkedin_id,
          __( 'LinkedIn profile:', 'gpalab-slo' ),
          array( $this, 'add_input' ),
          'gpalab-slo',
          'gpalab-slo-settings-' . $key,
          array(
            'label_for' => $linkedin_id,
            'key'       => $key,
            'field'     => 'linkedin',
            'option'    => $mission,
          )
        );

        $twitter_id = 'twitter_' . $key;

        add_settings_field(
          $twitter_id,
          __( 'Twitter profile:', 'gpalab-slo' ),
          array( $this, 'add_input' ),
          'gpalab-slo',
          'gpalab-slo-settings-' . $key,
          array(
            'label_for' => $twitter_id,
            'key'       => $key,
            'field'     => 'twitter',
            'option'    => $mission,
          )
        );

        $whatsapp_id = 'whatsapp_' . $key;

        add_settings_field(
          $whatsapp_id,
          __( 'WhatsApp profile:', 'gpalab-slo' ),
          array( $this, 'add_input' ),
          'gpalab-slo',
          'gpalab-slo-settings-' . $key,
          array(
            'label_for' => $whatsapp_id,
            'key'       => $key,
            'field'     => 'whatsapp',
            'option'    => $mission,
          )
        );

        $youtube_id = 'youtube_' . $key;

        add_settings_field(
          $youtube_id,
          __( 'YouTube profile:', 'gpalab-slo' ),
          array( $this, 'add_input' ),
          'gpalab-slo',
          'gpalab-slo-settings-' . $key,
          array(
            'label_for' => $youtube_id,
            'key'       => $key,
            'field'     => 'youtube',
            'option'    => $mission,
          )
        );
      }
    }
  }

  /**
   * Generate an input field for tabbed container.
   *
   * @param array $args   Data used to individualize input fields and get input value.
   *
   * @since 0.0.1
   */
  public function add_input( $args ) {
    $field  = $args['field'];
    $key    = $args['key'];
    $option = $args['option'];

    $id    = $field . '_' . $key;
    $value = isset( $option[ $field ] ) ? $option[ $field ] : '';

    // Generate the markup for the input field.
    $input .= '<input class="regular-text" type="text" ';
    $input .= 'name="gpalab-slo-settings[' . $key . '][' . $field . ']" ';
    $input .= 'id="' . $id . '" ';
    $input .= 'value="' . $value . '" >';

    // Identify which HTML elements to allow.
    $elements = array(
      'input' => array(
        'class' => array(),
        'id'    => array(),
        'name'  => array(),
        'type'  => array(),
        'value' => array(),
      ),
    );

    // Sanitize the input field before rendering on the settings page.
    echo wp_kses( $input, $elements );
  }

  /**
   * Generate a set of radio buttons to toggle the links display type.
   *
   * @param array $args   Data used to individualize input fields and get input value.
   *
   * @since 0.0.1
   */
  public function add_type_toggle( $args ) {
    $field  = $args['field'];
    $key    = $args['key'];
    $option = $args['option'];

    $id      = $field . '_' . $key;
    $checked = isset( $option[ $field ] ) ? $option[ $field ] : 'grid';

    // Generate the markup for the type toggle field.
    $input  = '<div class="gpalab-slo-type-toggle">';
    $input .= '<label for="' . $id . '_grid">';
    $input .= '<input type="radio" ';
    $input .= 'name="gpalab-slo-settings[' . $key . '][' . $field . ']" ';
    $input .= 'id="' . $id . '_grid" ';
    $input .= ( 'grid' === $checked ) ? 'checked ' : '';
    $input .= 'value="grid" >';
    $input .= 'Three column grid</label>';
    $input .= '<label for="' . $id . '_list">';
    $input .= '<input type="radio" ';
    $input .= 'name="gpalab-slo-settings[' . $key . '][' . $field . ']" ';
    $input .= 'id="' . $id . '_list" ';
    $input .= ( 'list' === $checked ) ? 'checked ' : '';
    $input .= 'value="list" >';
    $input .= 'Vertical list</label>';
    $input .= '</div>';

    // Identify which HTML elements to allow.
    $elements = array(
      'div'   => array(
        'class' => array(),
      ),
      'input' => array(
        'checked' => array(),
        'class'   => array(),
        'id'      => array(),
        'name'    => array(),
        'type'    => array(),
        'value'   => array(),
      ),
      'label' => array(
        'for' => array(),
      ),
    );

    // Sanitize the input field before rendering on the settings page.
    echo wp_kses( $input, $elements );
  }

  /**
   * Adaptation of the WordPress native do_settings_sections function.
   * Renders the sections wrapped in a section element with the appropriate classes.
   *
   * @param string $page  Slug title of the admin page whose settings fields you want to show.
   *
   * @since 0.0.1
   */
  private function custom_do_settings_sections( $page ) {
    global $wp_settings_sections, $wp_settings_fields;

    if ( ! isset( $wp_settings_sections[ $page ] ) ) {
      return;
    }

    foreach ( (array) $wp_settings_sections[ $page ] as $key => $section ) {
      echo '<section class="gpalab-slo-tabpanel" id=' . esc_attr( $key ) . ' role="tabpanel">';

      if ( $section['callback'] ) {
        call_user_func( $section['callback'], $section );
      }

      if ( ! isset( $wp_settings_fields ) || ! isset( $wp_settings_fields[ $page ] ) || ! isset( $wp_settings_fields[ $page ][ $section['id'] ] ) ) {
          continue;
      }

      $missions = get_option( 'gpalab-slo-settings' );

      // Extract the mission index and id from the section id.
      $index = str_replace( 'gpalab-slo-settings-', '', $key );
      $id    = $missions[ $index ]['id'];

      // Hidden input field to store the mission id.
      echo '<input type="hidden" name=' . esc_attr( 'gpalab-slo-settings[' . $index . '][id]' ) . ' value=' . esc_attr( $id ) . '>';

      // Render out all the input fields.
      $this->custom_do_settings_fields( $page, $section['id'] );

      // Button to remove the current section from the settings array.
      echo '<button class="button button-secondary slo-remove-mission" data-id=' . esc_attr( $id ) . ' type="button">Remove This Mission</button>';

      echo '</section>';
    }
  }

  /**
   * Adaptation of the WordPress native do_settings_fields function.
   * Renders the fields wrapped in a label with the appropriate classes.
   *
   * @param string $page     Slug title of the admin page whose settings fields you want to show.
   * @param string $section  Slug title of the settings section whose fields you want to show.
   *
   * @since 0.0.1
   */
  private function custom_do_settings_fields( $page, $section ) {
    global $wp_settings_fields;

    if ( ! isset( $wp_settings_fields[ $page ][ $section ] ) ) {
        return;
    }

    foreach ( (array) $wp_settings_fields[ $page ][ $section ] as $field ) {
      $class = 'gpalab-slo-label';

      if ( ! empty( $field['args']['class'] ) ) {
        $class = 'gpalab-slo-label ' . esc_attr( $field['args']['class'] );
      }

      echo '<label class=' . esc_attr( $class ) . ' for="' . esc_attr( $field['args']['label_for'] ) . '" >';
      echo esc_attr( $field['title'] );
      call_user_func( $field['callback'], $field['args'] );
      echo '</label>';
    }
  }

  /**
   * Adds a link to the plugin's settings page on the Installed Plugins page.
   *
   * @param array $links  List of plugin action links.
   * @return array        List of plugin action links with added settings link.
   */
  public function add_settings_link( $links ) {
    $query_params = array(
      'post_type' => 'gpalab-social-link',
      'page'      => 'gpalab-slo-settings',
    );

    // Build and escape the settings page URL.
    $url = esc_url(
      add_query_arg(
        $query_params,
        get_admin_url() . 'edit.php'
      )
    );

    // Write the link HTML.
    $settings_link = "<a href='$url'>" . __( 'Settings', 'gpalab-slo' ) . '</a>';

    // Add the Settings link to the beginning of the plugins list of action links.
    array_unshift(
      $links,
      $settings_link
    );

    return $links;
  }
}
