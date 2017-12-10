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
        <link rel="stylesheet" href="assets/css/animate.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/nexus.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/responsive.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/support.css">
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open Sans:300,400">
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Source Sans Pro:300,400">
        <style media="screen">
            h1 {
                margin-top: 20px;
                display: flex;
            }

            h1:before,
            h1:after {
                color: green;
                content: '';
                flex: 1;
                border-bottom: groove 1px;
                margin: auto 0.25em;
                box-shadow: 0 -1px;
            }
            #note {
                border-top-style: dotted;
                border-right-style: solid;
                border-bottom-style: dotted;
                border-left-style: solid;
                border-radius: 12px ;
            }
            p.round2 {
                border: 2px solid ;
                border-radius: 8px;
            }
        </style>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <link rel="stylesheet" type="text/css" href="assets/css/base.css">
    </head>

    <?php
    error_reporting(error_reporting() & ~E_NOTICE);
    session_start();
//    print_r($_SESSION['log']);
    include_once 'config.php';
//    $select_word = $_POST['word'];
    echo "<script>console.log('Number of log : " . count($_SESSION['log']) . "')</script>";
//    print_r($_SESSION['log']);
    if (is_array($_SESSION['log']) || is_object($_SESSION['log']))        
    foreach ($_SESSION['log'] as $log) {
        $pos = $log->pos;
        $before = $log->before;
        $after = $log->after;
        echo "<script>console.log('" . $before . " | " . $after . "')</script>";
        $sql = "SELECT * FROM logs WHERE pos='" . $pos . "' and before_word = '" . $before . "' and after_word = '" . $after . "'";
        $query_result = $link->query($sql);
        if ($query_result->num_rows > 0) {
            //update    
            $result = $query_result->fetch_assoc();
            $count_word = $result['count_word'] + 1;
            $sql2 = "UPDATE logs SET count_word = '" . $count_word . "' WHERE pos='" . $pos . "' and before_word = '" . $before . "' and after_word = '" . $after . "'";
            $query = mysqli_query($link, $sql2) or die(mysqli_error($link));
        } else {
            //insert
            $sql3 = "INSERT INTO logs(pos, before_word, after_word, count_word) VALUE"
                    . "('" . $pos . "','" . $before . "','" . $after . "',"
                    . "1)";
            mysqli_query($link, $sql3) or die(mysqli_error($link));
        }
    }

    unset($_SESSION['ss_time_of_post']);
    print_r($_SESSION, TRUE);
    include_once 'config.php';
    $sql_retrieve_content = "SELECT * FROM `files_resource` WHERE `id` = "
            . $_SESSION['ss_id_file'] . " AND `file_name` = '" . $_SESSION["ss_filename"] . "'";
    $result_set = mysqli_query($link, $sql_retrieve_content);
    if (!$result_set) {
        //echo '<center><h2><b>Can not find your file, please try again.<b></h2> <br><a href="index.php" type="button" class="btn btn-lg btn-danger">Try again</a></center></center><br>';
        //echo("Error description: " . mysqli_error($link));
        //require('./error.php');
    } else {
        while ($row = mysqli_fetch_array($result_set)) {
            $title = $row['file_name'];
            $upload_by = $row['upload_by'];
            if ($row['upload_by'] == "File") {
                $temp_title = explode(".", $row['file_name']);
                $title = "";
                for ($i = 0; $i < count($temp_title) - 1; $i = $i + 1)
                    $title .= $temp_title[$i];
            }
            $file_content = $row['content'];
        }
    }
    ?>

    <body>
        <div id="body_bg">
            <div id="container_header" class="container">
                <div id="header" class="row">
                    <div class="clear"></div>
                </div>
            </div>
            <div class="primary-container-group">
                <div class="primary-container-background">
                    <div class="primary-container"></div>
                    <div class="clearfix"></div>
                </div>
                <div class="primary-container">
                    <div id="container_hornav" class="container no-padding">
                        <div class="logo">
                            <a href="index.php">
                                <img src="assets/img/Untitled-1.png" alt="Logo" width="400px;" height="120px;">
                            </a>
                        </div>
                        <div class="row">
                            <div class="hornav-block">
                                <div id="hornav" class="pull-right">
                                <ul id="hornavmenu" class="nav navbar-nav">
                                    <li>
                                        <a href="index.php">Home</a>
                                    </li>                                        
                                    <li>
                                        <a href="publication_NCIT.php">Awards</a>
                                    </li>
                                    <li>
                                        <a href="about.php">About Us</a>
                                    </li>
                                    <li>
                                        <a href="contact.php">Contact Us</a>
                                    </li>
                                    <li>
                                        <a href="help.php">Help</a>
                                    </li>
                                </ul>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="container" id="thecontent">
                        <div class="row margin-vert-30">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12"><br>
                                        <center>
                                            <div class="image-hover">
                                                <img src="assets/img/portfolio/thank.png" alt="thank" width="460px"><br>
                                            </div>
                                        </center>
                                    </div>
                                    <div id="change"></div>
<?php
if (!$result_set) {
    echo '<center><h2><b>Can not find your file. Please try again.<b></h2> <br><a href="index.php" type="button" class="btn btn-lg btn-danger">Try again</a></center></center><hr class="margin-vert-40">';
}
if ($_POST['submit_1']) {
    error_reporting(error_reporting() & ~E_NOTICE);
    session_start();
    include('config.php');
    include('report/vsword/VsWord.php');
    require_once('report/fpdf181/fpdf.php');
    if (isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']) {
        $secret = "6LdMBxYUAAAAAHBGWk77p790Y195jUSASgAJ2ljb";
        $ip = $_SERVER['REMOTE_ADDR'];
        $captcha = $_POST['g-recaptcha-response'];
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip$ip");
        $array = json_decode($response, TRUE);
    }
    $sql_retrieve_content = "SELECT * FROM `files_resource` WHERE `id` = "
            . $_SESSION['ss_id_file'] . " AND `file_name` = '" . $_SESSION["ss_filename"] . "'";
    $result_set = mysqli_query($link, $sql_retrieve_content) or die(mysqli_error($link));
    while ($row = mysqli_fetch_array($result_set)) {
        $title = $row['file_name'];
        $upload_by = $row['upload_by'];
        if ($row['upload_by'] == "File") {
            $temp_title = explode(".", $row['file_name']);
            $title = "";
            for ($i = 0; $i < count($temp_title) - 1; $i = $i + 1)
                $title .= $temp_title[$i];
        }
        $file_content = $row['content'];
    }
    $name = $_POST['option'];
    if (isset($_POST['option'])) {
        foreach ($name as $format) {
            if ($format == "txt") {
                echo "<center><h2><b>You choose the following format file(s):</b> &nbsp; <b style='color: purple'>.TXT</b></h2></center><br>";
                $name = $_SESSION['ss_filename'];
                if ($upload_by == 'Text-Base') {
                    $name .= '.txt';
                }
                file_put_contents("download/" . $name, $title . "\r\n");
                file_put_contents("download/" . $name, $file_content, FILE_APPEND);
                echo "<center><a href=download/" . $name . " type='button' class='btn btn-lg btn-primary' id='downloadLink' download>Download</a>";
                echo "&nbsp; <b>or</b> &nbsp;<a href='result.php' type='button' class='btn btn-lg btn-danger'>Choose again</a></center><hr class='margin-vert-40'>";
            } else if ($format == "doc") {
                echo "<center><h2><b>You choose the following format file(s):</b> &nbsp; <b style='color: purple'>.DOCX</b></h2></center><br>";
                VsWord::autoLoad();
                $doc = new VsWord();
                $parser = new HtmlParser($doc);
                $parser->parse("<h4>" . $title . "</h4>");
                $parser->parse($file_content);
                $doc->saveAs("download/" . $title . ".docx");
                echo "<center><a href=download/" . $title . ".docx type='button' class='btn btn-lg btn-primary' id='downloadLink' download>Download</a>";
                echo "&nbsp; <b>or</b> &nbsp;<a href='result.php' type='button' class='btn btn-lg btn-danger'>Choose again</a></center><hr class='margin-vert-40'>";
            } else if ($format == "pdf") {
                echo "<center><h2><b>You choose the following format file(s):</b> &nbsp; <b style='color: purple'>.PDF</b></h2></center><br>";
                ob_start();
                $pdf = new FPDF();
                $pdf->AddPage();
                $pdf->AddFont('courier', '', 'courier.php');
                $pdf->SetFont('courier', 'B', 16);
                $pdf->Cell(190, 20, iconv('UTF-8', 'TIS-620', $title), 0, 1, 'C');
                $pdf->AddFont('courier', '', 'courier.php');
                $pdf->SetFont('courier', '', 16);
                $pdf->MultiCell(190, 7, iconv('UTF-8', 'TIS-620', $file_content), 'C');
                $pdf->Output("download/" . $title . ".pdf", "F");
                echo "<center><a href=download/" . $title . ".pdf type='button' class='btn btn-lg btn-primary' id='downloadLink' download>Download</a>";
                echo "&nbsp; <b>or</b> &nbsp;<a href='result.php' type='button' class='btn btn-lg btn-danger'>Choose again</a></center><hr class='margin-vert-40'>";
                ob_end_flush();
            }
        }
    }
}
?>
                                </div>
                                <div class="col-md-12">
                                    <center>
                                        <p style="color: red; font-size: 16px" id="note"><b style="font-size: 16px">NOTE:</b>
                                            After clicking on <b>"Download"</b>,
                                            <br>we may ask you for a few minute to do our survey<br>in order to improve our our system in the future.
                                        </p>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="footermenu" class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-9">
                                    <p>
                                    <style media="screen">
                                        a,
                                        u {
                                            text-decoration: none;
                                        }

                                        a {
                                            text-decoration: none !important;
                                            font-size: 12px;
                                        }
                                    </style>
                                    <p></p>
                                    <a href="index.php"> 
                                        <font style="color:white;">Copyright &copy; 2017 </font>
                                        <b>Alternative Word Suggestion System for English Writings Project. 
                                            <font style="color:white;">Version </font>1.0.3
                                        </b>
                                        <br>
                                        <font style="color:white;">Developed by </font>
                                        <b> Suphachok Noopan, Jirayu Chinnawong, Borey Sok.</b>
                                        <font style="color:white;">Inspired by </font><b> Dr. Nattapong Tongtep.</b>
                                    </a>
                                    <br>
                                    <a href="http://www.computing.psu.ac.th/" target="_blank">
                                        <b>College of Computing, 
                                            Prince of Songkla University, Phuket Campus.</b>
                                    </a>
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <br>
                                    <a href="index.php"><img src="assets\img\shortkey.png" alt="Alt+w"></a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-4">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>              
            <div class="container padding-vert-30">
                <div class="row">
                </div>
            </div>
        </div>
        <script type="text/javascript" src="assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/js/scripts.js"></script>
        <script type="text/javascript" src="assets/js/jquery.isotope.js"></script>
        <script type="text/javascript" src="assets/js/jquery.slicknav.js"></script>
        <script type="text/javascript" src="assets/js/jquery.visible.js" charset="utf-8"></script>
        <script type="text/javascript" src="assets/js/modernizr.custom.js"></script>
        <script type="text/javascript">
            //$('#change').replaceWith('');
        </script>   
        <script type="text/javascript">
            var checkSelectOption1 = "no";
            var checkSelectOption2 = "no";
            var checkCaptcha = "no";
            $("input:radio[name='option[]']").on('click', function () {
                var $box1 = $(this);
                if ($box1.is(":checked")) {
                    var group1 = "input:radio[name='option[]']";
                    console.log(group1);
                    $(group1).prop("checked", false);
                    $box1.prop("checked", true);
                    checkSelectOption1 = "yes";
                    $('#divCaptcha').removeAttr('hidden');
                } else {
                    $box1.prop("checked", false);
                }
            });
            $(function () {
                $("#downloadLink").click(function () {
                    window.location = "https://docs.google.com/forms/d/e/1FAIpQLSeT0IUUwvw4mgwVUkZmBpcuS1L3a0NoU4Gt_xOVQH2OUm7LFg/viewform";
                });
            });
            function callback() {
                if (checkSelectOption1 == "yes") {
                    $("#downloadLink").removeAttr('disabled');
                }
            }
        </script>
    </body>
</html>
