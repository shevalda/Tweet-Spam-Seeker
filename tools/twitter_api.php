<?php

    // keys and tokens
    $consumer_key = 'Dex1ZaT0xHMT9MxjFkTt4TcC1';
    $consumer_secret = 'CNjJC6iHi05r5ARCua8aiSbhujqZkxcjR0cSKSgzFVFkjVxlOu';
    $access_token = '985397289031118850-w01q6Rn6BnuUaF3t6fQjhY0OHZi11sd';
    $access_token_secret = 'B90pp6k2m3n6yUTRkk5khIs9WHdA2DqtH0kRSo141ziAw';

    // using library
    require "twitteroauth/autoload.php";
    use Abraham\TwitterOAuth\TwitterOAuth;

    // starting an API connection
    $connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
    $content = $connection->get("account/verify_credentials");

    // getting tweets
    $tweets = $connection->get("statuses/home_timeline", ["count" => $_SESSION['jumlah_tweet'], "exclude_replies" => true]);

    // writing to JSON file
    if ($connection->getLastHttpCode() == 200) {
        $fp = fopen('json\result_api.json', 'w');
        fwrite($fp, json_encode($tweets));
        fclose($fp);
        echo "koneksi berhasil. hasil telah ditulis ke result_api.json";
    } else {
        echo "koneksi tidak berhasil. coba lagi.";
    }

?>