<?php

/********************************************************************
NOTE
Started this project just for testing and fun i dont recommend 
using it , The script works fine as of now June 21 2023
Some stuff like video playable url dont work after a time 
if send too many requests.
I know code is dirty sorry for that is hard to read even i dont
understand it after a week or two but atleast its working, thats 
all matters to me :> 
*********************************************************************/
class YT
{

    protected $base_url = 'https://www.youtube.com/';

    protected $video_url = 'watch?v=';

    protected $search_query = 'results?search_query=';

    protected $channel = 'channel/';

    protected $authorization = null;

    protected $cookie = null;

    protected $FEATURED = 'featured';
    protected $VIDEOS = 'videos';
    protected $SHORTS = 'shorts';
    protected $PLAYLIST = 'playlists';
    protected $STREAMS = 'streams';
    protected $COMMUNITY = 'community';
    protected $ABOUT = 'about';



    public function setCookie(string $_ck)
    {
        $this->cookie = $_ck;
    }
    public function setAuthorization(string $_auth)
    {
        $this->authorization = $_auth;
    }
    /*
    GET THE VIDEO ARRAY OF YT HOMEPAGE
    THE RESULT DEPENDS ON SERVER LOCATION
    IF IN AMERICA RETURN YT AMERICA TRENDING VIDEOS
    */
    public function HomePageVideos()
    {
        $html = $this->get($this->base_url);
        $json = $this->getInitalData($html, 34);
        return $this->parseHomePageVideos($json);
    }
    /**
     *  To Get Your Videos With Channel Authentications
     *  Like You want the videos recommendations from your
     *  Youtube Account Set Cookie and Authorization
     *  
     *   Story : So youtube need a Authorization and a Cookie header to keep
     *   the record of wheter user is logged in or not , So We just neet to pass that and we are good 
     *   to go.
     * 
     */
    public function HomePageVideosWithAuth()
    {
        if ($this->authorization && $this->cookie) {
            $_auth = $this->authorization;
            $ck = $this->cookie;

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://www.youtube.com/",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "Accept: */*",
                    "User-Agent: Thunder Client (https://www.thunderclient.com)",
                    "authorization: $_auth",
                    "cookie: $ck",
                    "x-goog-authuser: 1",
                    "x-goog-visitor-id: CgtmZXN5X0VMZGwwSSi-jKykBg%3D%3D",
                    "x-origin: https://www.youtube.com",
                    "x-youtube-client-name: 1",
                    "x-youtube-client-version: 2.20230613.01.00"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $json = $this->getInitalData($response, 34);
                // return $json;
                return $this->parseHomePageVideos($json);
            }
        } else {
            throw new ErrorException("User is ot Authorized");
        }
    }
    public function HomePageVideosNext(string $continuationToken = null)
    {
        if ($this->authorization && $this->cookie) {
            $_auth = $this->authorization;
            $ck = $this->cookie;
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://www.youtube.com/youtubei/v1/browse?key=AIzaSyAO_FJ2SlqU8Q4STEHLGCilw_Y9_11qcW8&prettyPrint=false",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n  \"context\": {\n    \"client\": {\n      \"hl\": \"en-GB\",\n      \"gl\": \"UK\",\n      \"remoteHost\": \"119.152.234.18\",\n      \"deviceMake\": \"\",\n      \"deviceModel\": \"\",\n      \"visitorData\": \"CgtmZXN5X0VMZGwwSSi-jKykBg%3D%3D\",\n      \"userAgent\": \"Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36,gzip(gfe)\",\n      \"clientName\": \"WEB\",\n      \"clientVersion\": \"2.20230613.01.00\",\n      \"osName\": \"Windows\",\n      \"osVersion\": \"6.3\",\n      \"originalUrl\": \"https://www.youtube.com/\",\n      \"platform\": \"DESKTOP\",\n      \"clientFormFactor\": \"UNKNOWN_FORM_FACTOR\",\n      \"configInfo\": {\n        \"appInstallData\": \"CL6MrKQGEMzfrgUQssavBRD4ta8FEInorgUQzK7-EhCi7K4FEMy3_hIQ1bavBRDi1K4FEIKdrwUQkKOvBRDwtq8FEMO3_hIQ57qvBRDzqK8FELq0rwUQq7evBRC4i64FEOuTrgUQpZmvBRCitK8FEKXC_hIQ26-vBRDn964FEOCnrwUQj8OvBRDpw68FEO6irwUQ5LP-EhC9tq4FEKqy_hIQjLevBRDUoa8FEP61rwUQlb-vBRDetq8FEJvV_hI%3D\"\n      },\n      \"timeZone\": \"Asia/Karachi\",\n      \"browserName\": \"Chrome\",\n      \"browserVersion\": \"109.0.0.0\",\n      \"acceptHeader\": \"text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8\",\n      \"deviceExperimentId\": \"ChxOekU0T0RnMU9EazBORGt5TlRrMk1qTTFNQT09EL6MrKQGGJ_qj54G\",\n      \"screenWidthPoints\": 980,\n      \"screenHeightPoints\": 1672,\n      \"screenPixelDensity\": 2,\n      \"screenDensityFloat\": 2,\n      \"utcOffsetMinutes\": 300,\n      \"userInterfaceTheme\": \"USER_INTERFACE_THEME_LIGHT\",\n      \"memoryTotalKbytes\": \"8000000\",\n      \"mainAppWebInfo\": {\n        \"graftUrl\": \"https://www.youtube.com/\",\n        \"pwaInstallabilityStatus\": \"PWA_INSTALLABILITY_STATUS_CAN_BE_INSTALLED\",\n        \"webDisplayMode\": \"WEB_DISPLAY_MODE_BROWSER\",\n        \"isWebNativeShareAvailable\": false\n      }\n    },\n    \"user\": {\n      \"lockedSafetyMode\": false\n    },\n    \"request\": {\n      \"useSsl\": true,\n      \"internalExperimentFlags\": [],\n      \"consistencyTokenJars\": []\n    },\n    \"clickTracking\": {\n      \"clickTrackingParams\": \"CBgQ8eIEIhMIvJi5wKXF_wIVS1YPAh2Ebwev\"\n    },\n    \"adSignalsInfo\": {\n      \"params\": [\n        {\n          \"key\": \"dt\",\n          \"value\": \"1686832707442\"\n        },\n        {\n          \"key\": \"flash\",\n          \"value\": \"0\"\n        },\n        {\n          \"key\": \"frm\",\n          \"value\": \"0\"\n        },\n        {\n          \"key\": \"u_tz\",\n          \"value\": \"300\"\n        },\n        {\n          \"key\": \"u_his\",\n          \"value\": \"2\"\n        },\n        {\n          \"key\": \"u_h\",\n          \"value\": \"962\"\n        },\n        {\n          \"key\": \"u_w\",\n          \"value\": \"564\"\n        },\n        {\n          \"key\": \"u_ah\",\n          \"value\": \"962\"\n        },\n        {\n          \"key\": \"u_aw\",\n          \"value\": \"564\"\n        },\n        {\n          \"key\": \"u_cd\",\n          \"value\": \"24\"\n        },\n        {\n          \"key\": \"bc\",\n          \"value\": \"31\"\n        },\n        {\n          \"key\": \"bih\",\n          \"value\": \"1671\"\n        },\n        {\n          \"key\": \"biw\",\n          \"value\": \"980\"\n        },\n        {\n          \"key\": \"brdim\",\n          \"value\": \"0,0,0,0,564,0,564,962,980,1672\"\n        },\n        {\n          \"key\": \"vis\",\n          \"value\": \"1\"\n        },\n        {\n          \"key\": \"wgl\",\n          \"value\": \"true\"\n        },\n        {\n          \"key\": \"ca_type\",\n          \"value\": \"image\"\n        }\n      ]\n    }\n  },\n  \"continuation\": \"$continuationToken\"\n}",
                CURLOPT_HTTPHEADER => [
                    "Accept: */*",
                    "User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Mobile Safari/537.36",
                    "authorization: $_auth",
                    "content-type: application/json",
                    "cookie: $ck",
                    "x-goog-authuser: 1",
                    "x-goog-visitor-id: CgtmZXN5X0VMZGwwSSi-jKykBg%3D%3D",
                    "x-origin: https://www.youtube.com",
                    "x-youtube-client-name: 1",
                    "x-youtube-client-version: 2.20230613.01.00"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $response = json_decode($response);
                $videosJson = $response->onResponseReceivedActions[0]->appendContinuationItemsAction->continuationItems;
                $videos = [];
                $nextToken = null;
                foreach ($videosJson as $value) {
                    if (isset($value->richItemRenderer)) {
                        $_video = $value->richItemRenderer->content->videoRenderer;
                        $video['videoId'] = $_video->videoId ?? '';
                        $video['viewCount'] = $_video->viewCountText->simpleText ?? '';
                        $video['title'] = $_video->title->runs[0]->text ?? '';
                        $video['thumbnails'] = $_video->thumbnail->thumbnails ?? [];
                        $video['description'] = $_video->descriptionSnippet->runs[0]->text ?? '';
                        $video['channelName'] = $_video->longBylineText->runs[0]->text ?? '';
                        $video['channelThumbnail'] = $_video->channelThumbnailSupportedRenderers->channelThumbnailWithLinkRenderer->thumbnail->thumbnails[0]->url ?? [];
                        $video['publishedTime'] = $_video->publishedTimeText->simpleText ?? '';
                        $video['length'] = $_video->lengthText->accessibility->accessibilityData->label ?? '';
                        array_push($videos, $video);
                    }
                    if (isset($value->continuationItemRenderer)) {
                        $nextToken = $value->continuationItemRenderer->continuationEndpoint->continuationCommand->token;
                    }
                }
                return [
                    'videos' => $videos,
                    'nextToken' => $nextToken,
                ];
            }
        } else {
            throw new ErrorException("User is ot Authorized");
        }
    }
    /**
     *  RETURNS A RESULT OF VIDEO ARRAY 
     *  ON QUERY $query can be Php+Tutorial
     *  no space '+' sign instead of space
     *    @param string $query
     *    @return array
     */

    public function search($query)
    {
        $html = $this->get($this->base_url . $this->search_query . $query);
        $json = $this->getInitalData($html, 33);
        return $this->parseSearchResult($json);
    }
    /*
    pass a video Id it will return its related
    videos Array
    @param string $videoId
    @return array
    */
    public function getRelatedVideo($videoId)
    {
        $html = $this->get($this->base_url . $this->video_url . $videoId);
        $json = $this->getInitalData($html, 43);
        return $this->parserelatedVideoResult($json);
    }
    /*
    pass the channelId as String 
    get an Array of Videos Object
    */
    public function getChannelFeatured($channelId)
    {
        $html = $this->get($this->base_url . $this->channel . $channelId);
        $json = $this->getInitalData($html, 37);
        return $this->getParseChannelVideos($json, $this->FEATURED);
    }
    /*
    pass the channelId as String 
    get an Array of Videos Object
    */
    public function getChannelLive($channelId)
    {
        $html = $this->get($this->base_url . $this->channel . $channelId . '/streams');
        $json = $this->getInitalData($html, 37);
        return $this->getParseChannelVideos($json, $this->STREAMS);
    }
    public function getChannelCommunity($channelId)
    {
        $html = $this->get($this->base_url . $this->channel . $channelId . '/community');
        $json = $this->getInitalData($html, 37);
        return $this->getParseChannelVideos($json, $this->COMMUNITY);
    }
    public function getChannelAbout($channelId)
    {
        $html = $this->get($this->base_url . $this->channel . $channelId . '/about');
        $json = $this->getInitalData($html, 37);
        return $this->getParseChannelVideos($json, $this->ABOUT);
    }
    /*
    pass the channelId as String 
    get an Array of Videos Object
    */
    public function getChannelVideos($channelId)
    {
        $html = $this->get($this->base_url . $this->channel . $channelId . '/videos');
        $json = $this->getInitalData($html, 34);
        return $this->getParseChannelVideos($json, $this->VIDEOS);
    }
    /*
    pass the channelId as String 
    get an Array of Videos 
    */
    public function getChannelShorts($channelId)
    {
        $html = $this->get($this->base_url . $this->channel . $channelId . '/shorts');
        $json = $this->getInitalData($html, 34);
        return $this->getParseChannelVideos($json, $this->SHORTS);
    }
    /*
    pass the channelId as String 
    get an Array of Videos 
    */
    public function getChannelPlayList(string $channelId)
    {
        $html = $this->get($this->base_url . $this->channel . $channelId . '/playlists');
        $json = $this->getInitalData($html, 34);
        return $this->getParseChannelVideos($json, $this->PLAYLIST);
        // return $json;
    }
    /*
    pass the channelId as String 
    get an Array Object(title,avatar,banner,mobileBanner,videosCount,tagline,description)
    */
    public function getChannelMetaDetails($channelId)
    {
        $html = $this->get($this->base_url . $this->channel . $channelId . '/playlists');
        $json = $this->getInitalData($html, 34);
        $totalTabs = sizeof($json['contents']['twoColumnBrowseResultsRenderer']['tabs']);
        return array(
            'title' => $this->arrayGet($json, 'header.c4TabbedHeaderRenderer.title', ''),
            'avatar' => $this->arrayGet($json, 'header.c4TabbedHeaderRenderer.avatar.thumbnails', []),
            'banner' => $this->arrayGet($json, 'header.c4TabbedHeaderRenderer.banner.thumbnails', []),
            'mobileBanner' => $this->arrayGet($json, 'header.c4TabbedHeaderRenderer.mobileBanner.thumbnails', []),
            'videosCount' => $this->arrayGet($json, 'header.c4TabbedHeaderRenderer.videosCountText.runs.0.text', ''),
            'tagline' => $this->arrayGet($json, 'header.c4TabbedHeaderRenderer.tagline.channelTaglineRenderer.content', ''),
            'description' => $this->arrayGet($json, 'metadata.channelMetadataRenderer.description', ''),
            'totalTabs' => $totalTabs,
        );
    }

    /*
    Get video detail ,  Related Videos , Top Comment and comment Token
    Comment Token is used to load more comments can be used
    with getComments method.
    VideoInfo gives title desc thumbnail downloadurl etc
    Related videos gives an Array 
    */
    public function getVideo($videoId)
    {
        $html = $this->get($this->base_url . $this->video_url . $videoId);
        $json = $this->getPlayerResponse($html);
        $json2 = $this->getInitalData($html, 43);
        $subs = $json2["contents"]["twoColumnWatchNextResults"]["results"]["results"]["contents"][1]["videoSecondaryInfoRenderer"]["owner"]["videoOwnerRenderer"]["subscriberCountText"]["simpleText"];
        $video = $this->parseVideo($json);
        $video["subscriber"] = $subs;
        return array(
            'video' => $video,
            'recomended' => $this->parserelatedVideoResult($json2),
            'comment' => $this->getVideoCommentInfo($json2)
        );
    }
    /*
    pass the commentToken obtained from getVideo method or obtained 
    from last loaded comments
    */
    public function getComments(string $nextToken)
    {
        $json = $this->postNext($nextToken);
        // return $json;
        return $this->getParsedComments($json);
    }

    public function getReplyComments(string $nextToken)
    {
        $json = $this->postNext($nextToken);
        return $this->getParsedReplyComments($json);

    }
    /*
    @params $nextToken 
    you obtain nextToken from search function 
    when you search something u will recive a
    nextSearchToken pass that here it load more 
    results and generate a new nextSearch Token
    */
    public function getSearchNext($nextToken)
    {
        $json = $this->postNext($nextToken, 'search');
        return $this->getParsedSearchResult($json);
    }


    public function getSearchSuggestions($query)
    {
        $search_url = "https://suggestqueries-clients6.youtube.com/complete/search?client=youtube&hl=en-gb&gl=pk&sugexp=uqap13niqtn222%2Cytpo.bo.me%3D1%2Cytposo.bo.me%3D1%2Cytpo.bo.ro.mi%3D24381100%2Cytposo.bo.ro.mi%3D24381100%2Ccfro%3D1%2Cytpo.bo.me%3D0%2Cytposo.bo.me%3D0%2Cytpo.bo.ro.mi%3D24372967%2Cytposo.bo.ro.mi%3D24372967&gs_rn=64&gs_ri=youtube&authuser=1&tok=jyC9ATTibQdWkrbg_vfP4Q&ds=yt&cp=4&gs_id=m&q=$query&callback=google.sbox.p50&gs_gbg=ab4h6fv1Rwx36vY6ocxqP6";
        $response = $this->get($search_url);
        return $response;
    }


    protected function getParsedSearchResult($json)
    {
        $root = $json->onResponseReceivedCommands[0]->appendContinuationItemsAction->continuationItems;
        $videos = $root[0]->itemSectionRenderer->contents;
        $VideosSize = sizeof($videos) - 2;
        $videos_parsed = array();
        for ($i = 0; $i < $VideosSize; $i++) {
            $video = $videos[$i]->videoWithContextRenderer ?? null;
            if ($video) {
                array_push(
                    $videos_parsed,
                    array(
                        'videoId' => $video->videoId,
                        'thumbnails' => $video->thumbnail->thumbnails,
                        'title' => $video->headline->runs[0]->text ?? '',
                        'viewCount' => $video->shortViewCountText->runs[0]->text,
                        'publishedAt' => $video->publishedTimeText->runs[0]->text,
                        'channelName' => $video->shortBylineText->runs[0]->text,
                        'channelThumbnail' => $video->channelThumbnail->channelThumbnailWithLinkRenderer->thumbnail->thumbnails[0]->url ?? [],
                    )
                );
            }
        }
        return array(
            'videos' => $videos_parsed,
            'nextToken' => $root[sizeof($root) - 1]->continuationItemRenderer->continuationEndpoint->continuationCommand->token ?? null
        );
    }
    // Works for loading more Comments and Also for loading more search results
    protected function postNext(string $nextToken, $param = 'next')
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://www.youtube.com/youtubei/v1/$param?key=AIzaSyAO_FJ2SlqU8Q4STEHLGCilw_Y9_11qcW8&prettyPrint=false",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\r\n  \"context\": {\r\n    \"client\": {\r\n      \"hl\": \"en-GB\",\r\n      \"gl\": \"PK\",\r\n      \"deviceMake\": \"Google\",\r\n      \"deviceModel\": \"Nexus 5\",\r\n      \"visitorData\": \"CgtmZXN5X0VMZGwwSSiE1qWkBg%3D%3D\",\r\n      \"userAgent\": \"Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Mobile Safari/537.36,gzip(gfe)\",\r\n      \"clientName\": \"MWEB\",\r\n      \"clientVersion\": \"2.20230607.06.00\",\r\n      \"osName\": \"Android\",\r\n      \"osVersion\": \"6.0\",\r\n      \"playerType\": \"UNIPLAYER\",\r\n      \"screenPixelDensity\": 2,\r\n      \"platform\": \"MOBILE\",\r\n      \"clientFormFactor\": \"SMALL_FORM_FACTOR\",\r\n      \"screenDensityFloat\": 2,\r\n      \"browserName\": \"Chrome Mobile\",\r\n      \"browserVersion\": \"109.0.0.0\",\r\n      \"acceptHeader\": \"text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8\",\r\n      \"deviceExperimentId\": \"ChxOekU0T0RnMU9EazBORGt5TlRrMk1qTTFNQT09EITWpaQGGJ_qj54G\",\r\n      \"screenWidthPoints\": 564,\r\n      \"screenHeightPoints\": 962,\r\n      \"utcOffsetMinutes\": 300,\r\n      \"userInterfaceTheme\": \"USER_INTERFACE_THEME_LIGHT\",\r\n      \"memoryTotalKbytes\": \"4000000\",\r\n      \"mainAppWebInfo\": {\r\n        \"webDisplayMode\": \"WEB_DISPLAY_MODE_BROWSER\",\r\n        \"isWebNativeShareAvailable\": false\r\n      }\r\n    }\r\n  },\r\n  \"continuation\": \"$nextToken\"\r\n}",
            CURLOPT_HTTPHEADER => [
                "Accept: */*",
                "Content-Type: application/json",
                "User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Mobile Safari/537.36"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    }

    protected function getParsedReplyComments($json)
    {
        $comments = $json->onResponseReceivedEndpoints[0]->appendContinuationItemsAction->continuationItems;
        $commentsSize = sizeof($comments) - 2;
        $comments_parsed = array();
        for ($i = 0; $i < $commentsSize; $i++) {
            $comment = $comments[$i]->commentRenderer;
            array_push(
                $comments_parsed,
                array(
                    'Author' => $comment->authorText->runs[0]->text,
                    'AuthorThumbnail' => $comment->authorThumbnail->thumbnails,
                    'AuthorChannelId' => $comment->authorEndpoint->browseEndpoint->browseId,
                    'message' => $comment->contentText->runs,
                    'publishedAt' => $comment->publishedTimeText->runs[0]->text,
                    'commentId' => $comment->commentId,
                    'likes' => $comment->voteCount->runs[0]->text ?? 0,
                )
            );
        }
        return array(
            'comments' => $comments_parsed,
            'nextToken' => $comments[sizeof($comments) - 1]->continuationItemRenderer->button->buttonRenderer->command->continuationCommand->token ?? null
        );
    }
    protected function getParsedComments($json)
    {
        if (sizeof($json->onResponseReceivedEndpoints) == 1) {
            $comments = $json->onResponseReceivedEndpoints[0]->appendContinuationItemsAction->continuationItems;
        } else {
            $comments = $json->onResponseReceivedEndpoints[1]->reloadContinuationItemsCommand->continuationItems;
        }
        $commentsSize = sizeof($comments) - 2;
        $comments_parsed = array();
        for ($i = 0; $i < $commentsSize; $i++) {
            $comment = $comments[$i]->commentThreadRenderer;
            array_push(
                $comments_parsed,
                array(
                    'Author' => $comment->comment->commentRenderer->authorText->runs[0]->text,
                    'AuthorThumbnail' => $comment->comment->commentRenderer->authorThumbnail->thumbnails,
                    'AuthorChannelId' => $comment->comment->commentRenderer->authorEndpoint->browseEndpoint->browseId,
                    'message' => $comment->comment->commentRenderer->contentText->runs,
                    'publishedAt' => $comment->comment->commentRenderer->publishedTimeText->runs[0]->text,
                    'commentId' => $comment->comment->commentRenderer->commentId,
                    'replyCount' => $comment->comment->commentRenderer->replyCount ?? 0,
                    'likes' => $comment->comment->commentRenderer->voteCount->runs[0]->text ?? 0,
                    'nextReplyToken' => $comment->replies->commentRepliesRenderer->contents[0]->continuationItemRenderer->button->buttonRenderer->command->continuationCommand->token ?? null,
                )
            );
        }
        return array(
            'comments' => $comments_parsed,
            'nextToken' => $comments[sizeof($comments) - 1]->continuationItemRenderer->continuationEndpoint->continuationCommand->token ?? null
        );
    }
    protected function getVideoCommentInfo($json)
    {
        $video_page_response = $json["contents"]["twoColumnWatchNextResults"]["results"]["results"]["contents"];
        $size = sizeof($video_page_response);
        $top_comment = $video_page_response[$size - 2]["itemSectionRenderer"]["contents"][0]["commentsEntryPointHeaderRenderer"];
        $featured_comment = array(
            'Author' => $top_comment["contentRenderer"]["commentsEntryPointTeaserRenderer"]["teaserAvatar"]["accessibility"]["accessibilityData"]["label"],
            'thumbnails' => $top_comment["contentRenderer"]["commentsEntryPointTeaserRenderer"]["teaserAvatar"]["thumbnails"],
            'comment' => $top_comment["contentRenderer"]["commentsEntryPointTeaserRenderer"]["teaserContent"]["simpleText"],
        );
        $nextToken = $video_page_response[$size - 1]["itemSectionRenderer"]["contents"][0]["continuationItemRenderer"]["continuationEndpoint"]["continuationCommand"]["token"];

        return (
            array(
                'top_comment' => $featured_comment,
                'nextToken' => $nextToken
            )
        );
    }

    // $nodeIndex is the Script tag Dom tree Array index
    // which is different for every page
    // 33 for Search Page , 34 for Home Page , 43 for Video Watch 
    protected function getInitalData($html, $nodeIndex = 33)
    {
        // If our regex found the initialData then return 
        if (preg_match('/ytInitialData\s*=\s*({.+?})\s*;/i', $html, $matches)) {
            $json = $matches[1];
            return json_decode($json, true);

        }
        // Else  we will load it in dom and get through index
        $doc = new DOMDocument();
        @$doc->loadHTML($html);
        $nodes = $doc->getElementsByTagName('script');
        $Var_value = $nodes[$nodeIndex]->nodeValue;
        $res = rtrim(substr($Var_value, 20, strlen($Var_value)), ";");
        $json = json_decode($res, true);
        return $json;
    }
    protected function getPlayerResponse($html)
    {
        $re = '/ytInitialPlayerResponse\s*=\s*({.+?})\s*;/i';

        if (preg_match($re, $html, $matches)) {
            $data = json_decode($matches[1], true);
            return $data;
        }

        return null;
    }

    protected function get($url = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    protected function getParseChannelVideos($json, $page)
    {
        $valid = $this->isValidChannel($json["contents"]["twoColumnBrowseResultsRenderer"]["tabs"], $page);

        if (!$valid['isValid']) {
            return [];
        }
        $_res = $json["contents"]["twoColumnBrowseResultsRenderer"]["tabs"][$valid['index']]["tabRenderer"]["content"] ?? null;

        switch ($page) {
            case $this->ABOUT:
                $OBJ = $_res["sectionListRenderer"]["contents"][0]['itemSectionRenderer']['contents'][0]['channelAboutFullMetadataRenderer'];
                return array(
                    'description' => $OBJ['description']['simpleText'] ?? '',
                    'viewCount' => $OBJ['viewCountText']['simpleText'] ?? '',
                    'joinedDate' => $OBJ['joinedDateText']['runs'][0]['text'] ?? '',
                    'avatar' => $OBJ['avatar']['thumbnails'] ?? [],
                    'country' => $OBJ['country']['simpleText'] ?? '',
                    'channelId' => $OBJ['channelId'] ?? '',
                    'links' => $this->extractLink($OBJ['links']) ?? [],
                );
            case $this->FEATURED:
                $_videos = $_res["sectionListRenderer"]["contents"];
                return $this->getParsedChannelFeatures($_videos);
            case $this->VIDEOS:
                $_videos = $_res["richGridRenderer"]["contents"];
                return $this->getParsedChannelVideos($_videos);
            case $this->COMMUNITY:
                $_videos = $_res["sectionListRenderer"]["contents"][0]['itemSectionRenderer']['contents'];
                return $this->getParsedChannelCommunity($_videos);
            case $this->STREAMS:
                $_videos = $_res["richGridRenderer"]["contents"];
                return $this->getParsedChannelVideos($_videos); // returns same data as videos
            case $this->SHORTS:
                $_videos = $_res["richGridRenderer"]["contents"];
                return $this->getParsedChannelShorts($_videos);
            case $this->PLAYLIST:
                $_videos = $_res["sectionListRenderer"]["contents"];
                return $this->getParsedChannelPlaylist($_videos);
            default:
                return [];
        }
    }
    protected function isValidChannel($el, $match)
    {
        $till = sizeof($el);
        for ($i = 0; $i < $till; $i++) {
            $element = $el[$i];
            $url = $element['tabRenderer']['endpoint']['commandMetadata']['webCommandMetadata']['url'] ?? '';
            if (preg_match("/\b" . preg_quote($match) . "\b/", $url)) {
                return array(
                    'index' => $i,
                    'isValid' => true
                );
            }
        }
        return array(
            'index' => 0,
            'isValid' => false
        );
    }
    protected function extractLink($_link = []){
     $links =[];
     foreach ($_link as $key => $value) {
        array_push($links , array(
            'link' => $value['channelExternalLinkViewModel']['link']['content'],
            'title' => $value['channelExternalLinkViewModel']['title']['content'],
        ));
     }
     return $links;
    }
    protected function getParsedChannelCommunity($_videos){
        $posts = array();
        $nextToken = null;
        foreach ($_videos as $key => $value) {
             $post =  $value['backstagePostThreadRenderer']['post']['backstagePostRenderer'] ?? null;
             if($post){
                $_post['postId'] = $post['postId'] ?? '';
                $_post['Author'] = $post['authorText']['runs'][0]['text'] ?? '';
                $_post['AuthorThumbnail'] = $post['authorThumbnail']['thumbnails'] ?? [];
                $_post['postText'] = $post['contentText']['runs'] ?? [];
                $_post['postImages'] = $post['backstageAttachment']['postMultiImageRenderer']['images'] ?? [];
                $_post['publishedTime'] = $post['publishedTimeText']['runs'][0]['text'] ?? '';
                $_post['voteCount'] = $post['voteCount']['simpleText'] ?? '';
                $_post['replyCount'] = $post['actionButtons']['commentActionButtonsRenderer']['replyButton']['buttonRenderer']['text']['simpleText'] ?? '';
                array_push($posts , $_post);
             }else{
                $nextToken = $value['continuationItemRenderer']['continuationEndpoint']['continuationCommand']['token'];
             }
             
        }
        return array(
            'posts' => $posts,
            'nextToken' => $nextToken
        );
    }
    protected function getParsedChannelPlaylist($_videos)
    {
        $_videos = $_videos[0]["itemSectionRenderer"]["contents"][0]["gridRenderer"]["items"];
        $videos = array();
        foreach ($_videos as $key => $value) {
            $_temp = $this->arrayGet($value, "gridPlaylistRenderer", []);
            array_push(
                $videos,
                array(
                    "playlistId" => $this->arrayGet($_temp, "playlistId", ''),
                    "thumbnails" => $this->arrayGet($_temp, "thumbnail.thumbnails.0.url", []),
                    "title" => $this->arrayGet($_temp, "title.runs.0.text", ''),
                    "videoId" => $this->arrayGet($_temp, "title.runs.0.navigationEndpoint.watchEndpoint.videoId", ''),
                    "video_count" => $this->arrayGet($_temp, "videoCountText.runs.0.text", ''),
                )
            );
        }
        return $videos;
    }
    protected function getParsedChannelShorts($_videos)
    {
        $videos = array();
        foreach ($_videos as $key => $value) {
            $_temp = $this->arrayGet($value, "richItemRenderer.content.reelItemRenderer", []);
            array_push(
                $videos,
                array(
                    "videoId" => $this->arrayGet($_temp, "videoId", ''),
                    "thumbnails" => $this->arrayGet($_temp, "thumbnail.thumbnails", []),
                    "title" => $this->arrayGet($_temp, "headline.simpleText", ''),
                    "viewCount" => $this->arrayGet($_temp, "viewCountText.simpleText", ''),
                )
            );
        }
        return $videos;
    }
    protected function getParsedChannelVideos($_videos)
    {
        $videos = array();
        foreach ($_videos as $key => $value) {
            $_temp = $this->arrayGet($value, "richItemRenderer.content.videoRenderer", []);
            array_push(
                $videos,
                array(
                    "videoId" => $this->arrayGet($_temp, "videoId", ''),
                    "thumbnails" => $this->arrayGet($_temp, "thumbnail.thumbnails", []),
                    "title" => $this->arrayGet($_temp, "title.runs.0.text", ''),
                    "viewCount" => $this->arrayGet($_temp, "viewCountText.simpleText", ''),
                    "lengthText" => $this->arrayGet($_temp, "lengthText.simpleText", ''),
                )
            );
        }
        return $videos;
    }
    protected function getParsedChannelFeatures($_videos)
    {
        $videos = array();
        foreach ($_videos as $key => $value) {
            $_temp = $this->arrayGet($value, "itemSectionRenderer.contents.0.shelfRenderer", []);
            array_push(
                $videos,
                array(
                    "title" => $this->arrayGet($_temp, "title.runs.0.text", ''),
                    "content" => $this->arrayGet($_temp, "content.horizontalListRenderer.items", []),
                )
            );
        }
        return $videos;
    }

    protected function parseVideo($json)
    {
        $data = array(
            'id' => $this->arrayGet($json, 'videoDetails.videoId'),
            'channelId' => $this->arrayGet($json, 'videoDetails.channelId'),
            'channelTitle' => $this->arrayGet($json, 'videoDetails.author'),
            'title' => $this->arrayGet($json, 'videoDetails.title'),
            'description' => $this->arrayGet($json, 'videoDetails.shortDescription'),
            'uploadDate' => $this->arrayGet($json, 'microformat.playerMicroformatRenderer.uploadDate'),
            'viewCount' => $this->arrayGet($json, 'videoDetails.viewCount'),
            'thumbnail' => $this->arrayGet($json, 'videoDetails.thumbnail.thumbnails'),
            'duration' => $this->arrayGet($json, 'videoDetails.lengthSeconds'),
            'keywords' => $this->arrayGet($json, 'videoDetails.keywords', []),
            'regionsAllowed' => $this->arrayGet($json, 'microformat.playerMicroformatRenderer.availableCountries', []),
            'streaming' => $this->arrayGet($json, 'streamingData.formats', [])
        );
        return $data;
    }

    protected function parseHomePageVideos($json)
    {
        $UserAvatar = "";
        if ($this->authorization && $this->cookie) {
            $UserAvatar = $json["topbar"]["desktopTopbarRenderer"]["topbarButtons"][2]["topbarMenuButtonRenderer"]["avatar"]["thumbnails"][0]["url"] ?? "";
        }
        $videosJson = $json["contents"]["twoColumnBrowseResultsRenderer"]["tabs"][0]["tabRenderer"]["content"]["richGridRenderer"]["contents"];
        $chips = $json["contents"]["twoColumnBrowseResultsRenderer"]["tabs"][0]["tabRenderer"]["content"]["richGridRenderer"]["header"]["feedFilterChipBarRenderer"]["contents"];
        $videos = [];
        $videoShorts = [];
        $nextToken = null;
        foreach ($videosJson as $value) {
            if (isset($value["richItemRenderer"])) {
                $_video = $this->arrayGet($value, 'richItemRenderer.content.videoRenderer');
                $video['videoId'] = $this->arrayGet($_video, 'videoId', '') ?? "";
                $video['viewCount'] = $this->arrayGet($_video, 'viewCountText.simpleText', '') ?? "";
                $video['title'] = $_video["title"]["runs"][0]["text"] ?? "";
                $video['thumbnails'] = $this->arrayGet($_video, 'thumbnail.thumbnails', []) ?? "";
                $video['description'] = $_video["descriptionSnippet"]["runs"][0]["text"] ?? "";
                $video['channelName'] = $_video["longBylineText"]["runs"][0]["text"] ?? "";
                $video['channelThumbnail'] = $_video["channelThumbnailSupportedRenderers"]["channelThumbnailWithLinkRenderer"]["thumbnail"]["thumbnails"][0]["url"] ?? [];
                array_push($videos, $video);
            }
            if (isset($value["continuationItemRenderer"])) {
                $nextToken = $value["continuationItemRenderer"]["continuationEndpoint"]["continuationCommand"]["token"];
            }
            if (isset($value["richSectionRenderer"])) {
                $_shrtVideos = $this->arrayGet($value, 'richSectionRenderer.content.richShelfRenderer.contents');
                 $videoShorts = array_merge($videoShorts , $this->getShorts($_shrtVideos));
            }
        }
        return [
            'userAvatar' => $UserAvatar,
            'videos' => $videos,
            'videoShorts' => $videoShorts,
            'chips' => $chips,
            'nextToken' => $nextToken,
        ];
    }
    protected function getShorts($shorts = [])
    {
        $parsedJSON = [];
        foreach ($shorts as $value) {
            if (isset($value["richItemRenderer"]["content"]["reelItemRenderer"])) {
                $_video = $this->arrayGet($value, 'richItemRenderer.content.reelItemRenderer');
                $video['title'] = $_video["headline"]["simpleText"] ?? "";
                $video['videoId'] = $_video["videoId"] ?? "";
                $video['viewCount'] = $_video["viewCountText"]["simpleText"] ?? "";
                $video['thumbnails'] = $_video["thumbnail"]["thumbnails"] ?? [];
                array_push($parsedJSON, $video);
            }
        }
        return $parsedJSON;
    }

    protected function parseSearchResult($json)
    {
        $video_page_response = $json["contents"]["twoColumnSearchResultsRenderer"]["primaryContents"]["sectionListRenderer"]["contents"];
        $size = sizeof($video_page_response);
        $nextToken = $video_page_response[$size - 1]["continuationItemRenderer"]["continuationEndpoint"]["continuationCommand"]["token"];

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
        return array(
            'videos' => $videos,
            'nextSearchToken' => $nextToken
        );
    }

    protected function parserelatedVideoResult($json)
    {
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

    protected function isExits($key, $video, $returnValue)
    {
        if ($video[$key]) {
            return $returnValue;
        }
        return null;
    }
    protected function arrayGet($array, $key, $default = null)
    {
        foreach (explode('.', $key) as $segment) {

            if (is_array($array) && array_key_exists($segment, $array)) {
                $array = $array[$segment];
            } else {
                $array = $default;
                break;
            }
        }

        return $array;
    }

}