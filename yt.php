<?php

class YT
{

    protected $base_url = 'https://www.youtube.com/';

    protected $video_url = 'watch?v=';

    protected $search_query = 'results?search_query=';

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

    public function getVideo($videoId)
    {
        $html = $this->get($this->base_url . $this->video_url . $videoId);
        $json = $this->getPlayerResponse($html);
        $json2 = $this->getInitalData($html, 43);
        return array( 'video' => $this->parseVideo($json) , 'recomended' => $this->parserelatedVideoResult($json2));
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