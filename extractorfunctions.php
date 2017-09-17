<?php



function urlfixer($url){

	if (strpos($url, "http://") === false && strpos($url, "https://") === false) {
    $url = "http://".$url;
   }
   return $url;
}


function determine_extractor($url){


	if (strpos($url, "azlyrics") !== false) {
	    return azlyric_extractor($url);
	}

	if (strpos($url, "lyricsmode") !== false) {
	    return lyricsmode_extractor($url);
	}

	if (strpos($url, "metrolyrics") !== false) {
	    return metrolyrics_extractor($url);
	}

	else{return "INCORRECT URL ENTERED. PLEASE MAKE SURE THE PASTED LINKS ARE FROM AZLYRICS.COM, LYRICSMODE, OR METROLYRICS.";}


}




function azlyric_extractor($url) {

$htmldoc = new DOMDocument;
libxml_use_internal_errors(true);
$htmldoc->loadHTMLFile($url);


$xpath = new DOMXpath($htmldoc);


$nodes= $xpath->query('//comment()[. = " Usage of azlyrics.com content by any third-party lyrics provider is prohibited by our licensing agreement. Sorry about that. "][1]/parent::*[1]');

$title_node= $xpath->query('//span[@id="cf_text_top"][1]/following::*[1]');
foreach($title_node as $node1){
$title[]="\r\n \r\n \r\n \r\n".strtoupper($node1->textContent);}

	foreach ($nodes as $node) {
	   
	    $raw_lyrics= $node->c14n();
	}


$paras= preg_split('/<br>(.*)<br>/i', $raw_lyrics);



$unfiltered_para_array = array_map(function($v){
    return trim(strip_tags($v));
}, $paras);

$unfiltered_para_array = array_merge( $title, $unfiltered_para_array);

$unfiltered_para_array= preg_replace('/&#xD;/i', '', $unfiltered_para_array);
$filtered_para_array_with_title= preg_replace('/\n\n/i', '', $unfiltered_para_array);
return $filtered_para_array_with_title;
}



function lyricsmode_extractor($url) {

$htmldoc = new DOMDocument;
libxml_use_internal_errors(true);
$htmldoc->loadHTMLFile($url);


$xpath = new DOMXpath($htmldoc);



$nodes= $xpath->query('//p[@class="ui-annotatable"][1]');

$title_node= $xpath->query('//h1[@class="song_name fs32"][1]');
foreach($title_node as $node1){
$title[]="\r\n \r\n \r\n \r\n".strtoupper($node1->textContent);}

	foreach ($nodes as $node) {
	   
	    $raw_lyrics= $node->c14n();
	}


$paras= preg_split('/<br>(.*)<br>/i', $raw_lyrics);



$unfiltered_para_array = array_map(function($v){
    return trim(strip_tags($v));
}, $paras);



$unfiltered_para_array = array_merge( $title, $unfiltered_para_array);

$unfiltered_para_array= preg_replace('/\*ending/i', '', $unfiltered_para_array);
$unfiltered_para_array= preg_replace('/\*/i', '', $unfiltered_para_array);
$filtered_para_array_with_title= preg_replace('/\n\n/i', '', $unfiltered_para_array);
return $filtered_para_array_with_title;
}

	


function metrolyrics_extractor($url) {

$htmldoc = new DOMDocument;
libxml_use_internal_errors(true);
$htmldoc->loadHTMLFile($url);


$xpath = new DOMXpath($htmldoc);


$classname="verse";
$nodes= $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");

$title_node= $xpath->query('//h1[1]');
foreach($title_node as $node1){
$title[]="\r\n \r\n \r\n \r\n".strtoupper($node1->textContent);}

$raw_lyrics = "";
$i=0;
	foreach ($nodes as $node) {
	   
	   // = $node->c14n();
	    $newdoc = new DOMDocument();
    	$cloned = $node->cloneNode(TRUE);
    	$newdoc->appendChild($newdoc->importNode($cloned,TRUE));
    	$raw_lyrics[$i] = $newdoc->saveHTML();
    	$i++;
	}




$unfiltered_para_array = array_map(function($v){
    return trim(strip_tags($v));
}, $raw_lyrics);



$unfiltered_para_array = array_merge( $title, $unfiltered_para_array);

$unfiltered_para_array= preg_replace('/\*ending/i', '', $unfiltered_para_array);
$unfiltered_para_array= preg_replace('/\*/i', '', $unfiltered_para_array);
$filtered_para_array_with_title= preg_replace('/\n\n/i', '', $unfiltered_para_array);
return $filtered_para_array_with_title;
}



	
//print_r(array_values(metrolyrics_extractor("http://www.metrolyrics.com/i-love-you-lord-lyrics-petra.html")));







?>
