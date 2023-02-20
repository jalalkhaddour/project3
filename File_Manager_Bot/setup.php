<?php
include 'funs.php';
mkdir("directories");
mkdir("Places");
mkdir("States");
mkdir("FileStates");
mkdir("messages");
echo"Done folders <br><br><br>";
$rr=$_SERVER['SCRIPT_NAME'];
$pth=str_replace("setup.php","",$rr);
$urr='https://'.$_SERVER['HTTP_HOST'].$pth.'index.php';
$webhook=file_get_contents("https://api.telegram.org/bot".TOKEN."/setWebhook?url=$urr");
echo"webhook :
".$webhook;

?>