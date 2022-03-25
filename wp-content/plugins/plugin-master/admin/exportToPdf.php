<?php
require_once dirname( __DIR__ ) . '/vendor/autoload.php';
$path = $_SERVER['DOCUMENT_ROOT'];
require_once dirname( __DIR__ ) . '/admin/grammarapi.php';

include_once $path . '/wp-config.php';
include_once $path . '/wp-load.php';
include_once $path . '/wp-includes/wp-db.php';
include_once $path . '/wp-includes/pluggable.php';
use Dompdf\Dompdf;
global $wpdb;
$table_name = $wpdb->prefix . "new_scores";

$getId = $_GET['id'];
$getPostId = $_GET['postid'];

$records = $wpdb->get_results("SELECT * FROM $table_name WHERE id = $getId");
$getPostMeta = get_post_meta($getPostId, 'lquiz_questions_field', true);
$arrayWithCorrectAnswers = array();
$title = "";

$arrayWithAnswers = array();
$arrayWithPoints = array();
$arrayWithTitle = array();
$arrayWithExplodedTittles = array();
$arrWithPoints = array();
$arrayWithUserPoints = array();
foreach($records as $record) {
	$title .= $record->title;
}
if($getPostMeta):
foreach($getPostMeta as $item) {

	if ($item['correct'] !== null):
	foreach($item['correct'] as $singleCorrect) {
		array_push($arrayWithPoints, $item['points']);
		array_push($arrayWithCorrectAnswers, $singleCorrect);

	}
	else :
		array_push($arrayWithPoints, $item['points']);


	endif;
	array_push($arrayWithTitle, $item['title']);

}
endif;

foreach($arrayWithTitle as $item) {
	$explodedItems = explode("\n", $item);
	foreach($explodedItems as $single){
		array_push($arrayWithExplodedTittles, $single);
	}
}

$dompdf = new Dompdf();

$html =

	'<style>
   * {
                font-family: "DejaVu Sans Mono", monospace;
            }
#results {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#results td, #results th {
    border: 1px solid #ddd;
    padding: 15px;
}

#results tr:nth-child(even){background-color: #f2f2f2;}

#results tr:hover {background-color: #ddd;}

#results th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #04AA6D;
    color: white;
}</style>
	<h1>' . $title . '</h1><table width="100%" cellspacing="0" cellpadding="0" border="0" id="results">
    <tbody>
      <tr>
        <td><strong>Question</strong></td>
        <td><strong>User Answer / Correct Answer</strong></td>
        <td><strong>Points</strong></td>
      </tr>';

foreach($records as $record){
	$decodeData = json_decode($record->correct);
	foreach($decodeData as $item) {
if($item->answer):
		foreach($item->answer as  $value){
			array_push($arrayWithAnswers, $value);

		}
		endif;

	}

}
$arrayMapFinal = array_map(null, $arrayWithAnswers, $arrayWithCorrectAnswers, $arrayWithPoints, $arrayWithExplodedTittles);

foreach($arrayMapFinal as $item){
	$html .= '<tr>
        <td>';
		if(strpos($item[3], "__") !== false) {
			$question = str_replace("__",   "(".$item[0]."/".$item[1].")"   , $item[3]  );
			$html .= $question;
		}
		else if(strpos($item[3], "%%%") !==false ){
			$question = str_replace("%%%",   "<span style='color:blue'>"."(".$item[0]."/".$item[1].")"."</span>"   , $item[3]  );
			$html .= $question;
		}
		else{
			$html .= $item[3];

		}
	$html .='</td>
        <td>';
		$grammarScore = 0;
		if(intval($item[2]) > 1):
			$grammar = new lquiz_Admin_GrammarApi();
			$grammarChecker= $grammar->runApi($item[0]);
			$html .= $grammarChecker[0];
			$grammarScore += $grammarChecker[1];
			else:
		$html .= $item[0].'/'.$item[1];
			endif;
	$html .= '</td>
        <td>';
		if($item[2] > 1){
			array_push($arrWithPoints, floatval($item[2]));

			$differencePoints = intval($item[2] - intval($grammarScore));
			if($differencePoints < 0){
				$differencePoints = 0;
			}
			$html .= $differencePoints ."/". $item[2];
			array_push($arrayWithUserPoints, floatval($differencePoints));

		}
		else {
			array_push($arrWithPoints, floatval($item[2]));


			if ( $item[0] === $item[1] ):
				array_push($arrayWithUserPoints, floatval($item[2]));

				$html .= $item[2];
			else:
				$html .= '0';
				array_push($arrayWithUserPoints, 0);

			endif;
		}
	$html .='</td>
      </tr>';
}
$pointsMax = array_sum($arrWithPoints);
$pointsUser = array_sum($arrayWithUserPoints);

	$html .= '<tr>
        			<td></td>
        			<td>Total Points</td>
        			<td>';
	$html .= $pointsUser."/".$pointsMax;
	$html .= '</td></tr>';
	$html .= '<tr>
        			<td></td>
        			<td>Percentage</td>
        			<td>';
	$html .= intval((intval($pointsUser)/intval($pointsMax)) * 100);
	$html .= '%</td>
				</tr>';

    $html .= '</tbody> </table>';

$dompdf->loadHtml($html);


/* Render the HTML as PDF */
$dompdf->render();


/* Output the generated PDF to Browser */
$dompdf->stream('test.pdf');