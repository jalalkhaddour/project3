<?php
ob_start();
include 'funs.php';
#-------------------------
$adminId = 839137200;
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
$docuId = $docu->file_id;
$adminId = 839137200;
#-------------------------------

if ($textmsg == '/start'){
if ($chat_id == $adminId) {
    
    SendTypingAction($chat_id);
        setState("start1", $from_id);
        setPlace($from_id,$from_id);
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'parse_mode' => "MarkDown",
            'text' => "أهلاً بك  اختر من القائمة : ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "المجلدات الموجودة🔰", 'callback_data' => 'SEE_DIRES_0_']],
                    [['text' => " إنشاء مجلد جديد🔰", 'callback_data' => 'NEW_DIRE']],
                ]
            ])
        ]);
} else {
    setState("start1", $from_id);
    SendTypingAction($chat_id);
    bot('sendMessage', [
        'chat_id' => $chat_id,
        'parse_mode' => "MarkDown",
        'text' => "هذا البوت خاص __
        لايمكنك استخدامه " ]);
}
}elseif($message and $adminId ){
    SendTypingAction($chat_id);
    $st=getFileState($chat_id);
    if ($st=="w") {
        $sv_pth=getPlace($from_id);
        setFileState("d",$chat_id);
        saveFileFromId($docuId,$sv_pth,$docuname);
        $oldMs=getmessages($from_id);
        $usershowpth=getuserpth($from_id);
            bot('deleteMessage', [
                'chat_id' => $chat_id,
                'message_id' => $oldMs
            ]); 
                   bot('sendMessage', [
                    'chat_id' => $chat_id,
                'parse_mode' => "MarkDown",
                'text' => "تم رفع الملف  : 
                أنت الآن في المسار : `$usershowpth` ",
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => " رفع ملف جديد هنا🔰 ", 'callback_data' => 'TO_DIRE_0_'],['text' => " عرض الملفات الموجودة هنا🔰 ", 'callback_data' => "SEE_Files_0_".$sr]],
                        [['text' => "المجلدات الموجودة هنا🔰", 'callback_data' => 'SEE_DIRES_0_'.$sr],['text' => "إنشاء مجلد جديد هنا🔰", 'callback_data' => 'NEW_DIRE_0_'.$sr]],
                        [['text' => "حذف هذا المجلد ❌", 'callback_data' => 'DELE_DIRE_0_']],
                    ]
                ])
            ]);



    }
    
}

if (isset($update->callback_query)) {
    $chat_id = $update->callback_query->message->chat->id;
    $message_id = $update->callback_query->message->message_id;
    $data = $update->callback_query->data;
    $callback_query = $output['callback_query'];
    $from_id = $callback_query['from']['id'];
    
    $dt = explode('_0_', $data);
    if ($dt[0]=="NEW_DIRE") {
        SendTypingAction($chat_id);
        $thisplc=getPlace($from_id);
        $usershowpth=getuserpth($from_id);
        $sr=toadddire($thisplc);
        setPlace($thisplc."/$sr",$from_id);
        setState($data,$from_id);
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'parse_mode' => "MarkDown",
            'text' => "تم إنشاء مجلد جديد بالرقم $sr 📂 : 
            أنت الآن في المسار : `$usershowpth/$sr` ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => " رفع ملف جديد هنا🔰 ", 'callback_data' => 'TO_DIRE_0_'],['text' => " عرض الملفات الموجودة هنا🔰 ", 'callback_data' => "SEE_Files_0_".$sr]],
                    [['text' => "المجلدات الموجودة هنا🔰", 'callback_data' => 'SEE_DIRES_0_'.$sr],['text' => "إنشاء مجلد جديد هنا🔰", 'callback_data' => 'NEW_DIRE_0_'.$sr]],
                    [['text' => "حذف هذا المجلد ❌", 'callback_data' => 'DELE_DIRE_0_']],
                ]
            ])
        ]);
    }
    elseif ($dt[0]=="SEE_DIRES") {
    SendTypingAction($chat_id);
        $thisplc=getPlace($from_id);
        $usershowpth=getuserpth($from_id);
            $srlrr=getdires($thisplc);
        $inlineKeyboard=do_keyboard($srlrr,1);
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'parse_mode' => "MarkDown",
            'text' => "🗂 المجلدات الموجودة في المسار `$usershowpth`  : ",
            'reply_markup' => json_encode($inlineKeyboard)
        ]);

    }
    elseif ($dt[0]=="SEE_Files") {
    SendTypingAction($chat_id);
        $thisplc=getPlace($from_id);
        $usershowpth=getuserpth($from_id);
        $srlrr=getfiles($thisplc);
        $inlineKeyboard=do_keyboard($srlrr,0);
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'parse_mode' => "MarkDown",
            'text' => "📋 الملفات الموجودة في المسار: `$usershowpth`  : ",
            'reply_markup' => json_encode($inlineKeyboard)
        ]);

    }
    elseif ($dt[0]=="TO_DIRE") {
    SendTypingAction($chat_id);
        $thisplc=getPlace($from_id);
        $usershowpth=getuserpth($from_id);
        setState($data,$from_id);
        setFileState("w",$chat_id);
        setmessages($message_id,$from_id);
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "⌛ قم بإرسال الملف الآن ليتم رفعه في المسار: `$usershowpth`  : ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => 'الغاء❌', 'callback_data' => 'cancel_0_']],
                ]
            ])
        ]);
    }
    elseif ($dt[0]=="DELE_DIRE") {
        SendTypingAction($chat_id);
            $thisplc=getPlace($from_id);
            $usershowpth=getuserpth($from_id);
            setState($data,$from_id);
            bot('EditMessageText', [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
                'text' => "هل أنت متأكد أنك تريد حذف هذا المجلد `$usershowpth` ؟؟ ",
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => 'نعم متأكد', 'callback_data' => 'CONFIRM_DELE_0_']],
                        [['text' => 'إلغاء ', 'callback_data' => 'cancel_0_']],
                    ]
                ])
            ]);
        }    elseif ($dt[0]=="DELE_FILE") {
            SendTypingAction($chat_id);
            $fl=$dt[1];
            $trueN=str_replace('|','.',$fl);
                $thisplc=getPlace($from_id);
                $usershowpth=getuserpth($from_id);
                setState($data,$from_id);
                bot('EditMessageText', [
                    'chat_id' => $chat_id,
                    'message_id' => $message_id,
                    'text' => "هل أنت متأكد أنك تريد حذف هذا الملف `$trueN` ؟؟ ",
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [['text' => 'نعم متأكد', 'callback_data' => 'CONFIRM_DELE_0_'.$fl]],
                            [['text' => 'إلغاء ', 'callback_data' => 'cancel_0_']],
                        ]
                    ])
                ]);
            }
    elseif ($dt[0]=="CONFIRM_DELE") {
    SendTypingAction($chat_id);
    
    $fl=$dt[1];
        $thisplc=getPlace($from_id);
        $usershowpth=getuserpth($from_id);
    if ($fl=="") {

        $lstfol=getthisfoldernm($thisplc);
        deldire($thisplc,$lstfol);
        $newplc=GOBACK($thisplc);
        setPlace($newplc,$from_id);
        $usershowpthNEW=str_replace($from_id.'/',"",$newplc); 
       }else{
        $trueN=str_replace('|','.',$fl);
        delfile($thisplc,$trueN);
        $usershowpthNEW=$usershowpth;
       }
        setState($data,$from_id);
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "تم الحذف بنجاح  
            أنت الآن في المسار :  `$usershowpthNEW` ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => " رفع ملف جديد هنا🔰 ", 'callback_data' => 'TO_DIRE_0_'],['text' => " عرض الملفات الموجودة هنا🔰 ", 'callback_data' => "SEE_Files_0_".$sr]],
                    [['text' => "المجلدات الموجودة هنا🔰", 'callback_data' => 'SEE_DIRES_0_'.$sr],['text' => "إنشاء مجلد جديد هنا🔰", 'callback_data' => 'NEW_DIRE_0_'.$sr]],
                    [['text' => "حذف هذا المجلد ❌", 'callback_data' => 'DELE_DIRE_0_']],
                ]
            ])
        ]);
    }
    elseif ($dt[0] == "cancel") {
    SendTypingAction($chat_id);
        bot('deleteMessage', [
            'chat_id' => $chat_id,
            'message_id' => $message_id
        ]);
        setState('cancel_0_', $from_id);
    }
    elseif ($dt[0] == "GET_FILE_LINK") {
    SendTypingAction($chat_id);
    $fl=$dt[1];
    $trueN=str_replace('|','.',$fl);
    $thisplc=getPlace($from_id);
    $urrl=getFileLink($trueN,$thisplc);
    $usershowpth=getuserpth($from_id);
        setState('cancel_0_', $from_id);
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'parse_mode' => "MarkDown",
            'text' => "                   
            رابط الملف هو:
             `$urrl`  
             .
            أنت الآن في المسار 📂 `$usershowpth`: ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => " رفع ملف جديد هنا🔰 ", 'callback_data' => 'TO_DIRE_0_'],['text' => " عرض الملفات الموجودة هنا🔰 ", 'callback_data' => "SEE_Files_0_".$sr]],
                    [['text' => "المجلدات الموجودة هنا🔰", 'callback_data' => 'SEE_DIRES_0_'.$sr],['text' => "إنشاء مجلد جديد هنا🔰", 'callback_data' => 'NEW_DIRE_0_'.$sr]],
                    [['text' => "حذف هذا المجلد ❌", 'callback_data' => 'DELE_DIRE_0_']],
                ]
            ])
        ]);
    }
    elseif ($dt[0] == "GET_File") {
    SendTypingAction($chat_id);
    $newf=$dt[1];
    $newfl=str_replace('|','.',$newf);
    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'text' => "الملف:$newfl
         ماذا تريد أن تفعل؟؟ ",
        'reply_markup' => json_encode([
            'inline_keyboard' =>[
                [['text' => 'حذف هذا الملف ❌', 'callback_data' => 'DELE_FILE_0_'.$newf]],
                [['text' => 'رابط هذا الملف 🌐', 'callback_data' => 'GET_FILE_LINK_0_'.$newf]],
                [['text' => 'العودة إلى المجلد', 'callback_data' => 'GET_DIRE_0_']],
            ]
        ])
    ]);
        setState($data, $from_id);
    }
    elseif ($dt[0] == "GET_DIRE") {
    SendTypingAction($chat_id);
    $pth=getPlace($chat_id);
    $newdr=$dt[1];
    if ($newdr!="") {
    $newpth=$pth.'/'.$newdr;
    }else {
    $newpth=$pth;
    }
    $usershowpth=getuserpth($chat_id);
    setPlace($newpth,$chat_id);
    bot('EditMessageText', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'parse_mode' => "MarkDown",
        'text' => "                   
        أنت الآن في المسار : `$usershowpth`  📂 : ",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => " رفع ملف جديد هنا🔰 ", 'callback_data' => 'TO_DIRE_0_'],['text' => " عرض الملفات الموجودة هنا🔰 ", 'callback_data' => "SEE_Files_0_".$sr]],
                [['text' => "المجلدات الموجودة هنا🔰", 'callback_data' => 'SEE_DIRES_0_'.$sr],['text' => "إنشاء مجلد جديد هنا🔰", 'callback_data' => 'NEW_DIRE_0_'.$sr]],
                [['text' => "حذف هذا المجلد ❌", 'callback_data' => 'DELE_DIRE_0_']],
            ]
        ])
    ]);
        setState($data, $from_id);
    }
}

?>