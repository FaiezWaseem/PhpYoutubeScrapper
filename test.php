<?php

/*
   Testing file only for test
*/

$content = file_get_contents('https://www.youtube.com/results?search_query=React');
$doc = new DOMDocument();
@$doc->loadHTML($content);
$nodes = $doc->getElementsByTagName('script');
$Var_value = $nodes[33]->nodeValue;
$res = rtrim(substr($Var_value, 20, strlen($Var_value)), ";");
$json = json_decode($res, true);
$video_page_response = $json["contents"]["twoColumnSearchResultsRenderer"]["primaryContents"]["sectionListRenderer"]["contents"];
$size = sizeof($video_page_response);
$nextToken = $video_page_response[$size - 1]["continuationItemRenderer"]["continuationEndpoint"]["continuationCommand"]["token"];
echo $nextToken;