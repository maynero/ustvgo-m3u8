<?php
$curl = curl_init();
$channelId = $_GET["c"];

if ($channelId == "") {
    $ex = array("error" => "Missing channel ID.");
    $error = json_encode($ex);

    echo $error;
    return;
}

curl_setopt($curl, CURLOPT_URL, "https://ustvgo.tv/player.php?stream=$channelId");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_ENCODING, '');
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Referer: https://ustvgo.tv'
));
$response = curl_exec($curl);

if (curl_error($curl)) {
    echo curl_error($curl);
    return;
}
curl_close($curl);

$pattern = '/hls_src=["\'](?P<stream_url>[^"\']+)/';
preg_match($pattern, $response, $matches);
$video_url = $matches[1];
header("Location: $video_url");

