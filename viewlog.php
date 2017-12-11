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
        <form name="frmMain" action="#" method="POST">
            <?php
            include_once 'config.php';
            $sql = "SELECT * FROM logs ORDER BY count_word DESC";
            $result = mysqli_query($link, $sql) or die(mysql_error());
            ?>
            <br><table width="600" border="1" align="center">
                <tr>
                    <td colspan="4" bgcolor="#FFFFFF">
                        <strong><div align="center"><h3>Data in mysql</h3></strong></div> 
                    </td>
                </tr>
                <tr>
                    <th><div align="center">Word</div></th>
                    <th><div align="center">Count</div></th>
                    <th>
                        <div align="center">
                            Delete &nbsp;&nbsp;
                            <input name="CheckAll" type="checkbox" id="CheckAll" value="Y" onClick="ClickCheckAll(this);">
                        </div>
                    </th>
                </tr>
                <?php
                $i = 0;
                while ($objResult = mysqli_fetch_array($result)) {
                    $i++;
                    ?>
                    <tr>
                        <td><div align="center"><?php echo $objResult["select_word"]; ?></div></td>
                        <td><div align="center"><?php echo $objResult["count_word"]; ?></div></td>
                        <td align="center">
                            <input type="checkbox" name="chkDel[]" id="chkDel<?php echo $i; ?>" 
                                   value="<?php echo $objResult["id"]; ?>">
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <br><br><center><input type="submit" name="btnDelete" value="Delete"></center>
            <input type="hidden" name="hdnCount" value="<?php echo $i; ?>">
            <?php
            if (isset($_POST['btnDelete'])) {
                ?>
                <script type="text/javascript">
                    window.location = "viewlog.php";
                </script>
            <?php } ?>
        </form>
        <?php
        error_reporting(error_reporting() & ~E_NOTICE);
        include_once 'config.php';
        for ($i = 0; $i < count($_POST["chkDel"]); $i++) {
            if ($_POST["chkDel"][$i] != "") {
                $sql = "DELETE FROM log ";
                $sql .= "WHERE id = '" . $_POST["chkDel"][$i] . "' ";
                $result = mysqli_query($link, $sql) or die(mysql_error());
            }
        }
        ?> 
        <script language="JavaScript">
            function ClickCheckAll(vol) {
                var i = 1;
                for (i = 1; i <= document.frmMain.hdnCount.value; i++) {
                    if (vol.checked == true) {
                        eval("document.frmMain.chkDel" + i + ".checked=true");
                    } else {
                        eval("document.frmMain.chkDel" + i + ".checked=false");
                    }
                }
            }
        </script>        
    </body>
</html>