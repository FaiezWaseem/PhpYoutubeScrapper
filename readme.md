# PHP BASED YT SCRAPPER

### Features
 - GET HomePage Videos
 - GET Video Info + Video Related Recomended Videos
 - GET Video Playable links
 - GET Search Video + load more videos
 - GET Channel Meta Info
 - GET Channel Featured , Videos , Shorts & Playlist
 - GET Video Comments
 - GET Comment Replys


## how to
 just download the yt.php , include it and enjoy!
 for example checkout index.php

```
    include_once("./yt.php");

    $youtube = new YT();      
    echo json_encode($youtube->search("WordPress+Tutorail")); // search query with '+' sign no space
    echo json_encode($youtube->HomePageVideos());  // get youtube home page Array
    echo json_encode($youtube->getRelatedVideo('GlLRYml8mCY')); // pass videoId get an array of videos
  
   // pass videoId get a video object and related videos Array
    echo json_encode($youtube->getVideo('GlLRYml8mCY'));  
  
   //  pass channelId , channelId can be obtained from getVideo function in video object 
    echo json_encode($youtube->getChannelFeatured('UC8aFE06Cti9OnQcKpl6rDvQ'));
    echo json_encode($youtube->getChannelVideos('UC8aFE06Cti9OnQcKpl6rDvQ'));
    echo json_encode($youtube->getChannelShorts('UC8aFE06Cti9OnQcKpl6rDvQ'));
    echo json_encode($youtube->getChannelPlayList('UC8aFE06Cti9OnQcKpl6rDvQ'));
    echo json_encode($youtube->getChannelMetaDetails('UC8aFE06Cti9OnQcKpl6rDvQ'));

    // commentToken is Obtained from getVideo function
    // echo json_encode($youtube->getComments('Eg0SC0dsTFJZbWw4bUNZGAYyJSIRIgtHbExSWW1sOG1DWTAAeAJCEGNvbW1lbnRzLXNlY3Rpb24%3D'));

    // echo json_encode($youtube->getReplyComments('Eg0SC0dsTFJZbWw4bUNZGAYygwEaUBIaVWd4WlJRVWtVNjI3YlBwYlZleDRBYUFCQWciAggAKhhVQ2VWTW5TU2hQX0l2aXdra250ODNjd3cyC0dsTFJZbWw4bUNZQAFICoIBAggBQi9jb21tZW50LXJlcGxpZXMtaXRlbS1VZ3haUlFVa1U2MjdiUHBiVmV4NEFhQUJBZw%3D%3D'));


```



### Todo
 - get search suggestion
 - load more videos [for all functions like homepagevideos , relatedvideos etc]
 - video playable link speed increase

