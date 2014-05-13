<?php
/**
 * Admin class
 *
 * @package      Child_Theme
 * @subpackage	 Admin
 * @author       Joshua David Nelson <josh@joshuadnelson.com>
 * @copyright    Copyright (c) 2014, Joshua David Nelson
 * @license      http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @since        1.0.0
 *
 * Built from: https://github.com/WebDevStudios/Custom-Metaboxes-and-Fields-for-WordPress/wiki/Using-CMB-to-create-an-Admin-Theme-Options-Page
 *
 **/

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 **/
if( !defined( 'ABSPATH' ) ) {
        exit( 'You are not allowed to access this file directly.' );
}

/**
 * The Admin.
 *
 * @since 1.0.0
 **/
class Child_Admin {

    /**
     * Option key, and option page slug
   	 *
     * @since 1.0.0
     * @var string
     **/
    protected static $key = 'child-settings';
  	
    /**
     * Array of metaboxes/fields
  	 *
     * @since 0.1.0
     * @var array
     **/
    protected static $theme_options = array();
	
    /**
     * Options Page title
  	 *
     * @since 1.0.0
     * @var string
     **/
    protected $title = '';

    /**
     * Constructor
  	 *
     * @since 1.0.0
     **/
    public function __construct() {
        // Set our title
        $this->title = __( 'Child Theme Options', CHILD_THEME_DOMAN );
    }

    /**
     * Initiate our hooks
  	 *
     * @since 1.0.0
     **/
    public function hooks() {
        add_action( 'admin_init', array( $this, 'child_init' ) );
        add_action( 'admin_menu', array( $this, 'add_page' ) );
    }

    /**
     * Register our setting to WP
	 *
     * @since  1.0.0
     **/
    public function child_init() {
        register_setting( self::$key, self::$key );
    }

    /**
     * Add menu options page
	 *
     * @since 1.0.0
     **/
    public function add_page() {
		$this->options_page = add_menu_page( $this->title, $this->title, 'manage_options', self::$key, array( $this, 'admin_page_display' ) );
        add_action( 'admin_head-' . $this->options_page, array( $this, 'admin_head' ) );
    }

    /**
     * CSS, etc
	 *
     * @since  1.0.0
     **/
    public function admin_head() {
		// enqueue scripts
    }

    /**
     * Admin page markup. Mostly handled by CMB
	 *
     * @since  1.0.0
     **/
    public function admin_page_display() {
        ?>
        <div id="poststuff" class="wrap gcs_options_page <?php echo self::$key; ?>">
	        <div class="wrap cmb_options_page <?php echo self::$key; ?>">
	            <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	            <?php cmb_metabox_form( self::option_fields(), self::$key ); ?>
	        </div>
		</div>
        <?php
    }

    /**
     * Defines the plugin option metabox and field configuration
	 *
	 * For more information, view: 
	 *
     * @since  1.0.0
     * @return array
     **/
    public static function option_fields() {

		// Only need to initiate the array once per page-load
		if( !empty( self::$theme_options ) )
			return self::$theme_options;

		$prefix = 'child_';

		// Define the Theme Options
		self::$theme_options = array(
			'id'           => 'theme_options',
			'show_on'      => array( 'key' => 'options-page', 'value' => array( self::$key, ), ),
			'show_names'   => true,
			'fields'       => array(
				array(
					'name'    => 'Example Select',
					'desc'    => '',
					'id'      => $prefix . 'script',
					'type'    => 'select',
					'options' => array(
						'option-1'	=> __( 'Option 1', CHILD_THEME_DOMAN ),
						'option-2'	=> __( 'Option 2', CHILD_THEME_DOMAN ),
						'optino-2'	=> __( 'Option 3', CHILD_THEME_DOMAN ),
					),
					'default' => 'unslider',
				),
			),
	    );

	    return self::$theme_options;
    }
  
    /**
     * Make public the protected $key variable.
     *
     * @since  1.0.0
     * @return string  Option key
     **/
    public static function key() {
        return self::$key;
    }
}

// Get it started
$child_Admin = new Child_Admin();
$child_Admin->hooks();

/**
 * Wrapper function around cmb_get_option  
 *
 * @since  1.0.0
 * @param  string  $key Options array key
 * @return mixed        Option value
 **/
function child_admin_get_option( $key = '' ) {
    return cmb_Meta_Box::get_option( Child_Admin::key(), $key );
}