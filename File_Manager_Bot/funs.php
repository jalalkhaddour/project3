<?php

$API_KEY = 'MY_BOT_TOKEN';
define('TOKEN', $API_KEY);
#=============================
function bot($method, $datas = [])
{
    if (function_exists('curl_init')) {
        $url = "https://api.telegram.org/bot" . TOKEN . "/" . $method;
        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
        $res = curl_exec($ch);
        if (curl_error($ch)) {
            var_dump(curl_error($ch));
        } else {
            return json_decode($res);
        } # END OF ISSET CURL 
    } else {
        $iBadlz = http_build_query($datas);
        $url    = "https://api.telegram.org/bot" . TOKEN . "/" . $method . "?$iBadlz";
        $iBadlz = file_get_contents($url);
        return json_decode($iBadlz);
    } # END OF !CURL EXISTS 
}
#-------------------------------
function SendTypingAction($chId)
{
    bot('sendChatAction',['chat_id' => $chId,'action' => "typing"]);
}
function getsrldirenum($direuctCode)
{
    $srl1 = file_get_contents("directories/$direuctCode/srl_$direuctCode.txt");
    $srl = (int)$srl1;
    return $srl;
}
function getthisfoldernm($thisplc)
{  
    $rrr=explode('/',$thisplc);
    $lst=count($rrr)-1;
    $srl=$rrr[$lst];
    return $srl;
}
function GOBACK($thisplc)
{  
    $rrr=getthisfoldernm($thisplc);
    $newplc=str_replace("/".$rrr,"",$thisplc);
    return $newplc;
}
function getuserpth($from_id)
{
    $thisplc=getPlace($from_id);
    $userpth=str_replace($from_id.'/',"",$thisplc); 
    return $userpth;
}
function getdires($direuctCode)
{   
    $things=scandir("directories/$direuctCode");
    $srls=[];
    foreach ($things as $thing) {
        if (is_dir("directories/$direuctCode"."/"."$thing")) {
            if ($thing !='.' and $thing !='..') {
            $srls []=$thing;}
        }
    }
return $srls;
}
function getfiles($direuctCode){
    $things=scandir("directories/$direuctCode");
    $files=[];
    foreach ($things as $thing) {
        if (!is_dir("directories/$direuctCode"."/"."$thing")) {
            $newthing=str_replace(".",'|',$thing);
            $files []=$newthing;
        }
    }
return $files;
}
function deldire($direuctCode,$diresrl)
{
    file_put_contents("directories/$direuctCode/$direuctCode"."_".$diresrl.".txt","N");
    rmdir("directories/$direuctCode");
    
}
function delfile($direuctCode,$file_nm)
{
    unlink("directories/$direuctCode/$file_nm");
}
function toadddire($direuctCode)
{
    $srl = getsrldirenum($direuctCode);
    $newsrl = $srl + 1;
    file_put_contents("directories/$direuctCode/srl_$direuctCode.txt", $newsrl);
    file_put_contents("directories/$direuctCode/$direuctCode"."_".$newsrl.".txt", "Y");
    mkdir("directories/$direuctCode");
    mkdir("directories/$direuctCode/$newsrl");
    return $newsrl;
}
function do_keyboard($rr,$ty){
    if ($ty==1) {
        $tyy="المجلد";
        $en="DIRE";
    }else {
        $tyy="الملف"; 
        $en="File";       
    }
    $keyss=[];

    for ($i=0 ; $i< count($rr) ; $i++) {
        $def=count($rr)-$i;
        if (count($rr)==0) {
            $line=[['text' => " $tyy فارغ🔰 ", 'callback_data' => 'GET_'.$en.'_0_']];
            
        }elseif ($def>=2) {
                $line=[['text' => " $tyy : ".$rr[$i]." 🔰 ", 'callback_data' => 'GET_'.$en.'_0_'.$rr[$i]],['text' => " $tyy : ".$rr[$i+1]." 🔰 ", 'callback_data' => 'GET_'.$en.'_0_'.$rr[$i+1]]];
                $i+=1;
            }
            else{
                $line=[['text' => " $tyy : ".$rr[$i]." 🔰 ", 'callback_data' => 'GET_'.$en.'_0_'.$rr[$i]]];
    }
    $keyss[]=$line;

    }
    $inlineKeyboard=['inline_keyboard' => $keyss];
    return $inlineKeyboard;
    }
    function saveFileFromId($file_id,$sv_pth,$docunam)
    {   $url = "https://api.telegram.org/bot".TOKEN."/getFile?file_id=$file_id";
        $file_info1=file_get_contents($url);
        sleep(1);
        $file_info=json_decode($file_info1);
        $res=$file_info->result;
        $file_pth=$res->file_path;
        $file=file_get_contents("https://api.telegram.org/file/bot".TOKEN."/".$file_pth);
        sleep(1);
        $svp="directories/$sv_pth/$docunam";
        file_put_contents($svp,$file);

    }
    function getFileLink($file_nm, $place)
    {
        $rr=$_SERVER['SCRIPT_NAME'];
        $pth=str_replace("funs.php","",$rr);
        $url='https://'.$_SERVER['HTTP_HOST'].$pth.'directories/'.$place.'/'.$file_nm;
        return $url;
    }
    function setState($st, $idd)
    {
        file_put_contents("States/$idd.txt", $st);
    }
    function getState($idd)
    {
        $st = file_get_contents("States/$idd.txt");
        return $st;
    }
    function setFileState($st, $idd)
    {
        file_put_contents("FileStates/$idd.txt", $st);
    }
    function getFileState($idd)
    {
        $st = file_get_contents("FileStates/$idd.txt");
        return $st;
    }
    function setPlace($pl, $idd)
    {
        file_put_contents("Places/$idd.txt", $pl);
    }
    function getPlace($idd)
    {
        $pl = file_get_contents("Places/$idd.txt");
        return $pl;
    }
    function setmessages($st, $idd)
    {
        file_put_contents("messages/$idd.txt", $st);
    }
    function getmessages($idd)
    {
        $st = file_get_contents("messages/$idd.txt");
        return $st;
    }
?>