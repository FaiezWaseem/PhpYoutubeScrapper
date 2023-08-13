<?php

include_once("./yt.php");

$youtube = new YT();


// echo json_encode($youtube->search("WordPress+Tutorail"));
// echo json_encode($youtube->HomePageVideos());
// echo json_encode($youtube->getRelatedVideo('GlLRYml8mCY'));
// echo json_encode($youtube->getVideo('1WEAJ-DFkHE'));
// echo json_encode($youtube->getChannelFeatured('UC8aFE06Cti9OnQcKpl6rDvQ'));
// echo json_encode($youtube->getChannelVideos('UC8aFE06Cti9OnQcKpl6rDvQ'));
// echo json_encode($youtube->getChannelShorts('UC8aFE06Cti9OnQcKpl6rDvQ'));
// echo json_encode($youtube->getChannelPlayList('UCX6OQ3DkcsbYNE6H8uQQuVA'));
// echo json_encode($youtube->getChannelMetaDetails('UC8aFE06Cti9OnQcKpl6rDvQ'));
// echo json_encode($youtube->getComments('Eg0SC0dsTFJZbWw4bUNZGAYyJSIRIgtHbExSWW1sOG1DWTAAeAJCEGNvbW1lbnRzLXNlY3Rpb24%3D'));
// echo json_encode($youtube->getReplyComments('Eg0SC0dsTFJZbWw4bUNZGAYygwEaUBIaVWd4WlJRVWtVNjI3YlBwYlZleDRBYUFCQWciAggAKhhVQ2VWTW5TU2hQX0l2aXdra250ODNjd3cyC0dsTFJZbWw4bUNZQAFICoIBAggBQi9jb21tZW50LXJlcGxpZXMtaXRlbS1VZ3haUlFVa1U2MjdiUHBiVmV4NEFhQUJBZw%3D%3D'));
// echo json_encode($youtube->getSearchNext('EroDEgVSZWFjdBqwA1NCU0NBUXRWUWtka2RURk1WVFl5TUlJQkMySmhiWFZ5TVV4cVpWQTRnZ0VMZVhGRFpEUlpTVUYwYVdPQ0FRdFBaR3B6ZDJReVJFbFZXWUlCQ3pKdVNVcHFSa0ptWjNWamdnRUxZamxsVFVkRk4xRjBWR3VDQVFzdFNWQkxVRnBsY2xGaWI0SUJDemxCZW5Gc2JHVjVSbWc0Z2dFTFpFZDJSbmR1Y2tOcGVVMkNBUXRIVFZScmNGQXRUM28wT0lJQkMxbFpNbHBvVlZGYWVVVTBnZ0VMZFZKVE9ERkxVbUZ2YzNPQ0FRdGZjMXBGTlV4bFJHZ3pZNElCQzFsZlNIb3hkRGh4Y25STmdnRUxVVFJIUjJaWk5YRkVZVldDQVF0VFgzTnpOMU5HWjFaaGE0SUJDelpxT1hSdVIwMWliVEpqZ2dFTFkxQk9ORWd3YzFORFNGR0NBU0pRVEVNemVUZ3Rja1pJZG5kblp6TjJZVmxLWjBoSGJrMXZaRUkxTkhKNFQyc3pnZ0VMZHpkbGFrUmFPRk5YZGppeUFRWUtCQWdhRUFMcUFRSUlBZyUzRCUzRBiB4OgYIgtzZWFyY2gtZmVlZA%3D%3D'));
// var_dump($youtube->getSearchSuggestions('Top%20funny%20videos'));

// Authorization of Youtube 
// How to get authorization token and cookie please look into
// repo images for the guide
$env = parse_ini_file('.env');
$authorization = $env['AUTHORIZATION'] ;
$cookie = $env['COOKIE'];

echo json_encode($youtube->HomePageVideosWithAuth($authorization,$cookie));



