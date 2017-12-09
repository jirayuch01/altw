<?php

error_reporting(error_reporting() & ~E_NOTICE);
//BR
session_start();
if (!isset($_SESSION['log'][$_POST['id']])) {
    $_SESSION['log'][$_POST['id']] = new stdClass();
}
$_SESSION['log'][$_POST['id']]->pos = $_SESSION['content_pos'][substr($_POST['id'], 5)];
$_SESSION['log'][$_POST['id']]->before = $_POST['before'];
$_SESSION['log'][$_POST['id']]->after = $_POST['after'];
?>