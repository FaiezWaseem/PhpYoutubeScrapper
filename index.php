<?php

include_once("./yt.php");

$youtube = new YT();


// echo json_encode($youtube->search("WordPress+Tutorail"));
// echo json_encode($youtube->HomePageVideos());
// echo json_encode($youtube->getRelatedVideo('GlLRYml8mCY'));
// echo json_encode($youtube->getVideo('GlLRYml8mCY'));
// echo json_encode($youtube->getChannelFeatured('UC8aFE06Cti9OnQcKpl6rDvQ'));
// echo json_encode($youtube->getChannelVideos('UC8aFE06Cti9OnQcKpl6rDvQ'));
// echo json_encode($youtube->getChannelShorts('UC8aFE06Cti9OnQcKpl6rDvQ'));
echo json_encode($youtube->getChannelPlayList('UC8aFE06Cti9OnQcKpl6rDvQ'));
// echo json_encode($youtube->getChannelMetaDetails('UC8aFE06Cti9OnQcKpl6rDvQ'));