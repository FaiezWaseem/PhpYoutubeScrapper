<?php
// OLD functions

function getYoutubeSearchResults($query){
    $content = file_get_contents('https://www.youtube.com/results?search_query='.$query);
    $doc = new DOMDocument();
    @$doc->loadHTML($content);
    $nodes = $doc->getElementsByTagName('script');
    $Var_value = $nodes[33]->nodeValue;
    $res = rtrim(substr($Var_value, 20, strlen($Var_value)), ";");
    $json =  json_decode($res, true);
    $videosJson = $json["contents"]["twoColumnSearchResultsRenderer"]["primaryContents"]["sectionListRenderer"]["contents"][0]["itemSectionRenderer"]["contents"];
    $videos = [];
    foreach ($videosJson as $value) {

        if (isset($value["videoRenderer"])) {
            $_video = $value["videoRenderer"];
            $video['videoId'] = $_video["videoId"];
            $video['thumbnails'] = $_video["thumbnail"]["thumbnails"];
            $video['title'] = $_video["title"]["runs"][0]["text"];
            $video['viewCount'] = $_video["viewCountText"]["simpleText"];
            $video['channelName'] = $_video["longBylineText"]["runs"][0]["text"];
            $video['channelThumbnail'] = $_video["channelThumbnailSupportedRenderers"]["channelThumbnailWithLinkRenderer"]["thumbnail"]["thumbnails"][0]["url"];
            array_push($videos, $video);
        }
        if (isset($value["playlistRenderer"])) {
            $_video = $value["playlistRenderer"];
            $video['playlistId'] = $_video["playlistId"];
            $video['thumbnails'] = $_video["thumbnails"][0]["thumbnails"];
            $video['title'] = $_video["title"]["simpleText"];
            $video['videoCount'] = $_video["videoCount"];
            $video['channelName'] = $_video["longBylineText"]["runs"][0]["text"];
            array_push($videos, $video);
        }
    }
    return $videos;
}
function ytHomePage($url_home)
{
    $content = file_get_contents($url_home);
    $doc = new DOMDocument();
    @$doc->loadHTML($content);
    $nodes = $doc->getElementsByTagName('script');
    $Var_value = $nodes[34]->nodeValue;
    $res = rtrim(substr($Var_value, 20, strlen($Var_value)), ";");
    $json = json_decode($res, true);
    $videosJson = $json["contents"]["twoColumnBrowseResultsRenderer"]["tabs"][0]["tabRenderer"]["content"]["richGridRenderer"]["contents"];
    $videos = [];
    foreach ($videosJson as $value) {
        if (isset($value["richItemRenderer"])) {
            $_video = $value["richItemRenderer"]["content"]["videoRenderer"];
            $video['videoId'] = $_video["videoId"];
            $video['viewCount'] = $_video["viewCountText"]["simpleText"];
            $video['title'] = $_video["title"]["runs"][0]["text"];
            $video['thumbnails'] = $_video["thumbnail"]["thumbnails"];
            $video['description'] = $_video["descriptionSnippet"]["runs"][0]["text"];
            $video['channelName'] = $_video["longBylineText"]["runs"][0]["text"];
            $video['channelThumbnail'] = $_video["channelThumbnailSupportedRenderers"]["channelThumbnailWithLinkRenderer"]["thumbnail"]["thumbnails"][0]["url"];
            array_push($videos, $video);
        }
    }
    return $videos;
}
function getSimilarVideos($url)
{
    $content = file_get_contents($url);
    $doc = new DOMDocument();
    @$doc->loadHTML($content);
    $nodes = $doc->getElementsByTagName('script');
    $Var_value = $nodes[43]->nodeValue;
     $res =  rtrim(substr($Var_value, 20, strlen($Var_value)), ";");
    $json = json_decode($res, true);
    $videosJson = $json["playerOverlays"]["playerOverlayRenderer"]["endScreen"]["watchNextEndScreenRenderer"]["results"];
    $videos = [];
    foreach ($videosJson as $value) {
        if (isset($value["endScreenVideoRenderer"])) {
            $_video = $value["endScreenVideoRenderer"];
            $video['videoId'] = $_video["videoId"];
            $video['thumbnails'] = $_video["thumbnail"]["thumbnails"];
            $video['title'] = $_video["title"]["accessibility"]["accessibilityData"]["label"];
            $video['channelName'] = $_video["shortBylineText"]["runs"][0]["text"];
             array_push($videos, $video);
        }
    }
    return $videos;
}