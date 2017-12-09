<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <head>
        <title>Alternative Word Suggestion System for English Writings</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <link rel="shortcut icon" type="image/ico" href="assets/icon/favicons.ico">
        <link rel="apple-touch-icon" href="assets/icon/apple-touch-icon.png">
        <link rel="stylesheet" href="assets/css/bootstrap.css" rel="stylesheet">
    </head>
    <body>
        <br>
        <?php
        require('wn_config.php');
        session_start();

        print_r($_SESSION, TRUE);
        include('config.php');
        $sql_retrieve_content = "SELECT * FROM files_resource where id = " .
                $_SESSION['ss_id_file'] . " and file_name = '" . $_SESSION["ss_filename"] . "'";
        $result_set = mysqli_query($link, $sql_retrieve_content);
        while ($row = mysqli_fetch_array($result_set)) {
            $title = $row['file_name'];
            $upload_by = $row['upload_by'];
            if ($row['upload_by'] == "File") {
                $temp_title = explode(".", $row['file_name']);
                $title = "";
                for ($i = 0; $i < count($temp_title) - 1; $i = $i + 1)
                    $title .= $temp_title[$i];
            }
            $content = $row['content'];
        }

        $content = preg_replace('/\s+/', ' ', $content);
        $contents = explode(' ', $content);
        require './POS/file/vendor/autoload.php';
        use StanfordTagger\POSTagger;
        $pos = new POSTagger();
        $contentPos = $pos->tag($content);
        $contentPos = explode(" ", $contentPos);
        $_SESSION['numOfW'] = count($contentPos);
        echo "<br><mark>Verb in sentences : </mark><br><br>";
        for ($i = 0; $i < $_SESSION['numOfW']; $i++) {
            $idxOf_ = strrpos($contentPos[$i], "_");
            $p = substr($contentPos[$i], $idxOf_ + 1, 1);
            $c = $contentPos[$i];
//            $c = explode('_', $c);
//            $c = implode(' ', $c);
            if ($p == "V" || $p == "P") {
                echo "&nbsp;" . $c . "<br>";
            } 
        }
        echo "<br>";
        ?> 
    </body>
</html>