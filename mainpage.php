<!DOCTYPE html>
<html>
<head>
    <title>Spam Seeker</title>
</head>

<body>

    <center><h1>Spam Seeker</h1></center>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        Keyword(s): <input input="text" name="keyword" placeholder="pisahkan dengan koma(,)">
        
        <br><br>
        
        Algortima:
        <br><input type="radio" name="algorithm" value="bm" checked> Boyer-Moore
        <br><input type="radio" name="algorithm" value="kmp"> KMP
        <br><input type="radio" name="algorithm" value="regex"> Regex

        <br><br>

        <button type="submit">Cari Tweet Spam</button>

    </form>

    <br><br>

    <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $keyword = $_REQUEST['keyword'];
            $algorithm = $_REQUEST['algorithm'];
    
            // dictionary hasil input user
            $data = array('keyword' => $keyword, 'algorithm' => $algorithm);

            // tulis ke file user_input.json
            $fp = fopen('user_input.json', 'w');
            fwrite($fp, json_encode($data));
            fclose($fp);
            echo "Input user berhasil di-export ke user_input.json";
        }

        require 'api.php';
        
        // menjalankan program kmp dan boyce-moore
        exec('python test.py');

    ?>

</body>

</html>