<?php
session_start();
foreach ($_SESSION as $key => $value) {
    if ($key == 'input')
        continue;
    unset($_SESSION[$key]);
}
print_r($_SESSION, TRUE);
?>

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
        <link rel="stylesheet" href="assets/css/animate.css">
        <link rel="stylesheet" href="assets/css/font-awesome.css">
        <link rel="stylesheet" href="assets/css/nexus.css">
        <link rel="stylesheet" href="assets/css/responsive.css">
        <link rel="stylesheet" href="assets/css/slider.css">
        <link rel="stylesheet" href="assets/css/support.css">
        <link rel="stylesheet" type="text/css" href="assets/css/dropzone.css">
        <link rel="stylesheet" type="text/css" href="assets/css/base.css">
        <link rel="stylesheet" type="text/css" href="assets/css/translator.css">
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open Sans:300,400">
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Source Sans Pro:300,400">
        <style media="screen">
            h1 {
                margin-top: 20px;
                display: flex;
            }
            #note {
                border-top-style: dotted;
                border-right-style: solid;
                border-bottom-style: dotted;
                border-left-style: solid;
                border-radius: 12px ;
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
            .tb3 {
                border: 2px dashed #D1C7AC;
                width: 432px;
                height: 261px;
            }
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
                    <div class="container no-padding">
                        <div class="display-table">
                            <div class="display-table-cell">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <div class="header-text">
                                                <br><br>
                                                <h1 class="margin-vert-20" style="font-size: 35px;">
                                                    <b>
                                                        <span class="typing" style="color: orange"></span>
                                                    </b>
                                                </h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div id="carousel-example" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div id="view">
                                        <div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:810px;height:300px;overflow:hidden;visibility:hidden;background-color:#000000;">
                                            <div data-u="loading" style="position:absolute;top:0px;left:0px;background-color:rgba(0,0,0,0.7);">
                                                <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
                                                <div style="position:absolute;display:block;background:url('assets/img/slider/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
                                            </div>
                                            <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:600px;height:300px;overflow:hidden;">
                                                <div class="item">
                                                    <img data-u="image" src="assets/im/How1.png">
                                                    <div data-u="thumb">
                                                        <img class="i" src="assets/img/slider/thumb-01.jpg">
<!--                                                        <div class="t">Step 0ne:</div>-->
                                                        <div class="t">Input a file</div>
                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <img data-u="image" src="assets/im/How2.png">
                                                    <div data-u="thumb">
                                                        <img class="i" src="assets/img/slider/thumb-02.jpg">
<!--                                                        <div class="t">Step Two:</div>-->
                                                        <div class="t">Modify the result</div>
                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <img data-u="image" src="assets/im/How3.png">
                                                    <div data-u="thumb">
                                                        <img class="i" src="assets/img/slider/thumb-03.jpg">
<!--                                                        <div class="t">Step Three:</div>-->
                                                        <div class="t">Export the result</div>
                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <img data-u="image" src="assets/im/How4.png">
                                                    <div data-u="thumb">
                                                        <img class="i" src="assets/img/slider/thumb-04.jpg">
<!--                                                        <div class="t">Step Four:</div>-->
                                                        <div class="t">Evaluate the system</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div data-u="thumbnavigator" class="jssort11" style="position:absolute;right:5px;top:0px;font-family:Arial, Helvetica, sans-serif;-moz-user-select:none;-webkit-user-select:none;-ms-user-select:none;user-select:none;width:200px;height:300px;" data-autocenter="2">
                                                <div data-u="slides" style="cursor: default;">
                                                    <div data-u="prototype" class="p">
                                                        <div data-u="thumbnailtemplate" class="tp"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <span data-u="arrowleft" class="jssora02l" style="top:0px;left:8px;width:55px;height:55px;" data-autocenter="2"></span>
                                            <span data-u="arrowright" class="jssora02r" style="top:0px;right:218px;width:55px;height:55px;" data-autocenter="2"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="margin-vert-40">
                        </div>
                    </div>
                    <div class="container">
                        <div class="row margin-vert-30">
                            <div class="col-md-12">
                                <img src="assets/img/title.png" alt="uploads" style="display: block; margin: 0 auto;"><br>
                                <span id="mydiv"></span>                           
                                <div id="alert-both-input" class="alert alert-danger alert-dismissable fade in" hidden="true">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
                                    <strong>Please use only <font color="purple">"Upload your file"</font> or <font color="purple">"Type your text"</font> </strong>
                                </div>
                                <div id="alert-title-input" class="alert alert-danger alert-dismissable fade in" hidden="true">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
                                    <strong>If you use "Type your text", <font color='purple'>Tittle</font> cannot be empty.</strong>
                                </div>
                                <div id="alert-description-input" class="alert alert-danger alert-dismissable fade in" hidden="true">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
                                    <strong>If you use "Type your text", <font color='purple'>"Description"</font> cannot be empty.</strong>
                                </div>                                
                                <div id="alert-empty-input" class="alert alert-danger alert-dismissable fade in" hidden="true">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
                                    <strong>There is no any article. Please add by <font color='purple'>"Upload your file"</font> or <font color='purple'>"Type your text"</font></strong>
                                </div>    
                                <div id="alert-keyboard" class="alert alert-warning alert-dismissable fade in" hidden="true">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
                                    <strong>Please switch your keyboard layout to <font color='red'>"English language"</font> too.</strong>
                                </div>
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#home">Upload your file</a></li>
                                    <li><a data-toggle="tab" href="#menu1">Type your text</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">
                                        <div class="col-md-6">
                                            <p></p>
                                            <form method="post" action="loading.php" id='myForm'><br>
                                                <div action="loading.php" class="dropzone" id="my-dropzone" style="padding: 10px; text-align: center;">
                                                    <section class="wrap"><br>
                                                        <div class="dz-message needsclick">
                                                            <div class="dropzone-image">
                                                                <svg viewBox="0 0 200 110">
                                                                <path d="M108.5,75l0,23.9c0,6.1,5,11,11,11l40.4-0.1c10.7-0.1,20.7-4.3,28.2-11.9c7.5-7.6,11.6-17.6,11.6-28.3 c0-22.2-18.1-40.3-40.3-40.2c-4.4-8.5-11-15.6-19-20.8C131.6,3,121.3,0,110.8,0C101,0,91.4,2.6,83,7.5c-7.3,4.3-13.6,10.3-18.2,17.4 c-6.2-3.1-13-4.7-20-4.7C20.1,20.2,0,40.3,0,65.1S20.1,110,44.8,110l0,0l36.3-0.1c6.1,0,11-4.9,11-11l0-24.1l-10.2,0l18.5-25.3 L119.1,75L108.5,75z M159.9,104l-38.3,0.1c-4,0-7.3-3.3-7.3-7.3V80.8l16.3,0.1l-30.2-41.3l-29.9,41l15.7,0.1v16.2 c0,4-3.3,7.3-7.3,7.3l-34.2,0.1c-21.5,0-39-17.5-39-39.1c0-21.6,17.5-39.1,39-39.1c6.9,0,13.6,1.8,19.6,5.3l2.5,1.5l1.5-2.5 c8.8-15,25-24.4,42.4-24.4c18.8,0,36.2,10.9,44.3,27.9l0.8,1.7l1.9-0.1c0.6,0,1.2,0,1.8,0c18.9,0,34.3,15.4,34.3,34.3 C193.9,88.4,178.6,103.8,159.9,104z"></path>
                                                                </svg>                                  
                                                            </div>
                                                            <p class="dropzone-text">Drag &amp; drop your file here <span>or</span></p>
                                                            <button class="cta low dropzone-upload-btn" type="button">Upload file</button>
                                                        </div>
                                                    </section> 
                                                </div><br>
                                                </div>
                                                </div>
                                                <div id="menu1" class="tab-pane fade">
                                                    <div class="col-md-6">
                                                        <div id="carousel-example-1" class="carousel slide" data-ride="carousel">
                                                            <div class="carousel-inner">
                                                                <div class="item active">
                                                                    <div id="carousel-example-1" class="carousel slide" data-ride="carousel">
                                                                        <div class="carousel-inner">
                                                                            <div class="item active"><center><br>
                                                                                    <p></p>
                                                                                    <input name="title" type="text" id="title" placeholder=" Title here" style="border: 2px dashed #D1C7AC; width: 430px;" onchange="title_input();" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"> <!-- tb3 -->
                                                                                    <br><br>
                                                                                    <textarea name="description" rows="10.99" placeholder=" Article here" class="tb3" id="description" onchange="description_input();" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"></textarea>
                                                                                    <input name="selected" type="hidden" id="selected" value="No">
                                                                                    <input name="eid" type="hidden" id="eid" value="<?php echo time(); ?>">
                                                                                    <input type="hidden"  name='pics' id="pics" >  </center>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <br><br><br><br>
                                        <div class="col-md-6"><center> 
                                            <p style="color: red; font-size: 14px;" id="note">
                                                &nbsp;<b>NOTE:</b> 
                                                You can choose any option below or choose both options.
                                            </p></center>
                                        </div>
                                        <div class="col-md-6">                                        
                                            <center>                                                
                                                &nbsp;<label class="checkbox-inline" style="font-size: 16px; color: purple;">
                                                    <input type="checkbox" class="radio" id="toPassiveBox">
                                                    <input type="text" name="toPassive" id="toPassive" value="unchecked" hidden>
                                                    <b>Active voice to Passive voice</b>
                                                </label>
                                                <br><p></p>
                                                <label class="checkbox-inline" style="font-size: 16px; color: purple;">
                                                    <input type="checkbox" class="radio" id="toActiveBox">
                                                    <input type="text" name="toActive" id="toActive" value="unchecked" hidden>    
                                                    <b>Passive voice to Active voice</b>
                                                </label>
                                            </center><br>
                                        </div>
                                        <br><br>
                                        <center>
                                            <input class="btn btn-lg btn-primary" type="submit" name="finish" id="finish" value="Submit">
                                        </center>
                                        <input type="hidden" name="file-input" id="file-input" value="0">
                                        <input type="hidden" name="title-input" id="title-input" value="0">
                                        <input type="hidden" name="description-input" id="description-input" value="0">
                                        </form>	
                                    </div>
                                </div>
                            </div>
                            <div class="container no-padding gridgallery">
                                <div class="row"><br>
                                    <div class="col-md-12">
                                        <center>
                                            <div class="col-md-12 compatibility-software" data-color="#b3b3b3" data-hover-color="#333333">
                                                <p style="color: red;" id="note"><b style="font-size: 16px">System constraints:</b>
                                                    <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    - The system supports uploaded files <img src="assets/img/txt.png" alt="txt">
                                                    <span>.txt only.</span>                                                    
                                                    <br>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    - The system support uploaded files up to 1MB.
                                                                                                        
                                                    <br>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    - The text base supports 7,000 characters or 2 pages (A4).
                                                    <br> 
                                                    - The system does not consider grammar.
                                                </p>
                                            </div>
                                        </center>
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
            </div>
        </div> 
        <script type="text/javascript" src="assets/js/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="assets/js/bootstrap.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="assets/js/scripts.js"></script>
        <script type="text/javascript" src="assets/js/jquery.isotope.js" type="text/javascript"></script>
        <script type="text/javascript" src="assets/js/jquery.slicknav.js" type="text/javascript"></script>
        <script type="text/javascript" src="assets/js/jquery.visible.js" charset="utf-8"></script>
        <script type="text/javascript" src="assets/js/modernizr.custom.js"></script>
        <script type="text/javascript" src="assets/js/plugin.js"></script>
        <script type="text/javascript" src="assets/js/scripts_1.js"></script>      
        <script type="text/javascript" src="assets/js/jssor.slider-22.2.8.mini.js"></script>
        <script type="text/javascript" src="assets/js/jscontrol.js"></script>
        <script type="text/javascript" src="assets/js/slider.js"></script>
        <script type="text/javascript" src="assets/js/dropzone.js"></script>
        <?php
        if (isset($_SESSION['input']) && $_SESSION['input'] == 'empty') {
            echo "<script type='text/javascript'>
                            window.location.hash = '#alert-empty-input';                        
                            $('#alert-empty-input').removeAttr('hidden');
                        </script>
                        ";
        } else if (isset($_SESSION['input']) && $_SESSION['input'] == 'both') {
            echo "<script type='text/javascript'>              
                            window.location.hash = '#alert-both-input';          
                            $('#alert-both-input').removeAttr('hidden');
                        </script>
                        ";
        } else if (isset($_SESSION['input']) && $_SESSION['input'] == 'title') {
            echo "<script type='text/javascript'>  
                        window.location.hash = '#alert-title-input';                      
                        $('#alert-title-input').removeAttr('hidden');
                        </script>
                        ";
        } else if (isset($_SESSION['input']) && $_SESSION['input'] == 'description') {
            echo "<script type='text/javascript'> 
                        window.location.hash = '#alert-description-input';                       
                        $('#alert-description-input').removeAttr('hidden');
                        </script>
                ";
        }
        session_destroy();
        ?>
        <script type="text/javascript">
            function title_input() {
                var tit_ = $('#title').val();
                if (tit_.replace(/\s+/g, '').length == 0)
                    $('#title-input').val('0');
                else
                    $('#title-input').val('1');
            }

            function description_input() {
                var dec_ = $('#description').val();
                if (dec_.replace(/\s+/g, '').length == 0)
                    $('#description-input').val('0');
                else
                    $('#description-input').val('1');
            }
            Dropzone.options.myDropzone = {
                autoProcessQueue: false,
                parallelUploads: 2,
                uploadMultiple: false,
                maxFilesize: 1, // MB
                maxFiles: 1,
                acceptedFiles: ".txt",
                addRemoveLinks: true,
                init: function () {
                    var submitButton = document.querySelector("#finish")
                    myDropzone = this;
                    submitButton.addEventListener("click", function (e) {
                        //  e.preventDefault();                        
                        
                        if($("#toPassiveBox").is(':checked')) $('#toPassive').val('checked');
                        if($("#toActiveBox").is(':checked')) $('#toActive').val('checked');
                        
                        
                        myDropzone.processQueue();
                    });
                    this.on("removedfile", function (file) {
                        //                            x = confirm('Do you want to delete?');
                        //                            if (!x) {
                        //                                return false;
                        //                            }
                        // ********************************
                        $('#file-input').val('0');
                        // ********************************
                    });
                    this.on("addedfile", function (file) {
                        // ********************************
                        $('#file-input').val('1');
                        // ********************************
                        var ext = file.name.split('.').pop();
                        if (ext == "txt") {
                            //$(file.previewElement).find(".dz-image img").attr("src", "images/1487495563_txts.png");
                        }
                    });
                    this.on("sending", function (file, xhr, formData) {
                        formData.append("action", "value");
                    });
                    this.on('success', function (d, r) {
                        //$("#pics").attr('value', r);
                    });
                    this.on("queuecomplete", function (file) {
                        //alert("File big size");
                        //$("#myForm").off('submit').submit();
                    });
                    this.on("maxfilesexceeded", function (file) {
                        //alert("No more files please!");
                        $('#mydiv').replaceWith('<div id="mydiv" class="alert alert-danger alert-dismissable fade in">\n\
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>\n\
                        <strong>The file cannot be add more than one file! Please remove all files and add only one.</strong></div>');
                        $('#mydiv').show();
                        this.removeFile(file);
                    });
                    this.on("sending", function (file, xhr, formData) {
                        var eid = document.getElementById('eid').value;
                        formData.append('eid', eid);
                    });
                    this.on('error', function (file, errorMessage) {
                        if (errorMessage.indexOf('Error 404') !== -1) {
                            var errorDisplay = document.querySelectorAll('[data-dz-errormessage]');
                            errorDisplay[errorDisplay.length - 1].innerHTML = 'Error 404: The upload page was not found on the server';
                        }
                        if (errorMessage.indexOf('File is too big') !== -1) {
                            //alert("File big size!");
                            $('#mydiv').replaceWith('<div id="mydiv" class="alert alert-danger alert-dismissable fade in">\n\
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>\n\
                        <strong>The file is too big! Please choose any file with size smaller than or equal to 1MB only.</strong></div>');
                            $('#mydiv').show();
                            this.removeFile(file);
                        }
                    });
                }
            };

            $(function () {
                $("#title, #description").keypress(function (event) {
                    var keyboard = event.which;
                    //if ((keyboard == 32) || (48 <= keyboard && keyboard <= 57) || (65 <= keyboard && keyboard <= 90) || (97 <= keyboard && keyboard <= 122))
                    if(32 <= keyboard && keyboard <= 127)
                        return true;
                    $('#alert-keyboard').removeAttr('hidden');
                    return false;
                });
            });            
        </script>
    </body>
</html>
