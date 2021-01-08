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
      'gpalab_slo_manage_settings',
      'gpalab-slo-settings',
      function() {
        return $this->create_admin_page();
      },
      null
    );

    register_setting(
      'gpalab-slo',
      'gpalab-slo-settings',
      array(
        'sanitize_callback' => array( $this, 'sanitize_option_values' ),
      )
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

    wp_enqueue_media();
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
      <h1 class="wp-heading-inline"><?php esc_html_e( 'Social Link Settings', 'gpalab-slo' ); ?></h1>
      <button class="page-title-action" id="slo-add-mission" type="button">
        <?php esc_html_e( 'Add a Mission', 'gpalab-slo' ); ?>
      </button>
      <?php
      settings_errors();

      $missions    = get_option( 'gpalab-slo-settings' );
      $title       = __( 'Manage Mission Social Link Pages:', 'gpalab-slo' );
      $no_missions = __( 'No missions have been added.', 'gpalab-slo' );

      // Create the tabs for the tabbed container.
      if ( isset( $missions ) ) {
        echo '<h2>' . esc_html( $title ) . '</h2>';
        echo '<ul class="gpalab-slo-tab-container" role="tablist">';

        if ( empty( $missions ) ) {
          echo '<p>' . esc_html( $no_missions ) . '</p>';
        }

        foreach ( $missions as $key => $mission ) {
          ?>
          <li class="gpalab-slo-tab" role="presentation" >
            <a
              class="gpalab-slo-tab-button"
              href=<?php echo esc_attr( '#gpalab-slo-tab-' . $key ); ?>
              id=<?php echo esc_attr( 'gpalab-slo-tab-' . $key ); ?>
              data-id=<?php echo esc_attr( $key ); ?>
              role="tab"
              <?php echo empty( $mission['title'] ) ? 'style="font-style: italic;"' : ''; ?>
            >
              <?php
              if ( ! empty( $mission['title'] ) ) {
                echo esc_html( $mission['title'] );
              } else {
                echo esc_html__( 'untitled', 'gpalab-slo' );
              }
              ?>
            </a>
          </li>
          <?php
        }

        echo '</ul>';
      }
      ?>
    <form id="post" method="post" action="options.php">
        <?php
          settings_fields( 'gpalab-slo' );
          $this->custom_do_settings_sections( 'gpalab-slo' );
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

    if ( isset( $missions ) ) {

      foreach ( $missions as $key => $mission ) {
        add_settings_section(
          'gpalab-slo-settings-' . $key,
          __( 'Manage Mission Social Link Pages:', 'gpalab-slo' ),
          function() {
            return $this->generate_tab_panels();
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
          __( 'Mission name (used as page title):', 'gpalab-slo' ),
          array( $this, 'add_input' ),
          'gpalab-slo',
          'gpalab-slo-settings-' . $key,
          array(
            'label_for'   => $title_id,
            'key'         => $key,
            'field'       => 'title',
            'option'      => $mission,
            'placeholder' => 'Add Mission Title',
            'required'    => true,
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
    $field       = $args['field'];
    $key         = $args['key'];
    $option      = $args['option'];
    $placeholder = ! empty( $args['placeholder'] ) ? 'placeholder="' . $args['placeholder'] . '" ' : '';
    $type        = ! empty( $args['type'] ) ? $args['type'] : 'text';

    $id    = $field . '_' . $key;
    $value = isset( $option[ $field ] ) ? $option[ $field ] : '';

    // Generate the markup for the input field.
    ?>
    <input
      id=<?php echo esc_attr( $id ); ?>
      name=<?php echo esc_attr( 'gpalab-slo-settings[' . $key . '][' . $field . ']' ); ?>
      <?php echo wp_kses( $placeholder, 'post' ); ?>
      <?php echo true === $args['required'] ? 'required ' : ''; ?>
      type=<?php echo esc_attr( $type ); ?>
      value="<?php echo esc_attr( $value ); ?>"
    >
    <?php
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
    ?>
    <div class="gpalab-slo-type-toggle">
      <label for=<?php echo esc_attr( $id . '_grid' ); ?>>
        <input
          <?php echo ( 'grid' === $checked ? 'checked ' : '' ); ?>
          id=<?php echo esc_attr( $id . '_grid' ); ?>
          name=<?php echo esc_attr( 'gpalab-slo-settings[' . $key . '][' . $field . ']' ); ?>
          type="radio"
          value="grid"
        >
          <?php echo esc_html__( 'Three column grid', 'gpalab-slo' ); ?>
        </label>
        <label for=<?php echo esc_attr( $id . '_list' ); ?>>
          <input
            <?php echo ( 'list' === $checked ? 'checked ' : '' ); ?>
            id=<?php echo esc_attr( $id . '_list' ); ?>
            name=<?php echo esc_attr( 'gpalab-slo-settings[' . $key . '][' . $field . ']' ); ?>
            type="radio"
            value="list"
          >
        <?php echo esc_html__( 'Vertical list', 'gpalab-slo' ); ?>
      </label>
    </div>
    <?php
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

      // Render out link to the mission's SLO page.
      if ( isset( $missions[ $index ]['page'] ) ) {
        $post_id = esc_html( $missions[ $index ]['page'] );
        $link    = get_permalink( $post_id );

        $link_text = __( 'Social link optimizer page created at', 'gpalab-slo' );
        $details   = __( 'You can configure the page using the fields below. Use the "Change permalink" field below to change the page URL.', 'gpalab-slo' );

        ?>
        <p class="gpalab-slo-tabpanel-text">
          <?php echo esc_html( $link_text ); ?>:
            <a href="<?php echo esc_url( $link, array( 'http', 'https' ) ); ?>">
              <?php echo esc_url( $link, array( 'http', 'https' ) ); ?>
            </a>.
          </br>
          <?php echo esc_html( $details ); ?>
        </p>
        <?php
      }

      // Hidden input field to store the mission id.
      ?>
      <input
        name=<?php echo esc_attr( 'gpalab-slo-settings[' . $index . '][id]' ); ?>
        type="hidden"
        value=<?php echo esc_attr( $id ); ?>
      >
      <input
        name=<?php echo esc_attr( 'gpalab-slo-settings[' . $index . '][page]' ); ?>
        type="hidden"
        value=<?php echo esc_attr( $post_id ); ?>
      >
      <?php

      // Render out all the input fields.
      $this->custom_do_settings_fields( $page, $section['id'] );

      // Render out media uploader to set the mission avatar.
      $this->render_avatar_uploader( $missions[ $index ], $index, $id );

      // Render out the Add Mission & Submit buttons.
      ?>
      <div class="gpalab-slo-settings-form-controls">
        <?php
          submit_button(
            __( 'Save Changes', 'gpalab-slo' ),
            'primary',
            'submit',
            true,
            array( 'id' => 'slo-submit-' . $id )
          );
        ?>
      </div>
      <?php

      // Render out the danger section.
      $this->render_danger_section( $id, $post_id );

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
   * Render out the section that allows users to upload an avatar image.
   * The selected image id is stored in a hidden field to be submitted when the page is updated.
   *
   * @param object $mission   The selected mission's data.
   * @param string $index     The position of the given mission in the list of missions.
   * @param string $id        The id of the current mission.
   *
   * @since 0.0.1
   */
  private function render_avatar_uploader( $mission, $index, $id ) {
    $avatar      = esc_html( $mission['avatar'] );
    $media_label = __( 'Mission avatar:', 'gpalab-slo' );

    // Change the text of the upload button if no value saved.
    $btn_text = empty( $mission['avatar'] ) || 'undefined' === $mission['avatar']
      ? __( 'Select an avatar image', 'gpalab-slo' )
      : __( 'Change avatar image', 'gpalab-slo' );

    $remove_style = empty( $mission['avatar'] ) || 'undefined' === $mission['avatar'] ? 'display:none' : 'display:block'

    ?>
    <input
      type="hidden"
      name=<?php echo esc_attr( 'gpalab-slo-settings[' . $index . '][avatar]' ); ?>
      id=<?php echo esc_attr( 'slo-avatar-' . $id ); ?>
      value="<?php echo esc_attr( $avatar ); ?>"
    />
    <label class="gpalab-slo-label" for=<?php echo esc_attr( 'slo-avatar-manager-' . $id ); ?>>
      <?php echo esc_html( $media_label ); ?>
      <div class="gpalab-slo-settings-avatar-controls">
        <?php
        $image = null;
        if ( intval( $avatar ) > 0 ) {
          $image = wp_get_attachment_image(
            $avatar,
            'thumbnail',
            false,
            array(
              'class' => 'gpalab-slo-avatar-preview',
              'id'    => 'slo-avatar-preview-' . $id,
            )
          );
        }

        echo wp_kses( $image, 'post' );
        ?>
        <p
          class="gpalab-slo-avatar-placeholder"
          id=<?php echo esc_attr( 'slo-avatar-placeholder-' . $id ); ?>
          style=<?php echo esc_attr( $avatar && 'undefined' !== $avatar ? 'display:none;' : 'display:block' ); ?>
        >
          <?php esc_html_e( 'No avatar added', 'gpalab-slo' ); ?>
        </p>
        <input
          type='button'
          class="button-secondary gpalab-slo-avatar-media-manager"
          data-id=<?php echo esc_attr( $id ); ?>
          id=<?php echo esc_attr( 'slo-avatar-manager-' . $id ); ?>
          value="<?php echo esc_attr( $btn_text ); ?>"
        />
        <button
          type='button'
          class="button-secondary gpalab-slo-avatar-remove"
          data-id=<?php echo esc_attr( $id ); ?>
          id=<?php echo esc_attr( 'slo-avatar-remove-' . $id ); ?>
          style=<?php echo esc_attr( $remove_style ); ?>
        />
          <?php esc_attr_e( 'Remove avatar image', 'gpalab-slo' ); ?>
        </button>
      </div>
    </label>
    <?php
  }

  /**
   * Render out the section containing dangerous operations on the settings page.
   *
   * @param string $id        The id of the current mission.
   * @param string $post_id   The WordPress post id of the SLO page for the given mission.
   *
   * @since 0.0.1
   */
  private function render_danger_section( $id, $post_id ) {
    $title       = __( 'Danger Zone', 'gpalab-slo' );
    $warning     = __( 'Warning, altering the below settings can have destructive results. Proceed with caution.', 'gpalab-slo' );
    $perma_label = __( 'Change permalink:', 'gpalab-slo' );
    $perma_btn   = __( 'Update Permalink', 'gpalab-slo' );
    $remove_btn  = __( 'Remove This Mission', 'gpalab-slo' );

    ?>
    <hr class="gpalab-slo-hr">
    <strong class="gpalab-slo-danger"><?php echo esc_html( $title ); ?></strong>
    <p style="text-align:center"><?php echo esc_html( $warning ); ?></p>
    <label class="gpalab-slo-label-secondary" for=<?php echo esc_attr( 'permalink-' . $id ); ?>>
      <?php echo esc_html( $perma_label ); ?>
      <div>
        <input
          class="regular-text"
          id=<?php echo esc_attr( 'permalink-' . $id ); ?>
          name="permalink"
          type="text"
          value=<?php echo esc_attr( get_post_field( 'post_name', $post_id ) ); ?>
        >
        <button
          class="button button-secondary slo-permalink"
          data-id=<?php echo esc_attr( $id ); ?>
          data-post=<?php echo esc_attr( $post_id ); ?>
          type="button"
        >
          <?php echo esc_html( $perma_btn ); ?>
        </button>
      </div>
    </label>
    <!-- Button to remove the current section from the settings array. -->
    <button
      class="button button-link-delete slo-remove-mission"
      data-id=<?php echo esc_attr( $id ); ?>
      type="button"
    >
      <?php echo esc_html( $remove_btn ); ?>
    </button>
    <?php
  }

  /**
   * Adds a link to the plugin's settings page on the Installed Plugins page.
   *
   * @param array $links  List of plugin action links.
   * @return array        List of plugin action links with added settings link.
   *
   * @since 0.0.1
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

  /**
   * Sanitize the data provided in the mission settings page before saving to the DB.
   *
   * @param array $settings   A list of mission data objects to be sanitized.
   *
   * @since 0.0.1
   */
  public function sanitize_option_values( $settings ) {
    $sanitized_settings = array();

    if ( isset( $settings ) ) {
      foreach ( $settings as $setting ) {
        $sanitized = array();

        $sanitized['id']        = sanitize_text_field( $setting['id'] );
        $sanitized['page']      = sanitize_text_field( $setting['page'] );
        $sanitized['title']     = sanitize_text_field( $setting['title'] );
        $sanitized['website']   = $this->enforce_https( $setting['website'] );
        $sanitized['type']      = sanitize_text_field( $setting['type'] );
        $sanitized['facebook']  = $this->enforce_https( $setting['facebook'] );
        $sanitized['flickr']    = $this->enforce_https( $setting['flickr'] );
        $sanitized['instagram'] = $this->enforce_https( $setting['instagram'] );
        $sanitized['linkedin']  = $this->enforce_https( $setting['linkedin'] );
        $sanitized['twitter']   = $this->enforce_https( $setting['twitter'] );
        $sanitized['whatsapp']  = $this->enforce_https( $setting['whatsapp'] );
        $sanitized['youtube']   = $this->enforce_https( $setting['youtube'] );
        $sanitized['avatar']    = sanitize_text_field( $setting['avatar'] );

        array_push( $sanitized_settings, $sanitized );
      }
    }

    return $sanitized_settings;
  }

  /**
   * Ensures that a url uses https as the protocol and sanitizes it.
   *
   * @param string $url  The url string to be checked for https and sanitized.
   *
   * @since 0.0.1
   */
  public function enforce_https( $url ) {
    if ( empty( $url ) ) {

      return '';

    } elseif ( substr( $url, 0, 5 ) === 'https' ) {

      return esc_url_raw( $url, array( 'https' ) );

    } elseif ( substr( $url, 0, 5 ) === 'http:' ) {

      // Convert http to https.
      $https = str_replace( 'http:', 'https:', $url );
      return esc_url_raw( $https, array( 'https' ) );

    } else {

      // Add https if no protocol provided.
      return esc_url_raw( 'https://' . $url );

    }
  }
}
