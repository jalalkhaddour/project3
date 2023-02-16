<?php 
include 'funs.php';
ob_start();


$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$chat_id = $message->chat->id;
mkdir("data/$from_id");
$message_id = $message->message_id;
$from_id = $message->from->id;
$text = $message->text;
$settings = file_get_contents("data/$from_id/settings.txt");
$ADMIN = 4356897888;
$to =  file_get_contents("data/$from_id/token.txt");
$url =  file_get_contents("data/$from_id/url.txt");
if($text == "/start"){

if (!file_exists("data/$from_id/settings.txt")) {
        mkdir("data/$from_id");
        file_put_contents("data/$from_id/settings.txt","none");
        $myfile2 = fopen("Member.txt", "a") or die("Unable to open file!");
        fwrite($myfile2, "$from_id\n");
        fclose($myfile2);
    }
    
        sendAction($chat_id, 'typing');
	bot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"👨🏿‍💻¦ اهـلا بـك عزيزي↯

📮¦ في بوت انشاء ويب هوك √",
        'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[
	[['text'=>"🔘¦ عمل ويب هوك √"],['text'=>"🔍¦ ﺂستخراج معلومات التوكن √"]],
	[['text'=>"🚫¦ حذف ويب هوك ✘"]]
	]
	])
	]);
	}
elseif($text == "العودة 🔁"){
file_put_contents("data/$from_id/settings.txt","no");
file_put_contents("data/$from_id/token.txt","no");
file_put_contents("data/$from_id/url.txt","no");
        sendAction($chat_id, 'typing');
	bot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>"• تم الرجوع إلى القائمه الرئيسيه",
        'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[
	[['text'=>"🔘¦ عمل ويب هوك √"],['text'=>"🔍¦ ﺂستخراج معلومات التوكن √"]],
	[['text'=>"🚫¦ حذف ويب هوك ✘"]]
	]
	])
	]);
	}

elseif($text == "🔘¦ عمل ويب هوك √"){
     sendAction($chat_id, 'typing');
			file_put_contents("data/$from_id/settings.txt","to");
				bot('sendmessage',[
		'chat_id'=>$chat_id,
		'text'=>"💯¦ ﺂرسل الأن توكن البوت √",
                 'reply_markup'=>json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[
	[
	['text'=>"العودة 🔁"]
	],
	]
	])
	]);
	}
elseif($settings == "to"){
$token = $text;

    $settings1 = json_decode(file_get_contents("https://api.telegram.org/bot" . $token . "/getwebhookinfo"));
    $settings2 = json_decode(file_get_contents("https://api.telegram.org/bot" . $token . "/getme"));
        //==================
    $tik2 = objectToArrays($settings1);
    $ur = $tik2["result"]["url"];
    $ok2 = $tik2["ok"];
    $tik1 = objectToArrays($settings2);
    $un = $tik1["result"]["username"];
    $fr = $tik1["result"]["first_name"];
    $id = $tik1["result"]["id"];
    $ok = $tik1["ok"];
    if ($ok != 1) {
        //Token Not True
        SendMessage($chat_id, "");
    } else{
    file_put_contents("data/$from_id/settings.txt","url");
    file_put_contents("data/$from_id/token.txt",$text);
	SendAction($chat_id,'typing');
	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"🔍¦ ارسل الأن رابط الملف √",
  ]);
}
}
elseif($settings == "url"){
if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$text))
  {
  SendAction($chat_id,'typing');
	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"هناك خطاء رسائل متعددة 🚫",
  ]);
 }
 else {
 file_put_contents("data/$from_id/settings.txt","no");
 file_put_contents("data/$from_id/url.txt",$text);
 	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"🔍¦يتم الان الفحص",
  ]);
  sleep(1);
   	bot('editmessagetext',[
    'chat_id'=>$chat_id,
        'message_id'=>$message_id + 1,
    'text'=>"🔍¦ جار التحضير ثواني ....",
  ]);
	bot('editmessagetext',[
    'chat_id'=>$chat_id,
     'message_id'=>$message_id + 1,
    'text'=>"🔘¦ انت متأكد من عمل ويب هوك للمعلومات التاليه :- 

💳¦ توكن البوت ↙️;
$to
💯¦ رابط الملف ↙️;

 $text

📡¦ للتأكيد ارسل الامر   ↙️; 
/Webhook",
  ]);
 }
}
elseif($text == "/Webhook" ){
if($to != "no"){
 	 	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"⏳¦جار تفعيل ويب هوك ..",
  ]);
  sleep(1);
	bot('editmessagetext',[
    'chat_id'=>$chat_id,
     'message_id'=>$message_id + 1,
      'text'=>"⏳¦جار تخزين المعلومات ",
  ]);
  file_get_contents("https://api.telegram.org/bot$to/setwebhook?url=$url");
    sleep(1);
	bot('editmessagetext',[
    'chat_id'=>$chat_id,
     'message_id'=>$message_id + 1,
      'text'=>" ",
  ]);
  sleep(1);
  file_put_contents("data/$from_id/settings.txt","no");
	bot('sendmessage',[
	'chat_id'=>$chat_id,
		    'message_id'=>$message_id + 1,
	'text'=>"☑️¦ تم عمل ويب هوك بنجاح √",
        'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[
	[['text'=>"🔘¦ عمل ويب هوك √"],['text'=>"🔍¦ ﺂستخراج معلومات التوكن √"]],
	[['text'=>"🚫¦ حذف ويب هوك ✘"]]
	]
	])
	]);
}

}
/////--------
elseif($text == "🔍¦ ﺂستخراج معلومات التوكن √" ){
    file_put_contents("data/$from_id/settings.txt","token");
	sendaction($chat_id,'typing');
	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"💯¦ ﺂرسل الأن توكن البوت √",
    'parse_mode'=>'html',
    'reply_markup'=>json_encode([
      'keyboard'=>[
	  [['text'=>'العودة 🔁']],
      ],'resize_keyboard'=>true])
  ]);
}
elseif($settings == "token"){
$token = $text;

    $settings1 = json_decode(file_get_contents("https://api.telegram.org/bot" . $token . "/getwebhookinfo"));
    $settings2 = json_decode(file_get_contents("https://api.telegram.org/bot" . $token . "/getme"));
        //==================
    $tik2 = objectToArrays($settings1);
    $ur = $tik2["result"]["url"];
    $ok2 = $tik2["ok"];
    $tik1 = objectToArrays($settings2);
    $un = $tik1["result"]["username"];
    $fr = $tik1["result"]["first_name"];
    $id = $tik1["result"]["id"];
    $ok = $tik1["ok"];
    if ($ok != 1) {
        //Token Not True
        SendMessage($chat_id, "لقد ارسلت التوكن بشكل غير صحيح 
.! الرجاء ارسال التوكن بشكل صحيح 📬");
    } else{
    file_put_contents("data/$from_id/settings.txt","no");
    
	SendAction($chat_id,'typing');
 	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"
🔍¦جار الفحص اذا كان التوكن متوفراً . . . ⏱",
  ]);
  sleep(1);
	bot('editmessagetext',[
    'chat_id'=>$chat_id,
     'message_id'=>$message_id + 1,
    'text'=>"• معلومات 📬 التوكن هي 💬 •

• معرف البوت 💭 • @$un
• ايدي البوت 🔖 • $id
• اسم البوت 🌙 • $fr
• رابط الملف 💧•
$ur
"
,
  ]);
}
}
elseif($text == "🚫¦ حذف ويب هوك ✘" ){
    file_put_contents("data/$from_id/settings.txt","del");
	sendaction($chat_id,'typing');
	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"💯¦ ﺂرسل الأن توكن البوت √",
    'parse_mode'=>'html',
    'reply_markup'=>json_encode([
      'keyboard'=>[
	  [['text'=>'العودة 🔁']],
      ],'resize_keyboard'=>true])
  ]);
}
elseif($settings == "del"){
$token = $text;

    $settings1 = json_decode(file_get_contents("https://api.telegram.org/bot" . $token . "/getwebhookinfo"));
    $settings2 = json_decode(file_get_contents("https://api.telegram.org/bot" . $token . "/getme"));
        //==================
    $tik2 = objectToArrays($settings1);
    $ur = $tik2["result"]["url"];
    $ok2 = $tik2["ok"];
    $tik1 = objectToArrays($settings2);
    $un = $tik1["result"]["username"];
    $fr = $tik1["result"]["first_name"];
    $id = $tik1["result"]["id"];
    $ok = $tik1["ok"];
    if ($ok != 1) {
        //Token Not True
        SendMessage($chat_id, "لقد ارسلت التوكن بشكل غير صحيح 
.! الرجاء ارسال التوكن بشكل صحيح 📬");
    } else{
    file_put_contents("data/$from_id/settings.txt","no");
    
	SendAction($chat_id,'typing');
 	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>" ",
  ]);
  sleep(1);
	bot('editmessagetext',[
    'chat_id'=>$chat_id,
     'message_id'=>$message_id + 1,
    'text'=>"جار الحذف ....... ",
  ]);
}
file_get_contents("https://api.telegram.org/bot$text/deletewebhook");
sleep(1);
	bot('editmessagetext',[
    'chat_id'=>$chat_id,
     'message_id'=>$message_id + 1,
    'text'=>"تم الحذف بنجاح √",
  ]);
  sleep(1);
  file_put_contents("data/$from_id/settings.txt","no");
	bot('sendmessage',[
	'chat_id'=>$chat_id,
		    'message_id'=>$message_id + 1,
	'text'=>"• تم الرجوع  الى القائمه الرئيسيةه :-",
        'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
	'resize_keyboard'=>true,
	'keyboard'=>[
	[['text'=>"🔘¦ عمل ويب هوك √"],['text'=>"🔍¦ ﺂستخراج معلومات التوكن √"]],
	[['text'=>"🚫¦ حذف ويب هوك ✘"]]
	]
	])
	]);
}
//===============ᴏᴍᴀʀ ʜᴀѕʜᴍ ‏ ⌯┆-‏𖤍===============//
elseif($text =="/admin" && $chat_id == $ADMIN){
sendaction($chat_id, typing);
        bot('sendmessage', [
                'chat_id' =>$chat_id,
                'text' =>"اعزيزي المشرف، مرحبا بك في لوحة مشرف الروبوت 🌿",
                'parse_mode'=>'html',
      'reply_markup'=>json_encode([
            'keyboard'=>[
              [
              ['text'=>"عدد اعضاء البوت  👬"],['text'=>"رسالة للمشتركين 📄"],['text'=>"توجيه للمشتركين 💎"]
              ]
              ],'resize_keyboard'=>true
        ])
            ]);
        }
elseif($text == "عدد اعضاء البوت  👬" && $chat_id == $ADMIN){
	sendaction($chat_id,'typing');
    $user = file_get_contents("Member.txt");
    $member_id = explode("\n",$user);
    $member_count = count($member_id) -1;
	sendmessage($chat_id , " عدد اعضاء البوت  👬: $member_count" , "html");
}
elseif($text == "رسالة للمشتركين 📄" && $chat_id == $ADMIN){
    file_put_contents("data/$from_id/settings.txt","send");
	sendaction($chat_id,'typing');
	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"ارسل الرسالة التي تريد ارسالها بتنسيق نصي 📝",
    'parse_mode'=>'html',
    'reply_markup'=>json_encode([
      'keyboard'=>[
	  [['text'=>'/panel']],
      ],'resize_keyboard'=>true])
  ]);
}
elseif($settings == "send" && $chat_id == $ADMIN){
    file_put_contents("data/$from_id/settings.txt","no");
	SendAction($chat_id,'typing');
	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"تم إرسال رسالة عامة 🎉",
  ]);
	$all_member = fopen( "Member.txt", "r");
		while( !feof( $all_member)) {
 			$user = fgets( $all_member);
			SendMessage($user,$text,"html");
		}
}
elseif($text == "توجيه للمشتركين 💎" && $chat_id == $ADMIN){
    file_put_contents("data/$from_id/settings.txt","fowrded");
	sendaction($chat_id,'typing');
	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"نشر توجيهك 👣",
    'parse_mode'=>'html',
    'reply_markup'=>json_encode([
      'keyboard'=>[
	  [['text'=>'/panel']],
      ],'resize_keyboard'=>true])
  ]);
}
elseif($settings == "fowrded" && $chat_id == $ADMIN){
    file_put_contents("data/$from_id/settings.txt","no");
	SendAction($chat_id,'typing');
	bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"استمرار 🍁",
  ]);
$forp = fopen( "Member.txt", 'r'); 
while( !feof( $forp)) { 
$fakar = fgets( $forp); 
Forward($fakar, $chat_id,$message_id); 
  } 
   bot(
'sendMessage',[ 
   'chat_id'=>$chat_id, 
   'text'=>"تم نشر توجيهك بنجاح 🌟", 
   ]);
}
//===============ᴏᴍᴀʀ ʜᴀѕʜᴍ ‏ ⌯┆-‏𖤍================//
?>
