<?php
defined( 'ABSPATH' ) || exit;
require_once('class-lquiz-admin-validation.php');
require_once('classLquizAdminRenderTemplate.php');

/**
 * The admin-lquiz-post-type-specific functionality of the plugin.
 *
 * @link       lquiz
 * @since      0.0.1
 *
 * @package    lquiz
 * @subpackage lquiz/admin
 */

class lquiz_Admin_single_post extends lquiz_Admin {

	public function __construct( ) {
		add_action('admin_init', array($this, 'single_rapater_meta_boxes'));
		add_action('admin_menu', array($this, 'results_page'));

		add_action('save_post', array($this, 'save_questions'));
		add_action('save_post', array($this, 'single_repeatable_meta_box_save'));
		add_action( 'save_post', array($this, 'my_plugin_save_post' ));

		add_action( 'wp_restore_post_revision', array($this, 'my_plugin_restore_revision', 10, 2 ));
		add_filter( '_wp_post_revision_fields', array($this, 'my_plugin_revision_fields' ));
		add_filter( '_wp_post_revision_field_my_meta', array($this, 'my_plugin_revision_field', 10, 2 ));
		add_action('add_meta_boxes', array($this, 'settings_add_meta_box')); //add new meta boxes on post type

	}

	/**
	 * @param $post_type
	 * add meta box to test CPT
	 */
	public function settings_add_meta_box($post_type)
	{
		$post_type = 'tests';
		add_meta_box(
			'cs-meta',
			__('Settings', 'lquiz'),
			array($this, 'settings_meta_box_function'),
			$post_type,
			'advanced',
		);
	}

	/**
	 * New meta box html
	 *
	 */
	public function settings_meta_box_function()
	{
		global $post;
		wp_nonce_field('cs_nonce_check', 'cs_nonce_check_value');
		$meta = get_post_meta($post->ID, 'lquiz_setting_field', true);
		$meta_time = (isset($meta['time']) ?? $meta['time']);
		$meta_checkbox_multiple_times = (isset($meta['checkbox_multiple_times']) ?? $meta['checkbox_multiple_times']);
		$meta_checkbox_score_in_the_end = (isset($meta['meta_checkbox_score_in_the_end']) ?? $meta['meta_checkbox_score_in_the_end']);
		$meta_checkbox_unlogged = (isset($meta['meta_checkbox_score_in_the_end']) ?? $meta['meta_checkbox_unlogged']);
		$render = new classCrawlerRenderTemplate();

		echo ($render->render_template(
			'settings-meta-fields.php',
			array($meta, $meta_time, $meta_checkbox_multiple_times, $meta_checkbox_score_in_the_end, $meta_checkbox_unlogged)
		));

	}
	/**
	 * Save changing of meta box
	 *
	 */

	public function save_questions()
	{
		global $post_id;

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}
	$old = "";
		if (isset($_POST['lquiz_setting_field'])) {
			$new = $_POST['lquiz_setting_field'];
		} else {
			$new = null;
		}
		if ($new && $new !== $old) {
			update_post_meta($post_id, 'lquiz_setting_field', $new);
		} elseif (null === $new && $old) {
			delete_post_meta($post_id, 'lquiz_setting_field', $old);
		}
	}

	/**
	 * Creating test post type
	 *
	 */
	public function results_page() {
		add_submenu_page(
			'edit.php?post_type=tests',
			__("Results", "lquiz"),
			__("Results", "lquiz"),
			"manage_options",
			'settings',
			array($this, 'results_content'),
		);
	}

	public function results_content() {
		global $wpdb;
		$table_name = $wpdb->prefix . "new_scores";
		$data = $wpdb->get_results("SELECT * FROM $table_name ");
		$render = new classCrawlerRenderTemplate();

		echo ($render->render_template(
			'results-list.php',
			array($data)
		));
	}

	function my_plugin_save_post( $post_id ) {

		$parent_id = wp_is_post_revision( $post_id );
		if ( $parent_id  ) {

			$parent  = get_post( $parent_id );
			$my_meta = get_post_meta( $parent->ID, 'lquiz_questions_field', true );

			if ( false !== $my_meta ){
				add_metadata( 'post', $post_id, 'lquiz_questions_field', $my_meta );

			}

		}

	}

	function my_plugin_restore_revision( $post_id, $revision_id ) {

		$post     = get_post( $post_id );
		$revision = get_post( $revision_id );
		$my_meta  = get_metadata( 'post', $revision->ID, 'lquiz_setting_field', true );
		if ( false !== $my_meta )
			update_post_meta( $post_id, 'lquiz_setting_field', $my_meta );
		else
			delete_post_meta( $post_id, 'lquiz_setting_field' );

	}

	function my_plugin_revision_fields( $fields ) {

		$fields['lquiz_setting_field'] = 'Settings';
		return $fields;

	}

	function my_plugin_revision_field( $value, $field ) {
		global $revision;
		return get_metadata( 'post', $revision->ID, 'lquiz_setting_field', true );

	}
	// Add Meta Box to tests
	public function single_rapater_meta_boxes() {
		add_meta_box(
			'single-repeter-data',
			__('Questions for test', 'lquiz'),
			array($this, 'single_repeatable_meta_box_callback'),
			'tests',
			'normal',
		);
	}
	/**
	 * @param $post
	 * question meta box field repeater content
	 */

	public function single_repeatable_meta_box_callback() {
		global $post;
		$question_repeter_group = get_post_meta($post->ID, 'lquiz_questions_field', true);
		$render = new classCrawlerRenderTemplate();

		echo ($render->render_template(
			'questions-meta-fields.php',
			array($question_repeter_group)
		));
	}
	// Save Meta Box values.
	public function single_repeatable_meta_box_save() {
		global $post_id;
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/media.php' );
		if($_SERVER['REQUEST_METHOD'] == 'POST'):


			$old = get_post_meta($post_id, 'lquiz_questions_field', true);
			$new = array();
			$titles = ($_POST['title']);
			$category = ($_POST['category']);
			$correct = ($_POST['correct']);
			$points = ($_POST['points']);
			$mediaId = $_POST['imgid'];
			//save data into DB
			$count = count( $titles );
			for ( $i = 0; $i < $count; $i++ ) {
				if ( $titles[$i] != '' ) {
					$new[$i]['title'] =  ( $titles[$i] );
					$new[$i]['category'] =  ($category[$i]);
					$new[$i]['correct'] =  ($correct[$i]);
					$new[$i]['points'] =  ($points[$i]);
					$new[$i]['mediaId'] =  ($mediaId[$i]);
				}
			}
			if ( $new ){
				update_post_meta( $post_id, 'lquiz_questions_field', $new );
			}
			elseif ( empty($new) && $old ) {
				update_post_meta( $post_id, 'lquiz_questions_field', $new );
			}
			update_post_meta( $post_id, 'lquiz_questions_field', $new );
		endif;
	}

}