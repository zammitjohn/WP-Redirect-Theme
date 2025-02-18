<?php

function wpr_admin_styles() {
    wp_enqueue_style( 'wpr-admin-styles', get_template_directory_uri() . '/assets/css/admin-styles.css' );
}
add_action( 'admin_enqueue_scripts', 'wpr_admin_styles' );


function wpr_theme_settings() {
	add_submenu_page(
		'options-general.php',                 // parent slug
		__('WP Redirect (Headless CMS) Settings', 'wp-redirect'), // page title
		__('Theme settings', 'wp-redirect'),   // menu title
		'manage_options',                      // capability
		'wp-redirect-theme-settings',          // menu slug
		'wpr_theme_settings_html'              // callback function to be called when rendering the page
	);
	add_action('admin_init', 'wpr_settings_init');
}
add_action('admin_menu', 'wpr_theme_settings');


function wpr_settings_init() {
	add_settings_section(
		'wpr-settings-section',                // id
		'',                                    // title
		'',                                    // callback function
		'wp-redirect-theme-settings'           // page
    );
    
    // option checkbox
    register_setting(
		'wp-redirect-theme-settings',          // option group
        'wpr-option-checkbox',                 // option name
        ''                                     // args
    );
    add_settings_field(
		'wpr-option-checkbox',                 // id
		__('Your homepage displays', 'wp-redirect'), // title
		'wpr_form_option_checkbox',            // callback function
		'wp-redirect-theme-settings',          // page
        'wpr-settings-section',                // section
        ''                                     // args
    );

    // redirect url section heading
	add_settings_field(
		'redirect-url-section-heading',        // id
		__('<hr /><h2>Redirect URL</h2>', 'wp-redirect'), // title
		'redirect_url_section_heading',        // callback function
		'wp-redirect-theme-settings',          // page
        'wpr-settings-section',                // section
        ''                                     // args
    );

    // redirect url
    register_setting(
		'wp-redirect-theme-settings',          // option group
        'redirect-url',                        // option name
        ''                                     // args
    );
	add_settings_field(
		'redirect-url',                        // id
		__('Redirect URL', 'wp-redirect'),     // title
		'wpr_form_redirect_url',               // callback function
		'wp-redirect-theme-settings',          // page
        'wpr-settings-section',                // section
        ''                                     // args
    );

    // index page section heading
	add_settings_field(
		'indexpage-section-heading',           // id
		__('<hr /><h2>Index page settings</h2>', 'wp-redirect'), // title
		'indexpage_section_heading',           // callback function
		'wp-redirect-theme-settings',          // page
        'wpr-settings-section',                // section
        ''                                     // args
    );

    // index page heading
    register_setting(
		'wp-redirect-theme-settings',          // option group
        'indexpage-heading',                   // option name
        ''                                     // args
    );
    add_settings_field(
		'indexpage-heading',                   // id
		__('Index page heading', 'wp-redirect'), // title
		'wpr_form_indexpage_heading',          // callback function
		'wp-redirect-theme-settings',          // page
        'wpr-settings-section',                // section
        ''                                     // args
    );
    
    // index page content
    register_setting(
		'wp-redirect-theme-settings',          // option group
        'indexpage-content',                   // option name
        ''                                     // args
    );
    add_settings_field(
		'indexpage-content',                   // id
		__('Index page content', 'wp-redirect'), // title
		'wpr_form_indexpage_content',          // callback function
		'wp-redirect-theme-settings',          // page
        'wpr-settings-section',                // section
        ''                                     // args
    );
    
    // index page footer
    register_setting(
		'wp-redirect-theme-settings',          // option group
        'indexpage-footer',                    // option name
        ''                                     // args
    );
    add_settings_field(
		'indexpage-footer',                    // id
		__('Index page footer', 'wp-redirect'), // title
		'wpr_form_indexpage_footer',           // callback function
		'wp-redirect-theme-settings',          // page
        'wpr-settings-section',                // section
        ''                                     // args
	);
}

function redirect_url_section_heading() { }
function indexpage_section_heading() { }

function wpr_form_option_checkbox() {
    ?>
    <input type="radio" name="wpr-option-checkbox" value="redirect" <?php checked( "redirect", get_option( 'wpr-option-checkbox' ) ); ?> /> Redirect to <?php echo esc_attr(get_option('redirect-url', '')); ?><br />
    <input type="radio" name="wpr-option-checkbox" value="indexpage" <?php checked( "indexpage", get_option( 'wpr-option-checkbox' ) ); ?> /> Index page
    <?php 
}

function wpr_form_redirect_url() {
    $url = esc_attr(get_option('redirect-url', '')); ?>
    <input class="wpr-input" type="url" name="redirect-url" value="<?php echo $url; ?>" />
    <?php
}

function wpr_form_indexpage_heading() {
    $textpageHeading = esc_attr(get_option('indexpage-heading', '')); ?>
    <input class="wpr-input" type="text" name="indexpage-heading" value="<?php echo $textpageHeading; ?>" />
    <?php
}

function wpr_form_indexpage_content() {
    $textpageContent = esc_attr(get_option('indexpage-content', '')); ?>
    <textarea class="wpr-textarea" name="indexpage-content"><?php echo $textpageContent; ?></textarea>
    <?php
}

function wpr_form_indexpage_footer() {
    $textpageFooter = esc_attr(get_option('indexpage-footer', '')); ?>
    <input class="wpr-input" type="text" name="indexpage-footer" value="<?php echo $textpageFooter; ?>" />
    <?php
}


function wpr_theme_settings_html() {
    ?>
    <div class="wrap">
        <h1><?php _e('WP Redirect (Headless CMS) Settings', 'wp-redirect');  ?></h1>
        <form method="POST" action="options.php">
            <?php settings_fields('wp-redirect-theme-settings');?>
            <?php do_settings_sections('wp-redirect-theme-settings')?>
            <?php submit_button(
                null,                          // text
                'primary',                     // type
                'submit',                      // name
                true,                          // wrap
                null                           // other attributes
            )?>
        </form>
        <p><em>Support the development of this and other web projects with <a href="https://paypal.me/PRStuhlmann/2">your donation</a>.</em></p>
    </div>
<?php
}
 

// Translation
function wpr_theme_setup(){
    load_theme_textdomain('wp-redirect',   get_template_directory() . '/assets/languages');
}
add_action('after_setup_theme', 'wpr_theme_setup');

// This theme uses post thumbnails
add_theme_support('post-thumbnails');
