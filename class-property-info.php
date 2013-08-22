<?php
/**
 * Plugin Name.
 *
 * @package   PropertyInfo
 * @author    Jonathan Rivera <jrivera@picernefl.com>
 * @license   GPL-2.0+
 * @link      http://picernerealestategroup.com
 * @copyright 2013 Picerne Real Estate Group
 */

/**
 *
 * @package PropertyInfo
 * @author  Jonathan Rivera <jrivera@picernefl.com>
 */
class PropertyInfo {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	protected $version = '1.0.0';

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'property-info';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Add the options page and menu item.
		 add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// Define custom functionality. Read more about actions and filters: http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		add_action( 'admin_init', array( $this,'preg_admin_init' ));  
		add_shortcode( 'prop-information', array( $this, 'prop_info_frontend' )); 
		add_action( 'TODO', array( $this, 'action_method_name' ) );
		add_filter( 'TODO', array( $this, 'filter_method_name' ) );

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate( $network_wide ) {
		// TODO: Define activation functionality here
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {
		// TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $screen->id == $this->plugin_screen_hook_suffix ) {
			wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'css/admin.css', __FILE__ ), array(), $this->version );
		}

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $screen->id == $this->plugin_screen_hook_suffix ) {
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery' ), $this->version );
		}

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'css/public.css', __FILE__ ), array(), $this->version );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'js/public.js', __FILE__ ), array( 'jquery' ), $this->version );
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		/*
		 * TODO:
		 *
		 * Change 'Page Title' to the title of your plugin admin page
		 * Change 'Menu Text' to the text for menu item for the plugin settings page
		 * Change 'plugin-name' to the name of your plugin
		 */
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Property Information', $this->plugin_slug ),
			__( 'Property Info', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once( 'views/admin.php' );
		
		add_action( 'admin_init', array( $this,'preg_admin_init' ));
	}

	/**
	 * NOTE:  Actions are points in the execution of a page or process
	 *        lifecycle that WordPress fires.
	 *
	 *        WordPress Actions: http://codex.wordpress.org/Plugin_API#Actions
	 *        Action Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 * @since    1.0.0
	 */
	public function action_method_name() {
		// TODO: Define your action hook callback here
	}
	
	
	

	public function preg_admin_init() {
	/*	register_setting( 'prop-contact-group', 'prop-contact-info' );
		add_settings_section( 'section-one', 'Property Contact Information', array( $this,'section_one_callback'), 'property-info' );
		add_settings_field( 'addr-ln-one', 'Address Line 1', array( $this,'addr_ln_one_callback' ), 'property-info', 'section-one' );
		add_settings_field( 'addr-ln-two', 'Address Line 2', array( $this,'addr_ln_two_callback' ), 'property-info', 'section-one' );
		add_settings_field( 'city', 'City', array( $this,'city_callback' ), 'property-info', 'section-one' );
		add_settings_field( 'state', 'State', array( $this,'state_callback' ), 'property-info', 'section-one' );
		add_settings_field( 'zip', 'Zip', array( $this,'zip_callback' ), 'property-info', 'section-one' );
		add_settings_field( 'phone', 'Phone #', array( $this, 'phone_callback' ), 'property-info', 'section-one' );
		add_settings_field( 'fax', 'Fax #', array( $this, 'fax_callback' ), 'property-info', 'section-one' );	
	*/	

		
		register_setting( 'prop-contact-group', 'prop-contact-info' );
		add_settings_section( 'prop-contact-section', 'Property Information' , array( $this, 'contact_section_callback'), 'property-info' );
		
		add_settings_field('prop-addr-ln-one', 'Address Line 1', array($this, 'addr_ln_one_callback' ), 'property-info', 'prop-contact-section' );
		
		add_settings_field('prop-addr-ln-two', 'Address Line 2', array($this, 'addr_ln_two_callback' ), 'property-info', 'prop-contact-section' );
		
		add_settings_field('prop-city', 'City', array($this, 'city_callback' ), 'property-info', 'prop-contact-section' );
		
		add_settings_field('prop-state', 'State', array($this, 'state_callback' ), 'property-info', 'prop-contact-section' );
		
		add_settings_field('prop-zip', 'Zip', array($this, 'zip_callback' ), 'property-info', 'prop-contact-section' );
		
		add_settings_field('prop-phone', 'Phone #', array($this, 'phone_callback' ), 'property-info', 'prop-contact-section' );
		
		add_settings_field('prop-fax', 'Fax #', array($this, 'fax_callback' ), 'property-info', 'prop-contact-section' );
		
		add_settings_field('prop-google-map-url', 'Google Map URL', array($this, 'google_map_url_callback'), 'property-info', 'prop-contact-section' );
		
		add_settings_field('prop-eho', 'Display Equal Housing?', array($this, 'display_equal_housing_callback'), 'property-info', 'prop-contact-section');
		
		add_settings_field('prop-handicap', 'Display Handicap Accessible icon?', array($this, 'display_handicap_callback'), 'property-info', 'prop-contact-section');
			
		
		
	}
 
	/**
	 * Help Text Call Back For Address Section
	 *
	 * @since    1.0.0
	 */
	public function contact_callback() {
		echo 'Enter in The Contact information below.';
	}
	
	/**
	 * Help Text Call Back For Address Section
	 *
	 * @since    1.0.0
	 */
	public function contact_section_callback() {
		echo 'Please fill in the property information below.';
	}	
	
	
	/**
	 * Help Text Call Back For Address Section
	 *
	 * @since    1.0.0
	 */
	public function google_section_callback() {
		echo 'Copy and Paste Your Google Settings Below';
	}	
		
	
	/**
	 * Call Back For Address Line 1
	 *
	 * @since    1.0.0
	 */	
	public function addr_ln_one_callback() {
		
		$settings = (array) get_option( 'prop-contact-info' );
        $addrLnOne = esc_attr( $settings['prop-addr-ln-one'] );
		echo "<input type='text' name='prop-contact-info[prop-addr-ln-one]' value='$addrLnOne' />";
	}
	/**
	 * Call Back For Address Line 2
	 *
	 * @since    1.0.0
	 */		
	public function addr_ln_two_callback() {
		
		$settings = (array) get_option( 'prop-contact-info' );
        $addrLnTwo = esc_attr( $settings['prop-addr-ln-two'] );
		echo "<input type='text' name='prop-contact-info[prop-addr-ln-two]' value='$addrLnTwo' />";
	}	
	
	/**
	 * Call Back For The City Input
	 *
	 * @since    1.0.0
	 */		
	public function city_callback() {
		
		$settings = (array) get_option( 'prop-contact-info' );
        $city = esc_attr( $settings['prop-city'] );
		echo "<input type='text' name='prop-contact-info[prop-city]' value='$city' />";
	}		

	/**
	 * Call Back For The State Input
	 *
	 * @since    1.0.0
	 */		
	public function state_callback() {
		
		$settings = (array) get_option( 'prop-contact-info' );
        $state = esc_attr( $settings['prop-state'] );
		echo "<input type='text' name='prop-contact-info[prop-state]' value='$state' />";
	}
	
	/**
	 * Call Back For The Zip Input
	 *
	 * @since    1.0.0
	 */		
	public function zip_callback() {
		
		$settings = (array) get_option( 'prop-contact-info' );
        $zip = esc_attr( $settings['prop-zip'] );
		echo "<input type='text' name='prop-contact-info[prop-zip]' value='$zip' />";
	}
	
	/**
	 * Call Back For The Phone # Input
	 *
	 * @since    1.0.0
	 */		
	public function phone_callback() {
		
		$settings = (array) get_option( 'prop-contact-info' );
        $phone = esc_attr( $settings['prop-phone'] );
		echo "<input type='text' name='prop-contact-info[prop-phone]' value='$phone' />";
	}	
	
	/**
	 *
	 *
	 *
	 * @somce 1.0.0
	 */
	 public function fax_callback(){

		$settings = (array) get_option( 'prop-contact-info' );
        $fax = esc_attr( $settings['prop-fax'] );
		echo "<input type='text' name='prop-contact-info[prop-fax]' value='$fax' />";		   
	 }
	
	/**
	 * Callback To Store The Google Maps URL
	 *
	 * @since    1.0.0
	 */			
	public function google_map_url_callback() {
		
		$settings = (array) get_option( 'prop-contact-info' );
        $gMap = esc_attr( $settings['prop-google-map-url'] );
		echo "<input type='text' name='prop-contact-info[prop-google-map-url]' value='$gMap' />";	
	}	

	/**
	 * Callback To Store the check value for displaying the EHO icon
	 *
	 * @since    1.0.0
	 */			
	public function display_equal_housing_callback() {
		
		$settings = (array) get_option( 'prop-contact-info' );
        $eho = esc_attr( $settings['prop-eho'] );
		echo "<input type='checkbox' name='prop-contact-info[prop-eho]' value='1'". checked( 1, $settings['prop-eho'], false )."  />";	
	}	
	
	/**
	 * Callback To Store the check value for displaying the handicap accessible icon
	 *
	 * @since    1.0.0
	 */			
	public function display_handicap_callback() {
		
		$settings = (array) get_option( 'prop-contact-info' );
        $handicap = esc_attr( $settings['prop-handicap'] );
		echo "<input type='checkbox' name='prop-contact-info[prop-handicap]' value='1'". checked( 1, $settings['prop-handicap'], false )."  />";	
	}		


	/**
	 * Displays the form for the Property Information
	 *
	 * @since    1.0.0
	 */				
	public function prop_info_form() {
    ?>
        <form action="options.php" method="POST">
            <?php settings_fields( 'prop-contact-group' ); ?>
            <?php do_settings_sections( 'property-info' ); ?>
            <?php submit_button(); ?>
        </form>
    <?php
	}
	
	
	/**
	 * This function can be used to displays the Property Information on the Front end of the website
	 * via the Shortcode [prop-information]   i.e. echo do_shortcode('[prop-information]');
	 *
	 * @since    1.0.0
	 */			
	 public function prop_info_frontend(){
		ob_start();
		$html = 'Create Your HTML here';
		$html = 'and HERE';
		
		$output = ob_get_clean();
 
		return $html . $output; 
	 }

	/**
	 * NOTE:  Filters are points of execution in which WordPress modifies data
	 *        before saving it or sending it to the browser.
	 *
	 *        WordPress Filters: http://codex.wordpress.org/Plugin_API#Filters
	 *        Filter Reference:  http://codex.wordpress.org/Plugin_API/Filter_Reference
	 *
	 * @since    1.0.0
	 */
	public function filter_method_name() {
		// TODO: Define your filter hook callback here
	}

}