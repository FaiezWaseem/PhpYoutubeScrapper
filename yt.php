<?php

class YT
{

    protected $base_url = 'https://www.youtube.com/';

    protected $video_url = 'watch?v=';

    protected $search_query = 'results?search_query=';

    protected $channel = 'channel/';

    protected $FEATURED = 0;
    protected $VIDEOS = 1;
    protected $SHORTS = 2;
    protected $PLAYLIST = 3;


    public function HomePageVideos()
    {
        $html = $this->get($this->base_url);
        $json = $this->getInitalData($html, 34);
        return $this->parseHomePageVideos($json);
    }
    public function search($query)
    {
        $html = $this->get($this->base_url . $this->search_query . $query);
        $json = $this->getInitalData($html, 33);
        return $this->parseSearchResult($json);
    }
    public function getRelatedVideo($videoId)
    {
        $html = $this->get($this->base_url . $this->video_url . $videoId);
        $json = $this->getInitalData($html, 43);
        return $this->parserelatedVideoResult($json);
    }
    public function getChannelFeatured($channelId)
    {
        $html = $this->get($this->base_url . $this->channel . $channelId);
        $json = $this->getInitalData($html, 34);
        return $this->getParseChannelVideos($json, $this->FEATURED);
        // return $json;
    }
    public function getChannelVideos($channelId)
    {
        $html = $this->get($this->base_url . $this->channel . $channelId . '/videos');
        $json = $this->getInitalData($html, 34);
        return $this->getParseChannelVideos($json, $this->VIDEOS);
    }
    public function getChannelShorts($channelId)
    {
        $html = $this->get($this->base_url . $this->channel . $channelId . '/shorts');
        $json = $this->getInitalData($html, 34);
        return $this->getParseChannelVideos($json, $this->SHORTS);
        // return $json;
    }
    public function getChannelPlayList($channelId)
    {
        $html = $this->get($this->base_url . $this->channel . $channelId . '/playlists');
        $json = $this->getInitalData($html, 34);
        return $json;
        // return $this->getParseChannelVideos($json, $this->PLAYLIST);
    }
    public function getChannelMetaDetails($channelId){
        $html = $this->get($this->base_url . $this->channel . $channelId . '/playlists');
        $json = $this->getInitalData($html, 34);
        return array(
            'title' => $this->arrayGet($json , 'header.c4TabbedHeaderRenderer.title' , ''),
            'avatar' => $this->arrayGet($json , 'header.c4TabbedHeaderRenderer.avatar.thumbnails' , []),
            'banner' => $this->arrayGet($json , 'header.c4TabbedHeaderRenderer.banner.thumbnails' , []),
            'mobileBanner' => $this->arrayGet($json , 'header.c4TabbedHeaderRenderer.mobileBanner.thumbnails' , []),
            'videosCount' => $this->arrayGet($json , 'header.c4TabbedHeaderRenderer.videosCountText.runs.0.text' , ''),
            'tagline' => $this->arrayGet($json , 'header.c4TabbedHeaderRenderer.tagline.channelTaglineRenderer.content' , ''),
            'description' => $this->arrayGet($json , 'metadata.channelMetadataRenderer.description' , ''),
        );
    }

    public function getVideo($videoId)
    {
        $html = $this->get($this->base_url . $this->video_url . $videoId);
        $json = $this->getPlayerResponse($html);
        $json2 = $this->getInitalData($html, 43);
        $subs = $json2["contents"]["twoColumnWatchNextResults"]["results"]["results"]["contents"][1]["videoSecondaryInfoRenderer"]["owner"]["videoOwnerRenderer"]["subscriberCountText"]["simpleText"];
        $video = $this->parseVideo($json);
        $video["subscriber"] = $subs;
        return array('video' => $video, 'recomended' => $this->parserelatedVideoResult($json2));
    }

    // $nodeIndex is the Script tag Dom tree Array index
    // which is different for every page
    // 33 for Search Page , 34 for Home Page , 43 for Video Watch 
    protected function getInitalData($html, $nodeIndex = 33)
    {
        if (preg_match('/ytInitialData\s*=\s*({.+?})\s*;/i', $html, $matches)) {
            $json = $matches[1];
            return json_decode($json, true);
        }
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

    protected function getParseChannelVideos($json, $index)
    {
        $_res = $json["contents"]["twoColumnBrowseResultsRenderer"]["tabs"][$index]["tabRenderer"];
        if ($_res["content"]) {
            switch ($index) {
                case $this->FEATURED:
                    $_videos = $_res["content"]["sectionListRenderer"]["contents"];
                    return $this->getParsedChannelFeatures($_videos);
                case $this->VIDEOS:
                    $_videos = $_res["content"]["richGridRenderer"]["contents"];
                    return $this->getParsedChannelVideos($_videos);
                case $this->SHORTS:
                    $_videos = $_res["content"]["richGridRenderer"]["contents"];
                    return $this->getParsedChannelShorts($_videos);
                case $this->PLAYLIST:
                    $_videos = $_res["content"]["sectionListRenderer"]["contents"];
                    return $this->getParsedChannelPlaylist($_videos);
            }

        }
        return [];
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
                    "thumbnails" => $this->arrayGet($_temp, "thumbnail.thumbnails", []),
                    "title" => $this->arrayGet($_temp, "title.runs.0.text", ''),
                    "videoId" => $this->arrayGet($_temp, "title.runs.0.watchEndpoint.videoId", ''),
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
        $videosJson = $json["contents"]["twoColumnBrowseResultsRenderer"]["tabs"][0]["tabRenderer"]["content"]["richGridRenderer"]["contents"];
        $videos = [];
        foreach ($videosJson as $value) {
            if (isset($value["richItemRenderer"])) {
                $_video = $this->arrayGet($value, 'richItemRenderer.content.videoRenderer');
                $video['videoId'] = $this->arrayGet($_video, 'videoId', '');
                $video['viewCount'] = $this->arrayGet($_video, 'viewCountText.simpleText', '');
                $video['title'] = $_video["title"]["runs"][0]["text"];
                $video['thumbnails'] = $this->arrayGet($_video, 'thumbnail.thumbnails', []);
                $video['description'] = $this->isExits("descriptionSnippet", $_video, $_video["descriptionSnippet"]["runs"][0]["text"]);
                $video['channelName'] = $_video["longBylineText"]["runs"][0]["text"];
                $video['channelThumbnail'] = $_video["channelThumbnailSupportedRenderers"]["channelThumbnailWithLinkRenderer"]["thumbnail"]["thumbnails"][0]["url"];
                array_push($videos, $video);
            }
        }
        return $videos;
    }

    protected function parseSearchResult($json)
    {
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