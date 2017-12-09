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
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="assets/css/animate.css">
        <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="assets/css/nexus.css">
        <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open Sans:300,400">
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Source Sans Pro:300,400">
        <link rel="stylesheet" type="text/css" href="assets/css/base.css">
        <style>
            img.gal:hover {
                -webkit-transform: scaleX(-1);
                transform: scaleX(-1);
            }
            div.gallery {
                margin: 5px;
                border: 1px solid #ccc;
                float: left;

            }

            div.gallery:hover {
                border: 1px solid #777;
            }

            div.gallery img {
                width: 100%;
                height: auto;
            }

            div.desc {
                padding: 15px;
                text-align: center;
            }

            .tiles {
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }

            .tile {
                position: relative;
                float: left;
                width: 640px;
                height: 400px;
                overflow: hidden;
            }

            .photo {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-repeat: no-repeat;
                background-position: center;
                background-size: cover;
                transition: transform .5s ease-out;
            }

            .txt {
                position: absolute;
                z-index: 2;
                right: 0;
                bottom: 10%;
                left: 0;
                font-family: 'Roboto Slab', serif;
                font-size: 9px;
                line-height: 12px;
                text-align: center;
                cursor: default;
            }

            .x {
                font-size: 32px;
                line-height: 32px;
            }


            .shadow {-webkit-filter: drop-shadow(8px 8px 10px black);filter: drop-shadow(8px 8px 10px black);}
        </style>
    </head>
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
                    <div class="container">
                        <div class="row margin-vert-30">
                            <div class="col-md-12">
                                <img src="assets/img/portfolio/public.png" alt="About Us" style="display: block; margin: 0 auto;">
                                <p></p>
                                <ul class="breadcrumb">  <br>  
                                    <p></p>
                                    <div class="row">
                                        <center>
                                            <div class="col-md-12 col-lg-offset-2">
                                                <div class="shadow">
                                                    <div id="carousel-example-1" class="carousel slide" data-ride="carousel">
                                                        <div class="carousel-inner">
                                                            <div class="item active">
                                                                <div class="tiles">
                                                                    <div class="tile" data-scale="1.1" data-image="http://i68.tinypic.com/wancjq.jpg"> 
                                                                    </div>
                                                                </div>
                                                                <div class="desc">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">       
                                                <br>
                                                <center>
                                                    <img class="shadow" src="assets/images/1.jpg" alt="wordnet" height="180" width="">&nbsp;&nbsp;  
                                                    <img class="shadow" src="assets/images/3.jpg" alt="wordnet" height="180" width="">&nbsp;&nbsp;  
                                                    <img class="shadow" src="assets/images/4.jpg" alt="wordnet" height="180" width="">
                                                </center>
                                                <p></p><br>
                                            </div>
                                            <div class="col-md-12">       
                                                <p></p><br>
                                                <h3 class="MsoNormal">
                                                    <strong>National Conference on Information Technology (NCIT) No.9</strong>
                                                </h3>
                                                <p></p>
                                                <center>
                                                    <h2> 
                                                        <img src="assets/images/Book.gif" alt="" />
                                                        <a style="color: red; font-size: 20px;" target="_blank" 
                                                           href="https://drive.google.com/file/d/1LeaAXCoZDdkXJhHx2HCjQrxumS_EAkDU/view?usp=sharing">
                                                            <strong>click to read the paper.&nbsp;</strong>
                                                        </a>
                                                    </h2> 
                                                </center>
                                            </div>
                                        </center>
                                    </div>
                                    <hr class="margin-vert-40">
                                    <div class="container">            
                                        <ul class="pagination pagination-lg" style="float: right">
                                            <li><a href="publication_NCIT.php">NCIT</a></li>   
                                            <li class="active"><a href="publication_NSC.php" style="color: #ccc">NSC</a></li>
                                        </ul>
                                    </div> 
                                </ul>
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
        <script type="text/javascript" charset="utf-8" src="assets/js/jquery.min.js"></script>
        <script type="text/javascript" charset="utf-8" src="assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" charset="utf-8" src="assets/js/scripts.js"></script>
        <script type="text/javascript" charset="utf-8" src="assets/js/jquery.isotope.js"></script>
        <script type="text/javascript" charset="utf-8" src="assets/js/jquery.slicknav.js"></script>
        <script type="text/javascript" charset="utf-8" src="assets/js/jquery.visible.js"></script>
        <script type="text/javascript" charset="utf-8" src="assets/js/modernizr.custom.js"></script>
        <script>
            $('.tile').on('mouseout', function () {
                $(this).children('.photo').css({'transform': 'scale(' + $(this).attr('data-scale') + ')'});
            }).on('mouseover', function () {
                $(this).children('.photo').css({'transform': 'scale(1)'});
            }).each(function () {
                $(this).append('<div class="photo"></div>').append($(this).attr('data-scale')).children('.photo').css({'background-image': 'url(' + $(this).attr('data-image') + ')'});
            })
        </script>
    </body>
</html>