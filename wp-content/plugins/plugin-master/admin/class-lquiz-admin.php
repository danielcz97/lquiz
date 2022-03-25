<?php
defined( 'ABSPATH' ) || exit;
require_once('class-lquiz-admin-validation.php');
require_once('classLquizAdminUserRole.php');

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       lquiz
 * @since      0.0.1
 *
 * @package    lquiz
 * @subpackage lquiz/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    lquiz
 * @subpackage lquiz/admin
 * @author     Daniel <daniel.czerepak@polcode.net>
 */

class lquiz_Admin {

	public function __construct( ) {
		add_action('init', array($this, 'test_custom_post_type')); // creating custom post type
        add_action('init', array($this, 'insert_demo_table_into_db')); //add new table to DB new_scores
		add_action('init', array($this, 'run_custom_users')); //add new table to DB new_scores

	}
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    0.0.1
	 */

	public function enqueue_styles() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in lquiz_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The lquiz_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( 'my-styles', plugin_dir_url( __FILE__ ) . '/css/lquiz-admin.css', array(),  'all' );
		wp_enqueue_style('bootstrap', plugin_dir_url(__FILE__) . "/css/bootstrap.min.css", array(),  'all');
		wp_enqueue_style('sweetalert-style', plugin_dir_url(__FILE__) . "/css/sweetalert.css");


	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in lquiz_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The lquiz_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
        wp_enqueue_script( 'bootstrap', plugin_dir_url(__FILE__) . "/js/bootstrap.min.js", array('jquery'), '1.0', false);
		wp_enqueue_script('select2', plugin_dir_url(__FILE__) . "/js/sweetalert.js", array('jquery'), '1.0', true);
		wp_enqueue_script( 'my-scripts', plugin_dir_url( __FILE__ ) . '/js/lquiz-admin.js', array(),  false );

	}

public function run_custom_users(){
	$runCustomUsers = new classLquizAdminUserRole();

	}

    /**
     * Creating template file for single test
     *
     */
	 function get_category_name($post_id) {

			 switch ( $post_id ) {
				 case 0:
					 if ( is_singular( 'tests' ) ) {
						 echo __( 'Insert a letter.', 'lquiz' );
						 }
					 else {
						 echo 'selected';
					 }
					 break;
				 case 1:
					 if ( is_singular( 'tests' ) ) {
						 echo __( 'Insert date.', 'lquiz' );
					 }
					 else {
						 echo 'selected';
					 }
					 break;
				 case 2:
					 if ( is_singular( 'tests' ) ) {
						 echo __( 'Insert word.', 'lquiz' );
					 }
					 else {
						 echo 'selected';
					 }
					 break;
				 case 3:
					 if ( is_singular( 'tests' ) ) {
						 echo __( 'Insert time.', 'lquiz' );
					 }
					 else {
						 echo 'selected';
					 }
					 break;
				 case 4:
					 if ( is_singular( 'tests' ) ) {
						 echo __( 'Choice correct answer.', 'lquiz' );
					 }
					 else {
						 echo 'selected';
					 }
					 break;
				 case 5:
					 if ( is_singular( 'tests' ) ) {
						 echo __( 'Description task.', 'lquiz' );
					 }
					 else {
						 echo 'selected';
					 }
					 break;
			 }

	}
    /**
     * Creating new databse table for scoring
     *
     */

	public static function locate_template( $template_name, $template_path = '', $default_path = '' ) {
		if ( ! $template_path ) {
			$template_path = 'plugin-name-templates/';
		}
		if ( ! $default_path ) {
			$default_path = plugin_dir_path(__FILE__)  . 'partials/';
		}
		// Look within passed path within the theme - this is priority.
		$template = locate_template(
			array(
				trailingslashit( $template_path ) . $template_name,
				$template_name,
			)
		);

		// Get default template.
		if ( ! $template ) {
			$template = $default_path . $template_name;
		}

		if ( file_exists( $template ) ) {
			// Return what we found.
			return apply_filters( 'plugin_name_locate_template', $template, $template_name, $template_path );
		} else {
			return false;
		}
	}
	public static function render_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
		if ( $args && is_array( $args ) ) {
			extract( $args ); // @codingStandardsIgnoreLine.
		}

		$located = static::locate_template( $template_name, $template_path, $default_path );
		if ( false == $located ) {
			return;
		}

		ob_start();
		do_action( 'plugin_name_before_template_render', $template_name, $template_path, $located, $args );
		include( $located );
		do_action( 'plugin_name_after_template_render', $template_name, $template_path, $located, $args );

		return ob_get_clean(); // @codingStandardsIgnoreLine.
	}

    public function insert_demo_table_into_db()
    {
        global $wpdb;
        $plugin_name_db_version = '0.3.2';
        $table_name = $wpdb->prefix . "new_scores";
        $charset_collate = $wpdb->get_charset_collate();
        // add email/
        // checkbox loged/unloged
        //create new database table
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
                  	id int(20) NOT NULL AUTO_INCREMENT,
    				sessionid text(255) DEFAULT '' NULL,
                  	created timestamp NOT NULL default CURRENT_TIMESTAMP,
                  	name tinytext NULL,
                  	title text(255) DEFAULT '' NULL,
                  	correct text(255) DEFAULT '' NOT NULL,
                    currentcorrect text(255) DEFAULT '' NOT NULL,
                  	score int(10) DEFAULT 0 NOT NULL,
                  	postid int(20) NOT NULL,
                  	userid varchar(300) NOT NULL,
                  	loggeduser tinyint(1) NOT NULL,
                  	email text(255) DEFAULT '' NULL,
                  	starttime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  	endtime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  	UNIQUE KEY id (id)
                ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $wpdb->query( $sql );

        add_option('plugin_name_db_version', $plugin_name_db_version);
    }
    /**
     * Creating test post type
     *
     */
    public function test_custom_post_type()
    {
        $labels = array(
            'name'                => _x('Test', 'Post Type General Name'),
            'singular_name'       => _x('Test', 'Post Type Singular Name'),
            'menu_name'           => __('Test', 'lquiz'),
            'all_items'           => __('All tests', 'lquiz'),
            'view_item'           => __('See test', 'lquiz'),
            'add_new_item'        => __('Add new test', 'lquiz'),
            'add_new'             => __('Add test', 'lquiz'),
            'edit_item'           => __('Edit test', 'lquiz'),
            'update_item'         => __('Update test', 'lquiz'),
            'search_items'        => __('Search test', 'lquiz'),
            'not_found'           => __('Test not found', 'lquiz'),
            'not_found_in_trash'  => __('Test not found in bin', 'lquiz'),
        );

        register_post_type(
            'tests',
            array(
                'description'         => __('Test', 'lquiz'),
                'labels'              => $labels,
                'public'              => true,
                'show_in_menu'        => true,
                'show_in_nav_menus'   => true,
                'show_in_admin_bar'   => true,
                'menu_position'       => 5,
                'show_ui'      => true,
                'supports' => array('title', 'editor', 'revisions', 'thumbnail'),
                'rewrite' => array('tests')
            )
        );
    }
}