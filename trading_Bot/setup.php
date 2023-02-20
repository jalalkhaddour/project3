<?php
include 'funs.php';

mkdir('Prices');
mkdir('states');
mkdir('messages');
mkdir('chargestate');
mkdir('Products');
mkdir('balances');
mkdir('Products/SSN1');
mkdir('Products/SSN2');
mkdir('Products/INFO1');
mkdir('Products/INFO2');
mkdir('Products/INFO3');
echo "done creating folders <br><br><br>";
$rr=$_SERVER['SCRIPT_NAME'];
$pth=str_replace("setup.php","",$rr);
$urr='https://'.$_SERVER['HTTP_HOST'].$pth.'index.php';
$webhook=file_get_contents("https://api.telegram.org/bot".TOKEN."/setWebhook?url=$urr");
echo"webhook :
".$webhook;

?>