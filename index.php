<?php

include_once("./yt.php");

$youtube = new YT();


// echo json_encode($youtube->getShortDetails("5R7X7FoAcwQ"));
// echo json_encode($youtube->search("WordPress+Tutorail"));
// echo json_encode($youtube->HomePageVideos());
// echo json_encode($youtube->getRelatedVideo('GlLRYml8mCY'));
// echo json_encode($youtube->getVideo('1WEAJ-DFkHE'));
// echo json_encode($youtube->getDownloadURL('1WEAJ-DFkHE'));
// echo json_encode($youtube->getChannelFeatured('UCX6OQ3DkcsbYNE6H8uQQuVA'));
// echo json_encode($youtube->getChannelLive('UCX6OQ3DkcsbYNE6H8uQQuVA'));
// echo json_encode($youtube->getChannelCommunity('UCX6OQ3DkcsbYNE6H8uQQuVA'));
// echo json_encode($youtube->getChannelAbout('UCX6OQ3DkcsbYNE6H8uQQuVA'));
// echo json_encode($youtube->getChannelVideos('UC8aFE06Cti9OnQcKpl6rDvQ'));
// echo json_encode($youtube->getChannelShorts('UC8aFE06Cti9OnQcKpl6rDvQ'));
// echo json_encode($youtube->getChannelPlayList('UCX6OQ3DkcsbYNE6H8uQQuVA'));
// echo json_encode($youtube->getChannelMetaDetails('UC8aFE06Cti9OnQcKpl6rDvQ'));
// echo json_encode($youtube->getComments('Eg0SC0dsTFJZbWw4bUNZGAYyJSIRIgtHbExSWW1sOG1DWTAAeAJCEGNvbW1lbnRzLXNlY3Rpb24%3D'));
// echo json_encode($youtube->getReplyComments('Eg0SC0dsTFJZbWw4bUNZGAYygwEaUBIaVWd4WlJRVWtVNjI3YlBwYlZleDRBYUFCQWciAggAKhhVQ2VWTW5TU2hQX0l2aXdra250ODNjd3cyC0dsTFJZbWw4bUNZQAFICoIBAggBQi9jb21tZW50LXJlcGxpZXMtaXRlbS1VZ3haUlFVa1U2MjdiUHBiVmV4NEFhQUJBZw%3D%3D'));
// echo json_encode($youtube->getSearchNext('EroDEgVSZWFjdBqwA1NCU0NBUXRWUWtka2RURk1WVFl5TUlJQkMySmhiWFZ5TVV4cVpWQTRnZ0VMZVhGRFpEUlpTVUYwYVdPQ0FRdFBaR3B6ZDJReVJFbFZXWUlCQ3pKdVNVcHFSa0ptWjNWamdnRUxZamxsVFVkRk4xRjBWR3VDQVFzdFNWQkxVRnBsY2xGaWI0SUJDemxCZW5Gc2JHVjVSbWc0Z2dFTFpFZDJSbmR1Y2tOcGVVMkNBUXRIVFZScmNGQXRUM28wT0lJQkMxbFpNbHBvVlZGYWVVVTBnZ0VMZFZKVE9ERkxVbUZ2YzNPQ0FRdGZjMXBGTlV4bFJHZ3pZNElCQzFsZlNIb3hkRGh4Y25STmdnRUxVVFJIUjJaWk5YRkVZVldDQVF0VFgzTnpOMU5HWjFaaGE0SUJDelpxT1hSdVIwMWliVEpqZ2dFTFkxQk9ORWd3YzFORFNGR0NBU0pRVEVNemVUZ3Rja1pJZG5kblp6TjJZVmxLWjBoSGJrMXZaRUkxTkhKNFQyc3pnZ0VMZHpkbGFrUmFPRk5YZGppeUFRWUtCQWdhRUFMcUFRSUlBZyUzRCUzRBiB4OgYIgtzZWFyY2gtZmVlZA%3D%3D'));
// echo json_encode($youtube->getChannelVideosNext('4qmFsgLzCBIYVUM4YUZFMDZDdGk5T25RY0twbDZyRHZRGtYIOGdhNkJocTNCbnEwQmdxdkJncUdCa0ZXU21GdFJqRjRjR1ZGVkVSR1YxVkNTRXRDZVc5M1VEQkNMWFpwVmpOVGNrTkJWMjgyVDNrMWJXNUJjR2xFZHpZMFZIQkRaVVF0Wms5Q2VFZGlRVzloUm5KNlRYQkZYMEU1TlVoNmFHOXdRMHhJUzI5cGJsVkdSR2hCUmtVelJ6ZFhablI1Um5sS2VUQlJXSEZHVFVSNFdFTjJVRGRoVmxwTWFWQTVObkpmY1RCS2IzVkVOMDVUUm1oMU1ESTBNRGRQWmtwNGFHbHFTbUp1TWxwcWFsWTRWRmhyTnpabk1URlROMTl6WW0xR1ZuVlpjbWt5Um1rdFNWTTNTRVEzVFhwbU5ESXpMVXRsWWpCUFltSkxjRVZ5VldKcmNHRmhOMGhEYUdWb2FVb3dVa2x6Tm1aR1ozVTJPVTg0U1hoRlF6TmxNM0Z2VVhSNVVGcG5NM1Z6VGxKTk5qWjNiVmhMWDJ4SVVHZ3lRWFpHVjFOb1FUY3hSbmxYVFUxTFRYWTFaazVaVEUxUVRrSTJVM1ZoT1VKclpqaEpOaTFXWWt0bldrNUNXbU5vYVhOelprWjZNWEE0YVdWbWRFbEphbHBDYzFaaGJHRmtRelZWTmtoaFdtMTVWak42ZVU1cVpYWnNWVWt6TW0xQk5teGZRM1l0VTNvMFVqbFpaM1kzVVRGMlZ6WmlNVEpLYzBWeGNIcG1jRVpaY0RGWVZFZFFOakp2Ym1aSlRtZEVZVEpGVkdKdFgxcEpaamx5YzBFeU5XUmpVSFJtWkZwME9HRjRiWEpFZEU4NGQycDFOVGN5U0V4SE9YbElTemRmT1dsbFFtYzJURGs1U2tOd1ZFTXRUV2syZDA4NE1sSndVVnBtTlhoNmJHcFRNbXN4WkZNelRHUnBSazVqZEdacGVGbElUVTVIVjI1blNVVkZaMFJSVGpSdk9UaE9TR1J0YW5wUVNUTnhVbkEzYm1SUmNsOXBiREUwUkhvM01VMVJhRlZrWWpoVVIzbFlTemRWU0RKc0xWaDBkM001UjA5NlpsWmZRa2RRZGtsT1JqQkxkbmgxVGxKcmFVd3dPWEpoYzA1dVZpMWFkMDAzYTNkbE4yOWxMVGRyVFhGMWEwZE9WVVF0VkZjMU9VNXZORXRzT0dNeVVYVnNYMlJ6UTJoSFNFRmZZekZ0YjFSbFptdHFOakJDVG5JdGRXY3lWMFZ3V2xJMVoyMURlVFEyVWpSTVZuaDRjMFJITW5OaFpGVXlUM280UTFaUFR6TTNSRTVpY1ZoaFVVTnpTMVZmYzJKSmIyWk9WR05SYW5neFpraHVSbFZ6UzAwNFZHOXVRVTFRU1hFd1JrZDJSSHBsYVdGU00yMWxUME5NVUhseGVISm5aeElrTmpVeVlXUXdZMk10TURBd01DMHlabU5qTFdGaE5qY3ROVGd5TkRJNVlXRXlNekE0R0FFJTNE'));
// var_dump($youtube->getSearchSuggestions('Top%20funny%20videos'));

// Authorization of Youtube 
// How to get authorization token and cookie please look into
// repo images for the guide
// $env = parse_ini_file('.env');
// $authorization = $env['AUTHORIZATION'] ;
// $cookie = $env['COOKIE'];

// $youtube->setAuthorization($authorization);
// $youtube->setCookie($cookie);
// echo json_encode($youtube->HomePageVideosWithAuth());
// echo json_encode($youtube->HomePageVideosNext('xx'));



