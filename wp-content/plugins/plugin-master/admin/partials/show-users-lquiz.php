<?php


defined( 'ABSPATH' ) || exit;
require_once dirname( __DIR__ ) . '/grammarapi.php';
echo '        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>';

class resultTableList extends WP_List_Table {

	public function prepare_items() {

		$this->items = $this->wp_list_table_data();

		$columns = $this->get_columns();


		$this->_column_headers = array( $columns );
	}

	public function wp_list_table_data(): array {

		global $wpdb;
		$table_name         = $wpdb->prefix . "users";
		$all_users          = $wpdb->get_results( "SELECT * FROM $table_name " );
		$all_students_array = array();

		if ( count( $all_users ) > 0 ) {
			foreach ( $all_users as $index => $user ) {
				$user_meta = get_userdata( $user->ID );
				$userRole  = implode( '', $user_meta->roles );

				if ( $userRole === 'student' ):
					$postMeta  = get_user_meta( intval( $user->ID ) );
					$teacherId = $postMeta['_teacher'];
					$parentId  = $postMeta['_parent'];

					$all_students_array[] = array(
						"ID"            => $user->ID,
						"user_nickname" => $user->user_login,
						"user_type"     => $userRole,
						"teacher_id"    => $teacherId[0],
						"parent_id"     => $parentId[0],
					);

				endif;
			}
		}

		return $all_students_array;

	}


	/**
	 * @return string[]
	 */
	public function get_columns() {

		$columns = array(
			"user_nickname" => __("Student Name", "lquiz"),
			'action_user'=> __("Action User", "lquiz"),
			"teacher_info"    => __("Teacher", "lquiz"),
			"parent_info"     => __("Parent", "lquiz"),
			'action_parent'=> __("Action Parent", "lquiz"),
		);

		return $columns;
	}

	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'user_nickname':
				echo $item['user_nickname'];
				break;
			case 'action_user':
				echo "<button class='btn btn-sm btn-primary mx-2'>Send Test</button><button class='btn btn-sm btn-danger'>Send Email</button> <button class='btn btn-sm btn-info'>Check Scores</button>";
				break;
			case 'teacher_info':
				$teacherID = intval($item['teacher_id']);
				$teacherName = $this->getTeacherName($teacherID);
				echo $teacherName;
				break;
			case 'parent_info':
				$parentId = intval($item['parent_id']);
				$parentName = $this->getTeacherName($parentId);
				echo $parentName;
				break;
			case 'action_parent':
				echo "<button class='btn btn-sm btn-primary mx-2'>Call to Parent</button><button class='btn btn-sm btn-danger'>Send Email</button>";
				break;
		}
	}


	public function getTeacherName( $teacherId ) {
		global $wpdb;
		$table_name         = $wpdb->prefix . "users";
		$teacher          = $wpdb->get_results( "SELECT * FROM $table_name WHERE ID = $teacherId " );
		return $teacher[0]->user_login;
	}

	public function getParentName( $parentId ) {
		global $wpdb;
		$table_name         = $wpdb->prefix . "users";
		$parent          = $wpdb->get_results( "SELECT * FROM $table_name WHERE ID = $parentId " );
		return $parent[0]->user_login;
	}
}

function owt_show_data_list_table() {
	$result = new resultTableList();
	$result->prepare_items();
	echo '<h3>Students list</h3>';
	$result->display();
}

owt_show_data_list_table();