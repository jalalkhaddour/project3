<?php

$token = "MY_BOT_TOKEN";
define('api',"$token"); 
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".api."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($datas));
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}

$update = json_decode(file_get_contents('php://input'));
$output = json_decode(file_get_contents('php://input'), TRUE);
$message = $update->message;
$message_id = $update->message->message_id;
$chat_id = $message->chat->id;
$textmsg = $message->text;
$from_id = $message->from->id;
$idbot = "1153085855"; // ايدي بوتك
$usernamebot = "da3m_3k_bot"; //معرف بوتك
$idgp = "-1001247717804"; // ايدي كروب الاداره
$mhmd=279369853;
// كروب الاستقبال اي كروب تخلي عادي
// بس لازم تفعل خاصيه الاستقبال ب خاص من الاوامر بوت
if(isset($update->callback_query)){
    $chat_id = $update->callback_query->message->chat->id;
    $message_id = $update->callback_query->message->message_id;
    $data = $update->callback_query->data;
    $callback_query = $output['callback_query'];
    $from_id = $callback_query['from']['id'];
if($data=="Make_Code"){
    file_put_contents("data/$from_id/settings.txt","Make_Code");
    $getnumoldercode = file_get_contents("numcode.txt");
    $Rand = $getnumoldercode + 1; 
    file_put_contents("numcode.txt",$Rand);
    mkdir("codes/$Rand");
        file_put_contents("data/$from_id/settings2.txt","$Rand");
         bot('SendMessage',[
    'chat_id'=>$chat_id,
   'text'=>"أرسل مقدمة الرسالة 📩 وتكون على أنواع عديدة منها (الصور/ الفيديو / الصوتيات / الرسائل الصوتيه / ملفات / صوره متحركه) وتدعم خاصية الوصف الخاص بالميديا 📇️"
        ]);
         }
if($data == "re_msg"){
    $code = file_get_contents("data/$from_id/settings2.txt");
        file_put_contents("data/$from_id/settings.txt","");
  bot('editMessageText',[
   'chat_id'=>$chat_id,
    'message_id'=>$message_id,
   'text'=>"<code>@$usernamebot $code</code>",
    'parse_mode'=>'HTML',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"إنشاء رسالة خاصة 📃",'callback_data'=>"Make_Code"],
                        ]
                ]
            ])
        ]);
}
if($data == "save_msg"){
        file_put_contents("data/$from_id/settings.txt","create_keyborad");
  bot('editMessageText',[
   'chat_id'=>$chat_id,
    'message_id'=>$message_id,
   'text'=>"• إرسل القوائم الشفافة 📑 

• شرح انشاء كود ماركداون / انلاين 🗳

• الماركداون 🏷
text = link + text = link
text = link 

• انلاين 📝
[Text](link)
[Text](link)
️",
   'parse_mode'=>'MARKDOWN',
'disable_web_page_preview'=>'true'
        ]);
}

if($data and $data != "save_msg" and $data != "re_msg" and $data != "Make_Code" and $data != "help"){
if(file_exists("codes/$data/msgid.txt")){
  $Starttime = microtime(true);
  $txt = file_get_contents("codes/$data/msgid.txt");
$msgids = explode("\n", $txt);
  $txt2 = file_get_contents("codes/$data/chid.txt");
$chids = explode("\n", $txt2);
$sperds = count($msgids); 
  bot('editMessageText',[
   'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"جاري حذف الرسالة الخاصة من كل القنوات ❌"
  ]);
for($y=0;$y<count($msgids); $y++){
   file_get_contents("https://api.telegram.org/bot".api."/deleteMessage?chat_id=".$chids[$y]."&message_id=".$msgids[$y]);
}
    $reportdel = file_get_contents("texts/reportdel.txt");
if($reportdel == "on"){
  $list = scandir("channels");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){  
        continue;   
        }else{
 $id = $list[$i];
   $stat = file_get_contents("https://api.telegram.org/bot".api."/getChatMember?chat_id=$id&user_id=$idbot");
$statjson = json_decode($stat, true);
$status = $statjson['result']['status'];
$can = $statjson['result']['can_delete_messages'];

if($status != "administrator" and $can != "true"){
      $add_user = file_get_contents("list.txt");
      $add_user .= "• ".$list[$i]."  ";
     file_put_contents("list.txt",$add_user);
     $del = file_get_contents("numdel.txt");
     file_put_contents("numdel.txt",$del + 1);
     
    }else{
             $senda = file_get_contents("numsend.txt");
     file_put_contents("numsend.txt",$senda + 1);
    }
}
}
     $del = file_get_contents("numdel.txt");
             $senda = file_get_contents("numsend.txt");
  $listaaaa = file_get_contents("list.txt");
  $endtIme = microtime(true);
$speed = $endtIme - $Starttime;
$risss = round($speed,2);
}
if($reportdel == "on"){
  bot('editMessageText',[
   'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"تم حذف الرسالة الخاصة بنجاح ✅ 

⚠️ تقرير الحذف :- 
تم الحذف : $senda / تم الفشل : $del / خلال :- $risss (s)
قنوات لم يتم الحذف فيها ($del):
$listaaaa",
      'parse_mode'=>'HTML'
  ]);
          file_put_contents("list.txt", "");
    file_put_contents("numdel.txt","0");
          file_put_contents("numsend.txt","0");
}else {
      bot('editMessageText',[
   'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"تم حذف الرسالة الخاصة بنجاح ✅",
      'parse_mode'=>'HTML'
  ]);
}
 unlink("codes/$data/msgid.txt");
  unlink("codes/$data/chid.txt");
  
}else {
           bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"عذراً أما تم حذف الرسالة الخاصه بالفعل أو لا توجد رسالة⚠️"
   ]);
}
}
}

if($chat_id == "$idgp"){
//------------------
if($textmsg == "/help" or $data == "help"){
       bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"التعليمات :

يمكنك رؤية تفاصيل الأوامر عند الضغط عليها - مهم قراءة التفاصيل -
الشرح والتفاصيل  لكل ما يخص البوت هنا
جميع التعلميات تبدأ بـ / 

`/case` : لرؤية حالةِ البوت .
`/add + ID_CHANNEL OR USERNAME` : لأضافة قناة الى الدعم
`/rem + ID_CHANNEL OR USERNAME` : لمسح قناة من الدعم
`/sall + USERCHS` : لأضافة مجموعة قنوات دفعة واحده
`/rell + USERCHS` : لحذف مجموعة قنوات دفعة واحده
`/check `: لفحص جميع القنوات المخالفة
`/remall list` : لمسح جميع القنوات من الدعم
`/showall` : لمشاهدة جميع القنوات المضافة
`/send + NUM_CODE` : لنشر الرسالة الخاصة بكل القنوات
`/del + NUM_CODE` : لحذف الرسالة الخاصة من كل القنوات
`/delall` : لحذف كل الرسائل الخاصة من كل القنوات
`/report` : لأعطائك تقرير الزيادة الخاص بالدعم ويفضل استخدامة بعد الدعم 
`/reportpost on` : لتشغيل تقرير النشر 
`/reportpost off` : لأيقاف تقرير النشر
`/reportdel on` : لتشغيل تقرير الحذف 
`/reportdel off` : لأيقاف تقرير الحذف
`/update` : لتحديث عدد مشتركي القنوات يفضل استخدمه قبل الدعم
`/stats` : لرؤية معلومات اللستة كالقنوات المشاركة ... الخ
`/list` : لرؤية لستة الروابط الخاصة مع تنسيقها وعمل كود خاص بها
`/reup + TEXT` : لتغير كتابة المقدمه الخاص باللستة
`/addp on` : لتفعيل الاضافه التلقائيه بالخاص 
`/addp off` : لأيقاف الأضافه التلقائيه بالخاص
`/MAX NUM` : لتحديد اقصى عدد للمشاركة في الأضافة التلقائية

مصطلاحات خاصة في البوت :
`ID_CHANNEL` : ايدي الخاص في القناة
`USERNAME` : المعرف الخاص في القناة
`USERCHS` : معرفات يكون معرف تحت الأخر
`NUM_CODE` : رقم الرسالة الخاصة 
`OR` : معناها أو
`TEXT` : كتابة نصية
`NUM` : قيمة عدديه
-
",
       'parse_mode'=>'MARKDOWN',
    'disable_web_page_preview'=>'true'
   ]);
}
# هنا اكتب اي ترحيب يعجبك
$new_member = $update->message->new_chat_member; 










//------------------
if(preg_match("/^\/(rell) (.*)/s",$textmsg)){
  preg_match("/^\/(rell) (.*)/s",$textmsg,$matchaa);
 $chhhanels = $matchaa[2];
 $ex = explode("\n", $chhhanels);
for ($i=0; $i < count($ex); $i++) { 
  $getChatReq = file_get_contents("https://api.telegram.org/bot".api."/getChat?chat_id=".$ex[$i]);
  $getChatRes = json_decode($getChatReq, true);
 $id = $getChatRes['result']['id'];
 $fu = "@".$getChatRes['result']['username'];
  if (file_exists("channels/$id")){
              bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"القناة ($fu) تم حذفها من الدعم بنجاح ✅",
      'parse_mode'=>'HTML',
  ]);
   unlink("channels/$id");
unlink("members/".$id);
}else {
            bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"لا توجد قناة بهذا الأسم ($fu) في الدعم ⚠️",
      'parse_mode'=>'HTML',
  ]);
}
}
}

if(preg_match("/^\/(sall) (.*)/s",$textmsg)){
  preg_match("/^\/(sall) (.*)/s",$textmsg,$matchaa);
 $chhhanels = $matchaa[2];
 $ex = explode("\n", $chhhanels);
for ($i=0; $i < count($ex); $i++) { 
$fu = $ex[$i];
   $getChatReqw = file_get_contents("https://api.telegram.org/bot".api."/getChat?chat_id=".$fu);
  $getChatResw = json_decode($getChatReqw, true);
 $idw = $getChatResw['result']['id'];
if (!file_exists("channels/$idw")){
$stat = file_get_contents("https://api.telegram.org/bot".api."/getChatMember?chat_id=$fu&user_id=$idbot");
$statjson = json_decode($stat, true);
$status = $statjson['result']['status'];
if($status == "administrator"){
  $getChatReq = file_get_contents("https://api.telegram.org/bot".api."/getChat?chat_id=".$fu);
  $getChatRes = json_decode($getChatReq, true);
 $id = $getChatRes['result']['id'];
 
    $url = "http://api.telegram.org/bot".api."/getChatMembersCount?chat_id=".$fu;
$get = file_get_contents($url);
$json = json_decode($get);
$res  = $json->result;
file_put_contents("members/".$id,"$res");

 file_put_contents("channels/$id","$id");
     bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"القناة ($fu) تمت اضافتها بنجاح ✅",
      'parse_mode'=>'HTML',
  ]);
 
}else {
        bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"يرجى ترقية البوت مشرف في القناة ( $fu ) أولاً 👤",
      'parse_mode'=>'HTML',
  ]);
}
}else {
         bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"القناة ( $fu ) تمت أضافتها بالفعل ☑️",
      'parse_mode'=>'HTML',
  ]);
}
}
}

if($textmsg == "/delall" and $message){
//--------------
 $Starttime = microtime(true);
 
 $listaahsh = scandir("codes");
  bot('SendMessage',[
   'chat_id'=>$chat_id,
    'text'=>"جاري حذف كل الرسائل الخاصة من كل القنوات 🔹"
  ]);
for($a=0;$a<count($listaahsh);$a++) {
if( $listaahsh[$a] == "." or $listaahsh[$a] == ".." ){  
        continue;   
        }else{
  if(file_exists("codes/".$listaahsh[$a]."/msgid.txt")){
 $txt = file_get_contents("codes/".$listaahsh[$a]."/msgid.txt");
$msgids = explode("\n", $txt);
  $txt2 = file_get_contents("codes/".$listaahsh[$a]."/chid.txt");
$chids = explode("\n", $txt2);
for($y=0;$y<count($msgids); $y++){
   file_get_contents("https://api.telegram.org/bot".api."/deleteMessage?chat_id=".$chids[$y]."&message_id=".$msgids[$y]);
}
 unlink("codes/".$listaahsh[$a]."/msgid.txt");
  unlink("codes/".$listaahsh[$a]."/chid.txt");
//------------------
}
}
}
  $list = scandir("channels");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){  
        continue;   
        }else{
              $getChatReq = file_get_contents("https://api.telegram.org/bot".api."/getChat?chat_id=".$list[$i]);
  $getChatRes = json_decode($getChatReq, true);
 $id = $getChatRes['result']['id'];
  $usernameddhdhha = $getChatRes['result']['username'];
 
   $stat = file_get_contents("https://api.telegram.org/bot".api."/getChatMember?chat_id=$id&user_id=$idbot");
$statjson = json_decode($stat, true);
$status = $statjson['result']['status'];
$can = $statjson['result']['can_delete_messages'];

if($status != "administrator" and $can != "true"){
      $add_user = file_get_contents("list.txt");
      $add_user .= "• @".$usernameddhdhha."  ";
     file_put_contents("list.txt",$add_user);
     $del = file_get_contents("numdel.txt");
     file_put_contents("numdel.txt",$del + 1);
     }else{
             $senda = file_get_contents("numsend.txt");
     file_put_contents("numsend.txt",$senda + 1);
    }
}
}
     $del = file_get_contents("numdel.txt");
             $senda = file_get_contents("numsend.txt");
  $listaaaa = file_get_contents("list.txt");
  $endtIme = microtime(true);
$speed = $endtIme - $Starttime;
$risss = round($speed,2);
  bot('editMessageText',[
   'chat_id'=>$chat_id,
    'message_id'=>$message_id + 1,
    'text'=>"تم حذف جميع الرسائل الخاصة من كل القنوات بنجاح ✅

⚠️ تقرير الحذف :- 
تم الحذف : $senda / تم الفشل : $del / خلال :- $risss (s)
قنوات لم يتم الحذف فيها ($del):
$listaaaa",
      'parse_mode'=>'HTML'
  ]);
          file_put_contents("list.txt", "");
    file_put_contents("numdel.txt","0");
          file_put_contents("numsend.txt","0");
//---------------
}
//-----------------
if(preg_match("/^\/(check)/s",$textmsg)){
    bot('SendMessage',[
   'chat_id'=>$chat_id,
    'text'=>"جاري فحص جميع القنوات ‼️"
  ]);
  $list = scandir("channels");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){  
        continue;   
        }else{
              $getChatReq = file_get_contents("https://api.telegram.org/bot".api."/getChat?chat_id=".$list[$i]);
  $getChatRes = json_decode($getChatReq, true);
 $id = $getChatRes['result']['id'];
  $usernameddhdhha = $getChatRes['result']['username'];
 
   $stat = file_get_contents("https://api.telegram.org/bot".api."/getChatMember?chat_id=$id&user_id=$idbot");
$statjson = json_decode($stat, true);
$status = $statjson['result']['status'];
$can = $statjson['result']['can_delete_messages'];
$cans = $statjson['result']['can_post_messages'];

if($status != "administrator" and $can != "true" and $cans != "true"){
      $add_user = file_get_contents("list.txt");
      $add_user .= "• @".$usernameddhdhha." | ❌ \n";
     file_put_contents("list.txt",$add_user);
     $del = file_get_contents("numdel.txt");
        file_put_contents("numdel.txt",$del + 1);
}
if($can != "true" and $status == "administrator"){
        $add_user = file_get_contents("list.txt");
      $add_user .= "• @".$usernameddhdhha." | ⛔️ \n";
     file_put_contents("list.txt",$add_user);  
        $del = file_get_contents("numdel.txt");
        file_put_contents("numdel.txt",$del + 1);
}
if($cans != "true" and $status == "administrator"){
        $add_user = file_get_contents("list.txt");
      $add_user .= "• @".$usernameddhdhha." | ✖️ \n";
     file_put_contents("list.txt",$add_user);
     $del = file_get_contents("numdel.txt");   
        file_put_contents("numdel.txt",$del + 1);
}
}
}
     $del = file_get_contents("numdel.txt");
 $listaaaa = file_get_contents("list.txt");
    bot('SendMessage',[
   'chat_id'=>$chat_id,
    'text'=>"تم فحص جميع القنوات بنجاح ✅

معلومات الفحص :
❌ : البوت ليس مشرف في القناة
✖️: البوت ليس لديه صلاحية النشر
⛔️ : البوت ليس لديه صلاحية الحذف

تقرير الفحص الخاص بالقنوات($del):
$listaaaa"
  ]);
          file_put_contents("list.txt", "");
          file_put_contents("numdel.txt","0");
}
if(preg_match("/^\/(add) (.*)/s",$textmsg)){
  preg_match("/^\/(add) (.*)/s",$textmsg,$matchaa);
 $fu = $matchaa[2];
   $getChatReqw = file_get_contents("https://api.telegram.org/bot".api."/getChat?chat_id=".$fu);
  $getChatResw = json_decode($getChatReqw, true);
 $idw = $getChatResw['result']['id'];
if (!file_exists("channels/$idw")){
$stat = file_get_contents("https://api.telegram.org/bot".api."/getChatMember?chat_id=$fu&user_id=$idbot");
$statjson = json_decode($stat, true);
$status = $statjson['result']['status'];
if($status == "administrator"){
  $getChatReq = file_get_contents("https://api.telegram.org/bot".api."/getChat?chat_id=".$fu);
  $getChatRes = json_decode($getChatReq, true);
 $id = $getChatRes['result']['id'];
 
     $url = "http://api.telegram.org/bot".api."/getChatMembersCount?chat_id=".$fu;
$get = file_get_contents($url);
$json = json_decode($get);
$res  = $json->result;
file_put_contents("members/".$id,"$res");
 
 file_put_contents("channels/$id","$id");
     bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"القناة ($fu) تمت اضافتها بنجاح ✅",
      'parse_mode'=>'HTML',
  ]);
}else {
        bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"يرجى ترقية البوت مشرف في القناة ( $fu ) أولاً 👤",
      'parse_mode'=>'HTML',
  ]);
}
}else {
         bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"القناة ( $fu ) تمت أضافتها بالفعل ☑️",
      'parse_mode'=>'HTML',
  ]);
}
}

if(preg_match("/^\/(rem) (.*)/s",$textmsg)){
  preg_match("/^\/(rem) (.*)/s",$textmsg,$match);
    $getChatReq = file_get_contents("https://api.telegram.org/bot".api."/getChat?chat_id=".$match[2]);
  $getChatRes = json_decode($getChatReq, true);
 $id = $getChatRes['result']['id'];
 $fu = "@".$getChatRes['result']['username'];
  if (file_exists("channels/$id")){
              bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"القناة ($fu) تم حذفها من الدعم بنجاح ✅",
      'parse_mode'=>'HTML',
  ]);
   unlink("channels/$id");
unlink("members/".$id);
}else {
            bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"لا توجد قناة بهذا الأسم ($fu) في الدعم ⚠️",
      'parse_mode'=>'HTML',
  ]);
}
}


if($textmsg == "/remall list"){
        $list = scandir("channels");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){  
        continue;   
        }else{
      unlink("channels/".$list[$i]); 
      unlink("members/".$list[$i]);
        }
}
                  bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم حذف جميع القنوات من الدعم بنجاح ☑️",
      'parse_mode'=>'HTML',
  ]);
}

if($textmsg == "/showall"){
     file_put_contents("channels/$fu","$id - $matcsssehaa[2]");
     $list = scandir("channels");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){  
        continue;   
        }else{
        $namea = file_get_contents("channels/".$list[$i]);
        $namee = preg_match("/^(.*) = (.*)/s",$namea,$match);
        $nameee = $match[2];
$user = file_get_contents("list.txt");
    $members = explode("\n",$user);
      $getChatReq = file_get_contents("https://api.telegram.org/bot".api."/getChat?chat_id=".$list[$i]);
  $getChatRes = json_decode($getChatReq, true);
  $usernameddhdhha = $getChatRes['result']['username'];
  
    if (!in_array("@".$usernameddhdhha." / ".$list[$i],$members)){
      $add_user = file_get_contents("list.txt");
      $add_user .= "@".$usernameddhdhha." / ".$list[$i]."\n";
     file_put_contents("list.txt",$add_user);
    }
    
        }
}

$nuuuuuamam = $i - 2;

  $listaaaa = file_get_contents("list.txt");
                bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"جميع القنوات المضافة للدعم ($nuuuuuamam):
$listaaaa",
      'parse_mode'=>'HTML',
  ]);
          file_put_contents("list.txt", "");



}
if($textmsg == "/update"){
          $Starttime = microtime(true);
               $list = scandir("channels");
    for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){  
        continue;   
        }else{
    $url = "http://api.telegram.org/bot".api."/getChatMembersCount?chat_id=".$list[$i];
$get = file_get_contents($url);
$json = json_decode($get);
$res  = $json->result;
file_put_contents("members/".$list[$i],"$res");
       }
}
        $endtime = microtime(true);
$speed = $endtime - $Starttime;
$risss = round($speed,2);
$nuuuuuamam = $i - 2;

                   bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم تحديث عدد مشتركي القنوات [$nuuuuuamam] بنجاح خلال $risss ث ✅",
      'parse_mode'=>'HTML',
  ]);
}
if($textmsg == "/stats"){
              $Starttime = microtime(true);
    $ssa = count(scandir("channels"));
    $nuuuuuamam = $ssa - 2;
    $codes = count(scandir("codes"));
 $url = "http://api.telegram.org/bot".api."/getme";
$get = file_get_contents($url);
$json = json_decode($get);
$fanme  = $json->result->first_name;
$uanme  = $json->result->username;
        $endtime = microtime(true);
$speed = $endtime - $Starttime;
$risss = round($speed,2);
    $time = json_decode(file_get_contents('https://wathiq.us/time'));
    $time2 = $time->Time;
    $reportpost = file_get_contents("texts/reportpost.txt");
if($reportpost == "on"){
    $lock = "شغال ✅";
}else {
    $lock = "متوقف ❌";
}
    $reportdel = file_get_contents("texts/reportdel.txt");

if($reportdel == "on"){
    $locks = "شغال ✅";
}else {
    $locks = "متوقف ❌";
}
    $addp = file_get_contents("texts/addp.txt");

if($addp == "on"){
    $lockss = "شغال ✅";
}else {
    $lockss = "متوقف ❌";
}
              bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"معلومات البوت الخاص بك 💳

🔖اسم البوت :- $fanme
🗳معرف البوت :- $uanme 
📝عدد القنوات المضافه للبوت :- $nuuuuuamam
📨عدد الرسائل الخاصه التي تم صنعها :- $codes
💡سرعة البوت :- $risss
📡حالة تقرير النشر :- $lock 
⛔️حالة تقرير الحذف :- $locks
🗄حالة الاضافه التلقائية :- $lockss
⏰الوقت الحالي :- $time2
-",
      'parse_mode'=>'HTML',
  ]);
}
if($textmsg == "/reportdel on"){
    file_put_contents("texts/reportdel.txt","on");
                   bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم تشغيل تقرير الحذف بنجاح ✅",
      'parse_mode'=>'HTML',
  ]);
}
if($textmsg == "/reportdel off"){
    file_put_contents("texts/reportdel.txt","off");
                   bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم ايقاف تقرير الحذف بنجاح ✅",
      'parse_mode'=>'HTML',
  ]);
}
if($textmsg == "/reportpost on"){
    file_put_contents("texts/reportpost.txt","on");
                   bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم تشغيل تقرير النشر بنجاح ✅",
      'parse_mode'=>'HTML',
  ]);
}
if($textmsg == "/addp off"){
    file_put_contents("texts/addp.txt","off");
                   bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم ايقاف الاضافه التلقائيه بنجاح ✅",
      'parse_mode'=>'HTML',
  ]);
}
if($textmsg == "/addp on"){
    file_put_contents("texts/addp.txt","on");
                   bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم تشغيل الاضافه التلقائيه بنجاح ✅",
      'parse_mode'=>'HTML',
  ]);
}
if($textmsg == "/list"){
  $list = scandir("channels");
        $getnumoldercode = file_get_contents("numcode.txt");
    $Rand = $getnumoldercode + 1; 
    file_put_contents("numcode.txt",$Rand);
    mkdir("codes/$Rand");
  $code = $Rand;
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){  
        continue;   
        }else{
      $getChatReq = file_get_contents("https://api.telegram.org/bot".api."/getChat?chat_id=".$list[$i]);
  $getChatRes = json_decode($getChatReq, true);
  $usernameddhdhha = $getChatRes['result']['username'];
 $name = $getChatRes['result']['title'];
 
 $url = "http://api.telegram.org/bot".api."/getChatMembersCount?chat_id=".$list[$i];
$get = file_get_contents($url);
$json = json_decode($get);
$res  = $json->result;
//=======================
if($res<1000){
if($res<100){
$arr1 = str_split($res);
      $res = "0.".$res."h ";
}else {
 $arr1 = str_split($res);
      $res = $arr1[0].".".$arr1[1]."h ";   
}
}

if($res>1000){
$arr1 = str_split($res);
      $res = $arr1[0].".".$arr1[1]."k ";
}
 
  $linkk = "t.me/$usernameddhdhha";
 $nnnnaaa = count($list);
$nnnnaaahs = $nnnnaaa -3;

$a1 = str_replace('"',"",$name);
$av1 = str_replace("'","",$a1);


if($i != $nnnnaaahs){
$listt = '[{"text":"'.urlencode($res.$av1).'","url":"'.urlencode($linkk).'"}],';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);
}else {
 $listt = '[{"text":"'.urlencode($res.$av1).'","url":"'.urlencode($linkk).'"}]';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);   
}
        }
}
if (!file_exists("texts/listtext.txt")) {
    file_put_contents("texts/listtext.txt","لم يتم وضع نص");
}
$texxxtlist = file_get_contents("texts/listtext.txt");
file_put_contents("codes/$code/text.txt",urlencode($texxxtlist));
                   bot('SendMessage',[
    'chat_id'=>$chat_id,
   'text'=>"الكود الخاص باللستة الخاصه بك 📋 \n<code>@$usernamebot $code</code>",
    'parse_mode'=>'HTML',
        ]);
}
if(preg_match("/^\/(reup) (.*)/s",$textmsg)){
  preg_match("/^\/(reup) (.*)/s",$textmsg,$match);
      file_put_contents("texts/listtext.txt",$match[2]);
   bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم تغير رسالة المقدمة في امر /list بنجاح ✅",
      'parse_mode'=>'HTML',
  ]);
}
if(preg_match("/^\/(max) (.*)/s",$textmsg)){
  preg_match("/^\/(max) (.*)/s",$textmsg,$match);
      file_put_contents("texts/max.txt",$match[2]);
   bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم تعين اقصى عدد للمشاركة في الاضافة التلقائية ✅",
      'parse_mode'=>'HTML',
  ]);
}
if($textmsg == "/reportpost off"){
    file_put_contents("texts/reportpost.txt","off");
                   bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم ايقاف تقرير النشر بنجاح ✅",
      'parse_mode'=>'HTML',
  ]);
}

if($textmsg == "/res"){
mkdir("members");
     $list = scandir("channels");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){  
        continue;   
        }else{
    $url = "http://api.telegram.org/bot".api."/getChatMembersCount?chat_id=".$list[$i];
$get = file_get_contents($url);
$json = json_decode($get);
$res  = $json->result;
file_put_contents("members/".$list[$i],"$res");
       }
}
mkdir("texts");
    file_put_contents("texts/nsanaa.txt","0");
    file_put_contents("texts/zeadh.txt","0");
    file_put_contents("texts/lmezd.txt","0");
    file_put_contents("texts/allnsanaa.txt","0");
    file_put_contents("texts/allzeadh.txt","0");
   file_put_contents("texts/allmemberschs.txt","0");
                   bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"done",
      'parse_mode'=>'HTML',
  ]);
}

if($textmsg == "/case"){
      $Starttime = microtime(true);
    $time = json_decode(file_get_contents('https://wathiq.us/time'));
    $time2 = $time->Time;
        $endtime = microtime(true);
$speed = $endtime - $Starttime;
$risss = round($speed,2);
    bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"البوت بحالة ممتازه ✅

سرعة البوت 📈 : `$risss ` 
الوقت الحالي ⏰ : `$time2 `",
'parse_mode'=>'MARKDOWN'
]);
}

if($textmsg == "/report"){
                   bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"♻️ جاري أصدار تقرير الزيادة .....",
      'parse_mode'=>'HTML',
  ]);
$list = scandir("channels");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){  
        continue;   
        }else{

  $getChatReq = file_get_contents("https://api.telegram.org/bot".api."/getChat?chat_id=".urlencode($list[$i]));
  $getChatRes = json_decode($getChatReq, true);
  $namee = $getChatRes['result']['title'];
    $userr = "@".$getChatRes['result']['username'];

$url = "http://api.telegram.org/bot".api."/getChatMembersCount?chat_id=$list[$i]";
$get = file_get_contents($url);
$json = json_decode($get);
$res  = $json->result;
$emj  = $json->result;
$alllllmsm  = $json->result;
if($res<1000){
if($res<100){
$arr1 = str_split($res);
      $numberolder = "0.".$arr1[0]."h ";
}else {
 $arr1 = str_split($res);
      $numberolder = $arr1[0].".".$arr1[1]."h ";   
}
}
if($res>1000){
$arr1 = str_split($res);
      $numberolder = $arr1[0].".".$arr1[1]."k ";
}
//-----------------
$allmemberschs2 = file_get_contents("texts/allmemberschs.txt");
$allmemberschs = $alllllmsm + $allmemberschs2;
file_put_contents("texts/allmemberschs.txt",$allmemberschs);

$numold = file_get_contents("members/$list[$i]");
if ($emj == $numold){
    $numnew = $emj - $numold;
    $emoge = "⚠️ $numnew | $numberolder $userr";
        $get = file_get_contents("texts/lmezd.txt");
    $lmezd = $get + 1 ;
    file_put_contents("texts/lmezd.txt","$lmezd");
}
if ($emj > $numold){
    $numnew = $emj - $numold;
    $emoge = "♻️ $numnew | $numberolder $userr";
    $get = file_get_contents("texts/zeadh.txt");
    $zeadh = $get + 1 ;
    file_put_contents("texts/zeadh.txt","$zeadh");

    $zeadhall = $get + $numnew ;
    file_put_contents("texts/allzeadh.txt","$zeadhall");
}
if ($emj < $numold){
    $numnew = $emj - $numold;
    $emoge = "💔 $numnew | $numberolder $userr";
        $get = file_get_contents("texts/nsanaa.txt");
    $nsanaa = $get + 1 ;
    file_put_contents("texts/nsanaa.txt","$nsanaa");
    $allnsanaa = $get + $numnew ;
    file_put_contents("texts/allnsanaa.txt","$allnsanaa");
}
$user = file_get_contents("list.txt");
    $members = explode("\n",$user);
    if (!in_array($emoge,$members)){
      $add_user = file_get_contents("list.txt");
      $add_user .= $emoge."\n";
     file_put_contents("list.txt",$add_user);
    }
file_put_contents("members/".$list[$i],"$emj");
}
}
  $listaaaa = file_get_contents("list.txt");
        $lmezd = file_get_contents("texts/lmezd.txt");
        $zeadh = file_get_contents("texts/zeadh.txt");
        $nsanaa = file_get_contents("texts/nsanaa.txt");
        $allmemberschs22 = file_get_contents("texts/allmemberschs.txt");
        $allzeadh = file_get_contents("texts/allzeadh.txt");
        $allnasan = file_get_contents("texts/allnsanaa.txt");
        $nuuuuuamam = $i - 2;
        $egmaleh = $nuuuuuamam / $allzeadh ;
       bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"📝 تقرير الزيادة : \n$listaaaa
$zeadh | ♻️ زاد عدد المشتركين فيها.
$lmezd | ⚠️ لم تزد أي مشتركين.
$nsanaa | 💔 نقص عدد المشتركين فيها.

🔘 عدد المشتركين : $allmemberschs22
➕ الزيادة الأجمالية : $allzeadh
➖ إجمالي النقص : $allnasan
🔃 معدل الزيادة في [ $nuuuuuamam ] قناة : $egmaleh
-"
        ]);
          file_put_contents("list.txt", "");
    file_put_contents("texts/nsanaa.txt","0");
    file_put_contents("texts/zeadh.txt","0");
    file_put_contents("texts/lmezd.txt","0");
    file_put_contents("texts/allnsanaa.txt","0");
    file_put_contents("texts/allzeadh.txt","0");
   file_put_contents("texts/allmemberschs.txt","0");
}
    $reportpost = file_get_contents("texts/reportpost.txt");

if(preg_match("/^\/(send) (.*)/s",$textmsg)){
  preg_match("/^\/(send) (.*)/s",$textmsg,$match);
  $get = scandir("channels");
$channels = count($get);
$djajd = $channels - 2;
if($djajd >= "3"){
 $code = $match[2];
//--------------------
if(file_exists("codes/$code/audio.txt") or file_exists("codes/$code/voice.txt") or file_exists("codes/$code/photo.txt") or file_exists("codes/$code/text.txt") or file_exists("codes/$code/video.txt") or file_exists("codes/$code/document.txt") or file_exists("codes/$code/sticker.txt")){

if(!file_exists("codes/$code/msgid.txt")){
if(file_exists("codes/$code/text.txt")){
if(!file_exists("codes/$code/inline_keyboard.txt")){
        bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"جاري إرسال الرسالة الخاصة ✉️ ",
      'parse_mode'=>'HTML',
  ]);
$Starttime = microtime(true);
    $text = file_get_contents("codes/$code/text.txt");
         $list = scandir("channels");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){  
        continue;   
        }else{
 $id = $list[$i];
      $result = bot('SendMessage',[
    'chat_id'=>$id,
    'text'=>urldecode($text),
      'parse_mode'=>'HTML',
'disable_web_page_preview'=>'true'
  ]);
  $hdhdhdh = $result->result->message_id;
 
 file_put_contents("codes/$code/msgid.txt", "\n". $hdhdhdh, FILE_APPEND);
  file_put_contents("codes/$code/chid.txt", "\n". $id, FILE_APPEND);
 $lastMessages[] = $result;
 
if($reportpost == "on"){
$stat = file_get_contents("https://api.telegram.org/bot".api."/getChatMember?chat_id=$id&user_id=$idbot");
$statjson = json_decode($stat, true);
$status = $statjson['result']['status'];
$can = $statjson['result']['can_post_messages'];

if($status != "administrator" and $can != "true"){
      $add_user = file_get_contents("list.txt");
      $add_user .= "• ".$list[$i]."  ";
     file_put_contents("list.txt",$add_user);
     $del = file_get_contents("numdel.txt");
     file_put_contents("numdel.txt",$del + 1);
     
    }else{
             $senda = file_get_contents("numsend.txt");
     file_put_contents("numsend.txt",$senda + 1);
    }

}
}

        }
      
 if($reportpost == "on"){
$del = file_get_contents("numdel.txt");
             $senda = file_get_contents("numsend.txt");
  $listaaaa = file_get_contents("list.txt");
         $endtIme = microtime(true);
$speed = $endtIme - $Starttime;
$risss = round($speed,2);
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️

⚠️ تقرير النشر :- 
تم النشر : $senda / تم الفشل : $del / خلال :- $risss (s)
قنوات لم يتم النشر فيها ($del):
$listaaaa ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
          file_put_contents("list.txt", "");
    file_put_contents("numdel.txt","0");
          file_put_contents("numsend.txt","0");
}else {
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️ ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
}
}else {
            bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"جاري إرسال الرسالة الخاصة ✉️ ",
      'parse_mode'=>'HTML',
  ]);
$Starttime = microtime(true);
    $text = file_get_contents("codes/$code/text.txt");
         $list = scandir("channels");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){  
        continue;   
        }else{
 $id = $list[$i];
    $listtaaataaara = file_get_contents("codes/$code/inline_keyboard.txt");
      $result = file_get_contents('https://api.telegram.org/bot'.api.'/sendMessage?chat_id='.$id.'&text='.$text.'&parse_mode=HTML&disable_web_page_preview=true&reply_markup={"inline_keyboard":['.$listtaaataaara.']}');
 $lastMessages[] = $result;
 $getjsdonsend = json_decode($result);
 $hdhdhdh = $getjsdonsend->result->message_id;
 
 file_put_contents("codes/$code/msgid.txt", "\n". $hdhdhdh, FILE_APPEND);
  file_put_contents("codes/$code/chid.txt", "\n". $id, FILE_APPEND);
if($reportpost == "on"){
$stat = file_get_contents("https://api.telegram.org/bot".api."/getChatMember?chat_id=$id&user_id=$idbot");
$statjson = json_decode($stat, true);
$status = $statjson['result']['status'];
$can = $statjson['result']['can_post_messages'];

if($status != "administrator" and $can != "true"){
      $add_user = file_get_contents("list.txt");
      $add_user .= "• ".$list[$i]."  ";
     file_put_contents("list.txt",$add_user);
     $del = file_get_contents("numdel.txt");
     file_put_contents("numdel.txt",$del + 1);
     
    }else{
             $senda = file_get_contents("numsend.txt");
     file_put_contents("numsend.txt",$senda + 1);
    }

}
}

        }
      
 if($reportpost == "on"){
$del = file_get_contents("numdel.txt");
             $senda = file_get_contents("numsend.txt");
  $listaaaa = file_get_contents("list.txt");
         $endtIme = microtime(true);
$speed = $endtIme - $Starttime;
$risss = round($speed,2);
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️

⚠️ تقرير النشر :- 
تم النشر : $senda / تم الفشل : $del / خلال :- $risss (s)
قنوات لم يتم النشر فيها ($del):
$listaaaa ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
          file_put_contents("list.txt", "");
    file_put_contents("numdel.txt","0");
          file_put_contents("numsend.txt","0");
}else {
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️ ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
}}
}
if(file_exists("codes/$code/sticker.txt")){
if(!file_exists("codes/$code/inline_keyboard.txt")){
        bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"جاري إرسال الرسالة الخاصة ✉️ ",
      'parse_mode'=>'HTML',
  ]);
$Starttime = microtime(true);
    $file_id = file_get_contents("codes/$code/sticker.txt");
         $list = scandir("channels");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){  
        continue;   
        }else{
 $id = $list[$i];
      $result =  bot('sendsticker',[
   'chat_id'=>$id,
   'sticker'=>"$file_id"
]);
 $lastMessages[] = $result;
 $hdhdhdh = $result->result->message_id;
 
 file_put_contents("codes/$code/msgid.txt", "\n". $hdhdhdh, FILE_APPEND);
  file_put_contents("codes/$code/chid.txt", "\n". $id, FILE_APPEND);
if($reportpost == "on"){
$stat = file_get_contents("https://api.telegram.org/bot".api."/getChatMember?chat_id=$id&user_id=$idbot");
$statjson = json_decode($stat, true);
$status = $statjson['result']['status'];
$can = $statjson['result']['can_post_messages'];

if($status != "administrator" and $can != "true"){
      $add_user = file_get_contents("list.txt");
      $add_user .= "• ".$list[$i]."  ";
     file_put_contents("list.txt",$add_user);
     $del = file_get_contents("numdel.txt");
     file_put_contents("numdel.txt",$del + 1);
     
    }else{
             $senda = file_get_contents("numsend.txt");
     file_put_contents("numsend.txt",$senda + 1);
    }

}
}

        }
      
 if($reportpost == "on"){
$del = file_get_contents("numdel.txt");
             $senda = file_get_contents("numsend.txt");
  $listaaaa = file_get_contents("list.txt");
         $endtIme = microtime(true);
$speed = $endtIme - $Starttime;
$risss = round($speed,2);
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️

⚠️ تقرير النشر :- 
تم النشر : $senda / تم الفشل : $del / خلال :- $risss (s)
قنوات لم يتم النشر فيها ($del):
$listaaaa ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
          file_put_contents("list.txt", "");
    file_put_contents("numdel.txt","0");
          file_put_contents("numsend.txt","0");
}else {
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️ ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
}
}else {
            bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"جاري إرسال الرسالة الخاصة ✉️ ",
      'parse_mode'=>'HTML',
  ]);
$Starttime = microtime(true);
         $list = scandir("channels");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){  
        continue;   
        }else{
 $id = $list[$i];
    $listtaaataaara = file_get_contents("codes/$code/inline_keyboard.txt");
        $tttttweeeeexxiwis = file_get_contents("codes/$code/sticker.txt");
      $result = file_get_contents('https://api.telegram.org/bot'.api.'/sendsticker?chat_id='.$id.'&sticker='.$tttttweeeeexxiwis.'&reply_markup={"inline_keyboard":['.$listtaaataaara.']}');
 $lastMessages[] = $result;
 $getjsdonsend = json_decode($result);
 $hdhdhdh = $getjsdonsend->result->message_id;
 
 file_put_contents("codes/$code/msgid.txt", "\n". $hdhdhdh, FILE_APPEND);
  file_put_contents("codes/$code/chid.txt", "\n". $id, FILE_APPEND);

if($reportpost == "on"){
$stat = file_get_contents("https://api.telegram.org/bot".api."/getChatMember?chat_id=$id&user_id=$idbot");
$statjson = json_decode($stat, true);
$status = $statjson['result']['status'];
$can = $statjson['result']['can_post_messages'];

if($status != "administrator" and $can != "true"){
      $add_user = file_get_contents("list.txt");
      $add_user .= "• ".$list[$i]."  ";
     file_put_contents("list.txt",$add_user);
     $del = file_get_contents("numdel.txt");
     file_put_contents("numdel.txt",$del + 1);
     
    }else{
             $senda = file_get_contents("numsend.txt");
     file_put_contents("numsend.txt",$senda + 1);
    }

}
}

        }
      
 if($reportpost == "on"){
$del = file_get_contents("numdel.txt");
             $senda = file_get_contents("numsend.txt");
  $listaaaa = file_get_contents("list.txt");
         $endtIme = microtime(true);
$speed = $endtIme - $Starttime;
$risss = round($speed,2);
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️

⚠️ تقرير النشر :- 
تم النشر : $senda / تم الفشل : $del / خلال :- $risss (s)
قنوات لم يتم النشر فيها ($del):
$listaaaa ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
          file_put_contents("list.txt", "");
    file_put_contents("numdel.txt","0");
          file_put_contents("numsend.txt","0");
}else {
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️ ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
}}
}
if(file_exists("codes/$code/photo.txt")){
if(!file_exists("codes/$code/inline_keyboard.txt")){
        bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"جاري إرسال الرسالة الخاصة ✉️ ",
      'parse_mode'=>'HTML',
  ]);
$Starttime = microtime(true);
    $file_id = file_get_contents("codes/$code/photo.txt");
    $caption = file_get_contents("codes/$code/caption.txt");
         $list = scandir("channels");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){  
        continue;   
        }else{
 $id = $list[$i];
      $result =  bot('sendphoto',[
   'chat_id'=>$id,
   'photo'=>"$file_id",
   'caption'=>urldecode($caption)
]);
 $lastMessages[] = $result;
$hdhdhdh = $result->result->message_id;
 
 file_put_contents("codes/$code/msgid.txt", "\n". $hdhdhdh, FILE_APPEND);
  file_put_contents("codes/$code/chid.txt", "\n". $id, FILE_APPEND);
if($reportpost == "on"){
$stat = file_get_contents("https://api.telegram.org/bot".api."/getChatMember?chat_id=$id&user_id=$idbot");
$statjson = json_decode($stat, true);
$status = $statjson['result']['status'];
$can = $statjson['result']['can_post_messages'];

if($status != "administrator" and $can != "true"){
      $add_user = file_get_contents("list.txt");
      $add_user .= "• ".$list[$i]."  ";
     file_put_contents("list.txt",$add_user);
     $del = file_get_contents("numdel.txt");
     file_put_contents("numdel.txt",$del + 1);
     
    }else{
             $senda = file_get_contents("numsend.txt");
     file_put_contents("numsend.txt",$senda + 1);
    }

}
}

        }
      
 if($reportpost == "on"){
$del = file_get_contents("numdel.txt");
             $senda = file_get_contents("numsend.txt");
  $listaaaa = file_get_contents("list.txt");
         $endtIme = microtime(true);
$speed = $endtIme - $Starttime;
$risss = round($speed,2);
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️

⚠️ تقرير النشر :- 
تم النشر : $senda / تم الفشل : $del / خلال :- $risss (s)
قنوات لم يتم النشر فيها ($del):
$listaaaa ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
          file_put_contents("list.txt", "");
    file_put_contents("numdel.txt","0");
          file_put_contents("numsend.txt","0");
}else {
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️ ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
}
}else {
            bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"جاري إرسال الرسالة الخاصة ✉️ ",
      'parse_mode'=>'HTML',
  ]);
$Starttime = microtime(true);
         $list = scandir("channels");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){  
        continue;   
        }else{
 $id = $list[$i];
    $listtaaataaara = file_get_contents("codes/$code/inline_keyboard.txt");
        $tttttweeeeexxiwis = file_get_contents("codes/$code/photo.txt");
        $captionssajfnjs = file_get_contents("codes/$code/caption.txt");
      $result = file_get_contents('https://api.telegram.org/bot'.api.'/sendphoto?chat_id='.$id.'&photo='.$tttttweeeeexxiwis.'&caption='.$captionssajfnjs.'&reply_markup={"inline_keyboard":['.$listtaaataaara.']}');
 $lastMessages[] = $result;
 $getjsdonsend = json_decode($result);
 $hdhdhdh = $getjsdonsend->result->message_id;
 
 file_put_contents("codes/$code/msgid.txt", "\n". $hdhdhdh, FILE_APPEND);
  file_put_contents("codes/$code/chid.txt", "\n". $id, FILE_APPEND);

 $getjsdonsend = json_decode($result);
 $hdhdhdh = $getjsdonsend->result->message_id;
 
 file_put_contents("codes/$code/msgid.txt", "\n". $hdhdhdh, FILE_APPEND);
  file_put_contents("codes/$code/chid.txt", "\n". $id, FILE_APPEND);
  
if($reportpost == "on"){
$stat = file_get_contents("https://api.telegram.org/bot".api."/getChatMember?chat_id=$id&user_id=$idbot");
$statjson = json_decode($stat, true);
$status = $statjson['result']['status'];
$can = $statjson['result']['can_post_messages'];

if($status != "administrator" and $can != "true"){
      $add_user = file_get_contents("list.txt");
      $add_user .= "• ".$list[$i]."  ";
     file_put_contents("list.txt",$add_user);
     $del = file_get_contents("numdel.txt");
     file_put_contents("numdel.txt",$del + 1);
     
    }else{
             $senda = file_get_contents("numsend.txt");
     file_put_contents("numsend.txt",$senda + 1);
    }

}
}

        }

 if($reportpost == "on"){
$del = file_get_contents("numdel.txt");
             $senda = file_get_contents("numsend.txt");
  $listaaaa = file_get_contents("list.txt");
         $endtIme = microtime(true);
$speed = $endtIme - $Starttime;
$risss = round($speed,2);
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️

⚠️ تقرير النشر :- 
تم النشر : $senda / تم الفشل : $del / خلال :- $risss (s)
قنوات لم يتم النشر فيها ($del):
$listaaaa ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
          file_put_contents("list.txt", "");
    file_put_contents("numdel.txt","0");
          file_put_contents("numsend.txt","0");
}else {
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️ ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
}}
}
if(file_exists("codes/$code/voice.txt")){
if(!file_exists("codes/$code/inline_keyboard.txt")){
        bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"جاري إرسال الرسالة الخاصة ✉️ ",
      'parse_mode'=>'HTML',
  ]);
$Starttime = microtime(true);
    $file_id = file_get_contents("codes/$code/voice.txt");
    $caption = file_get_contents("codes/$code/caption.txt");
         $list = scandir("channels");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){  
        continue;   
        }else{
 $id = $list[$i];
      $result =  bot('sendvoice',[
   'chat_id'=>$id,
   'voice'=>"$file_id",
   'caption'=>urldecode($caption)
]);
 $lastMessages[] = $result;
$hdhdhdh = $result->result->message_id;
 
 file_put_contents("codes/$code/msgid.txt", "\n". $hdhdhdh, FILE_APPEND);
  file_put_contents("codes/$code/chid.txt", "\n". $id, FILE_APPEND);
if($reportpost == "on"){
$stat = file_get_contents("https://api.telegram.org/bot".api."/getChatMember?chat_id=$id&user_id=$idbot");
$statjson = json_decode($stat, true);
$status = $statjson['result']['status'];
$can = $statjson['result']['can_post_messages'];

if($status != "administrator" and $can != "true"){
      $add_user = file_get_contents("list.txt");
      $add_user .= "• ".$list[$i]."  ";
     file_put_contents("list.txt",$add_user);
     $del = file_get_contents("numdel.txt");
     file_put_contents("numdel.txt",$del + 1);
     
    }else{
             $senda = file_get_contents("numsend.txt");
     file_put_contents("numsend.txt",$senda + 1);
    }

}
}

        }
      
 if($reportpost == "on"){
$del = file_get_contents("numdel.txt");
             $senda = file_get_contents("numsend.txt");
  $listaaaa = file_get_contents("list.txt");
         $endtIme = microtime(true);
$speed = $endtIme - $Starttime;
$risss = round($speed,2);
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️

⚠️ تقرير النشر :- 
تم النشر : $senda / تم الفشل : $del / خلال :- $risss (s)
قنوات لم يتم النشر فيها ($del):
$listaaaa ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
          file_put_contents("list.txt", "");
    file_put_contents("numdel.txt","0");
          file_put_contents("numsend.txt","0");
}else {
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️ ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
}
}else {
            bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"جاري إرسال الرسالة الخاصة ✉️ ",
      'parse_mode'=>'HTML',
  ]);
$Starttime = microtime(true);
         $list = scandir("channels");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){  
        continue;   
        }else{
 $id = $list[$i];
    $listtaaataaara = file_get_contents("codes/$code/inline_keyboard.txt");
        $tttttweeeeexxiwis = file_get_contents("codes/$code/voice.txt");
        $captionssajfnjs = file_get_contents("codes/$code/caption.txt");
      $result = file_get_contents('https://api.telegram.org/bot'.api.'/sendvoice?chat_id='.$id.'&voice='.$tttttweeeeexxiwis.'&caption='.$captionssajfnjs.'&reply_markup={"inline_keyboard":['.$listtaaataaara.']}');
 $lastMessages[] = $result;
 $getjsdonsend = json_decode($result);
 $hdhdhdh = $getjsdonsend->result->message_id;
 
 file_put_contents("codes/$code/msgid.txt", "\n". $hdhdhdh, FILE_APPEND);
  file_put_contents("codes/$code/chid.txt", "\n". $id, FILE_APPEND);
if($reportpost == "on"){
$stat = file_get_contents("https://api.telegram.org/bot".api."/getChatMember?chat_id=$id&user_id=$idbot");
$statjson = json_decode($stat, true);
$status = $statjson['result']['status'];
$can = $statjson['result']['can_post_messages'];

if($status != "administrator" and $can != "true"){
      $add_user = file_get_contents("list.txt");
      $add_user .= "• ".$list[$i]."  ";
     file_put_contents("list.txt",$add_user);
     $del = file_get_contents("numdel.txt");
     file_put_contents("numdel.txt",$del + 1);
     
    }else{
             $senda = file_get_contents("numsend.txt");
     file_put_contents("numsend.txt",$senda + 1);
    }

}
}

        }
      
 if($reportpost == "on"){
$del = file_get_contents("numdel.txt");
             $senda = file_get_contents("numsend.txt");
  $listaaaa = file_get_contents("list.txt");
         $endtIme = microtime(true);
$speed = $endtIme - $Starttime;
$risss = round($speed,2);
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️

⚠️ تقرير النشر :- 
تم النشر : $senda / تم الفشل : $del / خلال :- $risss (s)
قنوات لم يتم النشر فيها ($del):
$listaaaa ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
          file_put_contents("list.txt", "");
    file_put_contents("numdel.txt","0");
          file_put_contents("numsend.txt","0");
}else {
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️ ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
}}
}
if(file_exists("codes/$code/video.txt")){
if(!file_exists("codes/$code/inline_keyboard.txt")){
        bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"جاري إرسال الرسالة الخاصة ✉️ ",
      'parse_mode'=>'HTML',
  ]);
$Starttime = microtime(true);
    $file_id = file_get_contents("codes/$code/video.txt");
    $caption = file_get_contents("codes/$code/caption.txt");
         $list = scandir("channels");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){  
        continue;   
        }else{
 $id = $list[$i];
      $result =  bot('sendvideo',[
   'chat_id'=>$id,
   'video'=>"$file_id",
   'caption'=>urldecode($caption)
]);
 $lastMessages[] = $result;

$hdhdhdh = $result->result->message_id;
 
 file_put_contents("codes/$code/msgid.txt", "\n". $hdhdhdh, FILE_APPEND);
  file_put_contents("codes/$code/chid.txt", "\n". $id, FILE_APPEND);
if($reportpost == "on"){
$stat = file_get_contents("https://api.telegram.org/bot".api."/getChatMember?chat_id=$id&user_id=$idbot");
$statjson = json_decode($stat, true);
$status = $statjson['result']['status'];
$can = $statjson['result']['can_post_messages'];

if($status != "administrator" and $can != "true"){
      $add_user = file_get_contents("list.txt");
      $add_user .= "• ".$list[$i]."  ";
     file_put_contents("list.txt",$add_user);
     $del = file_get_contents("numdel.txt");
     file_put_contents("numdel.txt",$del + 1);
     
    }else{
             $senda = file_get_contents("numsend.txt");
     file_put_contents("numsend.txt",$senda + 1);
    }

}
}

        }
      
 if($reportpost == "on"){
$del = file_get_contents("numdel.txt");
             $senda = file_get_contents("numsend.txt");
  $listaaaa = file_get_contents("list.txt");
         $endtIme = microtime(true);
$speed = $endtIme - $Starttime;
$risss = round($speed,2);
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️

⚠️ تقرير النشر :- 
تم النشر : $senda / تم الفشل : $del / خلال :- $risss (s)
قنوات لم يتم النشر فيها ($del):
$listaaaa ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
          file_put_contents("list.txt", "");
    file_put_contents("numdel.txt","0");
          file_put_contents("numsend.txt","0");
}else {
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️ ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
}
}else {
            bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"جاري إرسال الرسالة الخاصة ✉️ ",
      'parse_mode'=>'HTML',
  ]);
$Starttime = microtime(true);
         $list = scandir("channels");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){  
        continue;   
        }else{
 $id = $list[$i];
    $listtaaataaara = file_get_contents("codes/$code/inline_keyboard.txt");
        $tttttweeeeexxiwis = file_get_contents("codes/$code/video.txt");
        $captionssajfnjs = file_get_contents("codes/$code/caption.txt");
      $result = file_get_contents('https://api.telegram.org/bot'.api.'/sendvideo?chat_id='.$id.'&video='.$tttttweeeeexxiwis.'&caption='.$captionssajfnjs.'&reply_markup={"inline_keyboard":['.$listtaaataaara.']}');
 $lastMessages[] = $result;
 $getjsdonsend = json_decode($result);
 $hdhdhdh = $getjsdonsend->result->message_id;
 
 file_put_contents("codes/$code/msgid.txt", "\n". $hdhdhdh, FILE_APPEND);
  file_put_contents("codes/$code/chid.txt", "\n". $id, FILE_APPEND);
if($reportpost == "on"){
$stat = file_get_contents("https://api.telegram.org/bot".api."/getChatMember?chat_id=$id&user_id=$idbot");
$statjson = json_decode($stat, true);
$status = $statjson['result']['status'];
$can = $statjson['result']['can_post_messages'];

if($status != "administrator" and $can != "true"){
      $add_user = file_get_contents("list.txt");
      $add_user .= "• ".$list[$i]."  ";
     file_put_contents("list.txt",$add_user);
     $del = file_get_contents("numdel.txt");
     file_put_contents("numdel.txt",$del + 1);
     
    }else{
             $senda = file_get_contents("numsend.txt");
     file_put_contents("numsend.txt",$senda + 1);
    }

}
}

        }
      
 if($reportpost == "on"){
$del = file_get_contents("numdel.txt");
             $senda = file_get_contents("numsend.txt");
  $listaaaa = file_get_contents("list.txt");
         $endtIme = microtime(true);
$speed = $endtIme - $Starttime;
$risss = round($speed,2);
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️

⚠️ تقرير النشر :- 
تم النشر : $senda / تم الفشل : $del / خلال :- $risss (s)
قنوات لم يتم النشر فيها ($del):
$listaaaa ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
          file_put_contents("list.txt", "");
    file_put_contents("numdel.txt","0");
          file_put_contents("numsend.txt","0");
}else {
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️ ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
}}
}
if(file_exists("codes/$code/document.txt")){
if(!file_exists("codes/$code/inline_keyboard.txt")){
        bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"جاري إرسال الرسالة الخاصة ✉️ ",
      'parse_mode'=>'HTML',
  ]);
$Starttime = microtime(true);
    $file_id = file_get_contents("codes/$code/document.txt");
    $caption = file_get_contents("codes/$code/caption.txt");
         $list = scandir("channels");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){  
        continue;   
        }else{
 $id = $list[$i];
      $result =  bot('senddocument',[
   'chat_id'=>$id,
   'document'=>"$file_id",
   'caption'=>urldecode($caption)
]);
 $lastMessages[] = $result;

$hdhdhdh = $result->result->message_id;
 
 file_put_contents("codes/$code/msgid.txt", "\n". $hdhdhdh, FILE_APPEND);
  file_put_contents("codes/$code/chid.txt", "\n". $id, FILE_APPEND);
if($reportpost == "on"){
$stat = file_get_contents("https://api.telegram.org/bot".api."/getChatMember?chat_id=$id&user_id=$idbot");
$statjson = json_decode($stat, true);
$status = $statjson['result']['status'];
$can = $statjson['result']['can_post_messages'];

if($status != "administrator" and $can != "true"){
      $add_user = file_get_contents("list.txt");
      $add_user .= "• ".$list[$i]."  ";
     file_put_contents("list.txt",$add_user);
     $del = file_get_contents("numdel.txt");
     file_put_contents("numdel.txt",$del + 1);
     
    }else{
             $senda = file_get_contents("numsend.txt");
     file_put_contents("numsend.txt",$senda + 1);
    }

}
}

        }
      
 if($reportpost == "on"){
$del = file_get_contents("numdel.txt");
             $senda = file_get_contents("numsend.txt");
  $listaaaa = file_get_contents("list.txt");
         $endtIme = microtime(true);
$speed = $endtIme - $Starttime;
$risss = round($speed,2);
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️

⚠️ تقرير النشر :- 
تم النشر : $senda / تم الفشل : $del / خلال :- $risss (s)
قنوات لم يتم النشر فيها ($del):
$listaaaa ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
          file_put_contents("list.txt", "");
    file_put_contents("numdel.txt","0");
          file_put_contents("numsend.txt","0");
}else {
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️ ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
}
}else {
            bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"جاري إرسال الرسالة الخاصة ✉️ ",
      'parse_mode'=>'HTML',
  ]);
$Starttime = microtime(true);
         $list = scandir("channels");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){  
        continue;   
        }else{
 $id = $list[$i];
    $listtaaataaara = file_get_contents("codes/$code/inline_keyboard.txt");
        $tttttweeeeexxiwis = file_get_contents("codes/$code/document.txt");
        $captionssajfnjs = file_get_contents("codes/$code/caption.txt");
      $result = file_get_contents('https://api.telegram.org/bot'.api.'/senddocument?chat_id='.$id.'&document='.$tttttweeeeexxiwis.'&caption='.$captionssajfnjs.'&reply_markup={"inline_keyboard":['.$listtaaataaara.']}');
 $lastMessages[] = $result;
 $getjsdonsend = json_decode($result);
 $hdhdhdh = $getjsdonsend->result->message_id;
 
 file_put_contents("codes/$code/msgid.txt", "\n". $hdhdhdh, FILE_APPEND);
  file_put_contents("codes/$code/chid.txt", "\n". $id, FILE_APPEND);

if($reportpost == "on"){
$stat = file_get_contents("https://api.telegram.org/bot".api."/getChatMember?chat_id=$id&user_id=$idbot");
$statjson = json_decode($stat, true);
$status = $statjson['result']['status'];
$can = $statjson['result']['can_post_messages'];

if($status != "administrator" and $can != "true"){
      $add_user = file_get_contents("list.txt");
      $add_user .= "• ".$list[$i]."  ";
     file_put_contents("list.txt",$add_user);
     $del = file_get_contents("numdel.txt");
     file_put_contents("numdel.txt",$del + 1);
     
    }else{
             $senda = file_get_contents("numsend.txt");
     file_put_contents("numsend.txt",$senda + 1);
    }

}
}

        }
      
 if($reportpost == "on"){
$del = file_get_contents("numdel.txt");
             $senda = file_get_contents("numsend.txt");
  $listaaaa = file_get_contents("list.txt");
         $endtIme = microtime(true);
$speed = $endtIme - $Starttime;
$risss = round($speed,2);
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️

⚠️ تقرير النشر :- 
تم النشر : $senda / تم الفشل : $del / خلال :- $risss (s)
قنوات لم يتم النشر فيها ($del):
$listaaaa ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
          file_put_contents("list.txt", "");
    file_put_contents("numdel.txt","0");
          file_put_contents("numsend.txt","0");
}else {
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️ ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
}}
}
if(file_exists("codes/$code/audio.txt")){
if(!file_exists("codes/$code/inline_keyboard.txt")){
        bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"جاري إرسال الرسالة الخاصة ✉️ ",
      'parse_mode'=>'HTML',
  ]);
$Starttime = microtime(true);
    $file_id = file_get_contents("codes/$code/audio.txt");
$caption = file_get_contents("codes/$code/caption.txt");
         $list = scandir("channels");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){  
        continue;   
        }else{
 $id = $list[$i];
      $result =  bot('sendaudio',[
   'chat_id'=>$id,
   'audio'=>"$file_id",
   'caption'=>urldecode($caption)
]);
 $lastMessages[] = $result;

$hdhdhdh = $result->result->message_id;
 
 file_put_contents("codes/$code/msgid.txt", "\n". $hdhdhdh, FILE_APPEND);
  file_put_contents("codes/$code/chid.txt", "\n". $id, FILE_APPEND);
if($reportpost == "on"){
$stat = file_get_contents("https://api.telegram.org/bot".api."/getChatMember?chat_id=$id&user_id=$idbot");
$statjson = json_decode($stat, true);
$status = $statjson['result']['status'];
$can = $statjson['result']['can_post_messages'];

if($status != "administrator" and $can != "true"){
      $add_user = file_get_contents("list.txt");
      $add_user .= "• ".$list[$i]."  ";
     file_put_contents("list.txt",$add_user);
     $del = file_get_contents("numdel.txt");
     file_put_contents("numdel.txt",$del + 1);
     
    }else{
             $senda = file_get_contents("numsend.txt");
     file_put_contents("numsend.txt",$senda + 1);
    }

}
}

        }
      
 if($reportpost == "on"){
$del = file_get_contents("numdel.txt");
             $senda = file_get_contents("numsend.txt");
  $listaaaa = file_get_contents("list.txt");
         $endtIme = microtime(true);
$speed = $endtIme - $Starttime;
$risss = round($speed,2);
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️

⚠️ تقرير النشر :- 
تم النشر : $senda / تم الفشل : $del / خلال :- $risss (s)
قنوات لم يتم النشر فيها ($del):
$listaaaa ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
          file_put_contents("list.txt", "");
    file_put_contents("numdel.txt","0");
          file_put_contents("numsend.txt","0");
}else {
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️ ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
}
}else {
            bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"جاري إرسال الرسالة الخاصة ✉️ ",
      'parse_mode'=>'HTML',
  ]);
$Starttime = microtime(true);
         $list = scandir("channels");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){  
        continue;   
        }else{
 $id = $list[$i];
    $listtaaataaara = file_get_contents("codes/$code/inline_keyboard.txt");
        $tttttweeeeexxiwis = file_get_contents("codes/$code/audio.txt");
        $captionssajfnjs = file_get_contents("codes/$code/caption.txt");
      $result = file_get_contents('https://api.telegram.org/bot'.api.'/sendaudio?chat_id='.$id.'&audio='.$tttttweeeeexxiwis.'&caption='.$captionssajfnjs.'&reply_markup={"inline_keyboard":['.$listtaaataaara.']}');
 $lastMessages[] = $result;
 $getjsdonsend = json_decode($result);
 $hdhdhdh = $getjsdonsend->result->message_id;
 
 file_put_contents("codes/$code/msgid.txt", "\n". $hdhdhdh, FILE_APPEND);
  file_put_contents("codes/$code/chid.txt", "\n". $id, FILE_APPEND);
if($reportpost == "on"){
$stat = file_get_contents("https://api.telegram.org/bot".api."/getChatMember?chat_id=$id&user_id=$idbot");
$statjson = json_decode($stat, true);
$status = $statjson['result']['status'];
$can = $statjson['result']['can_post_messages'];

if($status != "administrator" and $can != "true"){
      $add_user = file_get_contents("list.txt");
      $add_user .= "• ".$list[$i]."  ";
     file_put_contents("list.txt",$add_user);
     $del = file_get_contents("numdel.txt");
     file_put_contents("numdel.txt",$del + 1);
     
    }else{
             $senda = file_get_contents("numsend.txt");
     file_put_contents("numsend.txt",$senda + 1);
    }

}
}

        }
      
 if($reportpost == "on"){
$del = file_get_contents("numdel.txt");
             $senda = file_get_contents("numsend.txt");
  $listaaaa = file_get_contents("list.txt");
         $endtIme = microtime(true);
$speed = $endtIme - $Starttime;
$risss = round($speed,2);
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️

⚠️ تقرير النشر :- 
تم النشر : $senda / تم الفشل : $del / خلال :- $risss (s)
قنوات لم يتم النشر فيها ($del):
$listaaaa ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
          file_put_contents("list.txt", "");
    file_put_contents("numdel.txt","0");
          file_put_contents("numsend.txt","0");
}else {
bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال الرسالة الخاصة بنجاح ☑️ ",
      'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"حذف الرسالة ❌",'callback_data'=>"$code"],
                        ]
                ]
            ])
  ]);
}}
}
//--------------- 
}else {
    bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"هذه الرسالة تم نشرها في القنوات بالفعل ✅",
      'parse_mode'=>'HTML',
  ]);
}
}else {
    bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"لا يوجد رقم رسالة مخصصه بهذا الأسم : $code",
      'parse_mode'=>'HTML',
  ]);
}
}else {
        bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"عدد القنوات المضافة قليل جداً",
      'parse_mode'=>'HTML',
  ]);
}
}


if(preg_match("/^\/(del) (.*)/s",$textmsg)){
  preg_match("/^\/(del) (.*)/s",$textmsg,$matchaa);
  $code = $matchaa[2];
 if(file_exists("codes/$code/msgid.txt")){
  $Starttime = microtime(true);
  $txt = file_get_contents("codes/$code/msgid.txt");
$msgids = explode("\n", $txt);
  $txt2 = file_get_contents("codes/$code/chid.txt");
$chids = explode("\n", $txt2);
$sperds = count($msgids); 
  bot('editMessageText',[
   'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"جاري حذف الرسالة الخاصة من كل القنوات ❌"
  ]);
for($y=0;$y<count($msgids); $y++){
   file_get_contents("https://api.telegram.org/bot".api."/deleteMessage?chat_id=".$chids[$y]."&message_id=".$msgids[$y]);
}
    $reportdel = file_get_contents("texts/reportdel.txt");
if($reportdel == "on"){
  $list = scandir("channels");
for($i=0;$i<count($list);$i++) {
if( $list[$i] == "." or $list[$i] == ".." ){  
        continue;   
        }else{
 $id = $list[$i];
   $stat = file_get_contents("https://api.telegram.org/bot".api."/getChatMember?chat_id=$id&user_id=$idbot");
$statjson = json_decode($stat, true);
$status = $statjson['result']['status'];
$can = $statjson['result']['can_delete_messages'];

if($status != "administrator" and $can != "true"){
      $add_user = file_get_contents("list.txt");
      $add_user .= "• ".$list[$i]."  ";
     file_put_contents("list.txt",$add_user);
     $del = file_get_contents("numdel.txt");
     file_put_contents("numdel.txt",$del + 1);
     
    }else{
             $senda = file_get_contents("numsend.txt");
     file_put_contents("numsend.txt",$senda + 1);
    }
}
}
     $del = file_get_contents("numdel.txt");
             $senda = file_get_contents("numsend.txt");
  $listaaaa = file_get_contents("list.txt");
  $endtIme = microtime(true);
$speed = $endtIme - $Starttime;
$risss = round($speed,2);
}
if($reportdel == "on"){
  bot('editMessageText',[
   'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"تم حذف الرسالة الخاصة بنجاح ✅ 

⚠️ تقرير الحذف :- 
تم الحذف : $senda / تم الفشل : $del / خلال :- $risss (s)
قنوات لم يتم الحذف فيها ($del):
$listaaaa",
      'parse_mode'=>'HTML'
  ]);
          file_put_contents("list.txt", "");
    file_put_contents("numdel.txt","0");
          file_put_contents("numsend.txt","0");
}else {
      bot('editMessageText',[
   'chat_id'=>$chat_id,
    'message_id'=>$message_id,
    'text'=>"تم حذف الرسالة الخاصة بنجاح ✅",
      'parse_mode'=>'HTML'
  ]);
}
 unlink("codes/$code/msgid.txt");
  unlink("codes/$code/chid.txt");
  
}else {
           bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"عذراً أما تم حذف الرسالة الخاصه بالفعل أو لا توجد رسالة⚠️"
   ]);
}
}
//--------------------------
}

$addpp = file_get_contents("texts/addp.txt");
if($addpp == "on" and $chat_id != "$idgp"){
$max = file_get_contents("texts/max.txt");
if(preg_match("/^\/(add) (.*)/s",$textmsg)){
  preg_match("/^\/(add) (.*)/s",$textmsg,$matchaa);
 $fu = $matchaa[2];
 $url = "http://api.telegram.org/bot".api."/getChatMembersCount?chat_id=$fu";
$get = file_get_contents($url);
$json = json_decode($get);
$res  = $json->result;
if($res>=$max){
//-------------------------- 
   $getChatReqw = file_get_contents("https://api.telegram.org/bot".api."/getChat?chat_id=".$fu);
  $getChatResw = json_decode($getChatReqw, true);
 $idw = $getChatResw['result']['id'];
if (!file_exists("channels/$idw")){
$stat = file_get_contents("https://api.telegram.org/bot".api."/getChatMember?chat_id=$fu&user_id=$idbot");
$statjson = json_decode($stat, true);
$status = $statjson['result']['status'];
if($status == "administrator"){
  $getChatReq = file_get_contents("https://api.telegram.org/bot".api."/getChat?chat_id=".$fu);
  $getChatRes = json_decode($getChatReq, true);
 $id = $getChatRes['result']['id'];
 
     $url = "http://api.telegram.org/bot".api."/getChatMembersCount?chat_id=".$fu;
$get = file_get_contents($url);
$json = json_decode($get);
$res  = $json->result;
file_put_contents("members/".$id,"$res");
 
 file_put_contents("channels/$id","$id");
     bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"القناة ($fu) تمت اضافتها بنجاح ✅",
      'parse_mode'=>'HTML',
  ]);
}else {
        bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"يرجى ترقية البوت مشرف في القناة ( $fu ) أولاً 👤",
      'parse_mode'=>'HTML',
  ]);
}
}else {
         bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"القناة ( $fu ) تمت أضافتها بالفعل ☑️",
      'parse_mode'=>'HTML',
  ]);
}
}else {
           bot('SendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"عدد مشتركي قناتك لا يناسب العدد الاقصى ($max) للأضافة 👍",
      'parse_mode'=>'HTML',
  ]);  
}
//--------------------------
}
}

if($textmsg=="/start" and $chat_id==$mhmd){
mkdir("data/$from_id");
$start = file_get_contents("start.txt");
   bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>" مرحباً بك في بوت صنع رسائل خاصة بالدعم المشترك   📋",
   'parse_mode'=>'HTML',
'disable_web_page_preview'=>'true',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
[['text'=>"انشـاء كود 📝",'callback_data'=>"Make_Code"] , ['text'=>"كيفية  استعمال البوت 📝",'callback_data'=>"help"]],
[['text'=>"تواصل مع المطور ",'url'=>"https://t.me/jalall_kh"]],
]
])
]);
    
}elseif ($textmsg=="/start") {
 bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"مرحباً بك في بوت صنع رسائل خاصة بالدعم المشترك   📋",
    'parse_mode'=>'HTML',
'disable_web_page_preview'=>'true',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
       [['text'=>"تواصل مع المطور لصنع بوتك الخاص ",'url'=>"https://t.me/jalall_kh"]],
]
])
]);           
}

$settings = file_get_contents("data/$from_id/settings.txt");

if($settings == "Make_Code" and $from_id != "$idbot" and $chat_id != "$idgp"){
//------------------------
if($textmsg){
$code = file_get_contents("data/$from_id/settings2.txt");
$aaa = str_replace('="',"='",$textmsg);
$bbb = str_replace('">',"'>" ,$aaa);
file_put_contents("codes/$code/text.txt",urlencode("$bbb"));
 bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"$textmsg",
   'parse_mode'=>'HTML',
'disable_web_page_preview'=>'true' 
]);
  bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"هل تريد إضافة قوائم شفافة ؟ 📑",
   'parse_mode'=>'HTML',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"نعم 👍",'callback_data'=>"save_msg"],['text'=>"لا 👎",'callback_data'=>"re_msg"],
                        ]
                ]
            ])
]);
}
if($message->sticker){
    $code = file_get_contents("data/$from_id/settings2.txt");
    $file_id = $message->sticker->file_id;
file_put_contents("codes/$code/sticker.txt","$file_id");
 bot('sendsticker',[
   'chat_id'=>$chat_id,
   'sticker'=>"$file_id"
]);
  bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"هل تريد إضافة قوائم شفافة ؟ 📑",
   'parse_mode'=>'HTML',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"نعم 👍",'callback_data'=>"save_msg"],['text'=>"لا 👎",'callback_data'=>"re_msg"],
                        ]
                ]
            ])
]);
}
if($message->voice){
    $code = file_get_contents("data/$from_id/settings2.txt");
    $file_id = $message->voice->file_id;
 $voice = $message->voice;
$file = $voice->file_id;
      $get = bot('getfile',['file_id'=>$file]);
      $patch = $get->result->file_path;
$caption = $update->message->caption;
file_put_contents("codes/$code/caption.txt",urlencode($caption));
file_put_contents("codes/$code/voice.txt",$file);
 bot('sendvoice',[
   'chat_id'=>$chat_id,
   'voice'=>"$file_id",
    'caption'=>"$caption"
]);
  bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"هل تريد إضافة قوائم شفافة ؟ 📑",
   'parse_mode'=>'HTML',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"نعم 👍",'callback_data'=>"save_msg"],['text'=>"لا 👎",'callback_data'=>"re_msg"],
                        ]
                ]
            ])
]);
}
if($message->video){
    $code = file_get_contents("data/$from_id/settings2.txt");
     $video = $message->video;
$file = $video->file_id;
$caption = $update->message->caption;
file_put_contents("codes/$code/caption.txt",urlencode($caption));
file_put_contents("codes/$code/video.txt",$file);
 bot('sendvideo',[
   'chat_id'=>$chat_id,
   'video'=>"$file",
    'caption'=>"$caption"
]);
  bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"هل تريد إضافة قوائم شفافة ؟ 📑",
   'parse_mode'=>'HTML',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"نعم 👍",'callback_data'=>"save_msg"],['text'=>"لا 👎",'callback_data'=>"re_msg"],
                        ]
                ]
            ])
]);
}
if($message->document){
    $code = file_get_contents("data/$from_id/settings2.txt");
     $document = $message->document;
$file = $document->file_id;
$caption = $update->message->caption;
file_put_contents("codes/$code/caption.txt",urlencode($caption));
file_put_contents("codes/$code/document.txt",$file);
 bot('senddocument',[
   'chat_id'=>$chat_id,
   'document'=>"$file",
    'caption'=>"$caption"
]);
  bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"هل تريد إضافة قوائم شفافة ؟ 📑",
   'parse_mode'=>'HTML',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"نعم 👍",'callback_data'=>"save_msg"],['text'=>"لا 👎",'callback_data'=>"re_msg"],
                        ]
                ]
            ])
]);
}
if($message->photo){
    $code = file_get_contents("data/$from_id/settings2.txt");
     $photo = $message->photo;
$file = $update->message->photo[1]->file_id;
$caption = $update->message->caption;
file_put_contents("codes/$code/caption.txt",urlencode($caption));
file_put_contents("codes/$code/photo.txt",$file);
 bot('sendphoto',[
   'chat_id'=>$chat_id,
   'photo'=>"$file",
    'caption'=>"$caption"
]);
  bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"هل تريد إضافة قوائم شفافة ؟ 📑",
   'parse_mode'=>'HTML',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"نعم 👍",'callback_data'=>"save_msg"],['text'=>"لا 👎",'callback_data'=>"re_msg"],
                        ]
                ]
            ])
]);
}
if($message->audio){
    $code = file_get_contents("data/$from_id/settings2.txt");
     $audio = $message->audio;
$file = $audio->file_id;
$caption = $update->message->caption;
file_put_contents("codes/$code/caption.txt",urlencode($caption));
file_put_contents("codes/$code/audio.txt",$file);
 bot('sendaudio',[
   'chat_id'=>$chat_id,
   'audio'=>"$file",
    'caption'=>"$caption"
]);
  bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"هل تريد إضافة قوائم شفافة ؟ 📑",
   'parse_mode'=>'HTML',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"نعم 👍",'callback_data'=>"save_msg"],['text'=>"لا 👎",'callback_data'=>"re_msg"],
                        ]
                ]
            ])
]);
}
}
if($settings == "create_keyborad" and $from_id != "$idbot" and $textmsg and $chat_id != "$idgp"){
$code = file_get_contents("data/$from_id/settings2.txt");
if(file_exists("codes/$code/text.txt")){
$tttttweeeeexxiwis = file_get_contents("codes/$code/text.txt");
$aaa = str_replace(" = ","=",$textmsg);
$bbb = str_replace(" =","=" ,$aaa);
$ccc = str_replace("= ","=",$bbb);
$ddd = str_replace(" + ","+",$ccc);
$eee = str_replace(" +","=",$ddd);
$fff = str_replace("+ ","+",$eee);
$ggg = str_replace("+"," + ",$fff);
$hhh = str_replace("="," = ",$ggg);

 $ex = explode("\n", $hhh);
for ($i=0; $i < count($ex); $i++) { 
if(preg_match("/^(.*) = (.*)/s",$ex[$i])){
    $olink2 = explode(" ", $ex[$i]);
if(!in_array("+", $olink2)){
  preg_match("/^(.*) = (.*)/s",$ex[$i],$match);
if($match[1] != ""){
$nnnnaaa = count($ex);
$nnnnaaahs = $nnnnaaa -1;
if($i != $nnnnaaahs){
$listt = '[{"text":"'.urlencode($match[1]).'","url":"'.urlencode($match[2]).'"}],';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);
}else {
 $listt = '[{"text":"'.urlencode($match[1]).'","url":"'.urlencode($match[2]).'"}]';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);   
}


}
//-----------------------------
}else{
//----------------- 
file_put_contents("codes/$code/inline_keyboard.txt","[",FILE_APPEND);
$aajndfjvfhwbvhavb =  explode(" + ", $ex[$i]);
for ($a=0; $a < 12; $a++) { 
list($list[1], $list[2], $list[3], $list[4], $list[5], $list[6], $list[7], $list[8], $list[9], $list[10]) = explode(" + ", $ex[$i]);
 preg_match("/^(.*) = (.*)/s",$list[$a],$matcheuue);
if($matcheuue[1] != ""){
//----------------
$nnnnaaa = count($aajndfjvfhwbvhavb);
if($a != $nnnnaaa){
$listt = '{"text":"'.urlencode($matcheuue[1]).'","url":"'.urlencode($matcheuue[2]).'"},';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);
}else {
$listt = '{"text":"'.urlencode($matcheuue[1]).'","url":"'.urlencode($matcheuue[2]).'"}';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND); 
}


//--------------------
}
}
$nnnnaaa = count($ex);
$nnnnaaahs = $nnnnaaa -1;
if($i != $nnnnaaahs){
$listt = '],';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);
}else {
 $listt = '],[{"text":"'.urlencode('Luminary💫♥️لومِـنـَري').'","url":"'.urlencode('https://t.me/luminary1').'" }] ';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);   
}
//-----------------    
}
}
}
$listtaaataaara = file_get_contents("codes/$code/inline_keyboard.txt");
file_get_contents('https://api.telegram.org/bot'.api.'/sendMessage?chat_id='.$chat_id.'&text='.$tttttweeeeexxiwis.'&parse_mode=HTML&disable_web_page_preview=true&reply_markup={"inline_keyboard":['.$listtaaataaara.']}');
 bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"<code>@$usernamebot $code</code>",
   'parse_mode'=>'HTML',
'disable_web_page_preview'=>'true',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"إنشاء رسالة خاصة 📃",'callback_data'=>"Make_Code"],
                        ]
                ]
            ])
]);
        file_put_contents("data/$from_id/settings.txt","");
}


if(file_exists("codes/$code/sticker.txt")){
$tttttweeeeexxiwis = file_get_contents("codes/$code/sticker.txt");
$aaa = str_replace(" = ","=",$textmsg);
$bbb = str_replace(" =","=" ,$aaa);
$ccc = str_replace("= ","=",$bbb);
$ddd = str_replace(" + ","+",$ccc);
$eee = str_replace(" +","=",$ddd);
$fff = str_replace("+ ","+",$eee);
$ggg = str_replace("+"," + ",$fff);
$hhh = str_replace("="," = ",$ggg);

 $ex = explode("\n", $hhh);
for ($i=0; $i < count($ex); $i++) { 
if(preg_match("/^(.*) = (.*)/s",$ex[$i])){
    $olink2 = explode(" ", $ex[$i]);
if(!in_array("+", $olink2)){
  preg_match("/^(.*) = (.*)/s",$ex[$i],$match);
if($match[1] != ""){
$nnnnaaa = count($ex);
$nnnnaaahs = $nnnnaaa -1;
if($i != $nnnnaaahs){
$listt = '[{"text":"'.urlencode($match[1]).'","url":"'.urlencode($match[2]).'"}],';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);
}else {
 $listt = '[{"text":"'.urlencode($match[1]).'","url":"'.urlencode($match[2]).'"}]';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);   
}


}
//-----------------------------
}else{
//----------------- 
file_put_contents("codes/$code/inline_keyboard.txt","[",FILE_APPEND);
$aajndfjvfhwbvhavb =  explode(" + ", $ex[$i]);
for ($a=0; $a < 12; $a++) { 
list($list[1], $list[2], $list[3], $list[4], $list[5], $list[6], $list[7], $list[8], $list[9], $list[10]) = explode(" + ", $ex[$i]);
 preg_match("/^(.*) = (.*)/s",$list[$a],$matcheuue);
if($matcheuue[1] != ""){
//----------------
$nnnnaaa = count($aajndfjvfhwbvhavb);
if($a != $nnnnaaa){
$listt = '{"text":"'.urlencode($matcheuue[1]).'","url":"'.urlencode($matcheuue[2]).'"},';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);
}else {
$listt = '{"text":"'.urlencode($matcheuue[1]).'","url":"'.urlencode($matcheuue[2]).'"}';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND); 
}


//--------------------
}
}
$nnnnaaa = count($ex);
$nnnnaaahs = $nnnnaaa -1;
if($i != $nnnnaaahs){
$listt = '],';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);
}else {
 $listt = '],[{"text":"'.urlencode('Luminary💫♥️لومِـنـَري').'","url":"'.urlencode('https://t.me/luminary1').'" }] ';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);   
}
//-----------------    
}
}
}
$listtaaataaara = file_get_contents("codes/$code/inline_keyboard.txt");
file_get_contents('https://api.telegram.org/bot'.api.'/sendsticker?chat_id='.$chat_id.'&sticker='.$tttttweeeeexxiwis.'&reply_markup={"inline_keyboard":['.$listtaaataaara.']}');
 bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"<code>@$usernamebot $code</code>",
   'parse_mode'=>'HTML',
'disable_web_page_preview'=>'true',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"إنشاء رسالة خاصة 📃",'callback_data'=>"Make_Code"],
                        ]
                ]
            ])
]);
        file_put_contents("data/$from_id/settings.txt","");
}
if(file_exists("codes/$code/voice.txt")){
$aaa = str_replace(" = ","=",$textmsg);
$bbb = str_replace(" =","=" ,$aaa);
$ccc = str_replace("= ","=",$bbb);
$ddd = str_replace(" + ","+",$ccc);
$eee = str_replace(" +","=",$ddd);
$fff = str_replace("+ ","+",$eee);
$ggg = str_replace("+"," + ",$fff);
$hhh = str_replace("="," = ",$ggg);

 $ex = explode("\n", $hhh);
for ($i=0; $i < count($ex); $i++) { 
if(preg_match("/^(.*) = (.*)/s",$ex[$i])){
    $olink2 = explode(" ", $ex[$i]);
if(!in_array("+", $olink2)){
  preg_match("/^(.*) = (.*)/s",$ex[$i],$match);
if($match[1] != ""){
$nnnnaaa = count($ex);
$nnnnaaahs = $nnnnaaa -1;
if($i != $nnnnaaahs){
$listt = '[{"text":"'.urlencode($match[1]).'","url":"'.urlencode($match[2]).'"}],';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);
}else {
 $listt = '[{"text":"'.urlencode($match[1]).'","url":"'.urlencode($match[2]).'"}]';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);   
}


}
//-----------------------------
}else{
//----------------- 
file_put_contents("codes/$code/inline_keyboard.txt","[",FILE_APPEND);
$aajndfjvfhwbvhavb =  explode(" + ", $ex[$i]);
for ($a=0; $a < 12; $a++) { 
list($list[1], $list[2], $list[3], $list[4], $list[5], $list[6], $list[7], $list[8], $list[9], $list[10]) = explode(" + ", $ex[$i]);
 preg_match("/^(.*) = (.*)/s",$list[$a],$matcheuue);
if($matcheuue[1] != ""){
//----------------
$nnnnaaa = count($aajndfjvfhwbvhavb);
if($a != $nnnnaaa){
$listt = '{"text":"'.urlencode($matcheuue[1]).'","url":"'.urlencode($matcheuue[2]).'"},';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);
}else {
$listt = '{"text":"'.urlencode($matcheuue[1]).'","url":"'.urlencode($matcheuue[2]).'"}';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND); 
}


//--------------------
}
}
$nnnnaaa = count($ex);
$nnnnaaahs = $nnnnaaa -1;
if($i != $nnnnaaahs){
$listt = '],';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);
}else {
 $listt = '],[{"text":"'.urlencode('Luminary💫♥️لومِـنـَري').'","url":"'.urlencode('https://t.me/luminary1').'" }] ';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);   
}
//-----------------    
}
}
}
$captionjhdbv = file_get_contents("codes/$code/caption.txt");
$urllllvoicd = file_get_contents("codes/$code/voice.txt");

$listtaaataaara = file_get_contents("codes/$code/inline_keyboard.txt");
file_get_contents('https://api.telegram.org/bot'.api.'/sendvoice?chat_id='.$chat_id.'&voice='.$urllllvoicd.'&caption='.$captionjhdbv.'&reply_markup={"inline_keyboard":['.$listtaaataaara.']}');

 bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"<code>@$usernamebot $code</code>",
   'parse_mode'=>'HTML',
'disable_web_page_preview'=>'true',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"إنشاء رسالة خاصة 📃",'callback_data'=>"Make_Code"],
                        ]
                ]
            ])
]);
        file_put_contents("data/$from_id/settings.txt","");
}
if(file_exists("codes/$code/video.txt")){
$aaa = str_replace(" = ","=",$textmsg);
$bbb = str_replace(" =","=" ,$aaa);
$ccc = str_replace("= ","=",$bbb);
$ddd = str_replace(" + ","+",$ccc);
$eee = str_replace(" +","=",$ddd);
$fff = str_replace("+ ","+",$eee);
$ggg = str_replace("+"," + ",$fff);
$hhh = str_replace("="," = ",$ggg);

 $ex = explode("\n", $hhh);
for ($i=0; $i < count($ex); $i++) { 
if(preg_match("/^(.*) = (.*)/s",$ex[$i])){
    $olink2 = explode(" ", $ex[$i]);
if(!in_array("+", $olink2)){
  preg_match("/^(.*) = (.*)/s",$ex[$i],$match);
if($match[1] != ""){
$nnnnaaa = count($ex);
$nnnnaaahs = $nnnnaaa -1;
if($i != $nnnnaaahs){
$listt = '[{"text":"'.urlencode($match[1]).'","url":"'.urlencode($match[2]).'"}],';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);
}else {
 $listt = '[{"text":"'.urlencode($match[1]).'","url":"'.urlencode($match[2]).'"}]';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);   
}


}
//-----------------------------
}else{
//----------------- 
file_put_contents("codes/$code/inline_keyboard.txt","[",FILE_APPEND);
$aajndfjvfhwbvhavb =  explode(" + ", $ex[$i]);
for ($a=0; $a < 12; $a++) { 
list($list[1], $list[2], $list[3], $list[4], $list[5], $list[6], $list[7], $list[8], $list[9], $list[10]) = explode(" + ", $ex[$i]);
 preg_match("/^(.*) = (.*)/s",$list[$a],$matcheuue);
if($matcheuue[1] != ""){
//----------------
$nnnnaaa = count($aajndfjvfhwbvhavb);
if($a != $nnnnaaa){
$listt = '{"text":"'.urlencode($matcheuue[1]).'","url":"'.urlencode($matcheuue[2]).'"},';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);
}else {
$listt = '{"text":"'.urlencode($matcheuue[1]).'","url":"'.urlencode($matcheuue[2]).'"}';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND); 
}


//--------------------
}
}
$nnnnaaa = count($ex);
$nnnnaaahs = $nnnnaaa -1;
if($i != $nnnnaaahs){
$listt = '],';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);
}else {
 $listt = '],[{"text":"'.urlencode('Luminary💫♥️لومِـنـَري').'","url":"'.urlencode('https://t.me/luminary1').'" }] ';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);   
}
//-----------------    
}
}
}
$captionjhdbv = file_get_contents("codes/$code/caption.txt");
$urllllvoicd = file_get_contents("codes/$code/video.txt");

$listtaaataaara = file_get_contents("codes/$code/inline_keyboard.txt");
file_get_contents('https://api.telegram.org/bot'.api.'/sendvideo?chat_id='.$chat_id.'&video='.$urllllvoicd.'&caption='.$captionjhdbv.'&reply_markup={"inline_keyboard":['.$listtaaataaara.']}');

 bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"<code>@$usernamebot $code</code>",
   'parse_mode'=>'HTML',
'disable_web_page_preview'=>'true',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"إنشاء رسالة خاصة 📃",'callback_data'=>"Make_Code"],
                        ]
                ]
            ])
]);
        file_put_contents("data/$from_id/settings.txt","");
}
if(file_exists("codes/$code/photo.txt")){
$aaa = str_replace(" = ","=",$textmsg);
$bbb = str_replace(" =","=" ,$aaa);
$ccc = str_replace("= ","=",$bbb);
$ddd = str_replace(" + ","+",$ccc);
$eee = str_replace(" +","=",$ddd);
$fff = str_replace("+ ","+",$eee);
$ggg = str_replace("+"," + ",$fff);
$hhh = str_replace("="," = ",$ggg);

 $ex = explode("\n", $hhh);
for ($i=0; $i < count($ex); $i++) { 
if(preg_match("/^(.*) = (.*)/s",$ex[$i])){
    $olink2 = explode(" ", $ex[$i]);
if(!in_array("+", $olink2)){
  preg_match("/^(.*) = (.*)/s",$ex[$i],$match);
if($match[1] != ""){
$nnnnaaa = count($ex);
$nnnnaaahs = $nnnnaaa -1;
if($i != $nnnnaaahs){
$listt = '[{"text":"'.urlencode($match[1]).'","url":"'.urlencode($match[2]).'"}],';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);
}else {
 $listt = '[{"text":"'.urlencode($match[1]).'","url":"'.urlencode($match[2]).'"}]';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);   
}


}
//-----------------------------
}else{
//----------------- 
file_put_contents("codes/$code/inline_keyboard.txt","[",FILE_APPEND);
$aajndfjvfhwbvhavb =  explode(" + ", $ex[$i]);
for ($a=0; $a < 12; $a++) { 
list($list[1], $list[2], $list[3], $list[4], $list[5], $list[6], $list[7], $list[8], $list[9], $list[10]) = explode(" + ", $ex[$i]);
 preg_match("/^(.*) = (.*)/s",$list[$a],$matcheuue);
if($matcheuue[1] != ""){
//----------------
$nnnnaaa = count($aajndfjvfhwbvhavb);
if($a != $nnnnaaa){
$listt = '{"text":"'.urlencode($matcheuue[1]).'","url":"'.urlencode($matcheuue[2]).'"},';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);
}else {
$listt = '{"text":"'.urlencode($matcheuue[1]).'","url":"'.urlencode($matcheuue[2]).'"}';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND); 
}


//--------------------
}
}
$nnnnaaa = count($ex);
$nnnnaaahs = $nnnnaaa -1;
if($i != $nnnnaaahs){
$listt = '],';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);
}else {
 $listt = '],[{"text":"'.urlencode('Luminary💫♥️لومِـنـَري').'","url":"'.urlencode('https://t.me/luminary1').'" }] ';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);   
}
//-----------------    
}
}
}
$captionjhdbv = file_get_contents("codes/$code/caption.txt");
$urllllvoicd = file_get_contents("codes/$code/photo.txt");

$listtaaataaara = file_get_contents("codes/$code/inline_keyboard.txt");
file_get_contents('https://api.telegram.org/bot'.api.'/sendphoto?chat_id='.$chat_id.'&photo='.$urllllvoicd.'&caption='.$captionjhdbv.'&reply_markup={"inline_keyboard":['.$listtaaataaara.']}');

 bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"<code>@$usernamebot $code</code>",
   'parse_mode'=>'HTML',
'disable_web_page_preview'=>'true',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"إنشاء رسالة خاصة 📃",'callback_data'=>"Make_Code"],
                        ]
                ]
            ])
]);
        file_put_contents("data/$from_id/settings.txt","");
}
if(file_exists("codes/$code/audio.txt")){
$aaa = str_replace(" = ","=",$textmsg);
$bbb = str_replace(" =","=" ,$aaa);
$ccc = str_replace("= ","=",$bbb);
$ddd = str_replace(" + ","+",$ccc);
$eee = str_replace(" +","=",$ddd);
$fff = str_replace("+ ","+",$eee);
$ggg = str_replace("+"," + ",$fff);
$hhh = str_replace("="," = ",$ggg);

 $ex = explode("\n", $hhh);
for ($i=0; $i < count($ex); $i++) { 
if(preg_match("/^(.*) = (.*)/s",$ex[$i])){
    $olink2 = explode(" ", $ex[$i]);
if(!in_array("+", $olink2)){
  preg_match("/^(.*) = (.*)/s",$ex[$i],$match);
if($match[1] != ""){
$nnnnaaa = count($ex);
$nnnnaaahs = $nnnnaaa -1;
if($i != $nnnnaaahs){
$listt = '[{"text":"'.urlencode($match[1]).'","url":"'.urlencode($match[2]).'"}],';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);
}else {
 $listt = '[{"text":"'.urlencode($match[1]).'","url":"'.urlencode($match[2]).'"}]';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);   
}


}
//-----------------------------
}else{
//----------------- 
file_put_contents("codes/$code/inline_keyboard.txt","[",FILE_APPEND);
$aajndfjvfhwbvhavb =  explode(" + ", $ex[$i]);
for ($a=0; $a < 12; $a++) { 
list($list[1], $list[2], $list[3], $list[4], $list[5], $list[6], $list[7], $list[8], $list[9], $list[10]) = explode(" + ", $ex[$i]);
 preg_match("/^(.*) = (.*)/s",$list[$a],$matcheuue);
if($matcheuue[1] != ""){
//----------------
$nnnnaaa = count($aajndfjvfhwbvhavb);
if($a != $nnnnaaa){
$listt = '{"text":"'.urlencode($matcheuue[1]).'","url":"'.urlencode($matcheuue[2]).'"},';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);
}else {
$listt = '{"text":"'.urlencode($matcheuue[1]).'","url":"'.urlencode($matcheuue[2]).'"}';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND); 
}


//--------------------
}
}
$nnnnaaa = count($ex);
$nnnnaaahs = $nnnnaaa -1;
if($i != $nnnnaaahs){
$listt = '],';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);
}else {
 $listt = '],[{"text":"'.urlencode('Luminary💫♥️لومِـنـَري').'","url":"'.urlencode('https://t.me/luminary1').'" }]';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);   
}
//-----------------    
}
}
}
$captionjhdbv = file_get_contents("codes/$code/caption.txt");
$urllllvoicd = file_get_contents("codes/$code/audio.txt");

$listtaaataaara = file_get_contents("codes/$code/inline_keyboard.txt");
file_get_contents('https://api.telegram.org/bot'.api.'/sendaudio?chat_id='.$chat_id.'&audio='.$urllllvoicd.'&caption='.$captionjhdbv.'&reply_markup={"inline_keyboard":['.$listtaaataaara.']}');

 bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"<code>@$usernamebot $code</code>",
   'parse_mode'=>'HTML',
'disable_web_page_preview'=>'true',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"إنشاء رسالة خاصة 📃",'callback_data'=>"Make_Code"],
                        ]
                ]
            ])
]);
        file_put_contents("data/$from_id/settings.txt","");
}
if(file_exists("codes/$code/document.txt")){
$aaa = str_replace(" = ","=",$textmsg);
$bbb = str_replace(" =","=" ,$aaa);
$ccc = str_replace("= ","=",$bbb);
$ddd = str_replace(" + ","+",$ccc);
$eee = str_replace(" +","=",$ddd);
$fff = str_replace("+ ","+",$eee);
$ggg = str_replace("+"," + ",$fff);
$hhh = str_replace("="," = ",$ggg);

 $ex = explode("\n", $hhh);
for ($i=0; $i < count($ex); $i++) { 
if(preg_match("/^(.*) = (.*)/s",$ex[$i])){
    $olink2 = explode(" ", $ex[$i]);
if(!in_array("+", $olink2)){
  preg_match("/^(.*) = (.*)/s",$ex[$i],$match);
if($match[1] != ""){
$nnnnaaa = count($ex);
$nnnnaaahs = $nnnnaaa -1;
if($i != $nnnnaaahs){
$listt = '[{"text":"'.urlencode($match[1]).'","url":"'.urlencode($match[2]).'"}],';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);
}else {
 $listt = '[{"text":"'.urlencode($match[1]).'","url":"'.urlencode($match[2]).'"}]';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);   
}


}
//-----------------------------
}else{
//----------------- 
file_put_contents("codes/$code/inline_keyboard.txt","[",FILE_APPEND);
$aajndfjvfhwbvhavb =  explode(" + ", $ex[$i]);
for ($a=0; $a < 12; $a++) { 
list($list[1], $list[2], $list[3], $list[4], $list[5], $list[6], $list[7], $list[8], $list[9], $list[10]) = explode(" + ", $ex[$i]);
 preg_match("/^(.*) = (.*)/s",$list[$a],$matcheuue);
if($matcheuue[1] != ""){
//----------------
$nnnnaaa = count($aajndfjvfhwbvhavb);
if($a != $nnnnaaa){
$listt = '{"text":"'.urlencode($matcheuue[1]).'","url":"'.urlencode($matcheuue[2]).'"},';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);
}else {
$listt = '{"text":"'.urlencode($matcheuue[1]).'","url":"'.urlencode($matcheuue[2]).'"}';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND); 
}


//--------------------
}
}
$nnnnaaa = count($ex);
$nnnnaaahs = $nnnnaaa -1;
if($i != $nnnnaaahs){
$listt = '],';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);
}else {
 $listt = '],[{"text":"'.urlencode('Luminary💫♥️لومِـنـَري').'","url":"'.urlencode('https://t.me/luminary1').'" }]';
file_put_contents("codes/$code/inline_keyboard.txt",$listt,FILE_APPEND);   
}
//-----------------    
}
}
}
$captionjhdbv = file_get_contents("codes/$code/caption.txt");
$urllllvoicd = file_get_contents("codes/$code/document.txt");

$listtaaataaara = file_get_contents("codes/$code/inline_keyboard.txt");
file_get_contents('https://api.telegram.org/bot'.api.'/senddocument?chat_id='.$chat_id.'&document='.$urllllvoicd.'&caption='.$captionjhdbv.'&reply_markup={"inline_keyboard":['.$listtaaataaara.']}');

 bot('sendMessage',[
   'chat_id'=>$chat_id,
   'text'=>"<code>@$usernamebot $code</code>",
   'parse_mode'=>'HTML',
'disable_web_page_preview'=>'true',
                  'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"إنشاء رسالة خاصة 📃",'callback_data'=>"Make_Code"],
                        ]
                ]
            ])
]);
        file_put_contents("data/$from_id/settings.txt","");
}
}
//------------------------
$inlineqt = $update->inline_query->query;
$textinline = file_get_contents("codes/$inlineqt/text.txt");
if($inlineqt != ''){
if(file_exists("codes/$inlineqt/audio.txt") or file_exists("codes/$inlineqt/voice.txt") or file_exists("codes/$inlineqt/photo.txt") or file_exists("codes/$inlineqt/text.txt") or file_exists("codes/$inlineqt/video.txt") or file_exists("codes/$inlineqt/document.txt") or file_exists("codes/$inlineqt/sticker.txt")){//-----------------------
if(file_exists("codes/$inlineqt/text.txt")){
if(!file_exists("codes/$inlineqt/inline_keyboard.txt")){
bot('answerInlineQuery',[
        'inline_query_id'=>$update->inline_query->id,    
        'cache_time'=>'300',
        'results' => json_encode([[
            'type'=>'article',
            'id'=>base64_encode(rand(5,555)),
            'title'=>"$inlineqt",
            'description'=>"إضغط هنا لرؤية الرسالة $inlineqt",
            'input_message_content'=>['parse_mode'=>'HTML','disable_web_page_preview'=>true,'message_text'=>urldecode($textinline)]
        ]])
        ]);
}else {
$keyborad = file_get_contents("codes/$inlineqt/inline_keyboard.txt");
 $inline_id = $update->inline_query->id;
        $id_rulest = base64_encode(rand(5,555));
$a1 = str_replace('"',"'",$textinline);
file_get_contents('https://api.telegram.org/bot'.api.'/answerInlineQuery?inline_query_id='.$inline_id.'&cache_time=300&results=[{"type":"article","id":"'.$id_rulest.'","title":"'.$inlineqt.'","description":"إضغط هنا لرؤية الرسالة","input_message_content":{"parse_mode":"HTML","disable_web_page_preview":true,"message_text":"'.$a1.'"},"reply_markup":{"inline_keyboard":['.$keyborad.']}}]');
}
}
//-----------------------
$srickke = file_get_contents("codes/$inlineqt/sticker.txt");
if(file_exists("codes/$inlineqt/sticker.txt")){
if(!file_exists("codes/$inlineqt/inline_keyboard.txt")){
bot('answerInlineQuery',[
        'inline_query_id'=>$update->inline_query->id,    
        'cache_time'=>'300',
        'results' => json_encode([[
            'type'=>'sticker',
            'id'=>base64_encode(rand(5,555)),
            'sticker_file_id'=>"$srickke"
        ]])
        ]);
}else {
        $keyborad = file_get_contents("codes/$inlineqt/inline_keyboard.txt");
 $inline_id = $update->inline_query->id;
        $id_rulest = base64_encode(rand(5,555));
        file_get_contents('https://api.telegram.org/bot'.api.'/answerInlineQuery?inline_query_id='.$inline_id.'&cache_time=300&results=[{"type":"sticker","id":"'.$id_rulest.'","sticker_file_id":"'.$srickke.'","reply_markup":{"inline_keyboard":['.$keyborad.']}}]');
}
}
//-------------------
$voicevoice = file_get_contents("codes/$inlineqt/voice.txt");
$captionvoice = file_get_contents("codes/$inlineqt/caption.txt");
if(file_exists("codes/$inlineqt/voice.txt")){
if(!file_exists("codes/$inlineqt/inline_keyboard.txt")){
bot('answerInlineQuery',[
        'inline_query_id'=>$update->inline_query->id,    
        'cache_time'=>'300',
        'results' => json_encode([[
            'type'=>'voice',
            'id'=>base64_encode(rand(5,555)),
            'voice_file_id'=>"$voicevoice",
            'title'=>"voice",
            'caption'=>urldecode($captionvoice)
        ]])
        ]);
}else {
        $keyborad = file_get_contents("codes/$inlineqt/inline_keyboard.txt");
 $inline_id = $update->inline_query->id;
        $id_rulest = base64_encode(rand(5,555));
        file_get_contents('https://api.telegram.org/bot'.api.'/answerInlineQuery?inline_query_id='.$inline_id.'&cache_time=300&results=[{"type":"voice","id":"'.$id_rulest.'","voice_file_id":"'.$voicevoice.'","title":"voice","caption":"'.$captionvoice.'","reply_markup":{"inline_keyboard":['.$keyborad.']}}]');
}
}
$videovideo = file_get_contents("codes/$inlineqt/video.txt");
$captionvideo = file_get_contents("codes/$inlineqt/caption.txt");
if(file_exists("codes/$inlineqt/video.txt")){
if(!file_exists("codes/$inlineqt/inline_keyboard.txt")){
bot('answerInlineQuery',[
        'inline_query_id'=>$update->inline_query->id,    
        'cache_time'=>'300',
        'results' => json_encode([[
            'type'=>'video',
            'id'=>base64_encode(rand(5,555)),
            'video_file_id'=>"$videovideo",
            'title'=>"video",
            'caption'=>urldecode($captionvideo)
        ]])
        ]);
}else {
        $keyborad = file_get_contents("codes/$inlineqt/inline_keyboard.txt");
 $inline_id = $update->inline_query->id;
        $id_rulest = base64_encode(rand(5,555));
        file_get_contents('https://api.telegram.org/bot'.api.'/answerInlineQuery?inline_query_id='.$inline_id.'&cache_time=300&results=[{"type":"video","id":"'.$id_rulest.'","video_file_id":"'.$videovideo.'","title":"video","caption":"'.$captionvideo.'","reply_markup":{"inline_keyboard":['.$keyborad.']}}]');
}
}
$photophoto = file_get_contents("codes/$inlineqt/photo.txt");
$captionphoto = file_get_contents("codes/$inlineqt/caption.txt");
if(file_exists("codes/$inlineqt/photo.txt")){
if(!file_exists("codes/$inlineqt/inline_keyboard.txt")){
bot('answerInlineQuery',[
        'inline_query_id'=>$update->inline_query->id,    
        'cache_time'=>'300',
        'results' => json_encode([[
            'type'=>'photo',
            'id'=>base64_encode(rand(5,555)),
            'photo_file_id'=>"$photophoto",
            'title'=>"photo",
            'caption'=>urldecode($captionphoto)
        ]])
        ]);
}else {
        $keyborad = file_get_contents("codes/$inlineqt/inline_keyboard.txt");
 $inline_id = $update->inline_query->id;
        $id_rulest = base64_encode(rand(5,555));
        file_get_contents('https://api.telegram.org/bot'.api.'/answerInlineQuery?inline_query_id='.$inline_id.'&cache_time=300&results=[{"type":"photo","id":"'.$id_rulest.'","photo_file_id":"'.$photophoto.'","title":"photo","caption":"'.$captionphoto.'","reply_markup":{"inline_keyboard":['.$keyborad.']}}]');
}
}
$audioaudio = file_get_contents("codes/$inlineqt/audio.txt");
$captionaudio = file_get_contents("codes/$inlineqt/caption.txt");
if(file_exists("codes/$inlineqt/audio.txt")){
if(!file_exists("codes/$inlineqt/inline_keyboard.txt")){
bot('answerInlineQuery',[
        'inline_query_id'=>$update->inline_query->id,    
        'cache_time'=>'300',
        'results' => json_encode([[
            'type'=>'audio',
            'id'=>base64_encode(rand(5,555)),
            'audio_file_id'=>"$audioaudio",
            'caption'=>urldecode($captionaudio)
        ]])
        ]);
}else {
        $keyborad = file_get_contents("codes/$inlineqt/inline_keyboard.txt");
 $inline_id = $update->inline_query->id;
        $id_rulest = base64_encode(rand(5,555));
        file_get_contents('https://api.telegram.org/bot'.api.'/answerInlineQuery?inline_query_id='.$inline_id.'&cache_time=300&results=[{"type":"audio","id":"'.$id_rulest.'","audio_file_id":"'.$audioaudio.'","caption":"'.$captionaudio.'","reply_markup":{"inline_keyboard":['.$keyborad.']}}]');
}
}
$documentdocument = file_get_contents("codes/$inlineqt/document.txt");
$captiondocument = file_get_contents("codes/$inlineqt/caption.txt");
if(file_exists("codes/$inlineqt/document.txt")){
if(!file_exists("codes/$inlineqt/inline_keyboard.txt")){
bot('answerInlineQuery',[
        'inline_query_id'=>$update->inline_query->id,    
        'cache_time'=>'300',
        'results' => json_encode([[
            'type'=>'document',
            'id'=>base64_encode(rand(5,555)),
            'document_file_id'=>"$documentdocument",
            'title'=>"document",
            'caption'=>urldecode($captiondocument)
        ]])
        ]);
}else {
        $keyborad = file_get_contents("codes/$inlineqt/inline_keyboard.txt");
 $inline_id = $update->inline_query->id;
        $id_rulest = base64_encode(rand(5,555));
        file_get_contents('https://api.telegram.org/bot'.api.'/answerInlineQuery?inline_query_id='.$inline_id.'&cache_time=300&results=[{"type":"document","id":"'.$id_rulest.'","document_file_id":"'.$documentdocument.'","title":"document","caption":"'.$captiondocument.'","reply_markup":{"inline_keyboard":['.$keyborad.']}}]');
}
}
//-----------------------
}else {
    bot('answerInlineQuery',[
        'inline_query_id'=>$update->inline_query->id,    
        'cache_time'=>'300',
        'results' => json_encode([[
            'type'=>'article',
            'id'=>base64_encode(rand(5,555)),
            'title'=>"لا توجد رسالة لهذا الرقم, تاكد من صحة الرقم وحاول مرة اخرى",
            'input_message_content'=>['parse_mode'=>'HTML','message_text'=>"لا توجد رسالة لهذا الرقم, تاكد من صحة الرقم وحاول مرة اخرى"]
        ]])
        ]);
}
}
