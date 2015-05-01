<?php
namespace omarabid\WP_Options;

/**
 * Options Panels 
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

 		require_once( 'includes/class-options-framework.php' );
		require_once( 'includes/class-options-interface.php' );
		require_once( 'includes/class-options-media-uploader.php' );
		require_once( 'includes/class-options-sanitization.php' );       

        // Register the Settings Form
        add_action( 'admin_init', array( &$this, 'settings_form' ), 100 );
    }

    public function settings_form() {
        register_setting( $this->option_name, $this->option_name );
    }

	public function load_resources() {
// Load the Options Framework Plugin
        $adapter = new Adapter();
		// Enqueue the Options Framework CSS and JS files
		add_action( 'admin_enqueue_scripts', array( $adapter, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $adapter, 'enqueue_admin_scripts' ) );
	}

    public function build_panel( $options ) {
        $this->options = $options;

        require_once(  'options-template.php' );
    }
}
