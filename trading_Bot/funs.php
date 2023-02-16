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
function getBaLaNCE($idd)
{
    $BaLaNCE1 = file_get_contents("balances/$idd.txt");
    $BaLaNCE = (int)$BaLaNCE1;
    return $BaLaNCE;
}
function setBaLaNCE($BaL, $idd)
{
    file_put_contents("balances/$idd.txt", $BaL);
}
function setState($st, $idd)
{
    file_put_contents("states/$idd.txt", $st);
}
function getState($idd)
{
    $st = file_get_contents("states/$idd.txt");
    return $st;
}
function setnewchargestate($chrgst, $idd)
{
    $st=file_get_contents("chargestate/$idd.txt");
    $newst=(int)$st+1;
    
    file_put_contents("chargestate/$idd.txt",$newst);
    if (!is_dir("chargestate/$idd")) {
        mkdir("chargestate/$idd");
        mkdir("chargestate/$idd/GFT");
    }
    file_put_contents("chargestate/$idd/$newst.txt", $chrgst);
    return $newst;
}
function setchargestate($chrgst, $idd,$st)
{
    file_put_contents("chargestate/$idd/$st.txt", $chrgst);
}
function getchargestate($usrid,$nm)
{
    $chrgst = file_get_contents("chargestate/$usrid/$nm.txt");
    return $chrgst;
}
function getchargestatecount($usrid){
    $st=file_get_contents("chargestate/$usrid.txt");
    $newst=(int)$st;
    return $newst;
}
function setPrice($prod, $newprice)
{
    file_put_contents("Prices/$prod.txt", $newprice);
}
function getPrice($prod)
{
    $s1t = file_get_contents("Prices/$prod.txt");
    $st = (int)$s1t;
    return $st;
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
function getvalidProdnum($productCode)
{

    $countVVProd = file_get_contents("Products/V$productCode.txt");
    $countProd = (int)$countVVProd;
    return $countProd;
}
function getsrlProdnum($productCode)
{
    $srl1 = file_get_contents("Products/srl$productCode.txt");
    $srl = (int)$srl1;
    return $srl;
}
function get_v_srl($productCode)
{
    $v = getvalidProdnum($productCode);
    $srl = getsrlProdnum($productCode);
    if ($v != 0 and $srl != 0) {
        $ss = $srl - $v + 1;
        return $ss;
    }else {
        return 0;
    }
}
function Isproductvalid($productCode)
{
    $ss = get_v_srl($productCode);
    if ($ss > 0) {
        return true;
    }
    return false;
}
function toaddProd($productCode, $prod)
{
    $countProd = getvalidProdnum($productCode);
    $newcountProd = $countProd + 1;
    file_put_contents("Products/V$productCode.txt", $newcountProd);
    $srl = getsrlProdnum($productCode);
    $newsrl = $srl + 1;
    file_put_contents("Products/srl$productCode.txt", $newsrl);
    file_put_contents("Products/$productCode/$newsrl.txt", $prod);
    return $newsrl;
}

function togetProd($productCode)
{
    $ss = get_v_srl($productCode);
    $prod = file_get_contents("Products/$productCode/$ss.txt");
    return $prod;
}
function useProduct($productCode)
{
    $v = getvalidProdnum($productCode);
    $ss = get_v_srl($productCode);
    $vv = $v - 1;
    file_put_contents("Products/V$productCode.txt", $vv);
    $prod=file_get_contents("Products/$productCode/$ss.txt");
    unlink("Products/$productCode/$ss.txt");
return $prod;
}
function get_mx_pg($productCode){
    $v=getvalidProdnum($productCode);
    $bl=$v/3;
    $mx=ceil($bl);
    return $mx;
}
function toget_all_prod($productCode,$pg)
{
    $v = getvalidProdnum($productCode);
    $srl = getsrlProdnum($productCode);
    $nmp=get_Name_prod($productCode);
    $prods = $nmp + " :
    
    ";
    $ss = $srl - $v + 1;
if ($pg==1) {
    $ss = $ss;
}else{
    $ss=$ss+(3*$pg);
}
    for ($i = $ss; $i <= $srl; $i++) {
        $prod = file_get_contents("Products/$productCode/$i.txt");
        $prods = $prods + "
        serial: `$i`
        " + $prod + "
        ____________";
    }
    return $prods;
}

function to_get_specific_prod($productCode, $srl)
{
    $prod = file_get_contents("Products/$productCode/$srl.txt");
    return $prod;
}

function get_prods_srls_edite($productCode)
{

    $ss = get_v_srl($productCode);
    $srl = getsrlProdnum($productCode);
    if ($ss > 0) {
        $srlsprods = "";
        for ($i = $ss; $i <= $srl; $i++) {
            $callback_da = 'ED0'.$productCode.'0'.$i;
            $srlsprods = $srlsprods.'[{"text":"'.urlencode($i).'","callback_data":"'.urlencode($callback_da).'"},';
            for($j=0;$j<2;$j++){
                $i++;
            $callback_da = 'ED0'.$productCode.'0'.$i;
            $srlsprods = $srlsprods.'{"text":"'.urlencode($i).'","callback_data":"'.urlencode($callback_da).'"}],';
        }}
    } else {
        $srlsprods = '[{"text":"أضف خدمات","callback_data":"AD0'.$productCode.'"}]';
    }
    return $srlsprods;
}
function to_edit_prod($productCode, $srl, $newProd)
{
    file_put_contents("Products/$productCode/$srl.txt", $newProd);
}
function get_Name_prod($productCode)
{
    if ($productCode == 'SSN1') {
        return 'SSN 1';
    }
    if ($productCode == 'SSN2') {
        return 'SSN 2';
    }
    if ($productCode == 'INFO2') {
        return 'INFO 2';
    }
    if ($productCode == 'INFO1') {
        return 'INFO 1';
    }
    if ($productCode == 'INFO3') {
        return 'INFO 3';
    }
}
