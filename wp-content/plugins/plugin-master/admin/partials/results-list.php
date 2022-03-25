<?php
defined( 'ABSPATH' ) || exit;
require_once dirname( __DIR__ ) . '/grammarapi.php';
echo '        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>';
class resultTableList extends WP_List_Table {

	public function prepare_items() {

		$this->items = $this->wp_list_table_data();

		$columns = $this->get_columns();


		$this->_column_headers = array($columns);
	}

	public function wp_list_table_data() {

		global $wpdb;
		$table_name = $wpdb->prefix . "new_scores";
		$all_posts = $wpdb->get_results("SELECT * FROM $table_name WHERE currentcorrect = 'finished' ORDER BY ID DESC");
		$posts_array = array();

		if (count($all_posts) > 0) {
			foreach ($all_posts as $index => $post) {
				$posts_array[] = array(
					"id" => $post->id,
					"date" => $post->starttime,
					"name" => $post->name,
					'title' =>$post->title,
					"answers" => $post->correct,
					"score" => $post->score,
					"postid" => $post->postid,
					"userid" => $post->userid,
					"loggeduser" => $post->loggeduser,
					"email" => $post->email
				);
			}
		}

		return $posts_array;
	}


	public function get_sortable_columns() {

		return array(
			"title" => array("title", true),
		);
	}

	public function get_columns() {

		$columns = array(
			"date" => "Date",
			"title" => "Title",
			"action" => "Action"
		);

		return $columns;
	}

	public function column_default($item, $column_name) {
		$getPostMeta = get_post_meta($item['postid'], 'lquiz_questions_field', true);
		if($getPostMeta):

			$arrayWithCorrectAndUserAnswers = array();
			$arrayWithCorrectAnswers = array();
			$arrayWithUserAnswers = array();
			$arrayWithTitles = array();
			$arrWithPoints = array();
			$arrWithCategory = array();
			global $wpdb;
			$table_name = $wpdb->prefix . "new_scores";
			if(isset($_POST['function-action'])){
				$function_action = $_POST['function-action'];
				$this_id         = (int)$_POST['this_id'];
				$wpdb->delete( $table_name, array( 'id' => $this_id ) );
			}
			foreach($getPostMeta as $itemPost) {
				if ( $itemPost['correct'] !== null){
					foreach ( $itemPost['correct'] as $singlePoint ) {
						if ( $singlePoint == null):
							array_push( $arrWithPoints, $itemPost['points'] );
							array_push( $arrWithCategory, $itemPost['category'] );

						else:
							array_push( $arrWithPoints, $itemPost['points'] );
							array_push( $arrWithCategory, $itemPost['category'] );

						endif;
					}
				}
				else{
					array_push( $arrWithPoints, $itemPost['points'] );
					array_push( $arrWithCategory, $itemPost['category'] );

				}
			}

			foreach($getPostMeta as $single) {
				array_push($arrayWithTitles, $single['title']);
			}

			foreach($getPostMeta as $single) {
				if($single['correct']):
					$arrayWithCorrectAnswers = array_merge( $arrayWithCorrectAnswers, $single['correct']);
				endif;
			}

			$decodeAnswers = json_decode($item['answers']);

			foreach($decodeAnswers as $single){
				if(!empty($single->answer)):
					$arrayWithUserAnswers = array_merge( $arrayWithUserAnswers, $single->answer );
				endif;
			}
			$arrayWithQuestionsArray = array();
			$arrayWithCorrectAndUserAnswers['correct'] = $arrayWithCorrectAnswers;
			$arrayWithCorrectAndUserAnswers['useranswers'] = $arrayWithUserAnswers;
			$array_with_points = array();

			$arrayMapData = (array_map(null,
				$arrayWithTitles,
				$arrayWithCorrectAnswers,
				$arrayWithUserAnswers
			));
			foreach($arrayMapData as $a) {
				$a[0] = preg_split( '/(\r\n|\n|\r)/', $a[0], - 1, PREG_SPLIT_NO_EMPTY );
				array_push($arrayWithQuestionsArray, $a[0]);
			}
			$finalArrWithQuestions = array();

			foreach($arrayWithQuestionsArray as $arrayQuestion){
				foreach($arrayQuestion as $question){
					array_push($finalArrWithQuestions, $question);
				}
			}
			$mapFinalArrays = (array_map(null, $finalArrWithQuestions, $arrayWithUserAnswers, $arrayWithCorrectAnswers, $arrWithPoints, $arrWithCategory));
			switch ($column_name) {
				case 'id':
					return ($item['id']);
					case 'date':
						return ($item['date']);
						case 'title':
							return ($item['title']);
							case 'action':
								echo '<div class="d-flex"><button type="button" class="btn btn-primary me-5" data-bs-toggle="modal" data-bs-target="#staticBackdrop'. $item['id'].'">';
								echo __('Show Results', 'lquiz');
								echo '
									</button>
									<form method="post" class="remove-result-form">
    									<input type="hidden" name="function-action" value="form-delete-profile" />
    									<input type="hidden" name="this_id" value="'. $item['id'].
								     '" /><input type="submit" id="remove-result" class="btn btn-danger me-5" value="'. __('Remove', 'lquiz').
								     '" class="button button-primary"  />
    									<a class="btn btn-success" href="'.plugin_dir_url( __DIR__ ) .'exportToPdf.php?id='.$item['id'].'&postid='.$item['postid'].'">Export to PDF</a>
    									</form>
    									</div>
    									<div class="modal fade" id="staticBackdrop'. $item['id'].'" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    									<div class="modal-dialog modal-xl">
    									<div class="modal-content">
    									<h3 class="modal-title" id="staticBackdropLabel">'. __('Result of the Test', 'lquiz').
								     '</h3><button type="button" class="btn-close position-absolute top-0 end-0" data-bs-dismiss="modal" aria-label="Close"></button>
    									<table id="results"><tr> <th>'.
								     __('Question', 'lquiz').
								     '</th> <th>'.
								     __('User Answer/Correct Answer', 'lquiz').
								     '</th><th>'.
								     __('Points', 'lquiz').
								     '</th></tr>';
								foreach($mapFinalArrays as $single) {

									if(strpos($single[0], "__") !== false) {

										echo "<tr><td>";
										$question = str_replace("__",   "<span class='user-answer-span'>".$single[1]."</span>/(<span class='correct-answer-span'>".$single[2].")</span>"   , $single[0]  );
										echo $question;
										echo "<td>".$single[1]."/".$single[2]."</td>";
										if($single[1] == $single[2]) {
											echo "<td>".$single[3]."</td>";
											array_push($array_with_points, $single[3]);
										}
										else{
											echo "<td>0</td>";
											array_push($array_with_points, 0);

										}
										echo "</td></tr>";
									}
									else if(strpos($single[0], "%%%") !== false) {

										echo "<tr><td>";
										$question = str_replace("%%%",   "<span class='user-answer-span'>".$single[1]."</span>/(<span class='correct-answer-span'>".$single[2].")</span>"   , $single[0]  );
										echo $question;
										echo "<td>".$single[1]."/".$single[2]."</td>";
										if($single[1] == $single[2]) {
											echo "<td>".$single[3]."</td>";
											array_push($array_with_points, $single[3]);

										}
										else{
											echo "<td>0</td>";
											array_push($array_with_points, 0);

										}
										echo "</td></tr>";
									}
									else if(strlen($single[2]) > 0) {

										echo "<tr><td>";
										$question = str_replace("%%%","<span class='user-answer-span'>".$single[1]."</span>/(<span class='correct-answer-span'>".$single[2].")</span>"   , $single[0]  );
										echo $question;
											echo "<td>".$single[1]."/".$single[2];
										echo "</td>";
										if(strtolower($single[1]) == strtolower($single[2]) && strlen($single[1]) > 0) {
											echo "<td>".$single[3]."</td>";
											array_push($array_with_points, $single[3]);
										}
										else{
											array_push($array_with_points, 0);
											echo "<td>0</td>";
										}
										echo "</td></tr>";
									}
									else if($single[4] == "5") {
										array_push($array_with_points, $single[3]);

										if(strlen($single[1]) > 0):
											if(strlen($single[1]) == 0){
												continue;
											}

										$grammar = new lquiz_Admin_GrammarApi();
										$grammarChecker= $grammar->runApi($single[1]);
										echo "<tr>";
											echo "<td>".$single[0]."</td>";
										if($grammarChecker){
										echo "<td>".$grammarChecker[0]."</td>";
										}

										$issuesNumber = intval($grammarChecker[1]);
										$pointsDesc = intval($single[3]);
										$totalPoints =   $pointsDesc - $issuesNumber;
											array_push($array_with_points, $totalPoints);

											if($totalPoints < 0){
											$totalPoints = 0;
										}
										echo "<td>".($totalPoints)."</td>";

										echo "</tr>";
										endif;

									}
								}

								echo '<tr><td></td><td><h4>';
								echo __('Points', 'lquiz');
								echo '</h4></td><td><h4>';
								$allPoints = array_sum($array_with_points);
								$pointsMax = array_sum($arrWithPoints);
								echo $allPoints."/".$pointsMax;
								$getProcentResult =  ($allPoints / $pointsMax) * 100;
								echo '</h4></td><tr><td></td><td><h4>';
								echo __('Percentage', 'lquiz');
								echo '</h4></td><td><h4>';
								echo intval($getProcentResult)."%";
								echo '</h4></td></tr></tr></table></div></div></div>';
			}
			endif;
	}
}

function owt_show_data_list_table() {
	$result = new resultTableList();
	$result->prepare_items();
	echo '<h3>Results list</h3>';
	$result->display();
}
owt_show_data_list_table();