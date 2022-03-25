<?php
include( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

switch($_GET['action']){
	case 'start':
		 startTest();
		break;
	case'reset':
		resetTest();
		break;
	case'save':
		saveTest();
		break;
}
function startTest(){
	global $wpdb;
	date_default_timezone_set('UTC');

	$sessionId = $_GET['session'];
	$testTime = $_GET['minutes'];
	$table_name = $wpdb->prefix . "new_scores";

	$is_in_database = $wpdb->get_results("SELECT * FROM $table_name WHERE sessionid = '$sessionId'");
	$allTime = date('Y-m-d H:i:s',strtotime('+ 2 hours +'.$testTime. 'minutes'));
	$dataInsert = array(
		'sessionid' => $_GET['session'] ,
		'postid' => $_GET['postid'],

		'title' => "Start Testu",
		'starttime' => date("Y/m/d H:i:s"),
		'endtime' => $allTime,
		'currentcorrect' => 'running'
	);
$dataUpdate = array(
	'sessionid' => $_GET['session'] ,
	'postid' => $_GET['postid'],
	'title' => "dzial",
	'currentcorrect' => 'running'

);

$where = ['sessionid' => $_GET['session']];
if(!empty($is_in_database)):
	$success=$wpdb->update($table_name, $dataUpdate, $where );
else :
	$success=$wpdb->insert($table_name, $dataInsert );

endif;
}

function resetTest() {
	session_start();
	session_regenerate_id();
	session_destroy();
	header("refresh: 3;");

}

function saveTest() {
	global $wpdb;
	$table_name = $wpdb->prefix . "new_scores";
	$data = json_decode(file_get_contents("php://input"));

	if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
		$sessionId = $data->sessionid;
		$data_json = array(
			'answers'  => [
				'answer' => $data->answer,

			],
			'loggedin' => 1
		);
		//store data to DB
		$data           = array(
			'sessionid'      => $sessionId,
			'correct'        => json_encode( $data_json ),
			'postid'         => $data->postid,
			'loggeduser'     => 1,
			'title'          => $data->title,
			'currentcorrect' => 'finished'

		);
		$is_in_database = $wpdb->get_results( "SELECT * FROM $table_name " );

		$where = [
			'sessionid' => $sessionId
		];
		$wpdb->update( $table_name, $data, $where );
	}
}

