<?php

require('wn_config.php');
include('config.php');
require('func_pas2act.php');
require('func_act2pas.php');

function console($str){echo "<script>console.log('".$str."');</script>";}

error_reporting(error_reporting() & ~E_NOTICE);
session_start();

$sql_retrieve_content = "SELECT * FROM files_resource where id = " .
        $_SESSION['ss_id_file'] . " and file_name = '" . $_SESSION["ss_filename"] . "'";
$result_set = mysqli_query($link, $sql_retrieve_content);
if (!$result_set)
{
    //echo("Error description: " . mysqli_error($link));
    require('./error.php');
}
else
{
    while ($row = mysqli_fetch_array($result_set))
    {
        $title = $row['file_name'];
        $upload_by = $row['upload_by'];
        if ($row['upload_by'] == "File")
        {
            $temp_titlze = explode(".", $row['file_name']);
            $title = "";
            for ($i = 0; $i < count($temp_title) - 1; $i = $i + 1)
                $title .= $temp_title[$i];
        }
        $content = $row['content'];
    }
}
for ($char = 33; $char <= 63; $char++)
{
    if ($char <= 47 || 58 <= $char)
    {
        $content = str_replace(chr($char), " " . chr($char) . " ", $content);
    }
}

$contents = explode(' ', $content);
$_SESSION['content_resource'] = array();
$_SESSION['content_pos'] = array();
$_SESSION['content_modified'] = array();

//require './POS/file/vendor/autoload.php';
require './vendor/autoload.php';
use StanfordTagger\POSTagger;
$pos = new POSTagger();
$contentPos = $pos->tag($content);

$contentPos_TEMP = str_replace("\n", " ", $contentPos);
$contentPos = explode(" ", $contentPos_TEMP);
$_SESSION['numOfW'] = count($contentPos);
$_SESSION['contentPos'] = $contentPos;

//count SENTENCE
$fullstop = array();
$idx = 0;
for ($i = 0; $i < $_SESSION['numOfW']; $i++) 
{
    if($contentPos[$i] == "._." || $contentPos[$i] == ",_," )
    {                
        $fullstop[$idx] = $i;        
        $idx++;
    }        
}

//idenifine setence
$changeToPassive = array(); $changeToActive = array();
for ($dot = 0; $dot < count($fullstop); $dot++) { $changeToPassive[$dot]=FALSE; $changeToActive[$dot]=FALSE; }

//find SYNONYM, ACTIVE TO PASSIVE, PASSIVE TO ACTIVE
$idx = 0;
for ($dot = 0; $dot < count($fullstop); $dot++) 
{       
    $sentence = "";    
    $prev_fullstop = $dot==0?0:$fullstop[$dot-1]+1;        


    $changeToPassive[$dot] = FALSE;
    $changeToActive[$dot] = FALSE;
    $v1_ = FALSE;
    $toBe_ = FALSE;
    $v3_ = FALSE;    
    $by_ = FALSE;
    $otherPos_ = FALSE;
    $toBeIdx = -1;

    for ($i = $prev_fullstop; $i < $fullstop[$dot]; $i++)
    {               
        $word = explode("_", $contentPos[$i]);  
        $sentence .= $word[0];                     
        if($i<$fullstop[$dot]-1) $sentence .= " ";

        if(in_array($word[1], array("NN", "NNS", "NNP", "NNPS", "VB", "VBN", "VBP", "VBZ", "VBG", "PRP")) || in_array($word[0], array("by", "A", "An", "The", "of")))
        {
            //echo "<script>console.log('----------".$word[0]." - ".$word[1]."')</script>";
            if(in_array($word[1], array("VB", "VBP", "VBZ", "VBG")))
            {
                $v1_ = TRUE;            
            }
            if(in_array($word[0], array("is", "am", "are")))
            {
                //echo "<script>console.log('".$word[0]." - ".$word[1]." : tobe')</script>";
                $toBe_ = TRUE;
                if($toBeIdx == -1) $toBeIdx = $i - $prev_fullstop;
            }        
            if($word[1] == "VBN")
            {
                $v3_ = TRUE;                          
                //echo "<script>console.log('".$word[0]." - ".$word[1]." : v3')</script>";
            } 
            if($word[0] == "by")
            {
                $by_ = TRUE;
                //echo "<script>console.log('".$word[0]." - ".$word[1]." : by')</script>";
            }
        }        
        else $otherPos_ = TRUE;
        //echo "<script>console.log('".$word[0]." - ".$word[1]."')</script>";
    }                    
    // echo "<script>console.log('---------".$i."------')</script>";
    $sentence .= ".";        
    
    if($i-$prev_fullstop <=9 && $toBe_ && $v3_ && $by_ && !$otherPos_) $changeToActive[$dot] = TRUE; 
    else if($i-$prev_fullstop <= 5 && $v1_ && !$otherPos_) $changeToPassive[$dot] = TRUE;
    
    if($_SESSION['toPassive']=="checked" && $changeToPassive[$dot]) //do PASSIVE VOICE if user checked
    {        
        $toPass = toPassive($sentence);   

        $toPass = rtrim($toPass, '.');         
        $toPass .= substr($contentPos[$fullstop[$dot]], -1); //chnage from . to , or .

        $sentence = rtrim($sentence, '.');         
        $sentence .= substr($contentPos[$fullstop[$dot]], -1); //chnage from . to , or .
        
        if(strpos($toPass, 'Not found verb') === FALSE)
        {         
            //$changeToPassive[$dot] = TRUE;        

            $_SESSION['content_modified'][$idx] = "<div class='dropdown'>"
            .   "&nbsp;"
            .   "<mark class='mark2passive' id='mark_$idx' style='background-color: #d6f5d6'>"
            .       "<span id='$idx' class='myspan'>"
            .            $toPass
            .       "</span>"
            .   "</mark>"
            .   "<div class='dropdown-content'>"
            .       "<form id='myform_$idx' method='POST'>"
            .            "<center>"
            .                "<label for='select_word' style='color: purple'>Change sentence to</label>"
            .            "</center>"
            .            "<div class='container'>"
            .                             "<select name='word opts' id='opts2passive' size='2' class='word' class='form-control'>"//style='width:100%; border:none; padding:1em;'
            .                                 "<mark class='mark2passive' id='mark_' style='background-color: #d6f5d6'>"
            .                                     "<option  style='border-bottom: 1px solid black; padding-bottom: 3px;' value='"        
            .                                            str_replace("'", "`", $sentence). "'"
            .                                            "data-toggle='tooltip' data-container='#tooltip_container' title='".str_replace("'", "`", $sentence)."'>"
            .                                            "Active voice (Original sentence)"
            .                                     "</option>"
            .                                     "<option value='"
            .                                            $toPass. "'"
            .                                            "data-toggle='tooltip' data-container='#tooltip_container' title='$toPass'>"
            .                                            "Passive voice"
            .                                     "</option>"
            .                             "</select>"
            .                             "<div id='tooltip_container'></div>"
            .               "</div>"
            .           "</form>"
            .   "</div>"
            ."</div>";
            
            
            $_SESSION['content_resource'][$idx] = "<mark class='mark' name='2pas' id='mark_$idx' style='background-color: #d6f5d6'>".$sentence."</mark>";            
            $idx++;
        }
    }
    else if($_SESSION['toActive']=="checked" && $changeToActive[$dot]) //cannot Change sentence to PASSIVE VOICE => do ACTIVE VOICE
    {   
        $toActi = toActive($sentence, $toBeIdx);        

        $toActi = rtrim($toActi, '.');         
        $toActi .= substr($contentPos[$fullstop[$dot]], -1); //chnage from . to , or .

        $sentence = rtrim($sentence, '.');         
        $sentence .= substr($contentPos[$fullstop[$dot]], -1); //chnage from . to , or .
        
        if(strpos($toActi, 'Not found verb') === FALSE)
        {
            //$changeToActive[$dot] = TRUE;

            $_SESSION['content_modified'][$idx] = "<div class='dropdown'>"
            .   "&nbsp;"
            .   "<mark class='mark2active' id='mark_$idx' style='background-color: #ffffcc'>"
            .       "<span id='$idx' class='myspan'>"
            .            $toActi
            .       "</span>"
            .   "</mark>"
            .   "<div class='dropdown-content'>"
            .       "<form id='myform_$idx' method='POST'>"
            .            "<center>"
            .                "<label for='select_word' style='color: purple'>Change sentence to</label>"
            .            "</center>"
            .            "<div class='container'>"
            .                             "<select name='word opts' id='opts2active' size='2' class='word' class='form-control'>"//style='width:100%; border:none; padding:1em;'
            .                                 "<mark class='mark2active' id='mark_' style='background-color: #ffffcc'>"
            .                                     "<option  style='border-bottom: 1px solid black; padding-bottom: 3px;' value='"        
            .                                            str_replace("'", "`", $sentence). "'"
            .                                            "data-toggle='tooltip' data-container='#tooltip_container' title='".str_replace("'", "`", $sentence)."'>"
            .                                            "Passive voice (Original sentence)"
            .                                     "</option>"
            .                                     "<option value='"
            .                                            $toActi. "'"
            .                                            "data-toggle='tooltip' data-container='#tooltip_container' title='$toActi'>"
            .                                            "Active voice"
            .                                     "</option>"
            .                             "</select>"
            .                             "<div id='tooltip_container'></div>"            
            .               "</div>"
            .           "</form>"
            .   "</div>"
            ."</div>";            
            $_SESSION['content_resource'][$idx] = "<mark class='mark' name='2act' id='mark_$idx' style='background-color: #ffffcc'>".$sentence."</mark>";

            $idx++;
        }
    }    
    else // do SYNONYM
    {     
        for ($i = $prev_fullstop; $i <= $fullstop[$dot]; $i++)
        {                   
            $idxOf_ = strrpos($contentPos[$i], "_");
            $p = substr($contentPos[$i], $idxOf_ + 1, 1);
            $wp = explode("_", $contentPos[$i]);    
            if ($p == "J" || $p == "R" || $p == "V") {                                                    
                if ($p == 'J') $p = "a";
                else if ($p == 'R') $p = "r";
                else if ($p == 'V') $p = "v";                
                $_SESSION['content_modified'][$idx] = word(urldecode($wp[0]), $p);
            } else {        
                $_SESSION['content_modified'][$idx] = $wp[0];                
            }          
            $_SESSION['content_resource'][$idx] = $wp[0];
            $_SESSION['content_pos'][$idx] = $wp[1];
            $idx++;
        }        
    }

}

error_reporting(error_reporting() & ~E_NOTICE);
unset($_SESSION['ss_time_of_post']);
$sql_retrieve_content = "SELECT * FROM files_resource where id = "
        . $_SESSION['ss_id_file'] . " and file_name = '" . $_SESSION["ss_filename"] . "'";
$result_set = mysqli_query($link, $sql_retrieve_content) or die("" + mysqli_error($link));
if (!$result_set)
{
    //echo("Error description: " . mysqli_error($link));
    require('./error.php');
}
else
{
    while ($row = mysqli_fetch_array($result_set)) {
        $title = $row['file_name'];
        $title = str_replace("_", " ", $title);
        $upload_by = $row['upload_by'];
        if ($row['upload_by'] == "File") {
            $temp_title = explode(".", $row['file_name']);
            $title = "";
            for ($i = 0; $i < count($temp_title) - 1; $i = $i + 1)
                $title .= $temp_title[$i];
            $title = str_replace("_", " ", $title);
        }
        $file_content = $row['content'];
    }
}
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
        <link rel="stylesheet" href="assets/css/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/animate.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/nexus.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/responsive.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/support.css">
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open Sans:300,400" />
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Source Sans Pro:300,400" />
        <style media="screen">
            .tooltip {
                width: 250px;
            }
        </style>
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
        <style media="screen">
            .dropdown {
                position: relative;
                display: inline-block;
            }

            .dropdown-content {
                display: none;
                position: absolute;
                background-color: #f9f9f9;
                min-width: 250px;
                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                padding: 11px 0px;
                z-index: 1;
            }

            .dropdown:hover .dropdown-content {
                display: block;
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
                    <div class="container">
                        <div class="row margin-vert-30">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <br><center><div class="image-hover">
                                                <a href="#">
                                                    <figure>
                                                        <img src="assets/img/portfolio/before.png" alt="before" width="200">
                                                    </figure>
                                                </a>
                                            </div></center>
                                        <div>
                                            <figure>
                                            <?php
                                                $content1 = "";
                                                $simicolon = 0;
                                                $pre_w = "";
                                                $numOfWord = count($_SESSION['content_modified']);                                                                                            
                                                for ($i = 0; $i < $numOfWord; $i++) 
                                                {
                                                    $word = $_SESSION['content_modified'][$i];
                                                    if(isset($word->lemma))
                                                    {

                                                        $lemma = $word->lemma;                                                                                                                                                                                                                                  
                                                        if( $word->msg == 'success')
                                                        {                                                                                                                  
                                                            $content1 .= "<div class='dropdown'>"
                                                                    . "&nbsp;"
                                                                    . "<mark class='mark' id='mark_$i' style='background-color: #99ddff'>"
                                                                    . "<span>"
                                                                    . $lemma
                                                                    . "</span>"
                                                                    . "</mark>"
                                                                    . "<div>"
                                                                    . "</div>"
                                                                    . "</div>";
                                                        }
                                                        else if($pre_w == "'") $content1 .= $lemma;
                                                        else if($lemma == "''" )                                                        
                                                        {                                                            
                                                            if($simicolon%2==0) $content1 .= $lemma;
                                                            else $content1 .= " ".$lemma;
                                                        }
                                                        else if (preg_match('/[\'^£$%&*()}{@#~?><>,.|=_+¬-]/', $lemma))
                                                        {
                                                            $content1 .= $lemma;
                                                        }
                                                        else
                                                        {
                                                            $content1 .= " ".$lemma;
                                                        }                                                            
                                                        $pre_w = $lemma;
                                                    }
                                                    else
                                                    {       
                                                        $word = $_SESSION['content_resource'][$i];                                                 
                                                        if($word == "''") $simicolon++;
                                                        
                                                        if($pre_w == "'")
                                                        {
                                                            $content1 .= $word;
                                                        }
                                                        else if($word == "''" )                                                        
                                                        {                                                            
                                                            if($simicolon%2==0) $content1 .= $word;
                                                            else $content1 .= " ".$word;
                                                        }
                                                        else if (preg_match('/[\'^£$%&*()}{@#~?><>,.|=_+¬-]/', $word))
                                                        {
                                                            $content1 .= $word;
                                                        }
                                                        else
                                                        {
                                                            $content1 .= " ".$word;
                                                        }                                                            
                                                        $pre_w = $word;
                                                    }
                                                }
                                                
                                                echo "<center><h2 style='color: green'><b>" . $title . "</b></h2></center></br>"
                                                . "<label class='MsoNormal' style=' font-weight: normal !important;
                                                     text-align: justify; text-justify: inter-word; word-wrap: break-word;'>"
                                                //. "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $file_content . "</p>";
                                                . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $content1 . "</label>";
                                                ?>
                                            </figure>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <br>
                                        <center>
                                            <div class="image-hover">
                                                <a href="#">
                                                    <figure>
                                                        <img src="assets/img/portfolio/after.png" alt="after" width="180">
                                                    </figure>
                                                </a>
                                            </div>
                                        </center>
                                        <div>
                                            <figure>
                                                <?php
                                                
                                                $simicolon = 0;
                                                $pre_w = "";
                                                $content2 = "";
                                                
                                                for ($i = 0; $i < $numOfWord; $i++) 
                                                {
                                                    $word = $_SESSION['content_modified'][$i];
                                                    if(isset($word->lemma))
                                                    {
                                                        $lemma = $word->lemma;   
                                                        if($word->msg == 'success')                                                     
                                                        {
                                                            $content2 .= "<div class='dropdown'>"
                                                                    . "&nbsp;"
                                                                    . "<mark class='mark' id='mark_$i' style='background-color: #99ddff'>"
                                                                    . "<span id='$i' class='myspan'>";
                                                            $words = $word->words;      
                                                            //------------------
                                                            $synonyms = $words[0]->word;//use the first definition as default   
                                                            if('A'<=$lemma && $lemma <= 'Z' )
                                                                $content2 .= ucfirst($synonyms[0][0]);//and use the first synonym of the first defintion as default
                                                            else 
                                                                $content2 .= $synonyms[0][0];//and use the first synonym of the first defintion as default
                                                        $content2 .= "</span>"
                                                                . "</mark>"
                                                                . "<div class='dropdown-content'>"
                                                                . "<form id='myform_$i' method='POST'>"
                                                                . "<center>"
                                                                . "<label for='select_word' style='color: purple'>Select new word</label>"
                                                                . "</center>";


                                                        $content2 .= "<div class='container'>"
                                                                . "<ul class='nav nav-tabs'>"
                                                                . "<li class='active'><a data-toggle='tab' href='#r1$i'>"
                                                                . "<span><img src='assets/img/w.png' style='width:20px; hight:20px;' title='WordNet order'></span>"
                                                                . "</a></li>"
                                                                . "<li><a data-toggle='tab' href='#r2$i'>"
                                                                . "<span><img src='assets/img/a.png' style='width:20px; hight:20px;' title='Alphabetical order'></span>"
                                                                . "</a></li>"
                                                                . "<li><a data-toggle='tab' href='#r3$i'>"
                                                                . "<span><img src='assets/img/u.png' style='width:20px; hight:20px;' title='Frequency used order'></span>"
                                                                . "</a></li>"
                                                                . "</ul>"
                                                                . "<div class='tab-content'>";

                                                        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                                                       
                                                        //WordNet order                                   
                                                        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                        $content2 .= "<div id='r1$i' class='tab-pane fade in active'>";
                                                        $content2 .= "<select name='word opts' id='opts' class='word' size='6' "
                                                        . "style='width:100%; border:none; padding:1em;' class='form-control'>";
                                                //show original word
                                                $content2 .= " 
                                                <mark class='mark' id='mark_' style='background-color: #99ddff'>
                                                <option id='logOf$i' style='border-bottom: 1px solid black; padding-bottom: 3px;' value='" 
                                                        . $lemma . "'"
                                                        . "data-toggle='tooltip' data-container='#tooltip_container' "
                                                        . "title='(Original word)'>"
                                                        . $lemma
                                                        . "</option>";
                                                // $words
                                                $myarray = [];
                                                // $n = count($synonyms);
                                                $n = count($words); //number of definition                                                
                                                $synonymAndMeaning1 = array();                                                 
                                                $synonymAndMeaning2 = array();   
                                                
                                                for ($i_def = 0; $i_def < $n; $i_def++) {

                                                    $word = $words[$i_def]->word; //each definition
                                                    
                                                    $definition = "";                                                                
                                                    $definitions = $words[$i_def]->definition;
                                                    foreach($definitions as $def)
                                                    {                                                                                                                                                                                                               
                                                        $definition  .= $def." - ";                                                                                                                                                                                                     
                                                    }                                                                                                                                                              
                                                    $sentence = "";
                                                    $sentences = $words[$i_def]->sentence;                                                                
                                                    if($sentences != null) foreach($sentences as $sent)
                                                    {
                                                        $sentence .= $sent." ";
                                                    }
                                                    
                                                    $definition = str_replace("'", "`", $definition);
                                                    $sentence = str_replace("'", "`", $sentence);
                                                    $toolTipContent = "$definition Example: $sentence";                                                                                                                                

                                                    $m = count($word); //number of syn in same definition

                                                    for($i_w = 0; $i_w<$m ;$i_w++ )
                                                    {   
                                                                  
                                                        // if($m < 0)
                                                        if (strtoupper($word[$i_w][0]) == strtoupper($lemma)) //show only the difference word from lemma
                                                        {
                                                            //                                                                                                                                                
                                                        }
                                                        else
                                                        {                                                                        
                                                            $inarr = in_array($word[$i_w][0], $myarray);
                                                            if ($inarr) {
                                                                continue;
                                                            } else {
                                                                array_push($myarray, $word[$i_w][0]);
                                                            }
                                                            
                                                            if('A'<=$lemma && $lemma <= 'Z' ) $word[$i_w][0] = ucfirst($word[$i_w][0]);                                                                    
                                                            if ($i == 0) {  
                                                                $content2 .= "                                               
                                                                <mark class='mark' id='mark_$i_w' style='background-color: #99ddff'>
                                                                <option value='" . ucfirst($word[$i_w][0]) . "' "
                                                                        . "data-toggle='tooltip' data-container='#tooltip_container' "
                                                                        . "title='".$toolTipContent."'>"
                                                                        . ucfirst($word[$i_w][0])
                                                                        . "</option>";

                                                                $synonymAndMeaning1[ucfirst($word[$i_w][0])] = $toolTipContent;      
                                                                                                                                                                                          
                                                                $sql2 = "SELECT * FROM logs WHERE pos='" . $_SESSION['content_pos'][$i]. "' and before_word = '" . $lemma . "' and after_word = '" . $word[$i_w][0] . "'";
                                                                $query_result2 = $link->query($sql2);
                                                                if ($query_result2->num_rows > 0) { 
                                                                    $c = $query_result2->fetch_assoc();
                                                                    $synonymAndMeaning2[ucfirst($word[$i_w][0])] = $c['count_word']."**". $toolTipContent;
                                                                }                                                                    
                                                                else $synonymAndMeaning2[ucfirst($word[$i_w][0])] ="0**". $toolTipContent;
                                                            } else {
                                                                $content2 .= " 
                                                                <mark class='mark' id='mark_$i_w' style='background-color: #99ddff'>
                                                                <option value='" . $word[$i_w][0] . "' "
                                                                        . "data-toggle='tooltip' data-container='#tooltip_container' "
                                                                        . "title='".$toolTipContent."'>"
                                                                        . $word[$i_w][0]
                                                                        . "</option>";
                                                                $synonymAndMeaning1[$word[$i_w][0]] = $toolTipContent;


                                                                $sql2 = "SELECT * FROM logs WHERE pos='" . $_SESSION['content_pos'][$i]. "' and before_word = '" . $lemma . "' and after_word = '" . $word[$i_w][0] . "'";
                                                                $query_result2 = $link->query($sql2);
                                                                if ($query_result2->num_rows > 0) { 
                                                                    $c = $query_result2->fetch_assoc();
                                                                    $synonymAndMeaning2[$word[$i_w][0]] = $c['count_word']."*". $toolTipContent;
                                                                }                                                                    
                                                                else $synonymAndMeaning2[$word[$i_w][0]] ="0**". $toolTipContent;
                                                            }                                                                        
                                                        }
                                                    }
                                                    
                                                }
                                                // echo "<script>console.log('".json_encode($synonymAndMeaning1)."')</script>";
                                                ksort($synonymAndMeaning1);

                                                        $content2 .= "</select>"
                                                                . "<div id='tooltip_container'></div>"
                                                                . "</div>";
                                                        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                                                       
                                                        //Alphabetical order                                      
                                                        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                        $content2 .= "<div id='r2$i' class='tab-pane fade' style='wight:10px;'>"
                                                                . "<select name='word opts' id='opts' class='word' size='6' "
                                                                . "style='width:100%; border:none; padding:1em;' class='form-control'>";
                                                        //                            $unique_syns = array_unique($syns);
                                                        //                            foreach ($unique_syns as $value) {
                                                        //                               $content2 .= "<option value='" . $value . "'>$value</option>";
                                                        //                            }
                                                //show original word
                                                $content2 .= " 
                                                <mark class='mark' id='mark_' style='background-color: #99ddff'>
                                                <option id='logOf$i' style='border-bottom: 1px solid black; padding-bottom: 3px;'value='" 
                                                        . $lemma . "'"
                                                        . "data-toggle='tooltip' data-container='#tooltip_container' "
                                                        . "title='(Original word)'>"
                                                        . $lemma
                                                        . "</option>";

                                                
                                                foreach($synonymAndMeaning1 as $key => $val )
                                                {
                                                    $content2 .= "                                               
                                                    <mark class='mark' id='mark_$i_w' style='background-color: #99ddff'>
                                                    <option value='" . $key . "' "
                                                            . "data-toggle='tooltip' data-container='#tooltip_container' "
                                                            . "title='".$val."'>"
                                                            . $key
                                                            . "</option>";
                                                }
                                                // $words
                                                //$myarray = [];
                                                // $n = count($synonyms);
                                                //$n = count($words); //number of definition
                                                // for ($i_def = 0; $i_def < $n; $i_def++) {


                                                //     $word = $words[$i_def]->word; //each definition
                                                    
                                                //     $definition = "";                                                                
                                                //     $definitions = $words[$i_def]->definition;
                                                //     foreach($definitions as $def)
                                                //     {                                                                                                                                                                                                               
                                                //         $definition  .= $def." - ";                                                                                                                                                                                                     
                                                //     }                                                                                                                                                              
                                                //     $sentence = "";
                                                //     $sentences = $words[$i_def]->sentence;                                                                
                                                //     if($sentences != null) foreach($sentences as $sent)
                                                //     {
                                                //         $sentence .= $sent." ";
                                                //     }
                                                    
                                                //     $definition = str_replace("'", "`", $definition);
                                                //     $sentence = str_replace("'", "`", $sentence);
                                                //     $toolTipContent = "$definition Example: $sentence";                                                                                                                                

                                                //     $m = count($word); //number of syn in same definition

                                                //     for($i_w = 0; $i_w<$m ;$i_w++ )
                                                //     {   
                                                                  
                                                //         // if($m < 0)
                                                //         if (strtoupper($word[$i_w][0]) == strtoupper($lemma)) //show only the difference word from lemma
                                                //         {
                                                //             //                                                                                                                                                
                                                //         }
                                                //         else
                                                //         {                                                                        
                                                //             $inarr = in_array($word[$i_w][0], $myarray);
                                                //             if ($inarr) {
                                                //                 continue;
                                                //             } else {
                                                //                 array_push($myarray, $word[$i_w][0]);
                                                //             }
                                                            
                                                //             if('A'<=$lemma && $lemma <= 'Z' ) $word[$i_w][0] = ucfirst($word[$i_w][0]);                                                                    
                                                //             if ($i == 0) {  
                                                //                 $content2 .= "                                               
                                                //                 <mark class='mark' id='mark_$i_w' style='background-color: #99ddff'>
                                                //                 <option value='" . ucfirst($word[$i_w][0]) . "' "
                                                //                         . "data-toggle='tooltip' data-container='#tooltip_container' "
                                                //                         . "title='".$toolTipContent."'>"
                                                //                         . ucfirst($word[$i_w][0])
                                                //                         . "</option>";
                                                //             } else {
                                                //                 $content2 .= " 
                                                //                 <mark class='mark' id='mark_$i_w' style='background-color: #99ddff'>
                                                //                 <option value='" . $word[$i_w][0] . "' "
                                                //                         . "data-toggle='tooltip' data-container='#tooltip_container' "
                                                //                         . "title='".$toolTipContent."'>"
                                                //                         . $word[$i_w][0]
                                                //                         . "</option>";
                                                //             }                                                                        
                                                //         }
                                                //     }
                                                    
                                                // }

                                                        $content2 .= "</select>"
                                                                . "<div id='tooltip_container'></div>"
                                                                . "</div>";
                                                        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                                                       
                                                        //Frequency used order                                    
                                                        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                        $content2 .= "<div id='r3$i' class='tab-pane fade'>"
                                                                . "<select name='word opts' id='opts' class='word' size='6' "
                                                                . "style='width:100%; border:none; padding:1em;' class='form-control'>";
                                                        //                            $unique_syns = array_unique($syns);
                                                        //                            foreach ($unique_syns as $value) {
                                                        //                               $content2 .= "<option value='" . $value . "'>$value</option>";
                                                        //                            }
                                                       //show original word
                                                       $content2 .= " 
                                                       <mark class='mark' id='mark_' style='background-color: #99ddff'>
                                                       <option id='logOf$i' style='border-bottom: 1px solid black; padding-bottom: 3px;'value='" 
                                                               . $lemma . "'"
                                                               . "data-toggle='tooltip' data-container='#tooltip_container' "
                                                               . "title='(Original word)'>"
                                                               . $lemma
                                                               . "</option>";

                                                        arsort($synonymAndMeaning2);

                                                        foreach($synonymAndMeaning2 as $key => $val )
                                                        {
                                                            $v = explode("**", $val);
                                                            $content2 .= "                                               
                                                            <mark class='mark' id='mark_$i_w' style='background-color: #99ddff'>
                                                            <option value='" . $key . "' "
                                                                    . "data-toggle='tooltip' data-container='#tooltip_container' "
                                                                    . "title='".$v[1]."'>"
                                                                    . $key
                                                                    . "</option>";
                                                        }

                                                    //    // $words
                                                    //    $myarray = [];
                                                    //    // $n = count($synonyms);
                                                    //    $n = count($words); //number of definition
                                                       
                                                    //    for ($i_def = 0; $i_def < $n; $i_def++) {

                                                    //        $word = $words[$i_def]->word; //each definition
                                                           
                                                    //        $definition = "";                                                                
                                                    //        $definitions = $words[$i_def]->definition;
                                                    //        foreach($definitions as $def)
                                                    //        {                                                                                                                                                                                                               
                                                    //            $definition  .= $def." - ";                                                                                                                                                                                                     
                                                    //        }                                                                                                                                                              
                                                    //        $sentence = "";
                                                    //        $sentences = $words[$i_def]->sentence;                                                                
                                                    //        if($sentences != null) foreach($sentences as $sent)
                                                    //        {
                                                    //            $sentence .= $sent." ";
                                                    //        }
                                                           
                                                    //        $definition = str_replace("'", "`", $definition);
                                                    //        $sentence = str_replace("'", "`", $sentence);
                                                    //        $toolTipContent = "$definition Example: $sentence";                                                                                                                                

                                                    //        $m = count($word); //number of syn in same definition

                                                    //        for($i_w = 0; $i_w<$m ;$i_w++ )
                                                    //        {                                                                            
                                                    //            // if($m < 0)
                                                    //            if (strtoupper($word[$i_w][0]) == strtoupper($lemma)) //show only the difference word from lemma
                                                    //            {
                                                    //                //                                                                                                                                                
                                                    //            }
                                                    //            else
                                                    //            {                                                                        
                                                    //                $inarr = in_array($word[$i_w][0], $myarray);
                                                    //                if ($inarr) {
                                                    //                    continue;
                                                    //                } else {
                                                    //                    array_push($myarray, $word[$i_w][0]);
                                                    //                }                                                                   
                                                    //                if('A'<=$lemma && $lemma <= 'Z' ) $word[$i_w][0] = ucfirst($word[$i_w][0]);                                                                    
                                                    //                if ($i == 0) {  
                                                    //                    $content2 .= "                                               
                                                    //                    <mark class='mark' id='mark_$i_w' style='background-color: #99ddff'>
                                                    //                    <option value='" . ucfirst($word[$i_w][0]) . "' "
                                                    //                            . "data-toggle='tooltip' data-container='#tooltip_container' "
                                                    //                            . "title='".$toolTipContent."'>"
                                                    //                            . ucfirst($word[$i_w][0])
                                                    //                            . "</option>";
                                                    //                } else {
                                                    //                    $content2 .= " 
                                                    //                    <mark class='mark' id='mark_$i_w' style='background-color: #99ddff'>
                                                    //                    <option value='" . $word[$i_w][0] . "' "
                                                    //                            . "data-toggle='tooltip' data-container='#tooltip_container' "
                                                    //                            . "title='".$toolTipContent."'>"
                                                    //                            . $word[$i_w][0]
                                                    //                            . "</option>";
                                                    //                }                                                                        
                                                    //            }
                                                    //        }
                                                           
                                                    //    }

                                                        $content2 .= "</select>"
                                                                . "<div id='tooltip_container'></div>"
                                                                . "</div>";
                                                        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                                                    
                                                        
                                                        if (!isset($_SESSION['log']["logOf$i"])) {
                                                            $_SESSION['log']["logOf$i"] = new stdClass();
                                                        }
                                                        $_SESSION['log']["logOf$i"]->pos = $_SESSION['content_pos'][$i];
                                                        $_SESSION['log']["logOf$i"]->before = $lemma;
                                                        $_SESSION['log']["logOf$i"]->after = $synonyms[0][0];

                                                        
                                                        
                                                        $content2 .= "</div>"
                                                                . "</div>";
                                                        $content2 .= "</form>"
                                                                . "</div>"
                                                                . "</div>";
                                                            }
                                                            else if($pre_w == "'") $content2 .= $lemma;
                                                            else if($lemma == "''" )                                                        
                                                            {                                                            
                                                                if($simicolon%2==0) $content2 .= $lemma;
                                                                else $content2 .= " ".$lemma;
                                                            }
                                                            else if (preg_match('/[\'^£$%&*()}{@#~?><>,.|=_+¬-]/', $lemma))
                                                            {
                                                                $content2 .= $lemma;
                                                            }
                                                            else
                                                            {
                                                                $content2 .= " ".$lemma;
                                                            }                                                            
                                                            $pre_w = $lemma;
                                                           
                                                        }
                                                        else
                                                        {
                                                            if($word == "''") $simicolon++;
                                                            
                                                            if($pre_w == "'")
                                                            {
                                                                $content2 .= $word;
                                                            }
                                                            else if($word == "''" )                                                        
                                                            {                                                            
                                                                if($simicolon%2==0) $content2 .= $word;
                                                                else $content2 .= " ".$word;
                                                            }
                                                            else if (preg_match('/[\'^£$%&*()}{@#~?><>,.|=_+¬-]/', $word))
                                                            {
                                                                $content2 .= $word;
                                                            }
                                                            else
                                                            {
                                                                $content2 .= " ".$word;
                                                            }                                                            
                                                            $pre_w = $word;
                                                        }
                                                    }
                                                echo "<center><h2 style='color: green'><b>" . $title . "</b></h2></center></br>"
                                                . "<label class='MsoNormal' style=' font-weight: normal !important;"
                                                . "text-align: justify; text-justify: inter-word; word-wrap: break-word;'>"
                                                //. "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $file_content . "</p>";
                                                . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $content2 . "</label>";
                                                ?>
                                            </figure>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>


                    </div>
<!--                    <style>
                        .circle {
                            display: block;
                            width: 150px;
                            height: 150px;
                            background-size: cover;
                            background-repeat: no-repeat;
                            background-position: center center;
                            -webkit-border-radius: 99em;
                            -moz-border-radius: 99em;
                            border-radius: 99em;
                            border: 5px solid #eee;
                            box-shadow: 0 3px 2px rgba(0, 0, 0, 0.3);  
                        }
                        p.thought {
                            position:relative; 
                            width:200px; 
                            padding:2px 15px;
                            margin:-30px 10px 80px 140px;
                            background:#f7a944;
                            background:-webkit-gradient(linear, 0 0, 0 100%, from(#fac868), to(#f3961c));
                            background:-moz-linear-gradient(#fac868, #f3961c);
                            background:-o-linear-gradient(#fac868, #f3961c);
                            background:linear-gradient(#fac868, #f3961c);
                            -webkit-border-radius:180px;
                            -moz-border-radius:180px;
                            border-radius:180px;
                            -webkit-box-shadow: -3px 4px 8px #989898;
                            -moz-box-shadow: -3px 4px 8px #989898;
                            box-shadow: -3px 4px 8px #989898;
                            color:#575544;
                            font-size:1em;
                            letter-spacing:.06em;
                        }
                        p.thought:before {
                            content:"";
                            position:absolute; 
                            bottom:-40px; 
                            left:20px; 
                            background:#f3961c;
                            width:30px; 
                            height:30px;
                            -webkit-border-radius:30px;
                            -moz-border-radius:30px;
                            border-radius:30px;
                            -webkit-box-shadow: -3px 3px 4px #989898;
                            -moz-box-shadow: -3px 3px 4px #989898;
                            box-shadow: -3px 3px 8px #989898;
                        }
                        p.thought:after {
                            content:"";
                            position:absolute;
                            bottom:-55px;
                            left:0;
                            width:15px;
                            height:15px;
                            background:#f3961c;
                            -webkit-border-radius:15px;
                            -moz-border-radius:15px;
                            border-radius:15px;
                            -webkit-box-shadow: -3px 3px 4px #989898;
                            -moz-box-shadow: -3px 3px 4px #989898;
                            box-shadow: -3px 3px 8px #989898;
                        }

                    </style>
                    <div class="container">
                        <div class="row margin-vert-30">
                            <div class="col-md-12">
                                <div class="row">
                                    <center>
                                        <div class="col-md-4">
                                            <div class="circle" style="background-image: 
                                                 url('assets/img/a.png')">
                                                <p class="thought">Alphabetical order</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="circle" style="background-image: 
                                                 url('assets/img/u.png')">
                                                 <p class="thought">Frequency used order</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="circle" style="background-image: 
                                                 url('assets/img/w.png')">
                                                <p class="thought">WordNet order</p>
                                            </div>
                                        </div>
                                    </center>  
                                </div>
                            </div>
                        </div>
                    </div>-->
                    <div class="container">
                        <div class="row">
                            <hr class="margin-vert-40">
                            <div class="container">
                                <div class="row margin-vert-30">
                                    <div class="col-md-12">
                                        <h1>
                                            <img src="assets/img/export.png" alt="export" style="display: block; margin: 0 auto;"><br>
                                        </h1>
                                        <div class="col-md-6">
                                            <h2 class="margin-vert-20"><b>Meaning of highlight colours :</b></h2>
                                            <h2 style="font-size: 24px;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="label label-default">1</span> <span class="label label-info">Word synonyms</span></h2>
                                            <h2 style="font-size: 24px;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="label label-default">2</span> <span class="label label-success">Passive voice</span></h2>
                                            <h2 style="font-size: 24px;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="label label-default">3</span> <span class="label label-warning">Active voice</span></h2>
                                            <br>
                                            <div class="col-md-12"><center>
                                                <p style="color: red; font-size: 16px;" id="note">
                                                    &nbsp;&nbsp;<b>NOTE:</b>&nbsp;  
                                                    You can change the result by moving your mouse on the highlight word or sentence in the <b>AFTER</b> side.
                                                </p></center>
                                            </div><br><br><br><br>
                                        </div>
                                        <br><div class="col-md-6">
                                            <form id="form_1" action="export.php" method="POST">
                                                <div class="row">
                                                    <center>
                                                        <div class="col-md-12">
                                                            <p class="round2">
                                                                <br>&nbsp;&nbsp;&nbsp;&nbsp;<label class="radio-inline" style="font-size: 30px;">
                                                                    <input type="radio" value="txt" name="option[]" id="option">
                                                                    <img src="assets/img/txts.png" alt="txt" width="50" height="50">&nbsp;&nbsp;
                                                                </label>
                                                                <label class="radio-inline" style="font-size: 30px;">
                                                                    <input type="radio" value="pdf" name="option[]" id="option">
                                                                    <img src="assets/img/pdfs.png" alt="pdf" width="50" height="50">&nbsp;&nbsp;
                                                                </label>
                                                                <label class="radio-inline" style="font-size: 30px;">
                                                                    <input type="radio" value="doc" name="option[]" id="option">
                                                                    <img src="assets/img/docs.png" alt="doc" width="50" height="50">&nbsp;&nbsp;
                                                                </label><br><br>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div id="carousel-example-1" class="carousel slide" data-ride="carousel">
                                                                <div class="carousel-inner" id="divCaptcha" hidden>
                                                                    <div class="g-recaptcha" id="captcha" data-sitekey="6LdMBxYUAAAAAGSpWxs1G-swk4qo_5mWVfTpESOE" data-callback="callback"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </center></div>
                                                <br>
                                                <center>
                                                    <input type="submit" name="submit_1" class="btn btn-lg btn-primary" value="Submit" id="downloadLink" disabled>
                                                </center>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
                                        <font style="color:white;">Copyright &copy; 2017 </font><b>Alternative Word Suggestion System for English Writings Project. 
                                            Version 1.0.3</b>
                                        <br><font style="color:white;">Developed by </font><b> Suphachok Noopan, Jirayu Chinnawong, 
                                            Borey Sok.</b>
                                        <font style="color:white;">Inspired by </font><b> Dr. Nattapong Tongtep.
                                        </b>
                                        <br><a ehref="http://www.phuket.psu.ac.th/index1.php" target="_blank">
                                            College of Computing, 
                                            Prince of Songkla University, Phuket Campus.</a>
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
<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/scripts.js"></script>
<script type="text/javascript" src="assets/js/jquery.isotope.js"></script>
<script type="text/javascript" src="assets/js/jquery.slicknav.js"></script>
<script type="text/javascript" src="assets/js/jquery.visible.js" charset="utf-8"></script>
<script type="text/javascript" src="assets/js/modernizr.custom.js"></script>
<script type='text/javascript'>
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
            window.location = "https://docs.google.com/forms/d/1lHiGRgmimU2ss2qawR1yY3TLOzr9z0Sgk4xaIEDivTg";
        });
    });
    function callback() {
        if (checkSelectOption1 == "yes") {
            $("#downloadLink").removeAttr('disabled');
        }
    }

    //        var myid = '';
    //        $('.myspan').hover(function () {
    //            myid = $(this).attr('id');
    //        });
    //        $('.word').change(function () {
    //            myval = $(this).val();
    //            $("#" + myid).text(myval);
    //            $.ajax({
    //                method: "POST",
    //                url: "log.php",
    //                data: {
    //                    word: myval
    //                },
    //            }).done(function (msg) {
    //                //console.log(msg);
    //                //alert("Data Saved: " + msg);
    //            });
    //        });
    $(document).ready(function () {
        $('.word').change(function () {
            var id = $(this).find('option').attr('id');
            var after = $(this).val();
            $(this).parents('.dropdown').find('.myspan').text(after);
            var before = $(this).find("option:first-child").val();
            console.log("id: " + id + " before: " + before + " after: " + after);
            $.ajax({
                method: "POST",
                url: "log.php",
                data: {
                    id: id,
                    before: before,
                    after: after
                },
            });
        });
    });
</script>
<script>
    //            $(document).ready(function () {
    //                $('[data-toggle="tooltip"]').tooltip();
    //            });
</script>
</body>
</html> 