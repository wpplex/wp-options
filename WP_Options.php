<?php
namespace wpplex\WP_Options;

/**
 * Options Panels 
 *
 * Load Options Framework, and pull the wanted bits
 *
 * @class WP_Options
 * @package Inc
 * @subpackage Options 
 * @author Abid Omar
 */
class WP_Options {
	public $option_name;
	public $options;

	function __construct( $option_name ) {

		$this->option_name = $option_name;

		require_once( 'Includes/class-options-framework.php' );
		require_once( 'Includes/class-options-interface.php' );
		require_once( 'Includes/class-options-media-uploader.php' );
		require_once( 'Includes/class-options-sanitization.php' );       

		// Register the Settings Form
		add_action( 'admin_init', array( &$this, 'settings_form' ), 100 );
	}

	public function settings_form() {
		register_setting( $this->option_name, $this->option_name );
	}

	public function load_resources() {	
		// Enqueue the Options Framework CSS and JS files
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
	}

	public function enqueue_admin_styles() {
		wp_enqueue_style( 'optionsframework', plugin_dir_url( __FILE__ ) . 'css/optionsframework.css', array() );
		wp_enqueue_style( 'wp-color-picker' );
	}

	public function enqueue_admin_scripts() {	
		wp_enqueue_script( 'options-custom', plugin_dir_url( __FILE__ ) . 'js/options-custom.js', array( 'jquery','wp-color-picker' ) );
		if ( function_exists( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}
		wp_register_script( 'of-media-uploader', plugin_dir_url( __FILE__ ) .'js/media-uploader.js', array( 'jquery' ) );
		wp_enqueue_script( 'of-media-uploader' );
		wp_localize_script( 'of-media-uploader', 'optionsframework_l10n', array(
			'upload' => __( 'Upload', 'options-framework' ),
			'remove' => __( 'Remove', 'options-framework' )
		) );
	}

	public function build_panel( $options ) {
		$this->options = $options;

		require_once(  'options-template.php' );
	}
}
