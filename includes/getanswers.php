<?php
ini_set('memory_limit', '96M');
ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');
ini_set('allow_url_fopen', 'on');
ini_set('mbstring.encoding_translation', 'on');

//** questions array Start **//
$questions = array('what is a string descriptor','how to know manufacturer of USB device','what is speed of USB 2.0 devices','What is difference between USB 2.0 hubs and USB 3.0 hubs','What is maximum length of low speed cable','what is reliable scalable cluster technology','What is the command to know the installed RSCT version','What is the path of the MPM configuration file','What are the libraries used for ioctl subroutine','What is the third parameter of ioctl subroutine for fioasync command','When will ioctl subroutine fails');
//** questions array  End**//
error_reporting(E_ALL);
ini_set('display_errors', 0);
extract($_REQUEST);
$question = $_REQUEST['question'];
if($question != ''){
	
	$myfile = file_put_contents('../logs.txt', $question.PHP_EOL , FILE_APPEND | LOCK_EX);
	
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://5c0ebee2-7d74-43fd-8a3a-b96fcbb49c2b:C1IhFy1GfHR0@gateway.watsonplatform.net/retrieve-and-rank/api/v1/solr_clusters/sca6c5105f_f181_436d_995a_4c88f20edacb/solr/DESIGN/fcselect?ranker_id=7ff711x34-rank-107&q='".urlencode($question)."'&wt=json&rows=5");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
curl_close($ch);
$machineSearchcontent = $data; 
//exit;
//	$machineSearchcontent =  file_get_contents("https://5c0ebee2-7d74-43fd-8a3a-b96fcbb49c2b:C1IhFy1GfHR0@gateway.watsonplatform.net/retrieve-and-rank/api/v1/solr_clusters/sca6c5105f_f181_436d_995a_4c88f20edacb/solr/DESIGN/fcselect?ranker_id=81aacex30-rank-18034&q='".urlencode($question)."'&wt=json&rows=5", true);

	
	$decoded = json_decode($machineSearchcontent,JSON_PRETTY_PRINT);
	//** Start json pasring for machine search **//
	

	$info = $decoded['response']['docs'];

	$numberOfrows = count($decoded['response']['docs']);
	$content = '';
	$serviceSearch = '';
	if($numberOfrows > 0) {
	
	for($i=0; $i<$numberOfrows; $i++){
		$title = substr($info[$i]['body'], 0, strpos($info[$i]['body'], '.'));
		$score = $info[$i]['score'];
		if($score <= 1){
			$scoreclass = 'results--increase-icon icon results--increase-icon_DOWN icon-arrow_down';
		}
		else {
			$scoreclass = 'results--increase-icon icon results--increase-icon_UP icon-arrow_up';
		}
		$confidenceValue = $info[$i]['ranker.confidence'];
		$confidenceValue = round($confidenceValue,2);

		if($confidenceValue == 0){
			$confidencebar ='<div class="results--item-score-bar"></div>
			<div class="results--item-score-bar"></div>
			<div class="results--item-score-bar"></div>
			<div class="results--item-score-bar"></div>';
		}
		else if($confidenceValue >= 0.2 && $confidenceValue <= 0.39){
			$confidencebar = '<div class="results--item-score-bar green"></div>
						<div class="results--item-score-bar green"></div>
						<div class="results--item-score-bar"></div>
						<div class="results--item-score-bar"></div>';
		}
		else if($confidenceValue >= 0.1 && $confidenceValue <= 0.29){
			$confidencebar = '<div class="results--item-score-bar green"></div>
						<div class="results--item-score-bar"></div>
						<div class="results--item-score-bar"></div>
						<div class="results--item-score-bar"></div>';
		}
		else if($confidenceValue >= 0.4 && $confidenceValue <= 0.5){
			$confidencebar = '<div class="results--item-score-bar green"></div>&nbsp;
						<div class="results--item-score-bar green"></div>&nbsp;
						<div class="results--item-score-bar green"></div>&nbsp;
						<div class="results--item-score-bar"></div>';
		}
		else if($confidenceValue >= 0.5){
			$confidencebar = '<div class="results--item-score-bar green"></div>
						<div class="results--item-score-bar green"></div>
						<div class="results--item-score-bar green"></div>
						<div class="results--item-score-bar green"></div>';
		}
		$serviceSearch.='<div class="results--item result--template" style="display: block;">
			<div class="results--item-container">
				<div class="results--item-rank">
					<span class="'.$scoreclass.'"></span><span class="results--increase-value">&nbsp;'.$score.'</span>
				</div>
				<div class="results--basic-info">
					<div class="results--item-text">'.html_entity_decode($title, ENT_QUOTES, "UTF-8").'.
						<span class="icon icon-see_more results--see-more" id='.$i.'></span>
					</div>
					<div class="results--item-score">
						<div class="results--item-score-title">Confidence</div>
						<div class="results--item-score-value">'.$confidencebar.'
						</div>
					</div>
				</div>
				<div class="results--more-info_'.$i.'" style="display: none;">
					<blockquote class="results--item-details base--blockquote">'.html_entity_decode($info[$i]['contentHtml'], ENT_QUOTES, "UTF-8").'<br><br><b>Source</b>: '.$info[$i]['fileName'].'</blockquote>
				</div>
			</div>
		</div>';
	}
	//$serviceSearch = mb_convert_encoding($serviceSearch, 'UTF-8', 'UTF-8'); 
	$serviceSearch = html_entity_decode($serviceSearch, ENT_QUOTES, "UTF-8");
	$serviceSearch = str_replace("â†'", '', $serviceSearch);
	file_put_contents("service.txt", $serviceSearch);
	//** End json pasring for machine search **//
	//** Start json pasring for Standard search **//
	
	//$standardSearchcontent  =  file_get_contents("https://5c0ebee2-7d74-43fd-8a3a-b96fcbb49c2b:C1IhFy1GfHR0@gateway.watsonplatform.net/retrieve-and-rank/api/v1/solr_clusters/sca6c5105f_f181_436d_995a_4c88f20edacb/solr/DESIGN/select?q='".urlencode($question)."'&wt=json", true);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://5c0ebee2-7d74-43fd-8a3a-b96fcbb49c2b:C1IhFy1GfHR0@gateway.watsonplatform.net/retrieve-and-rank/api/v1/solr_clusters/sca6c5105f_f181_436d_995a_4c88f20edacb/solr/DESIGN/select?q='".urlencode($question)."'&wt=json");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
curl_close($ch);
$standardSearchcontent = $data;
	$decoded = json_decode($standardSearchcontent,JSON_PRETTY_PRINT);
	$info = $decoded['response']['docs'];
	$numberOfrows = count($decoded['response']['docs']);	
	$content.= '@@@@@@@';
	$standarSearch = '';
	for($j=0; $j<$numberOfrows; $j++){
		$title = substr($info[$j]['body'], 0, strpos($info[$j]['body'], '.'));
		$standarSearch.='<div class="results--item result--template" style="display: block;">
			<div class="results--item-container">
				<div class="results--item-rank">
					<span ></span><span class="results--increase-value"></span>
				</div>
				<div class="results--basic-info">
					<div class="results--item-text">'.html_entity_decode($title, ENT_QUOTES, "UTF-8").'.
						<span class="icon icon-see_more results--see-more" id='.$i.'></span>
					</div>
					<div class="results--item-score">
						<div class="results--item-score-title"></div>
						<div class="results--item-score-value">
							<div class="results--item-score-value"></div>
							<div class="results--item-score-value"></div>
							<div class="results--item-score-value"></div>
							<div class="results--item-score-value"></div>
						</div>
					</div>
				</div>
				<div class="results--more-info_'.$i.'" style="display: none;">
					<blockquote class="results--item-details base--blockquote">'.html_entity_decode($info[$j]['contentHtml'], ENT_QUOTES, "UTF-8").'<br><br><b>Source</b>: '.$info[$j]['fileName'].'</blockquote>
				</div>
			</div>
		</div>';
		$i++;
		}
	}
	//$standarSearch = mb_convert_encoding($standarSearch, 'UTF-8', 'UTF-8'); 
	$standarSearch = html_entity_decode($standarSearch, ENT_QUOTES, "UTF-8");
	$standarSearch = str_replace("â†'", '', $standarSearch);
	file_put_contents("standard.txt", $standarSearch);
	//** End json pasring for Standard search **//

}
else if($action == 'random'){
	//** Start code to get random question **//
		$rand_num = array_rand($questions);
		$content = $questions[$rand_num];
	//** End code to get random question **//
}
echo $content;

?>