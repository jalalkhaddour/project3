<?php 



ob_start(); 

$API_KEY = 'MY_BOT_TOKEN'; 
##------------------------------## 
define('TOKEN',$API_KEY); 
function dothing($method, $datas = []) 
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
$IDs=array(437087364,876201369);
$output = json_decode(file_get_contents('php://input'), TRUE); 
 
$update = json_decode(file_get_contents('php://input')); 
$message = $update->message; 
$chat_id = $message->chat->id; 
$textmsg = $message->text; 
$first_name = $message->from->first_name; 
$username = $message->from->username; 
$from_id = $message->from->id; 
$docu = $message->document ; 
$docuname = $docu->file_name ; 
$idbot= substr($API_KEY, 0, strpos($API_KEY, ':')); 

if(in_array($from_id,$IDs)){
    $state=intval(file_get_contents("try/state.txt"));
    $seconds=time();
    $try=gmdate("Y/m/j H:i:s",$seconds+3600*(2+date("I")));
    if($textmsg=="/startcount" and $state==0){
          $state=1;
         file_put_contents("try/state.txt",$state);
        $starttime=time();
        file_put_contents("try/try.txt",$starttime);
        foreach($IDs as $admin){
            dothing('sendMessage',[
                'chat_id'=>$admin,
                'text'=>"
                ٭ تم بدء العداد🔰؛
              • من قبل  ؛ 
              $first_name ،
    
              بتاريخ : 
              $try
              
              ",
                    ]); 
                }
        
        }
    if($textmsg=="/endcount"){
        if( $state==1){
            $endtime=time();
        $state=0;
 $starttime=intval(file_get_contents("try/try.txt"));
        $period=$endtime-$starttime;
        $period1=gmdate("H:i:s",$period);
        $sumperiod=intval(file_get_contents("try/periods.txt"));
        $sumperiod=$period+$sumperiod; 
        file_put_contents("try/periods.txt",$sumperiod);
         file_put_contents("try/state.txt",$state);
         foreach($IDs as $admin){
            dothing('sendMessage',[
                'chat_id'=>$admin,
                'text'=>"٭ تم إيقاف العداد🔰؛
                
                • من قبل  ؛ $first_name ،
                بتاريخ  :  $try",
                ]);
    
    
            dothing('sendMessage',[
                'chat_id'=>$admin,
                'text'=>"مدة الجلسة : $period1",
                ]); 
            
            }}

        else{
            dothing('sendMessage',[
                'chat_id'=>$from_id,
                'text'=>"مافيك تعمل إيقاف اذا لسا ما بلشت عداد 🌝",
                ]);
        }

    }
    if($textmsg=="/total_talk_time"){
        $ss=intval(file_get_contents("try/periods.txt"));
$s = $ss%60;
$m = floor(($ss%3600)/60);
$h = floor(($ss%86400)/3600);
$d = floor(($ss%2592000)/86400);
$M = floor($ss/2592000);
        foreach($IDs as $admin){
            dothing('sendMessage',[
                'chat_id'=>$admin,
                'text'=>"المدة الكلية :
seconds : $s
minutes :  $m
hours     :   $h
days       :   $d
Months  :   $M

",
                ]);
        }
    }

}
else{
    dothing('sendMessage',[
        'chat_id'=>$chat_id,
        'text'=>"this is a private bot so go and kill yourself you can't use it 
        
        بالمشرمحي ما خصك 🤣😜",
        ]);
}
?>