<?php

use JetBrains\PhpStorm\Pure;

defined( 'ABSPATH' ) || exit;

require_once('classLquizAdminRenderTemplate.php');

class classLquizAdminUserRole{

	public function __construct(){
		add_action('admin_menu', array($this, 'add_users_page'));
		add_action('admin_init', array($this, 'create_user_roles'));

	}
	public function add_users_page() {
		add_submenu_page(
			'edit.php?post_type=tests',
			__("Add user", "lquiz"),
			__("Add user", "lquiz"),
			"manage_options",
			'adduser',
			array($this, 'add_new_user_content'),
		);
		add_submenu_page(
			'edit.php?post_type=tests',
			__("Show students", "lquiz"),
			__("Show students", "lquiz"),
			"manage_options",
			'showuserspage',
			array($this, 'show_all_users_content'),
		);
	}
	public function create_user_roles() {
		add_role('student', __(
			'Student'),
			array(
				'read'            => true, // Allows a user to read
				'create_posts'      => true, // Allows user to create new posts
				'edit_posts'        => false, // Allows user to edit their own posts
				'edit_others_posts' => false, // Allows user to edit others posts too
				'publish_posts' => true, // Allows the user to publish posts
				'manage_categories' => false, // Allows user to manage post categories
			)
		);

		add_role('parents', __(
			'Parents'),
			array(
				'read'            => true, // Allows a user to read
				'create_posts'      => true, // Allows user to create new posts
				'edit_posts'        => true, // Allows user to edit their own posts
				'edit_others_posts' => true, // Allows user to edit others posts too
				'publish_posts' => true, // Allows the user to publish posts
				'manage_categories' => true, // Allows user to manage post categories
				'manage_options'=>true

			)
		);

		add_role('teacher', __(
			'Teacher'),
			array(
				'read'            => true, // Allows a user to read
				'create_posts'      => true, // Allows user to create new posts
				'edit_posts'        => true, // Allows user to edit their own posts
				'publish_posts' => true, // Allows the user to publish posts
				'manage_categories' => true, // Allows user to manage post categories
			)
		);
	}


	 public function add_new_user_content(){
		$render = new classCrawlerRenderTemplate();
		 if (isset($_POST['user_registeration']))
		 {
			 global $reg_errors;
			 $reg_errors = new WP_Error;
			 $username  = $_POST['username'];
			 $useremail = $_POST['useremail'];
			 $password  = $_POST['password'];
			 $userrole  = $_POST['userrole'];
			 $teacherId = 0;
			 $parentId = 0;
			 if(isset($_POST['teacherid'])):
			    $teacherId = $_POST['teacherid'];
			 endif;
			 if(isset($_POST['parentsid'])):
				 $parentId = $_POST['parentsid'];
			 endif;
			 if(empty( $username ) || empty( $useremail ) || empty($password))
			 {
				 $reg_errors->add('field', 'Required form field is missing');
			 }
			 if ( 6 > strlen( $username ) )
			 {
				 $reg_errors->add('username_length', 'Username too short. At least 6 characters is required' );
			 }
			 if ( username_exists( $username ) )
			 {
				 $reg_errors->add('user_name', 'The username you entered already exists!');
			 }

			 if ( !is_email( $useremail ) )
			 {
				 $reg_errors->add( 'email_invalid', 'Email id is not valid!' );
			 }

			 if ( email_exists( $useremail ) )
			 {
				 $reg_errors->add( 'email', 'Email Already exist!' );
			 }
			 if ( 5 > strlen( $password ) ) {
				 $reg_errors->add( 'password', 'Password length must be greater than 5!' );
			 }

			 if (is_wp_error( $reg_errors ))
			 {
				 foreach ( $reg_errors->get_error_messages() as $error )
				 {
					 $signUpError='<p style="color:#FF0000; text-aling:left;"><strong>ERROR</strong>: '.$error . '<br /></p>';
				 }
			 }
			 if ( 1 > count( $reg_errors->get_error_messages() ) )
			 {
				 // sanitize user form input
				 global $username, $useremail;
				 $username   =   sanitize_user( $_POST['username'] );
				 $useremail  =   sanitize_email( $_POST['useremail'] );
				 $password   =   esc_attr( $_POST['password'] );

				 $userdata = array(
					 'user_login'    =>   $username,
					 'user_email'    =>   $useremail,
					 'user_pass'     =>   $password,
					 'role'          => $userrole
				 );
				wp_insert_user( $userdata );
				$thisUser = get_user_by('email', $useremail);
				$thisUserId = $thisUser->ID;

				if($userrole === 'parents'):
					add_user_meta( $thisUserId, '_teacher', $teacherId);
				elseif($userrole === 'student'):
					add_user_meta( $thisUserId, '_teacher', $teacherId);
					add_user_meta( $thisUserId, '_parent', $parentId);

				endif;

			 }

		 }

		 echo ($render->render_template(
			 'add-new-user.php',
			 array()
		 ));
	}

	public function show_all_users_content(){
		$render = new classCrawlerRenderTemplate();

		echo ($render->render_template(
			'show-users-lquiz.php',
			array()
		));
	}

	public function getUserInfo(): array {
		global $wpdb;
		$table_name = $wpdb->prefix . "users";
		$all_users  = $wpdb->get_results( "SELECT * FROM $table_name " );
		$all_users_array = array();
		foreach ( $all_users as $index => $user ) {
			$user_meta = get_userdata( $user->ID );
			$userRole  = implode( '', $user_meta->roles );
			if ( $userRole === 'parents' or $userRole === 'teacher' or $userRole === 'student' ):
				$all_users_array[] = array(
					"ID"            => $user->ID,
					"user_nickname" => $user->user_login,
					"user_type"     => $userRole,
				);
			endif;
		}
		return $all_users_array;
	}
}