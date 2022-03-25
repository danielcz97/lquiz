<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       lquiz
 * @since      0.0.1
 *
 * @package    lquiz
 * @subpackage lquiz/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    lquiz
 * @subpackage lquiz/public
 * @author     Daniel <daniel.czerepak@polcode.net>
 */
class lquiz_Public {


	public function __construct(  ) {
		add_action('single_template', array($this, 'load_tests_template'));
		add_action('wp_ajax_nopriv_save_post_details_form',array($this, 'save_enquiry_form_action'));

	}


	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_styles() {
		wp_enqueue_style('bootstrap', plugin_dir_url(__DIR__) . "/admin/css/bootstrap.min.css", array(),  'all');
		wp_enqueue_style('single-style', plugin_dir_url(__FILE__) . "/css/single_post.css");
		wp_enqueue_style('style', plugin_dir_url(__FILE__) . "/css/wqt-frontend.css");

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'bootstrap', plugin_dir_url(__DIR__) . "/admin/js/bootstrap.min.js", array('jquery'), '1.0', false);
        wp_enqueue_script('timmer', plugin_dir_url(__FILE__) . "/js/timmer.js", array('jquery'), '1.0', true);
        wp_enqueue_script('front', plugin_dir_url(__FILE__) . "/js/front.js", array('jquery'), '1.0', true);
		wp_enqueue_script('ajax-script', plugin_dir_url(__FILE__) . "/js/ajax.js", array('jquery'), '1.0', true);
		wp_localize_script( 'ajax-script', 'my_ajax_object', array( 'ajax_url' => plugins_url() . '/test2/public/partials/'. 'ajax.php'  ) );

	}

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



	public function load_tests_template()
	{
		global $post, $template, $wpdb;
		$meta = get_post_meta($post->ID, 'lquiz_setting_field', true);
		$meta_question = get_post_meta($post->ID, 'lquiz_questions_field', true);
		$meta_photos = get_post_meta($post->ID, 'photos', true);

		$user_id = get_current_user_id();
		$user_info = get_userdata($user_id);

		$test_title_question = get_the_title($post->ID);
		//set template for CPT
		if ('tests' === $post->post_type && locate_template(array('single-tests.php')) !== $template) {

			$table_name = $wpdb->prefix . "new_scores";
			$logged = false;
			if(is_user_logged_in()){
				$logged = true;
			}
			echo ($this->render_template(
				'single-tests.php',
				array($meta, $meta_question, $meta_photos)
			));

			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$userid = get_current_user_id();
				$test_title = $test_title_question;
				$data_answer  =  $_POST['answer'];

				$data_json = array(
					'answers' =>[
						'answer' =>$data_answer,

					],
					'loggedin' => $logged
				);
				//store data to DB
				$data = array(
					'sessionid' => $_POST['sessionID'],
					'correct' => json_encode($data_json),
					'postid' => $post->ID,
					'userid' => $userid,
					'loggeduser' => $logged,
					'title' => $test_title,
					'currentcorrect' => 'finished'

				);
				$is_in_database = $wpdb->get_results("SELECT * FROM $table_name ");

				$where = [
					'postid' => $post->ID,
					'sessionid' => $_POST['sessionID']
				];
				$wpdb->update($table_name, $data, $where );

			}

		}

		return $template;
	}

}