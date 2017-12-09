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
    </head>
    <body>
        <br> &nbsp; &nbsp;<a href="create.php" type='button' class='btn btn-lg btn-primary'>Result</a><br>
    </body>
</html>

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
for ($char = 33; $char <= 63; $char++) {
    if ($char <= 47 || 58 <= $char) {
        $content = str_replace(chr($char), " " . chr($char) . " ", $content);
    }
}

echo "<br><mark>0 * content</mark><br>";
echo "&nbsp;&nbsp;" . $content;
// echo "<br><br><mark>1 * input space before and after special character</mark><br>";
// echo "&nbsp;&nbsp;" . $content;
// echo "<br>";

$content = preg_replace('/\s+/', ' ', $content);
// echo "<br><mark>2 * delete​ the excess space</mark><br>";
// echo "&nbsp;&nbsp;" . $content;
// echo "<br>";
$contents = explode(' ', $content);
$_SESSION['content_resource'] = $contents;
$_SESSION['content_modified'] = array(array());

echo "<br><mark>Part Of Speech of each word</mark><br>";
require './POS/file/vendor/autoload.php';
use StanfordTagger\POSTagger;
$pos = new POSTagger();
$contentPos = $pos->tag($content);
$contentPos = explode(" ", $contentPos);

$_SESSION['numOfW'] =  count($contentPos);

// echo "<br><br><mark>3 * splite each word and charater : " . $_SESSION['numOfW'] . "</mark><br>";
// for ($i = 0; $i < $_SESSION['numOfW']; $i++)
// {
//     echo $contentPos[$i]."<br>";
// }

//find out the synonym
for($i=0;$i<$_SESSION['numOfW'];$i++)
{
    $idxOf_ = strrpos($contentPos[$i], "_");    
    $p = substr($contentPos[$i], $idxOf_+1, 1);
    $wp = explode("_", $contentPos[$i]);    
    if($p == "J" || $p == "R" || $p == "V")
    {        
        $_SESSION['content_modified'][$i] = synonym($wp[0], $p);
    }
    else
    {
        $_SESSION['content_modified'][$i][] = $wp[0];
    }
}

// $uniqueWs = array();
// for ($i = 0; $i < count($contents); $i++) 
// {
//     if (!in_array($contents[$i], $uniqueWs))
//     {
//         $uniqueWs[] = $contents[$i];
//     }
// }
// echo "<br><mark>4 * Unique word : " . count($constand_word) . "</mark><br>";
// for ($i = 0; $i < count($constand_word); $i++) {
//     echo "&nbsp;&nbsp;" . $constand_word[$i] . "<br>";
// }
// $numOfWs = array(array());
// $freqOfWs = array();
// for ($i = 0; $i < count($uniqueWs); $i++) {
//     $idxOfDup = 0;
//     $freqOfWs[$uniqueWs[$i]] = 0;
//     for ($idxOfDup = 0; $idxOfDup < count($word); $idxOfDup++) {
//         if ($constand_word[$i] == $word[$idx_that_duplicate]) {
//             $number_of_word[$constand_word[$i]][$idx_of_duplicate] = $idx_that_duplicate;
//             $word_freq[$constand_word[$i]] ++;
//             $idx_of_duplicate++;
//         }
//     }
// }
// asort($freqOfWs);
// echo "<br><br><mark>5 * word within its index frequency : " . count($word_freq) . "</mark>";
// echo "<table>";
// foreach ($word_freq as $x => $x_value) {
//     echo "<tr bgcolor=' #ebebe0'>";
//     echo "<td>" . "&nbsp;&nbsp;" . $x . "</td><td>[" . $x_value . "]</td>";
//     for ($num = 0; $num < $x_value; $num++) {
//         echo "<td>&nbsp;&nbsp;" . $number_of_word[$x][$num] . "</td>";
//     }
//     echo "<tr>";
// }
// echo "</table>";
// $w_not_symbol = 0;
// $number_of_word_without_symbol = 0;
// foreach ($word_freq as $x => $x_value) {
//     if (('A' <= $x && $x <= 'Z') || ('a' <= $x && $x <= 'z')) {
//         $w_not_symbol += $x_value;
//         $number_of_word_without_symbol++;
//     }
// }
// echo "<br><br><mark>6 * word without symbol : " . $number_of_word_without_symbol . "</mark>";
// echo "<table>";
// echo "<tr bgcolor='blue'>
//     <td>Word&nbsp;&nbsp;</td>
//     <td>POS&nbsp;&nbsp;</td>
//     <td>Freq&nbsp;&nbsp;</td>    
//     <td>Percent</td>    
// </tr>";
// foreach ($word_freq as $x => $x_value) {

//     echo "<tr bgcolor=' #ebebe0'>";    
//     if (('A' <= $x && $x <= 'Z') || ('a' <= $x && $x <= 'z')) {
        
//         // **************************
//         $x_pos = explode('_', $x);
//         echo "<td>" . "&nbsp;&nbsp;" . $x_pos[0] . "</td><td bgcolor='white'>". $x_pos[1] ."</td><td>[" . $x_value . "]</td>";
//         // **************************

//         // echo "<td>" . "&nbsp;&nbsp;" . $x . "</td><td>[" . $x_value . "]</td>";
//         echo "<td><font style='color:red'>&nbsp;&nbsp;" . number_format(($x_value / $w_not_symbol * 100), 2, '.', '') . "%&nbsp;&nbsp;</font></td>";
//         for ($num = 0; $num < $x_value; $num++) {
//             echo "<td>" . $number_of_word[$x][$num] . "</td>";
//         }
//         echo "<tr>";
//     }
// }
// echo "</table><br>";


// // ***********************************
// echo "<br><br><mark>7 * The word maybe change (verb(V), adv(R), and adj(J))</mark>";
// echo "<table>";
// echo "<tr bgcolor='blue'>
//     <td>Word&nbsp;&nbsp;</td>
//     <td>POS&nbsp;&nbsp;</td>
//     <td>Freq&nbsp;&nbsp;</td>    
//     <td>Percent</td>    
// </tr>";
// foreach ($word_freq as $x => $x_value) {

//     echo "<tr bgcolor=' #ebebe0'>";    
//     if (('A' <= $x && $x <= 'Z') || ('a' <= $x && $x <= 'z')) {            
//         $x_pos = explode('_', $x);
//         if($x_pos[1][0] == 'J' || $x_pos[1][0] == 'R' || $x_pos[1][0] == 'V')
//         {
//             echo "<td>" . "&nbsp;&nbsp;" . $x_pos[0] . "</td><td bgcolor='white'>". $x_pos[1] ."</td><td>[" . $x_value . "]</td>";                
//             echo "<td><font style='color:red'>&nbsp;&nbsp;" . number_format(($x_value / $w_not_symbol * 100), 2, '.', '') . "%&nbsp;&nbsp;</font></td>";
//             for ($num = 0; $num < $x_value; $num++) {
//                 echo "<td>" . $number_of_word[$x][$num] . "</td>";
//             }
//             echo "<tr>";
//         }
//     }
// }
// echo "</table><br>";

// echo "<br><br><mark>8 * The word maybe change (verb(V), adv(R), and adj(J)) with synonym</mark>";
// echo "<table border='1'>";
// echo "<tr bgcolor='blue'>
//     <td>Word&nbsp;&nbsp;</td>
//     <td>POS&nbsp;&nbsp;</td>
//     <td>Freq&nbsp;&nbsp;</td>    
//     <td>Percent</td>    
//     <td>Syn</td>    
// </tr>";
// $col = 0;
// $color = array("", "#d9d9d9");
// foreach ($word_freq as $x => $x_value) {    
    
//     if (('A' <= $x && $x <= 'Z') || ('a' <= $x && $x <= 'z')) {            
        
//         $x_pos = explode('_', $x);
//         if($x_pos[1][0] == 'J' || $x_pos[1][0] == 'R' || $x_pos[1][0] == 'V')
//         {
//             $col = ($col + 1) % 2;
//             echo "<tr bgcolor='".$color[$col]."'>";    
//             echo "<td>" . "&nbsp;&nbsp;" . $x_pos[0] . "</td><td>". $x_pos[1] ."</td><td>[" . $x_value . "]</td>";                
//             echo "<td><font style='color:red'>&nbsp;&nbsp;" . number_format(($x_value / $w_not_symbol * 100), 2, '.', '') . "%&nbsp;&nbsp;</font></td>";

//             //*******************************************
//             $syn0 = array();
//             $syn0 = synonym($x_pos[0], $x_pos[1][0]);
//             $s = "<strong>".$syn0[0]."</strong><br>";
//             for($i=1; $i<count($syn0); $i=$i+1) { $s .= $syn0[$i]."<br>"; }
//             echo "<td>".($s)."</td>";
        
//             //*******************************************
//             for ($num = 0; $num < $x_value; $num++) {
//                 echo "<td>" . $number_of_word[$x][$num] . "</td>";
//             }                    
            
//             echo "<td>";
//             echo "</td>";    
//             echo "<tr>";
//         }
        
//     }
    
// }
// echo "</table boarder='1'><br>";
// ****************************


// header("Content-Type: application/json");
function synonym($word_, $pos_)
{

    if($pos_ == 'J') $pos_ = "a";
    else if($pos_ == 'R') $pos_ = "r";
    else if($pos_ == 'V') $pos_ = "v";
    
    $word = urldecode($word_);
    $results = word($word);    
    $json = json_decode($results);
    $msg = $json->msg;

    $synonymArr = array();    
    $synonymArr[] = $word_;    

    if($msg == "not found")
    {        
        $synonymArr[] = "not_found";
    }
    else
    {
        $lemma = $json->lemma;
        str_replace('_', " ", $lemma);              
        $words = $json->words;        
        $max_syn = -1;    
                    
        foreach($words as $word)
        {

            $type = $word->type;                    
            if($type == $pos_)
            {                        
                $wordList = $word->word;
                if($max_syn < count($wordList))
                {                
                    $max_syn = count($wordList);                  

                    foreach($wordList as $w)
                    {                        
                        $synonymArr[] = str_replace("_", " ", $w[0]);                      
                    }              

                }
            }                       
        }   
    }        
    return $synonymArr;    
}

?>
