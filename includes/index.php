<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
     
$content =  file_get_contents("https://5c0ebee2-7d74-43fd-8a3a-b96fcbb49c2b:C1IhFy1GfHR0@gateway.watsonplatform.net/retrieve-and-rank/api/v1/solr_clusters/sca6c5105f_f181_436d_995a_4c88f20edacb/solr/DESIGN/select?q='".urlencode('what is the speed of USB 2.0 devices')."'&wt=json", true);
$decoded = json_decode($content,JSON_PRETTY_PRINT);
echo count($decoded['response']['docs']);
print_r($decoded['response']['docs']);	

?>
