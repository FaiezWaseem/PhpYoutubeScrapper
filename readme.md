# PHP BASED YT SCRAPPER

### Features
 - GET HomePage Videos
 - GET Video Info + Video Related Recomended Videos
 - GET Video Playable links
 - GET Search Video
 - GET Channel Meta Info
 - GET Channel Featured , Videos , Shorts & Playlist


## how to
 just download the yt.php , include it and enjoy!

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

```



### Todo
 - get video comments
 - get search suggestion
 - load more videos [for all functions like homepagevideos , relatedvideos etc]
 - video playable link speed increase

