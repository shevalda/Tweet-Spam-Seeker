<!DOCTYPE html>
<html>
<head>
    <title>Spam Seeker</title>

    <link rel="stylesheet" href="/style/style.css">
</head>

<body>
    <h1>Tweet Spam Seeker</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        Spam Keyword(s): <input input="text" name="keyword" placeholder="pisahkan dengan koma(,)">
        <br><br>
        Algortima:
        <br><input type="radio" name="algorithm" value="bm" checked> Boyer-Moore
        <br><input type="radio" name="algorithm" value="kmp"> KMP
        <br><input type="radio" name="algorithm" value="regex"> Regex
        <br><br>
        Jumlah tweet: <input input="text" name="jumlah_tweet" placeholder="min. 20, max 200">
        <br><br>
        <button type="submit">Cari Tweet Spam</button>
    </form>

    <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $keyword = $_REQUEST['keyword'];
            $algorithm = $_REQUEST['algorithm'];

            session_start();
            $_SESSION['jumlah_tweet'] = $_REQUEST['jumlah_tweet'];


            // dictionary hasil input user
            $data = array('keyword' => $keyword, 'algorithm' => $algorithm);

            // tulis ke file user_input.json
            $fp = fopen('tools\json\user_input.json', 'w');
            fwrite($fp, json_encode($data));
            fclose($fp);
            echo "Input user berhasil di-export ke user_input.json";

//            require "tools/twitter_api.php";
//
//            // menjalankan program kmp dan boyce-moore
//            exec('python test.py');

            for ($i = 1; $i <= $_REQUEST['jumlah_tweet']; $i++) {
                echo "<div>
                        ini printan ke $i
                        </div>";
            }
        }


    ?>

</body>

</html>