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
        <link rel="stylesheet" href="assets/css/bootstrap.css">
        <link rel="stylesheet" href="assets/css/splash.css">
    </head>
    <body>
        <div class="preload">
            <div class="logo">
                Alt<span style="color: #BA55D3;">W</span>
            </div>
            <div class="loader-frame">
                <div class="loader1" id="loader1"></div>
                <div class="loader2" id="loader2"></div>
            </div>
            <div class="col-md-12 text-center">
                <br><br><br>
                <h3 style="color: white;">
<!--                    Please wait while the system is <span style="color: #BA55D3;">processing your request.</span>-->
                    Please wait a minute, <span style="color: #BA55D3;">our system is processing.</span> 
                </h3>  
            </div>
        </div>
    </body>
</html>

<?php
session_start();

$_SESSION['toPassive'] = $_POST['toPassive'];
$_SESSION['toActive'] = $_POST['toActive'];

if ($_POST['title-input'] == '0' && $_POST['description-input'] == '0' && $_POST['file-input'] == '0') {
    $_SESSION['input'] = "empty";
    header("location: index.php");
} else if (($_POST['title-input'] == '1' || $_POST['description-input'] == '1') && $_POST['file-input'] == '1') {
    $_SESSION['input'] = "both";
    header("location: index.php");
} else if ($_POST['title-input'] == '1' && $_POST['description-input'] == '0') {
    $_SESSION['input'] = "description";
    header("location: index.php");
} else if ($_POST['title-input'] == '0' && $_POST['description-input'] == '1') {
    $_SESSION['input'] = "title";
    header("location: index.php");
} else {
    if (!empty($_FILES)) {
        $file_name = $_FILES['file']['name'];
        $file_name = str_replace(" ", "_", $file_name);
        $content = file_get_contents($_FILES['file']['tmp_name']);
        $content = addslashes($content);
        $upload_by = "File";
        $upload_date = date('Y-m-d H:i:s', $_POST['eid']);
        include('config.php');
        $sql_store_content = "INSERT INTO files_resource (file_name, content,  upload_by, upload_date)
                VALUES ('" . $file_name . "','" . $content . "', '" . $upload_by . "', '" . $upload_date . "')";
        $result_set = mysqli_query($link, $sql_store_content);
        $sql_call_id = "SELECT id, file_name FROM files_resource ORDER BY id DESC LIMIT 1";
        $result_id = mysqli_query($link, $sql_call_id);
        while ($row = $result_id->fetch_assoc()) {
            if (isset($_SESSION['ss_id_file'])) {
                unset($_SESSION['ss_id_file']);
                $_SESSION["ss_id_file"] = $row['id'];
            } else {
                $_SESSION["ss_id_file"] = $row['id'];
            }
            if (isset($_SESSION['ss_filename'])) {
                unset($_SESSION['ss_filename']);
                $_SESSION["ss_filename"] = $row['file_name'];
            } else {
                $_SESSION["ss_filename"] = $row['file_name'];
            }
        }
    } else {
        $file_name = $_POST['title'];
        $file_name = str_replace(" ", "_", $file_name);
        $content = $_POST['description'];
        $content = addslashes($content);
        $upload_by = "Text-Base";
        if (!$file_name == "" || !$content == "") {
            $upload_date = date('Y-m-d H:i:s', $_POST['eid']);
            include('config.php');
            $sql_store_content = "INSERT INTO files_resource (file_name, content,  upload_by, upload_date)
                    VALUES ('" . $file_name . "','" . $content . "', '" . $upload_by . "', '" . $upload_date . "')";
            $result_set = mysqli_query($link, $sql_store_content);
            $sql_call_id = "SELECT id, file_name FROM files_resource ORDER BY id DESC LIMIT 1";
            $result_id = mysqli_query($link, $sql_call_id);
            while ($row = $result_id->fetch_assoc()) {
                if (isset($_SESSION['ss_id_file'])) {
                    unset($_SESSION['ss_id_file']);
                    $_SESSION["ss_id_file"] = $row['id'];
                } else {
                    $_SESSION["ss_id_file"] = $row['id'];
                }
                if (isset($_SESSION['ss_filename'])) {
                    unset($_SESSION['ss_filename']);
                    $_SESSION["ss_filename"] = $row['file_name'];
                } else {
                    $_SESSION["ss_filename"] = $row['file_name'];
                }
            }
        }
    }
    if (isset($_POST['finish'])) {
        ?>
        <script type="text/javascript">
            //window.location = "countword.php";
            window.location = "result.php";
        </script>
        <?php
    }
}
?>

