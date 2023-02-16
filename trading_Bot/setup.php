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
echo "done creating folders
";
$urr='https://'.$_SERVER['SERVER_NAME'].'/index.php';
$webhook=file_get_contents("https://api.telegram.org/bot".TOKEN."/setWebhook?url=$urr");
echo"webhook :
".$webhook;

?>