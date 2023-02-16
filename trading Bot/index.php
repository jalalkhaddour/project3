<?php
include "funs.php";
ob_start();

##------------------------------## 
$output = json_decode(file_get_contents('php://input'), TRUE);
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$chat_id = $message->chat->id;
$textmsg = $message->text;
$data = $update->callback_query->data;
$first_name = $message->from->first_name;
$username = $message->from->username;
$from_id = $message->from->id;
$docu = $message->document;
$docuname = $docu->file_name;
$adminId = 839137200;
$admin2Id = 839137201;
$notifB = true;
$INFON1 = get_Name_prod("INFO1");
$INFON2 = get_Name_prod("INFO2");
$INFON3 = get_Name_prod("INFO3");
$SSN1N = get_Name_prod("SSN1");
$SSN2N = get_Name_prod("SSN2");
$idbot = substr($API_KEY, 0, strpos($API_KEY, ':'));


if ($textmsg == '/start') {
    if ($chat_id != $adminId) {

        setState("start1", $from_id);
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'parse_mode' => "MarkDown",
            'text' => "أهلاً بك  اختر من القائمة : ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "SSN 🔰", 'callback_data' => 'SSN'], ['text' => "معلومات  🔰", 'callback_data' => 'INFO']],
                    [['text' => "شحن حسابي  💲", 'callback_data' => 'CHARGE'], ['text' => "نشرة الأسعار 💹", 'callback_data' => 'PRICES']],
                    [['text' => "طلبات شحن الرصيد", 'callback_data' => 'REQU'],['text' => 'دليل المستخدم ', 'callback_data' => 'USERIN']],

                ]
            ])
        ]);




        $Members11 = file_get_contents("members.txt");
        $Membercount = substr_count($Members11, $from_id);
        if ($Membercount == 0) {
            $Members11 = $Members11 . "  \n " . $from_id;
            setBaLaNCE(0, $from_id);
            file_put_contents("members.txt", $Members11);
        }
    } else {
        setState("start1", $from_id);
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'parse_mode' => "MarkDown",
            'text' => "أهلاً بك  اختر من القائمة : ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "SSN 🔰", 'callback_data' => 'SSN'], ['text' => "معلومات  🔰", 'callback_data' => 'INFO']],
                    [['text' => "إضافة الخدمات ♻", 'callback_data' => 'PRODUCTS'], ['text' => "نشرة الأسعار 💹", 'callback_data' => 'PRICES']],
                    [['text' => '  دليل المستخدم   ', 'callback_data' => 'USERIN']],

                ]
            ])
        ]);
    }
} elseif ($message /*and $from_id != $admin2Id */ and $from_id != $adminId) {
    $st = getState($chat_id);
    if ($st == 'CHARGESYCSH') {
$newst=setnewchargestate("في انتظار المراجعة", $from_id);
        $photos = $message->photo;
        $photoi = $photos[0];
        $photoid = $photoi->file_id;
        $BaLaNCE = getBaLaNCE($from_id);
        bot('sendPhoto', [
            'chat_id' => $adminId,
            'parse_mode' => "MarkDown",
            'caption' => " USER ID : $from_id
            لقد قام المستخدم $first_name 
            بإرسال اثبات شحن سيريتيل كاش",
            'photo' => $photoid,
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'الموافقة على الشحن', 'callback_data' => 'APPROVE0'.$from_id.'_'.$newst.'_P']],
                    [['text' => 'رفض عملية الشحن', 'callback_data' => 'DECLINE0'.$from_id.'_'.$newst.'_P']],
                ]
            ])
        ]);
        $oldID = getmessages($chat_id);
        bot('deleteMessage', ['chat_id' => $chat_id, 'message_id' => $oldID]);
        $result = bot('sendMessage', [
            'chat_id' => $chat_id,
            'parse_mode' => "MarkDown",
            'text' => " تم ارسال طلب الشحن سيتم إضافة الرصيد مباشرةً بعد مراجعة العملية من قبل الادمن ✔✔",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'العودة إلى البداية', 'callback_data' => 'start1']],
                ]
            ])
        ]);
        $mesID = $result->result->message_id;
        setmessages($mesID, $chat_id);
    } elseif ($st == 'CHARGEGFTCRD') {
        $newst=setnewchargestate("في انتظار المراجعة", $from_id);
        $mddddd=" USER ID : `$from_id`
        لقد قام المستخدم $first_name 
        بإرسال كود شحن بطاقة دفع الكتروني
        👇 الرسالة التي أرسلها المستخدم 👇:
        ```text
        $textmsg
        ``` ";
        file_put_contents("chargestate/$from_id/GFT/$newst.txt",$mddddd);
        bot('sendMessage', [
            'chat_id' => $adminId,
            'parse_mode' => "MarkDown",
            'text' =>  $mddddd,
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'الموافقة على الشحن', 'callback_data' => 'APPROVE0'.$from_id.'_'.$newst.'_C']],
                    [['text' => 'رفض عملية الشحن', 'callback_data' => 'DECLINE0'.$from_id.'_'.$newst.'_C']],
                ]
            ])
        ]);
        $oldID = getmessages($chat_id);
        bot('deleteMessage', ['chat_id' => $chat_id, 'message_id' => $oldID]);
        $result = bot('sendMessage', [
            'chat_id' => $chat_id,
            'parse_mode' => "MarkDown",
            'text' => " تم ارسال طلب الشحن سيتم إضافة الرصيد مباشرةً بعد مراجعة العملية من قبل الادمن ✔✔",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'العودة إلى البداية', 'callback_data' => 'start1']],
                ]
            ])
        ]);
        $mesID = $result->result->message_id;
        setmessages($mesID, $chat_id);
    }
} elseif ($message and $chat_id == $adminId) {
    $st2 = getState($chat_id);
    $msgid = getmessages($adminId);
    $st1 = explode('0', $st2);
    $st = $st1[0];

    if ($st == "APPROVE") {
        $bb55 = (int)$textmsg;
        $newdtt=str_replace("APPROVE0","",$st2);
        $trr=explode('_',$newdtt);
        if ($bb55<0) {
            $bb=0-$bb55;
        }else{$bb=$bb55;}
        if ($bb != null and $bb != 0) {
            setState("done ", $from_id);
            $usid = $trr[0];
            $userid = (int)$usid;
            $sttt=$trr[1];
            $stt=(int)$sttt;
            $wyy=$trr[2];
            $BaLaNCE = getBaLaNCE($userid);
            $newBaLaNCE = $BaLaNCE + $bb;
            setBaLaNCE($newBaLaNCE, $userid);
            setchargestate("تمت العملية بنجاح
تم إضافة `$bb`
: الرصيد الجديد أصبح `$newBaLaNCE` ", $userid,$stt);
if ($wyy=='P') {

            bot('editMessageCaption', [
                'chat_id' => $chat_id,
                'message_id' => $msgid,
                'parse_mode' => "MarkDown",
                'caption' => " USER ID : `$userid`
تمت الموافقة على طلب الشحن تمت إضافة $bb إلى الرصيد
وأصبح الرصيد الجديد : `$newBaLaNCE` "]);
}else
{
    $oldgft=file_get_contents("chargestate/$userid/GFT/$stt.txt");
    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $msgid,
        'parse_mode' => "MarkDown",
        'text' => " 
``` $oldgft ```
____________________ 
تمت الموافقة على طلب الشحن وتمت إضافة $bb إلى الرصيد
فأصبح الرصيد الجديد : `$newBaLaNCE` 
"
    ]);
}
$secId=getmessages($adminId.'nd');
bot('deleteMessage', ['chat_id' => $adminId, 'message_id' => $secId]);

            bot('sendMessage', [
                'chat_id' => $adminId,
                'parse_mode' => "MarkDown",
                'text' =>  "✔✔ تمت إضافة الرصيد بنجاح 
                USERID:`$userid`
                رقم طلب الشحن : $stt
                رصيد المستخدم الجديد: `$newBaLaNCE`"
            ]);
            bot('sendMessage', [
                'chat_id' => $userid,
                'parse_mode' => "MarkDown",
                'text' =>  "
USERID:`$userid`
✔✔تمت إضافة الرصيد بنجاح
تمت الموافقة على طلب الشحن رقم : $stt
رصيدك الجديد: $newBaLaNCE "
            ]);
        }
    } elseif ($st == "SETPRIC") {
        $productcode = $st1[1];
        $newPrice = (int)$textmsg;
        setPrice($productcode, $newPrice);
        $prodn = get_Name_prod($productcode);
        bot('deleteMessage', ['chat_id' => $chat_id, 'message_id' => $msgid]);
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'parse_mode' => "MarkDown",
            'text' =>  "$prodn
✔✔ تم تعديل السعر بنجاح 
سعر الخدمة الجديد: $newPrice",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "العودة إلى نشرة الأسعار 💹", 'callback_data' => 'PRICES']],
                ]
            ])
        ]);

        setState("done ", $from_id);
    } elseif ($st == "AD") {
        $productcode = $st1[1];
        $newsr = toaddProd($productcode, $textmsg);
        $npro = get_Name_prod($productcode);
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'parse_mode' => "MarkDown",
            'text' =>  "تمت إضافة الخدمة بنجاح ✔✔ 
الخدمة التي تمت إضافتها من نوع `".$npro."`"
        ]);
        $result =   bot('sendMessage', [
            'chat_id' => $chat_id,
            'parse_mode' => "MarkDown",
            'text' =>  "تمت إضافة الخدمة بنجاح ✔✔ 
الخدمة التي تمت إضافتها من نوع `".$npro."`:
`$newsr` :
```   ".$textmsg."```

            ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "إضافة خدمة أخرى🔰", 'callback_data' => 'PRODUCTS']],
                    [['text' => "عرض كل خدمات هذا القسم🔰", 'callback_data' => 'All0'.$productcode]],
                    [['text' => 'العودة إلى البداية ', 'callback_data' => 'start1']],

                ]
            ])
        ]);
        bot('deleteMessage', ['chat_id' => $chat_id, 'message_id' => $msgid]);

        $mesID = $result->result->message_id;
        setmessages($mesID, $adminId);
        setState("done ", $chat_id);
    } elseif ($st == 'ED') {
        $newprod = $textmsg;
        $temp=str_replace("ED0","",$st2);
        $trr=explode('_',$temp);
        $productcode = $trr[0];
        $prodsrl = $trr[1];
        $prodn = get_Name_prod($productcode);
        setState("start1", $chat_id);
        to_edit_prod($productcode, $prodsrl, $newprod);
        $mesID = getmessages($chat_id);
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $mesID,
            'parse_mode' => "MarkDown",
            'text' => "تم تعديل خدمة الـ($prodn) رقم ($prodsrl) بنجاح ✔✔
        "
        ]);
        $result = bot('sendMessage', [
            'chat_id' => $chat_id,
            'parse_mode' => "MarkDown",
            'text' => "أهلاً بك  اختر من القائمة : ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "SSN 🔰", 'callback_data' => 'SSN'], ['text' => "معلومات  🔰", 'callback_data' => 'INFO']],
                    [['text' => "إضافة الخدمات ♻", 'callback_data' => 'PRODUCTS'], ['text' => "نشرة الأسعار 💹", 'callback_data' => 'PRICES']],
                    [['text' => '  دليل المستخدم   ', 'callback_data' => 'USERIN']],

                ]
            ])
        ]);
        $mesID = $result->result->message_id;
        setmessages($mesID, $chat_id);
    }
}
if (isset($update->callback_query)) {
    $chat_id = $update->callback_query->message->chat->id;
    $message_id = $update->callback_query->message->message_id;
    $data = $update->callback_query->data;
    $callback_query = $output['callback_query'];
    $from_id = $callback_query['from']['id'];
    $dt = explode('0', $data);
    if ($dt[0] == 'start1') {
        setState("start1", $from_id);
        if ($from_id == $adminId) {
            bot('sendMessage', [
                'chat_id' => $chat_id,
                'parse_mode' => "MarkDown",
                'text' => "أهلاً بك  اختر من القائمة : ",
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "SSN 🔰", 'callback_data' => 'SSN'], ['text' => "معلومات  🔰", 'callback_data' => 'INFO']],
                        [['text' => "إضافة الخدمات ♻", 'callback_data' => 'PRODUCTS'], ['text' => "نشرة الأسعار 💹", 'callback_data' => 'PRICES']],
                        [['text' => '  دليل المستخدم   ', 'callback_data' => 'USERIN']],

                    ]
                ])
            ]);
        } else {
            bot('sendMessage', [
                'chat_id' => $chat_id,
                'parse_mode' => "MarkDown",
                'text' => "أهلاً بك  اختر من القائمة : ",
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "SSN 🔰", 'callback_data' => 'SSN'], ['text' => "معلومات  🔰", 'callback_data' => 'INFO']],
                        [['text' => "شحن حسابي  💲", 'callback_data' => 'CHARGE'],['text' => "نشرة الأسعار 💹", 'callback_data' => 'PRICES']],
                        [['text' => "طلبات شحن الرصيد", 'callback_data' => 'REQU'],['text' => 'دليل المستخدم ', 'callback_data' => 'USERIN']],

                    ]
                ])
            ]);
        }
    }


    #####STaRT OF SERVICES
    #####STaRT OF SSN
    elseif ($dt[0] == 'SSN') {
        setmessages($message_id, $chat_id);
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "خدمات SSN 🔰: ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "$SSN1N 🔰", 'callback_data' => 'SSN1']],
                    [['text' => "$SSN2N 🔰", 'callback_data' => 'SSN2']],
                    [['text' => 'العودة إلى البداية ', 'callback_data' => 'start1']],
                ]
            ])
        ]);

        setState($data, $from_id);
    } elseif ($dt[0] == 'SSN1') {
        $productcode=$dt[0];
        $prodn=get_Name_prod($productcode);
        if ($chat_id == $adminId) {
             setmessages($message_id, $chat_id);
              bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "قسم خدمات $prodn",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "إضافة خدمة جديدة", 'callback_data' => "AD0$productcode"]],
                    [['text' => 'عرض كل الخدمات المتوفرة', 'callback_data' => 'All0'.$productcode]],
                    [['text' => 'الخلف 🔙', 'callback_data' => 'SSN']],
                ]
            ])
        ]);
        setState($data, $from_id);
        }else {
            
      
        $PRICESSN1 = getPrice($data);
        setmessages($message_id, $chat_id);
        $BaLaNCE = getBaLaNCE($from_id);
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "سعر خدمة  $SSN1N هو  $PRICESSN1 : ورصيدك هو $BaLaNCE
",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'تأكيد الشراء ✔', 'callback_data' => 'BUY0SSN1']],
                    [['text' => 'الخلف 🔙', 'callback_data' => 'SSN']],
                ]
            ])
        ]);

        setState($data, $from_id);
      }
    } elseif ($dt[0] == 'SSN2') {
        $productcode=$dt[0];
        $prodn=get_Name_prod($productcode);
        if ($chat_id == $adminId) {
             setmessages($message_id, $chat_id);
              bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "قسم خدمات $prodn",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "إضافة خدمة جديدة", 'callback_data' => "AD0$productcode"]],
                    [['text' => 'عرض كل الخدمات المتوفرة', 'callback_data' => 'All0'.$productcode]],
                    [['text' => 'الخلف 🔙', 'callback_data' => 'SSN']],
                ]
            ])
        ]);
        setState($data, $from_id);
        }else {
        $PRICESSN2 = getPrice($data);
        setmessages($message_id, $chat_id);
        $BaLaNCE = getBaLaNCE($from_id);
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "سعر خدمة  $SSN2N هو  $PRICESSN2 :
    ورصيدك هو $BaLaNCE
",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'تأكيد الشراء ✔', 'callback_data' => 'BUY0SSN2']],
                    [['text' => 'الخلف 🔙', 'callback_data' => 'SSN']],
                ]
            ])
        ]);

        setState($data, $from_id);
    }}
    #####END OF SSN
    #####STaRT OF INFORMaTION
    elseif ($dt[0] == 'INFO') {
        setmessages($message_id, $chat_id);
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "خدمات  المعلومات 🔰: ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "$INFON1", 'callback_data' => 'INFO1']],
                    [['text' => "$INFON2", 'callback_data' => 'INFO2']],
                    [['text' => "$INFON3", 'callback_data' => 'INFO3']],
                    [['text' => 'العودة إلى البداية ', 'callback_data' => 'start1']],
                ]
            ])
        ]);

        setState($data, $from_id);
    } elseif ($dt[0] == 'INFO1') {
        $productcode=$dt[0];
        $prodn=get_Name_prod($productcode);
        if ($chat_id == $adminId) {
             setmessages($message_id, $chat_id);
              bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "قسم خدمات $prodn",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "إضافة خدمة جديدة", 'callback_data' => "AD0$productcode"]],
                    [['text' => 'عرض كل الخدمات المتوفرة', 'callback_data' => 'All0'.$productcode]],
                    [['text' => 'الخلف 🔙', 'callback_data' => 'INFO']],
                ]
            ])
        ]);
        setState($data, $from_id);
        }else {
        $PRICEINFO1 = getPrice($data);
        setmessages($message_id, $chat_id);
        $BaLaNCE = getBaLaNCE($from_id);
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "سعر خدمة  $INFON1 هو  $PRICEINFO1 :
        ورصيدك هو $BaLaNCE
        ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'تأكيد الشراء ✔', 'callback_data' => 'BUY0INFO1']],
                    [['text' => 'الخلف 🔙', 'callback_data' => 'INFO']],
                ]
            ])
        ]);
        setState($data, $from_id);}
    } elseif ($dt[0] == 'INFO2') {
        $productcode=$dt[0];
        $prodn=get_Name_prod($productcode);
        if ($chat_id == $adminId) {
             setmessages($message_id, $chat_id);
              bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "قسم خدمات $prodn",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "إضافة خدمة جديدة", 'callback_data' => "AD0$productcode"]],
                    [['text' => 'عرض كل الخدمات المتوفرة', 'callback_data' => 'All0'.$productcode]],
                    [['text' => 'الخلف 🔙', 'callback_data' => 'INFO']],
                ]
            ])
        ]);
        setState($data, $from_id);
        }else {
        $PRICEINFO2 = getPrice($data);
        setmessages($message_id, $chat_id);
        $BaLaNCE = getBaLaNCE($from_id);
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "سعر خدمة  $INFON2 هو  $PRICEINFO2 :
        ورصيدك هو $BaLaNCE
        ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'تأكيد الشراء ✔', 'callback_data' => 'BUY0INFO2']],
                    [['text' => 'الخلف 🔙', 'callback_data' => 'INFO']],
                ]
            ])
        ]);

        setState($data, $from_id);}
    } elseif ($dt[0] == 'INFO3') {
        $productcode=$dt[0];
        $prodn=get_Name_prod($productcode);
        if ($chat_id == $adminId) {
             setmessages($message_id, $chat_id);
              bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "قسم خدمات $prodn",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "إضافة خدمة جديدة", 'callback_data' => "AD0$productcode"]],
                    [['text' => 'عرض كل الخدمات المتوفرة', 'callback_data' => 'All0'.$productcode]],
                    [['text' => 'الخلف 🔙', 'callback_data' => 'INFO']],
                ]
            ])
        ]);
        setState($data, $from_id);
        }else {
        setmessages($message_id, $chat_id);
        $PRICEINFO3 = getPrice($data);
        $BaLaNCE = getBaLaNCE($from_id);
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "سعر خدمة  $INFON3 هو  $PRICEINFO3 :
        ورصيدك هو $BaLaNCE
        ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'تأكيد الشراء ✔', 'callback_data' => 'BUY0INFO3']],
                    [['text' => 'الخلف 🔙', 'callback_data' => 'INFO']],
                ]
            ])
        ]);

        setState($data, $from_id);}
    }


    #####END OF INFORMaTION
    #####STaRT OF prices
    elseif ($dt[0] == 'PRICES') {
        if ($from_id != $adminId) {



            setmessages($message_id, $chat_id);
            $PRICESSN1 = getPrice("SSN1");
            $PRICESSN2 =  getPrice("SSN2");
            $PRICEINFO1 =  getPrice("INFO1");
            $PRICEINFO2 =  getPrice("INFO2");
            $PRICEINFO3 =  getPrice("INFO3");
            bot('EditMessageText', [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
                'text' => "نشرة الاسعار 💹: 
            $SSN1N : $PRICESSN1
            $SSN2N : $PRICESSN2
            $INFON1 : $PRICEINFO1
            $INFON2 : $PRICEINFO2
            $INFON3 : $PRICEINFO3
            ",
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => 'العودة إلى البداية ', 'callback_data' => 'start1']],
                    ]
                ])
            ]);
        } elseif ($from_id == $adminId) {
            setmessages($message_id, $chat_id);
            $PRICESSN1 = getPrice("SSN1");
            $PRICESSN2 =  getPrice("SSN2");
            $PRICEINFO1 =  getPrice("INFO1");
            $PRICEINFO2 =  getPrice("INFO2");
            $PRICEINFO3 =  getPrice("INFO3");
            bot('EditMessageText', [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
                'text' => "نشرة الاسعار 💹: 
            $SSN1N : $PRICESSN1
            $SSN2N : $PRICESSN2
            $INFON1 : $PRICEINFO1
            $INFON2 : $PRICEINFO2
            $INFON3 : $PRICEINFO3
            ",
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => 'تعديل الأسعار', 'callback_data' => 'ToSETPRIC']],
                        [['text' => 'العودة إلى البداية ', 'callback_data' => 'start1']],
                    ]
                ])
            ]);
        }
    } elseif ($dt[0] == 'ToSETPRIC') {
        setState($data, $adminId);
        $PRICESSN1 = getPrice("SSN1");
        $PRICESSN2 =  getPrice("SSN2");
        $PRICEINFO1 =  getPrice("INFO1");
        $PRICEINFO2 =  getPrice("INFO2");
        $PRICEINFO3 =  getPrice("INFO3");
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "تعديل الاسعار 💱: 
            ___SSN___
            $SSN1N : $PRICESSN1
            $SSN2N : $PRICESSN2
            ___المعلومات___
            $INFON1 : $PRICEINFO1
            $INFON2 : $PRICEINFO2
            $INFON3 : $PRICEINFO3
            ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'خدمات المعلومات', 'callback_data' => 'SETPRICE0INFO']],
                    [['text' => 'SSN', 'callback_data' => 'SETPRICE0SSN']],
                ]
            ])
        ]);
    } elseif ($dt[0] == "SETPRICE") {
        $PRICESSN1 = getPrice("SSN1");
        $PRICESSN2 =  getPrice("SSN2");
        $PRICEINFO1 =  getPrice("INFO1");
        $PRICEINFO2 =  getPrice("INFO2");
        $PRICEINFO3 =  getPrice("INFO3");
        $service = $dt[1];
        setState($data, $adminId);
        if ($service == "SSN") {
            bot('EditMessageText', [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
                'text' => "تعديل الاسعار 💱: 
            ___SSN___
            $SSN1N : $PRICESSN1
            $SSN2N : $PRICESSN2
            ",
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "$SSN1N", 'callback_data' => 'SETPRIC0SSN1']],
                        [['text' => "$SSN2N", 'callback_data' => 'SETPRIC0SSN2']],
                    ]
                ])
            ]);
        } elseif ($service == "INFO") {
            bot('EditMessageText', [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
                'text' => "تعديل الاسعار 💱: 
            ___المعلومات___
            $INFON1 : $PRICEINFO1
            $INFON2 : $PRICEINFO2
            $INFON3 : $PRICEINFO3
            ",
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "$INFON1", 'callback_data' => 'SETPRIC0INFO1']],
                        [['text' => "$INFON2", 'callback_data' => 'SETPRIC0INFO2']],
                        [['text' => "$INFON3", 'callback_data' => 'SETPRIC0INFO3']],
                    ]
                ])
            ]);
        }
    } elseif ($dt[0] == "SETPRIC") {
        setmessages($message_id, $chat_id);
        setState($data, $from_id);
        $productcode = $dt[1];
        $CurrPrice = getPrice($productcode);
        $prodn = get_Name_prod($productcode);
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "
            $prodn : 
            السعر الحالي هو :$CurrPrice 
            أرسل السعر الجديد
            ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'إلغاء التعديل', 'callback_data' => 'cancel']],
                ]
            ])
        ]);
    }
    #####END OF prices
    #####STaRT OF charge

    elseif ($dt[0] == 'CHARGE') {

        setmessages($message_id, $chat_id);
        $BaLaNCE = getBaLaNCE($from_id);
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => " UserId : `$from_id`
            رصيدك حالياً هو `$BaLaNCE`
            كيف تريد شحن رصيدك؟💲
        ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'سيريتيل كاش ✔', 'callback_data' => 'CHARGESYCSH']],
                    [['text' => 'بطاقات دفع الكتروني✔', 'callback_data' => 'CHARGEGFTCRD']],
                    [['text' => 'الخلف 🔙', 'callback_data' => 'start1']],
                ]
            ])
        ]);

        setState($data, $from_id);
    } elseif ($dt[0] == 'CHARGESYCSH') {

        setmessages($message_id, $chat_id);
        $BaLaNCE = getBaLaNCE($from_id);
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "قم بإرسال اثبات التحويل على شكل صورة 
     ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'الغاء❌', 'callback_data' => 'CHARGE']],
                ]
            ])
        ]);

        setState($data, $from_id);
    } elseif ($dt[0] == 'CHARGEGFTCRD') {

        setmessages($message_id, $chat_id);
        $BaLaNCE = getBaLaNCE($from_id);
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "قم بإرسال كود البطاقة :  ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'الغاء❌', 'callback_data' => 'CHARGE']],
                ]
            ])
        ]);

        setState($data, $from_id);
    } elseif ($dt[0] == "APPROVE") {
        $dtt=str_replace('APPROVE0','',$data);
        $trr=explode('_',$dtt);
        $userid = $trr[0];
        setmessages($message_id, $chat_id);
        $result=bot('sendMessage', [
            'chat_id' => $adminId,
            'parse_mode' => "MarkDown",
            'text' => " UserId : `$userid`
            ارسل الرصيد المراد إضافته للمستخدم: ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'الغاء❌', 'callback_data' => 'cancel']],
                ]
            ])
        ]);
        
        $mesID = $result->result->message_id;
        setmessages($mesID, $adminId.'nd');
        setState($data, $from_id);

    } elseif ($dt[0] == "DECLINE") {
        
        $newdtt=str_replace("DECLINE0","",$data);
        $trr=explode('_',$newdtt);
        $userid = $trr[0];
        $stnm=$trr[1];
        bot('sendMessage', [
            'chat_id' => $adminId,
            'parse_mode' => "MarkDown",
            'text' => " UserId : ` $userid `
            هل أنت متأكد من رفض العملية؟",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'تأكيد الإلغاء❌', 'callback_data' => 'tcancel0'.$userid.'_'.$stnm]],
                ]
            ])
        ]);

        setState($data, $from_id);
    } elseif ($dt[0] == "tcancel") {
        $newdtt=str_replace("tcancel0","",$data);
        $trr=explode('_',$newdtt);
        $userid = $trr[0];
        $stnm=$trr[1];
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'parse_mode' => "MarkDown",
            'text' => "تم تأكيد الرفض"
        ]);
        setState('tcancel', $from_id);
        setchargestate("
        USER_ID:`$userid`
        تم رفض العملية تواصل مع الأدمن لمعرفة المزيد
        ", $userid,$stnm);
    } elseif ($dt[0] == "cancel") {
        bot('deleteMessage', [
            'chat_id' => $chat_id,
            'message_id' => $message_id
        ]);
        setState('cancel', $from_id);
    }
    #END_OF_CHARGE
    #START_OF_BUYING
    elseif ($dt[0] == "BUY") {
        $product = $dt[1];
        $npro = get_Name_prod($product);
        $PRICEPROD = getPrice($product);
        $BaLaNCE = getBaLaNCE($from_id);
        if (Isproductvalid($product)) {
            $prod = togetProd($product);
            if ($BaLaNCE >= $PRICEPROD) {
                $newBaLaNCE = $BaLaNCE - $PRICEPROD;
                setBaLaNCE($newBaLaNCE, $from_id);
                bot('sendMessage', [
                    'chat_id' => $chat_id,
                    'parse_mode' => "MarkDown",
                    'text' => "خدمة $npro : 
```text
$prod  ``` "]);
                useProduct($product);
                bot('EditMessageText', [
                    'chat_id' => $chat_id,
                    'message_id' => $message_id,
                    'parse_mode' => "MarkDown",
                    'text' => "تمت العملية بنجاح✔✔
                 UserId : `$from_id`
                رصيدك الآن هو : $newBaLaNCE",
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [['text' => 'العودة إلى البداية', 'callback_data' => 'start1']],
                        ]
                    ])
                ]);
                if ($notifB) {
                    bot('sendMessage', [
                        'chat_id' => $adminId,
                        'parse_mode' => "MarkDown",
                        'text' => "لقد قام المستخدم $first_name UserID: `$from_id`  بشراء الخدمة التالية :
$npro
______________
```text  $prod ```
______________
وتم حذفها من الملفات 
                "
                    ]);
                }
            } else {
                bot('EditMessageText', [
                    'chat_id' => $chat_id,
                    'message_id' => $message_id,
                    'parse_mode' => "MarkDown",
                    'text' => " UserId : `$from_id`
            عذراً رصيدك غير كافي ‼",
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [['text' => 'العودة إلى البداية', 'callback_data' => 'start1']],
                        ]
                    ])
                ]);
            }
        } else {
            bot('EditMessageText', [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
                'parse_mode' => "MarkDown",
                'text' => " UserId : `$from_id`
        عذراً الخدمة غير متوفرة حالياً حاول مرة أخرى لاحقاً ‼",
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => 'العودة إلى البداية', 'callback_data' => 'start1']],
                    ]
                ])
            ]);
        }
        setState($data, $chat_id);
    }
    #END_OF_BUYING
    #START_OF_BOT_INFO
    elseif ($dt[0] == "USERIN") {
        setState($data, $chat_id);
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'parse_mode' => "MarkDown",
            'text' => " دليل المستخدم : ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'تواصل مع الأدمن ', 'callback_data' => 'ABOUT0A']],
                    [['text' => 'معلومات صانع البوت', 'url' => 'http://t.me/jalall_kh']],
                ]
            ])
        ]);
    } elseif ($dt[0] == "ABOUT") {
        $st = $dt[1];
        if ($st == 'A') {
            bot('EditMessageText', [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
                'parse_mode' => "MarkDown",
                'text' => " تواصل مع الأدمن : 
                
                
                ",
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => 'تواصل مع الأدمن على تيليجرام', 'url' => 'http://t.me/']],
                        [['text' => 'تواصل مع الأدمن على واتساب', 'url' => 'http://wa.me/']],
                        [['text' => 'العودة إلى البداية', 'callback_data' => 'USERIN']],
                    ]
                ])
            ]);
        } elseif ($st == 'M') {
            bot('EditMessageText', [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
                'parse_mode' => "MarkDown",
                'text' => " معلومات صانع البوت :


                 ",
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => 'تواصل مع الأدمن ', 'callback_data' => 'ABOUT0A']],
                        [['text' => 'العودة إلى البداية', 'callback_data' => 'start1']],
                    ]
                ])
            ]);
        }
    }
    #END_OF_BOT_INFO
    #START_OF_ADD_PRODUCTS
    elseif ($dt[0] == 'PRODUCTS') {
        setState($data, $chat_id);
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'parse_mode' => "MarkDown",
            'text' => "إضافة الخدمات ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'معلومات', 'callback_data' => 'ADD0INFO']],
                    [['text' => 'SSN', 'callback_data' => 'ADD0SSN']],
                ]
            ])
        ]);
    } elseif ($dt[0] == "ADD") {
        $st = $dt[1];
        setState($data, $chat_id);
        if ($st == "INFO") {
            bot('EditMessageText', [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
                'parse_mode' => "MarkDown",
                'text' => "إضافة الخدمات ",
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "$INFON1", 'callback_data' => 'AD0INFO1']],
                        [['text' => "$INFON2", 'callback_data' => 'AD0INFO2']],
                        [['text' => "$INFON3", 'callback_data' => 'AD0INFO3']],
                    ]
                ])
            ]);
        } elseif ($st == "SSN") {
            bot('EditMessageText', [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
                'parse_mode' => "MarkDown",
                'text' => "إضافة الخدمات ",
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "$SSN1N", 'callback_data' => 'AD0SSN1']],
                        [['text' => "$SSN2N", 'callback_data' => 'AD0SSN2']],
                    ]
                ])
            ]);
        }
    } elseif ($dt[0] == "AD") {
        $productcode = $dt[1];
        setState($data, $chat_id);
        $npro = get_Name_prod($productcode);
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'parse_mode' => "MarkDown",
            'text' => " 
            ارسل الآن خدمة الـ(`$npro`)  : 
            ملاحظة : الرجاء الارسال على شكل نص ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'الغاء❌', 'callback_data' => 'cancel']],
                ]
            ])
        ]);
        setmessages($message_id, $adminId);
        setState($data, $from_id);
    }elseif ($dt[0] == "REQU") {
        $numb=getchargestatecount($from_id);
        for ($i=1; $i <=$numb ; $i++) { 
            $chrgstt=getchargestate($from_id,$i);
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'parse_mode' => "MarkDown",
            'text' => "الطلب رقم : `$i`\
الحالة: ```text
$chrgstt
            ```"
        ]);
        }
        bot('deleteMessage', ['chat_id' => $chat_id, 'message_id' => $message_id]);
        setmessages($message_id, $adminId);
        setState($data, $from_id);
    } elseif ($dt[0] == "All") {
        $productcode = $dt[1];
       // $pg=$dt[2];
        setState($data, $chat_id);
        //$mxpg=get_mx_pg($productcode);
        $npro = get_Name_prod($productcode);
       // $prods = toget_all_prod($productcode,$pg);
       $v=getvalidProdnum($productcode);
       $srl=getsrlProdnum($productcode);

       $ss = $srl - $v;
       if ($v!=0 ) {
        $s=$ss+1; 
        if ($v==1) {
           $s=$srl;
        }     
       for ($i=$s; $i <=$srl ; $i++) { 
        $prod = file_get_contents("Products/$productcode/$i.txt");
       bot('sendMessage', [
        'chat_id' => $chat_id,
        'parse_mode' => "MarkDown",
        'text' => "
serial : `$i` 
```text 
$prod
```",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => 'تعديل ✏', 'callback_data' => 'ED0'.$productcode.'_'.$i]],
            ]
        ])
    ]);  } }else{
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'parse_mode' => "MarkDown",
            'text' => "لا يوجد خدمات متاحة في هذا القسم ‼"  ]);
    }

        $result = bot('sendMessage', [
            'chat_id' => $chat_id,
            'parse_mode' => "MarkDown",
            'text' =>  "
            تم عرض جميع خدمات $npro
            ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "إضافة خدمة $npro جديدة", 'callback_data' => "AD0$productcode"]],
                    [['text' => "العودة إلى البداية", 'callback_data' => "start1"]],
                ]
            ])
        ]);
        $mesID = $result->result->message_id;
        setmessages($mesID, $adminId);
    } elseif ($dt[0] == "EDIT") {
        setState($data, $chat_id);
        $productcode = $dt[1];
        $npro = get_Name_prod($productcode);
        $texxt = "اختر الSerial للخدمة التي تريد تعديلها";
        $thesrls = get_prods_srls_edite($productcode);
        $result = file_get_contents('https://api.telegram.org/bot' . TOKEN . '/sendMessage?chat_id=' . $adminId . '&text=' . $texxt . '&parse_mode=HTML&disable_web_page_preview=true&reply_markup={"inline_keyboard":[[{"text":"العودة إلى البداية","callback_data":"start1"}],' . $thesrls . ']}');
    } elseif ($dt[0] == "ED") {
        $temp=str_replace("ED0","",$data);
        $trr=explode('_',$temp);
        $productcode = $trr[0];
        $prodsrl = $trr[1];
        $thepr = to_get_specific_prod($productcode, $prodsrl);
        setState($data, $chat_id);
        setmessages($message_id, $chat_id);
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'parse_mode' => "MarkDown",
            'text' => "
أرسل الخدمة الجديدة ليتم تعديلها
هذه هي الخدمة القديمة رقم `$prodsrl`  :
```text 
$thepr ```
    ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'الغاء❌', 'callback_data' => 'cancel']],
                ]
            ])
        ]);
    }
}
