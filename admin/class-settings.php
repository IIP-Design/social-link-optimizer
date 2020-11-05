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
  private $gpalab_slo_settings_options;

  public function gpalab_slo_settings_add_plugin_page() {
    add_submenu_page(
      'edit.php?post_type=gpalab-social-link',
      'Social Links settings', // page_title
      'Settings', // menu_title
      'manage_options', // capability
      'gpalab-slo-settings', // menu_slug
      array( $this, 'gpalab_slo_settings_create_admin_page' ), // function
      null
    );
  }

  public function gpalab_slo_settings_create_admin_page() {
    $this->gpalab_slo_settings_options = get_option( 'gpalab_slo_settings_option_name' ); ?>

    <div class="wrap">
      <h2>Social Links settings</h2>
      <p>Configure the social links page.</p>
      <?php settings_errors(); ?>

      <form method="post" action="options.php">
        <?php
          settings_fields( 'gpalab_slo_settings_option_group' );
          do_settings_sections( 'gpalab-slo-settings-admin' );
          submit_button();
        ?>
      </form>
    </div>
  <?php }

  public function gpalab_slo_settings_page_init() {
    register_setting(
      'gpalab_slo_settings_option_group', // option_group
      'gpalab_slo_settings_option_name', // option_name
      array( $this, 'gpalab_slo_settings_sanitize' ) // sanitize_callback
    );

    /**
     * Sections
     */
    add_settings_section(
      'gpalab_slo_settings_identity_section', // id
      'Header Information', // title
      array( $this, 'gpalab_slo_identity_settings_section_info' ), // callback
      'gpalab-slo-settings-admin' // page
    );

    add_settings_section(
      'gpalab_slo_settings_layout_section', // id
      'Layout', // title
      array( $this, 'gpalab_slo_layout_settings_section_info' ), // callback
      'gpalab-slo-settings-admin' // page
    );

    add_settings_section(
      'gpalab_slo_settings_social_accts_section', // id
      'Social Media', // title
      array( $this, 'gpalab_slo_social_accts_settings_section_info' ), // callback
      'gpalab-slo-settings-admin' // page
    );

    /**
     * Fields
     */
    add_settings_field(
      'gpalab_slo_logo', // id
      'Logo:', // title
      array( $this, 'mission_identity_logo_callback' ), // callback
      'gpalab-slo-settings-admin', // page
      'gpalab_slo_settings_identity_section' // section
    );

    add_settings_field(
      'gpalab_slo_mission_title', // id
      'Name:', // title
      array( $this, 'mission_identity_name_callback' ), // callback
      'gpalab-slo-settings-admin', // page
      'gpalab_slo_settings_identity_section', // section
      array( 'label_for' => 'gpalab_slo_mission_title' )
    );

    add_settings_field(
      'gpalab_slo_mission_website', // id
      'Website URL:', // title
      array( $this, 'mission_identity_web_url_callback' ), // callback
      'gpalab-slo-settings-admin', // page
      'gpalab_slo_settings_identity_section', // section
      array( 'label_for' => 'gpalab_slo_mission_website' )
    );

    add_settings_field(
      'display_gpalab_slo_as_a_0', // id
      'Display social links as a:', // title
      array( $this, 'display_gpalab_slo_as_a_0_callback' ), // callback
      'gpalab-slo-settings-admin', // page
      'gpalab_slo_settings_layout_section' // section
    );

    add_settings_field(
      'facebook_page_1', // id
      'Facebook page:', // title
      array( $this, 'facebook_page_1_callback' ), // callback
      'gpalab-slo-settings-admin', // page
      'gpalab_slo_settings_social_accts_section', // section
      array( 'label_for' => 'facebook_page_1' ) // args
    );

    add_settings_field(
      'linkedin_profile_2', // id
      'LinkedIn profile:', // title
      array( $this, 'linkedin_profile_2_callback' ), // callback
      'gpalab-slo-settings-admin', // page
      'gpalab_slo_settings_social_accts_section', // section
      array( 'label_for' => 'linkedin_profile_2' ) // args
    );

    add_settings_field(
      'twitter_feed_3', // id
      'Twitter feed:', // title
      array( $this, 'twitter_feed_3_callback' ), // callback
      'gpalab-slo-settings-admin', // page
      'gpalab_slo_settings_social_accts_section', // section
      array( 'label_for' => 'twitter_feed_3' ) // args
    );

    add_settings_field(
      'youtube_channel_4', // id
      'YouTube channel:', // title
      array( $this, 'youtube_channel_4_callback' ), // callback
      'gpalab-slo-settings-admin', // page
      'gpalab_slo_settings_social_accts_section', // section
      array( 'label_for' => 'youtube_channel_4' ) // args
    );

    add_settings_field(
      'instagram_feed_5', // id
      'Instagram feed:', // title
      array( $this, 'instagram_feed_5_callback' ), // callback
      'gpalab-slo-settings-admin', // page
      'gpalab_slo_settings_social_accts_section', // section
      array( 'label_for' => 'instagram_feed_5' ) // args
    );
  }

  public function gpalab_slo_identity_settings_section_info() {
    echo '<p>The following information will be displayed in the social links page header.</p>';
  }
  public function gpalab_slo_layout_settings_section_info() {}
  public function gpalab_slo_social_accts_settings_section_info() {
    echo '<p>Enter URLs below to display social media icons on the social links page.</p>';
  }

  public function gpalab_slo_settings_sanitize( $input ) {
    $sanitary_values = array();
    if ( isset( $input['gpalab_slo_logo'] ) ) {
      $sanitary_values['gpalab_slo_logo'] = $input['gpalab_slo_logo'];
    }

    if ( isset( $input['gpalab_slo_mission_title'] ) ) {
      $sanitary_values['gpalab_slo_mission_title'] = $input['gpalab_slo_mission_title'];
    }

    if ( isset( $input['gpalab_slo_mission_website'] ) ) {
      $sanitary_values['gpalab_slo_mission_website'] = $input['gpalab_slo_mission_website'];
    }

    if ( isset( $input['display_gpalab_slo_as_a_0'] ) ) {
      $sanitary_values['display_gpalab_slo_as_a_0'] = $input['display_gpalab_slo_as_a_0'];
    }

    if ( isset( $input['facebook_page_1'] ) ) {
      $sanitary_values['facebook_page_1'] = sanitize_text_field( $input['facebook_page_1'] );
    }

    if ( isset( $input['linkedin_profile_2'] ) ) {
      $sanitary_values['linkedin_profile_2'] = sanitize_text_field( $input['linkedin_profile_2'] );
    }

    if ( isset( $input['twitter_feed_3'] ) ) {
      $sanitary_values['twitter_feed_3'] = sanitize_text_field( $input['twitter_feed_3'] );
    }

    if ( isset( $input['youtube_channel_4'] ) ) {
      $sanitary_values['youtube_channel_4'] = sanitize_text_field( $input['youtube_channel_4'] );
    }

    if ( isset( $input['instagram_feed_5'] ) ) {
      $sanitary_values['instagram_feed_5'] = sanitize_text_field( $input['instagram_feed_5'] );
    }

    return $sanitary_values;
  }

  public function mission_identity_logo_callback() {
    ?>
      <?php
        $image_url = ( isset( $this->gpalab_slo_settings_options['gpalab_slo_logo'] ) )
          ? esc_attr( $this->gpalab_slo_settings_options['gpalab_slo_logo'] )
          : '' ;
        $mission_title = isset( $this->gpalab_slo_settings_options['gpalab_slo_mission_title'] )
          ? esc_attr( $this->gpalab_slo_settings_options['gpalab_slo_mission_title'] ) . ' logo'
          : 'mission logo';
      ?>
      <div class="gpalab-slo-identify-logo-wrapper" style="display: grid; place-content: center; height: 150px; width: 150px; margin-bottom: 16px; padding: 16px; overflow: hidden; background-color: #e6e6e6;">
        <img src="<?php echo $image_url ?>" id="gpalab-slo-identity-logo" alt="<?php echo $mission_title; ?>" style="display: block; height: auto; max-width: 100%; margin: auto;">
      </div>

      <input type="hidden" id="gpalab-slo-identity-input" name="gpalab_slo_settings_option_name[gpalab_slo_logo]" value="<?php echo $image_url; ?>">

      <button type="button" id="gpalab-slo-identity-logo-btn" class="button-primary">Select logo</button>

      <?php
      if ( '' !== $image_url ) {
      ?>
        <button type="button" id="gpalab-slo-identity-remove-logo-btn" class="button-secondary">Remove logo</button>
      <?php
      }
  }

  public function mission_identity_name_callback() {
    printf(
      '<input class="regular-text" type="text" name="gpalab_slo_settings_option_name[gpalab_slo_mission_title]" id="gpalab_slo_mission_title" value="%s">',
      isset( $this->gpalab_slo_settings_options['gpalab_slo_mission_title'] ) ? esc_attr( $this->gpalab_slo_settings_options['gpalab_slo_mission_title']) : ''
    );
  }

  public function mission_identity_web_url_callback() {
    printf(
      '<input class="regular-text" type="text" name="gpalab_slo_settings_option_name[gpalab_slo_mission_website]" id="gpalab_slo_mission_website" value="%s">',
      isset( $this->gpalab_slo_settings_options['gpalab_slo_mission_website'] ) ? esc_attr( $this->gpalab_slo_settings_options['gpalab_slo_mission_website']) : ''
    );
  }

  public function display_gpalab_slo_as_a_0_callback() {
    ?> <fieldset><?php $checked = ( isset( $this->gpalab_slo_settings_options['display_gpalab_slo_as_a_0'] ) && $this->gpalab_slo_settings_options['display_gpalab_slo_as_a_0'] === 'grid' ) ? 'checked' : '' ; ?>
    <label for="display_gpalab_slo_as_a_0-0"><input type="radio" name="gpalab_slo_settings_option_name[display_gpalab_slo_as_a_0]" id="display_gpalab_slo_as_a_0-0" value="grid" <?php echo $checked; ?>> Three column grid</label><br>
    <?php $checked = ( isset( $this->gpalab_slo_settings_options['display_gpalab_slo_as_a_0'] ) && $this->gpalab_slo_settings_options['display_gpalab_slo_as_a_0'] === 'list' ) ? 'checked' : '' ; ?>
    <label for="display_gpalab_slo_as_a_0-1"><input type="radio" name="gpalab_slo_settings_option_name[display_gpalab_slo_as_a_0]" id="display_gpalab_slo_as_a_0-1" value="list" <?php echo $checked; ?>> Vertical list</label></fieldset> <?php
  }

  public function facebook_page_1_callback() {
    printf(
      '<input class="regular-text" type="text" name="gpalab_slo_settings_option_name[facebook_page_1]" id="facebook_page_1" value="%s">',
      isset( $this->gpalab_slo_settings_options['facebook_page_1'] ) ? esc_attr( $this->gpalab_slo_settings_options['facebook_page_1']) : ''
    );
  }

  public function linkedin_profile_2_callback() {
    printf(
      '<input class="regular-text" type="text" name="gpalab_slo_settings_option_name[linkedin_profile_2]" id="linkedin_profile_2" value="%s">',
      isset( $this->gpalab_slo_settings_options['linkedin_profile_2'] ) ? esc_attr( $this->gpalab_slo_settings_options['linkedin_profile_2']) : ''
    );
  }

  public function twitter_feed_3_callback() {
    printf(
      '<input class="regular-text" type="text" name="gpalab_slo_settings_option_name[twitter_feed_3]" id="twitter_feed_3" value="%s">',
      isset( $this->gpalab_slo_settings_options['twitter_feed_3'] ) ? esc_attr( $this->gpalab_slo_settings_options['twitter_feed_3']) : ''
    );
  }

  public function youtube_channel_4_callback() {
    printf(
      '<input class="regular-text" type="text" name="gpalab_slo_settings_option_name[youtube_channel_4]" id="youtube_channel_4" value="%s">',
      isset( $this->gpalab_slo_settings_options['youtube_channel_4'] ) ? esc_attr( $this->gpalab_slo_settings_options['youtube_channel_4']) : ''
    );
  }

  public function instagram_feed_5_callback() {
    printf(
      '<input class="regular-text" type="text" name="gpalab_slo_settings_option_name[instagram_feed_5]" id="instagram_feed_5" value="%s">',
      isset( $this->gpalab_slo_settings_options['instagram_feed_5'] ) ? esc_attr( $this->gpalab_slo_settings_options['instagram_feed_5'] ) : ''
    );
  }

  /**
   * Enqueue media uploader script.
   *
   * @since 0.0.1
   */
  public function gpalab_slo_media_uploader_scripts() {
    wp_enqueue_media();
    wp_register_script(
      'social-bio-links',
      GPALAB_SLO_URL . 'admin/js/gpalab-slo-media-uploader.js',
      array( 'jquery' ),
      $version
    );
    wp_enqueue_script( 'social-bio-links' );
  }
}
