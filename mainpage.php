<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compartible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Spam Seeker</title>

    <!-- css style -->
    <link rel="stylesheet" href="/style/style.css">
    <!-- font awesome -->
    <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet' />
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Berkshire+Swash" rel="stylesheet">

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Spam Seeker</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="mainpage.php">Home
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-angle-double-up"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <br><br>

    <!-- Form -->
    <div class="user-input">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-md-11 mx-auto">
                    <div class="form">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                            <input type="text" name="keyword" placeholder="keyword spam" id="keyword">
                            <br><br>
                            <select name="algorithm">
                                <option value="kmp">Knuth-Morris-Pratt</option>
                                <option value="bm">Boyer-Moore</option>
                                <option value="regex">Regex</option>
                            </select>
                            <br><br>
                            <input input="text" name="jumlah_tweet" placeholder="number of tweets (20-200)">
                            <br><br>
                            <button type="reset" class="btn-form" id="btn-reset">Reset</button>
                            <button type="submit" class="btn-form" id="btn-submit">Cari</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php

        $output_file = 'tools\json\user_input.json';
        $input_file = 'tools\json\final_result.json';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $keyword = $_REQUEST['keyword'];
            $algorithm = $_REQUEST['algorithm'];

            $_SESSION['jumlah_tweet'] = $_REQUEST['jumlah_tweet'];

            // dictionary hasil input user
            $data = array('keyword' => $keyword, 'algorithm' => $algorithm);

            // tulis ke file user_input.json
            $fp = fopen($output_file, 'w');
            fwrite($fp, json_encode($data));
            fclose($fp);

            // memanggil API Twitter
//			require "tools/twitter_api.php";

            // menjalankan program kmp dan boyce-moore
            exec('python tools/main.py');

            //Decode JSON
            $result = json_decode(file_get_contents($input_file), true);

            $spam_count = 0;
            foreach ($result['tweets'] as $tweet) {
                if ($tweet['spam'] == true) {
                    $spam_count += 1;
                }
            }

            echo "<div class=\"output\">
                <div class=\"container\">
                <div class=\"row\">
                <div class=\"col-lg-10 col-md-11 mx-auto\">";

            echo "<span class=\"result-output\"> Result: ";
            if ($spam_count == 0) {
                echo "no tweet contains possible spam";
            } else if ($spam_count == 1) {
                echo "one tweet is a possible spam";
            } else {
                echo "$spam_count tweets are possible spams";
            }
            echo "</span><br>";

            echo "<span class=\"runtime\"> ";
            if ($algorithm == "kmp") {
                echo "Knuth-Morris-Pratt";
            } elseif ($algorithm == "bm") {
                echo "Boyer-Moore";
            } else {
                echo "Regex";
            }
            echo " algorithm runtime: " . $result['runtime'] . " s</span>";

            foreach ($result['tweets'] as $tweet) {
                echo "<div ";
                if ($tweet['spam'] == true) {
                    echo " class=\"spam-tweet tweet\">";
                } else {
                    echo " class=\"not-spam-tweet tweet\">";
                }
                echo "<span class='tweet-text'>". $tweet['text'] . "</span><br>";
                echo "&nbsp &nbsp";
                echo "<span class='twitter-name'>- " . $tweet['name'] . "</span>";
                echo "<span class='twitter-username'> &nbsp @" . $tweet['username'] . "</span>";
                echo "</div>";
            }

            echo "</div></div></div></div>";

        }

    ?>

</body>

</html>