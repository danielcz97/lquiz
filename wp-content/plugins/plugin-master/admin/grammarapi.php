<?php
require_once dirname( __DIR__ ) . '/vendor/autoload.php';

use GrammarBot\GrammarBot;

class lquiz_Admin_GrammarApi {
	public function runApi(  $text )  {
		$base_uri = 'http://api.grammarbot.io/v2';

		$endpoint = '/check';

		$lang = 'pl-PL';

		$api_key = 'kedgEasERWSzxc!@12';
		$grammarbot = new GrammarBot( $base_uri, $endpoint, $api_key, $lang );
		if ( strlen( $text ) > 50 ):
			$json = $grammarbot->check( $text );
		$matches = $json->matches;

		$arrayWithIssues = [];
		foreach ( $matches as $match ) {
			$arrayWithIssues[] = array( "text" => $match->context->text, "issue" => $match->rule->description );
		}
		$arrayWithChangesStrings = [];
		$arrWithIssues=[];
		$counter = 0;
		foreach($matches as $item) {
			$issueText = $item->context->text;
			$issueType = $item->message;
			$replace = str_replace("...", "", $issueText);
			if (stripos($text, $replace) !== false) {
				$counter +=1;

				array_push($arrWithIssues, $replace);
				array_push($arrayWithChangesStrings, "<span style='color:red' data-bs-toggle='tooltip' title='".$issueType."'>".$replace."</span>");
			}
		}
		return [(str_replace($arrWithIssues, $arrayWithChangesStrings, $text, $count)), $counter];
		endif;

	}


}

