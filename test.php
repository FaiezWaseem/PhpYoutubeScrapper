<?php

$content = file_get_contents('https://www.youtube.com/watch?v=q1fsBWLpYW4');
$doc = new DOMDocument();
@$doc->loadHTML($content);
$nodes = $doc->getElementsByTagName('script');
$Var_value = $nodes[43]->nodeValue;
$res = rtrim(substr($Var_value, 20, strlen($Var_value)), ";");
$json = json_decode($res, true);
$video_page_response = $json["contents"]["twoColumnWatchNextResults"]["results"]["results"]["contents"];
$size = sizeof($video_page_response);
$top_comment = $video_page_response[$size - 2]["itemSectionRenderer"]["contents"][0]["commentsEntryPointHeaderRenderer"];
$featured_comment = array(
    'Author' => $top_comment["contentRenderer"]["commentsEntryPointTeaserRenderer"]["teaserAvatar"]["accessibility"]["accessibilityData"]["label"],
    'thumbnails' => $top_comment["contentRenderer"]["commentsEntryPointTeaserRenderer"]["teaserAvatar"]["thumbnails"],
    'comment' => $top_comment["contentRenderer"]["commentsEntryPointTeaserRenderer"]["teaserContent"]["simpleText"],
);
$nextToken = $video_page_response[$size - 1]["itemSectionRenderer"]["contents"][0]["continuationItemRenderer"]["continuationEndpoint"]["continuationCommand"]["token"];

echo json_encode(array(
    'top_comment' => $featured_comment,
    'nextToken' => $nextToken
));