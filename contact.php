<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <head>
        <title>Alternative Word Suggestion System for English Writings</title>
        <meta >
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
        <link rel="stylesheet" type="text/css" href="assets/css/contact-form.css">
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
                            <div class="col-md-9">
                                <div class="headline">
                                    <img src="assets/img/contact.png" alt="Contact Us" style="display: block; margin: 0 auto;"><br>
                                </div>
                                <div class="headline">
                                    <p class="MsoNormal" style="text-align: justify; text-justify: inter-word;">
                                        <b>80 Village No.1 Vichitsongkram Road, Kathu, Kathu District, Phuket, 83120</b>
                                    </p>
                                </div>
                                <br>
                                <form id="contact-form">
                                    <div class="contact-form-loader"></div>
                                    <fieldset>
                                        <label class="name">
                                            <input type="text" name="name" placeholder="Name:" value="" data-constraints="@Required @JustLetters"  >
                                            <span class="empty-message">*This field is required.</span>
                                            <span class="error-message">*This is not a valid name.</span>
                                        </label>
                                        <label class="email">
                                            <input type="text" name="email" placeholder="E-mail:" value="" data-constraints="@Required @Email">
                                            <span class="empty-message">*This field is required.</span>
                                            <span class="error-message">*This is not a valid email.</span>
                                        </label>
                                        <label class="phone">
                                            <input type="text" name="phone" placeholder="Phone:" value="" data-constraints="@Required @JustNumbers" maxlength="10">
                                            <span class="empty-message">*This field is required.</span>
                                            <span class="error-message">*This is not a valid phone.</span>
                                        </label>
                                        <label class="message">
                                            <textarea name="message" placeholder="Message:" data-constraints='@Required @Length(min=20,max=999999)'></textarea>
                                            <span class="empty-message">*This field is required.</span>
                                            <span class="error-message">*The message is too short.</span>
                                        </label><br>
                                        <div class="ta__right" style="float: right;">
                                            <a href="#" class="btn btn-primary" data-type="reset">Clear</a>
                                            <a href="#" class="btn btn-primary" data-type="submit">Send</a><br><br>
                                        </div>
                                    </fieldset>
                                    <div class="modal fade response-message">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title">Modal title</h4>
                                                </div>
                                                <div class="modal-body">
                                                    You message has been sent! We will be in touch soon.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><b><center>Contact Info</center></b></h3>
                                    </div>
                                    <div class="panel-body">
                                        <br>
                                        <center>&nbsp;&nbsp; <img src="assets\img\TE+PSU_logo_TH2.png" height="260px"><br><br></center>
                                        <ul class="list-unstyled">
                                            <li>
                                                <strong class="color-primary">Monday-Saturday:</strong><br>&nbsp;&nbsp;&nbsp;9 a.m. to 6 p.m.</li>
                                            <li>
                                                <strong class="color-primary">Sunday:</strong><br>&nbsp;&nbsp;&nbsp;Closed</li>
                                        </ul>
                                    </div>
                                    <div class="panel-footer">
                                        <ul class="list-unstyled">
                                            <li>
                                                <i class="fa-phone color-primary"></i>0-7627-6012-13</li>
                                            <li>
                                                <i class="fa-home color-primary"></i><a target="blank" href="http://www.phuket.psu.ac.th">www.phuket.psu.ac.th</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="margin-vert-40">
                    </div>
                    <div id="base" class="container padding-vert-30">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- <script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script>
                                <div style='overflow:hidden;height:200px;width:1012px;'>
                                    <div id='gmap_canvas' style='height:200px;width:1012px;'></div>
                                    <div><small><a href="http://embedgooglemaps.com">embed google maps</a></small></div>
                                    <div><small><a href="http://ironlinkdirectory.com/">link directory</a></small></div>
                                    <style>
                                        #gmap_canvas img {
                                            max-width: none!important;
                                            background: none!important
                                        }
                                    </style>
                                </div>
                                <script type='text/javascript'>
                                    function init_map() {
                                        var myOptions = {
                                            zoom: 19,
                                            center: new google.maps.LatLng(7.894738785211739, 98.35266449794582),
                                            mapTypeId: google.maps.MapTypeId.ROADMAP
                                        };
                                        map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);
                                                TE + PSU_logo_TH2.pngmarker = new google.maps.Marker({
                                                map: map,
                                                        position: new google.maps.LatLng(7.894738785211739, 98.35266449794582)
                                                });
                                        infowindow = new google.maps.InfoWindow({
                                            content: '<strong>PSU phuket</strong><br>Prince of Songkla University, Phuket Campus<br>'
                                        });
                                        google.maps.event.addListener(marker, 'click', function () {
                                            infowindow.open(map, marker);
                                        });
                                        infowindow.open(map, marker);
                                    }
                                    google.maps.event.addDomListener(window, 'load', init_map);
                                </script> -->
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.0112259143048!2d98.3502991491014!3d7.893893494285219!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30503034ccf5b0bf%3A0x7df5467aad0bbdf9!2sPrince+of+Songkla+University%2C+Phuket+Campus!5e0!3m2!1sen!2sth!4v1512370322900" 
                                width="1030" height="210" frameborder="0" style="border:0" allowfullscreen></iframe>
                            </div>
                            <div class="clearfix"></div>
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
        <script type="text/javascript" charset="utf-8" src="assets/js/superfish.js"></script>
        <script type="text/javascript" charset="utf-8" src="assets/js/modernizr.custom.js"></script>
        <script type="text/javascript" charset="utf-8" src="assets/js/jquery.easing.1.3.js"></script>
        <script type="text/javascript" charset="utf-8" src="assets/js/script.js"></script>
        <script type="text/javascript" charset="utf-8" src="assets/js/tmStickUp.js"></script>
        <script type="text/javascript" charset="utf-8" src="assets/js/TMForm.js"></script>
        <script type="text/javascript" charset="utf-8" src="assets/js/modal.js"></script>
    </body>
</html>
