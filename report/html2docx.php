<?php

session_start();

include('vsword/VsWord.php');
include('../config.php');

$sql_retrieve_content = "SELECT * FROM files_resource where id = 43";
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
    $new_file_name = $row['file_name'];
}

VsWord::autoLoad();

$doc = new VsWord();
$parser = new HtmlParser($doc);

$parser->parse("<h4>" . $new_file_name . "</h4>");
$parser->parse($file_content);


$doc->saveAs($new_file_name . ".docx");
?>