<?php
/**
 * Cherry Wizard and Cherry Data Manager add-ons.
 */

// Assign register plugins function to appropriate filter.
add_filter( 'cherry_theme_required_plugins',     'cherry_child_register_plugins' );

// Assign options filter to apropriate filter.
add_filter( 'cherry_data_manager_export_options', 'cherry_child_options_to_export' );

// Assign option id's filter to apropriate filter.
add_filter( 'cherry_data_manager_options_ids',    'cherry_child_options_ids' );

// Assign cherry_child_menu_meta to aproprite filter.
add_filter( 'cherry_data_manager_menu_meta',      'cherry_child_menu_meta' );

// Customize a cherry shortcodes.
add_filter( 'custom_cherry4_shortcodes', '__return_true' );

/**
 * Register required plugins for theme.
 *
 * Plugins registered by this function will be automatically installed by Cherry Wizard.
 *
 * Notes:
 * - Slug parameter must be the same with plugin key in array
 * - Source parameter supports 3 possible values:
 *   a) cherry    - plugin will be downloaded from cherry plugins repository
 *   b) wordpress - plugin will be downloaded from wordpress.org repository
 *   c) path      - plugin will be downloaded by provided path
 *
 * @param  array $plugins Default array of required plugins (empty).
 * @return array          New array of required plugins.
 */

// Add custom child theme assets
add_action( 'wp_enqueue_scripts', 'theme3706_theme_assets' );
/*
 * Include custom assets
 */
function theme3706_theme_assets() {
	wp_enqueue_script( 'theme3706_script', get_stylesheet_directory_uri() . '/assets/js/my_script.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', '', '4.3' );
}

// comment form

add_filter('comment_form_defaults', 'theme3706_modify_comment_form');
function theme3706_modify_comment_form($arg) {
    
 $commenter = wp_get_current_commenter();
 $req = get_option( 'require_name_email' );
 $aria_req = ( $req ? " aria-required='true'" : '' );

 //$arg['title_reply'] = __( 'Leave a Comment', 'theme3706' );
 //$arg['label_submit'] = __( 'Send', 'theme3706' );
 $arg['fields']['author'] = '<p class="comment-form-author"><input id="author" name="author" type="text" placeholder="' . __( 'Name*', 'theme3706' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />';
 $arg['fields']['email'] = '<p class="comment-form-email"><input id="email" name="email" type="email"  placeholder="' . __( 'Email (will not be published)*', 'theme3706' ) . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-describedby="email-notes"' . $aria_req . ' /></p>';
 $arg['fields']['url'] =  '<p class="comment-form-url"><input id="url" name="url" type="url" placeholder="' . __( 'Website', 'theme3706' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>';
 $arg['comment_field'] = '<p class="comment-form-comment"><textarea id="comment" name="comment" placeholder="' . __( 'Your Comment', 'theme3706' ) . '" cols="45" rows="8" aria-describedby="form-allowed-tags" aria-required="true" required="required"></textarea></p>';

    return $arg;
}

// end comment form


// footer info

add_filter( 'cherry_default_footer_info_format', 'theme3706_footer_info_format' );

function theme3706_footer_info_format(){
	return '%2$s &copy; %1$s '. __('All Rights Reserved', 'theme3706').' <span>|</span> %3$s';
}

// end footer info

// Breadcrumbs

add_action( 'init', 'cherryone_replace_breadcrumbs' );
function cherryone_replace_breadcrumbs() {
	remove_action( 'cherry_content_before', 'cherry_get_breadcrumbs', 5 );
	add_action( 'cherry_header', 'cherry_get_breadcrumbs', 99 );
}

add_filter( 'cherry_breadcrumbs_custom_args',      'theme3706_breadcrumbs_custom_wrapper' );

function theme3706_breadcrumbs_custom_wrapper($arg){
	$arg['wrapper_format'] = '<div class="row cherry-breadcrumbs-holder">
		<div class="container">
			<div class="col-md-12 col-sm-12 col-xs-12">%s</div>
			<div class="col-md-12 col-sm-12 col-xs-12">%s</div>
		</div>
	</div>';

	return $arg;
}

// End Breadcrumbs

add_shortcode( 'template_url', 'url_template_shortcode' );
function url_template_shortcode( $atts ) {
 return get_bloginfo('url');
}


function cherry_child_register_plugins( $plugins ) {

	$plugins = array(
		'contact-form-7' => array(
			'name'   => 'Contact Form 7',
			'slug'   => 'contact-form-7',
			'source' => 'wordpress',
		),
		'cherry-shortcodes' => array(
			'name'   => 'Cherry Shortcodes',
			'slug'   => 'cherry-shortcodes',
			'source' => 'cherry-free',
		),
		'cherry-shortcodes-templater' => array(
			'name'   => 'Cherry shortcodes templater',
			'slug'   => 'cherry-shortcodes-templater',
			'source' => 'cherry-free',
		),
		'cherry-portfolio' => array(
			'name'   => 'Cherry portfolio',
			'slug'   => 'cherry-portfolio',
			'source' => 'cherry-free',
		),
		'cherry-testimonials' => array(
			'name'   => 'Cherry testimonials',
			'slug'   => 'cherry-testimonials',
			'source' => 'cherry-free',
		),
		'cherry-team' => array(
			'name'   => 'Cherry team',
			'slug'   => 'cherry-team',
			'source' => 'cherry-free',
		),
		'cherry-mega-menu' => array(
			'name'   => 'Cherry Mega Menu',
			'slug'   => 'cherry-mega-menu',
			'source' => 'cherry-free',
		),
		'motopress-cherryframework4' => array(
			'name'   => 'MotoPress and CherryFramework 4 Integration',
			'slug'   => 'motopress-cherryframework4',
			'source' => 'cherry-free',
		),
		'motopress-content-editor' => array(
			'name'   => 'Motopress content editor',
			'slug'   => 'motopress-content-editor',
			'source' => 'cherry-premium',
		),
	);

	return $plugins;
}

// Register plugin for TGM activator.
require_once get_stylesheet_directory() . '/inc/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'cherry_child_tgmpa_register' );
function cherry_child_tgmpa_register() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 */
	$plugins = array(
		array(
			'name'     => 'Contact Form 7',
			'slug'     => 'contact-form-7',
			'required' => true,
		),
		array(
			'name'     => 'Cherry Testimonials',
			'slug'     => 'cherry-testimonials',
			'source'   => 'cherry-free',
			'required' => true,
		),
		array(
			'name'     => 'Cherry Team',
			'slug'     => 'cherry-team',
			'source'   => 'cherry-free',
			'required' => true,
		),
		array(
			'name'     => 'Cherry Shortcodes Templater',
			'slug'     => 'cherry-shortcodes-templater',
			'source'   => 'cherry-free',
			'required' => true,
		),
		array(
			'name'     => 'Cherry Shortcodes',
			'slug'     => 'cherry-shortcodes',
			'source'   => 'cherry-free',
			'required' => true,
		),
		array(
			'name'     => 'Cherry Portfolio',
			'slug'     => 'cherry-portfolio',
			'source'   => 'cherry-free',
			'required' => true,
		),
		array(
			'name'     => 'Cherry Mega Menu',
			'slug'     => 'cherry-mega-menu',
			'source'   => 'cherry-free',
			'required' => true,
		),
		array(
			'name'     => 'MotoPress CherryFramework4',
			'slug'     => 'motopress-cherryframework4',
			'source'   => 'cherry-free',
			'required' => true,
		),
		array(
			'name'         => 'Motopress content editor',
			'slug'         => 'motopress-content-editor',
			'source'       => CHILD_DIR . '/assets/includes/plugins/motopress-content-editor.zip',
			'required'     => true,
		),
	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 */
	$config = array(
		'default_path' => '',                      // Default absolute path to pre-packaged plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'tgmpa' ),
			'menu_title'                      => __( 'Install Plugins', 'tgmpa' ),
			'installing'                      => __( 'Installing Plugin: %s', 'tgmpa' ), // %s = plugin name.
			'oops'                            => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
			'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
			'return'                          => __( 'Return to Required Plugins Installer', 'tgmpa' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'tgmpa' ),
			'complete'                        => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
			'nag_type'                        => 'updated'
		)
	);

	tgmpa( $plugins, $config );

}

/**
 * Pass own options to export (for example if you use thirdparty plugin and need to export some default options).
 *
 * WARNING #1
 * You should NOT totally overwrite $options_ids array with this filter, only add new values.
 *
 * @param  array $options Default options to export.
 * @return array          Filtered options to export.
 */
function cherry_child_options_to_export( $options ) {

	/**
	 * Example:
	 *
	 * $options[] = 'woocommerce_default_country';
	 * $options[] = 'woocommerce_currency';
	 * $options[] = 'woocommerce_enable_myaccount_registration';
	 */

	return $options;
}

/**
 * Pass some own options (which contain page ID's) to export function,
 * if needed (for example if you use thirdparty plugin and need to export some default options).
 *
 * WARNING #1
 * With this filter you need pass only options, which contain page ID's and it's would be rewrited with new ID's on import.
 * Standrd options should passed via 'cherry_data_manager_export_options' filter.
 *
 * WARNING #2
 * You should NOT totally overwrite $options_ids array with this filter, only add new values.
 *
 * @param  array $options_ids Default array.
 * @return array              Result array.
 */
function cherry_child_options_ids( $options_ids ) {

	/**
	 * Example:
	 *
	 * $options_ids[] = 'woocommerce_cart_page_id';
	 * $options_ids[] = 'woocommerce_checkout_page_id';
	 */

	return $options_ids;
}

/**
 * Pass additional nav menu meta atts to import function.
 *
 * By default all nav menu meta fields are passed to XML file,
 * but on import processed only default fields, with this filter you can import your own custom fields.
 *
 * @param  array $extra_meta Ddditional menu meta fields to import.
 * @return array             Filtered meta atts array.
 */
function cherry_child_menu_meta( $extra_meta ) {

	/**
	 * Example:
	 *
	 * $extra_meta[] = '_cherry_megamenu';
	 */

	return $extra_meta;
}