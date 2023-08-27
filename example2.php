<?php
header("Access-Control-Allow-Origin: *");
error_reporting(E_ALL & ~E_DEPRECATED);
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include_once("./yt.php");
$yt = new YT();


/**
 * -----------------------------------
 *          AUTHORIZATION
 * -----------------------------------
 */
$env = parse_ini_file('.env');
$authorization = $env['AUTHORIZATION'];
$cookie = $env['COOKIE'];
$yt->setAuthorization($authorization);
$yt->setCookie($cookie);
// ------------------------------------



if (isset($_GET["videoInfo"])) {
    $vid_id = $_GET["videoInfo"];
    $res = $yt->getVideo($vid_id);
    return response(200, 'ok', $res);
}
if (isset($_GET["search_query"])) {
    $Query = $_GET["search_query"];
    echo response(200, 'ok', $yt->search($Query));
}
if (isset($_GET["recomended"])) {
    echo response(200, 'ok', $yt->HomePageVideos());
}
if (isset($_GET["relatedVideos"])) {
    $videoId = $_GET["relatedVideos"];
    echo response(200, 'ok', $yt->getRelatedVideo($videoId));
}
if (isset($_GET["channel_detail"])) {
    $channelId = $_GET["channel_detail"];
    echo response(200, 'ok', $yt->getChannelMetaDetails($channelId));
}
if (isset($_GET["channel_feature"])) {
    $channelId = $_GET["channel_feature"];
    echo response(200, 'ok', $yt->getChannelFeatured($channelId));
}
if (isset($_GET["channel_live"])) {
    $channelId = $_GET["channel_feature"];
    echo response(200, 'ok', $yt->getChannelLive($channelId));
}
if (isset($_GET["channel_community"])) {
    $channelId = $_GET["channel_feature"];
    echo response(200, 'ok', $yt->getChannelCommunity($channelId));
}
if (isset($_GET["channel_videos"])) {
    $channelId = $_GET["channel_videos"];
    echo response(200, 'ok', $yt->getChannelVideos($channelId));
}
if (isset($_GET["channel_shorts"])) {
    $channelId = $_GET["channel_shorts"];
    echo response(200, 'ok', $yt->getChannelShorts($channelId));
}
if (isset($_GET["channel_playlist"])) {
    $channelId = $_GET["channel_playlist"];
    echo response(200, 'ok', $yt->getChannelPlayList($channelId));
}
if (isset($_GET["getComments"])) {
    echo response(200, 'ok', $yt->getComments($_GET["getComments"]));
}
if (isset($_GET["getReplyComments"])) {
    echo response(200, 'ok', $yt->getReplyComments($_GET["getReplyComments"]));
}
if (isset($_GET["getSearchNext"])) {
    echo response(200, 'ok', $yt->getSearchNext($_GET["getSearchNext"]));
}
if (isset($_GET["recomendedAuth"])) {
    echo response(200, 'ok', $yt->HomePageVideosWithAuth());
}
if (isset($_GET["getHomeNext"])) {
    echo response(200, 'ok', $yt->HomePageVideosNext($_GET["getHomeNext"]));
}


function response($status, $status_message, $data)
{
    header("HTTP/1.1 " . $status);
    $response['status'] = $status;
    $response['status_message'] = $status_message;
    $response['data'] = $data;
    $json_response = json_encode($response);
    echo $json_response;
}