<!DOCTYPE html>
<html>
<head>

    <title>Tweet Spam Seeker</title>

    <!-- css style -->
    <link rel="stylesheet" href="/style/style.css">
    <!-- font awesome -->
    <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet' />
<!--    <link href='https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet' />-->
<!--    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">-->

</head>

<body>
    <h1>Tweet Spam Seeker</h1>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        Spam Keyword(s): <input type="text" name="keyword" placeholder="pisahkan dengan koma(,)">
        <br><br>
        Algortima:
        <br><input type="radio" name="algorithm" value="kmp" checked> KMP
        <br><input type="radio" name="algorithm" value="bm"> Boyer-Moore
        <br><input type="radio" name="algorithm" value="regex"> Regex
        <br><br>
        Jumlah tweet: <input input="text" name="jumlah_tweet" placeholder="min. 20, max 200">
        <br><br>
        <button type="reset">Reset Pencarian</button>
        <button type="submit">Cari Tweet Spam</button>
    </form>

    <?php

        $output_file = 'tools\json\user_input.json';
        $input_file = 'tools\json\final_result.json';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $keyword = $_REQUEST['keyword'];
            $algorithm = $_REQUEST['algorithm'];

            session_start();
            $_SESSION['jumlah_tweet'] = $_REQUEST['jumlah_tweet'];

            // dictionary hasil input user
            $data = array('keyword' => $keyword, 'algorithm' => $algorithm);

            // tulis ke file user_input.json
            $fp = fopen($output_file, 'w');
            fwrite($fp, json_encode($data));
            fclose($fp);

            // require "tools/twitter_api.php";

            // menjalankan program kmp dan boyce-moore
            exec('python tools/main.py');

            //Decode JSON
            $result = json_decode(file_get_contents($input_file), true);

            foreach ($result as $tweet) {
                echo "<p>";
                if ($tweet['spam'] == true) {
                    echo "<i class=\"fa fa-flag\"></i>";
                }
                echo " <b>" . $tweet['name'] . "</b> - @" . $tweet['username'] . "<br>";
                echo $tweet['text'] . "<br>";
                echo "</p>";
            }

        }

    ?>

</body>

</html>