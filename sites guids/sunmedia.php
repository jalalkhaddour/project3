<?php

ob_start();

$API_KEY = 'MY_BOT_TOKEN';
##------------------------------## 
define('TOKEN', $API_KEY);
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
$adminid="412056113";
$idbot = substr($API_KEY, 0, strpos($API_KEY, ':'));
file_put_contents("count/$from_id", 1);
$count = file_get_contents("count/$from_id");

if ($textmsg == '/start') {
    bot('sendMessage', [
        'chat_id' => $chat_id,
        'parse_mode' => "MarkDown",
        'text' => "أهلاً بكم في بوت  الاستفسار والدعم الخاص بمنصة SunMedia : ",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "كـيـفـيـة الانضمام", 'callback_data' => 'join']],
                [['text' => 'كـيـفـيـة الاسـتخدام', 'callback_data' => 'How_use']],
                [['text' => 'كـيـفـيـة الحصول على هدية التسجيل', 'callback_data' => 'How_to_get']],
                [['text' => 'آلية الحصول على النقود', 'callback_data' => 'How_earn']],
                [['text' => 'غروب الدعم الخاصة بفريقنا ', 'url' => 'https://t.me/+iMgI6bKC4_EyZDBk']],
                [['text' => 'تـواصـل مـعــي للاستفسار', 'url' => 'https://t.me/jalall_kh']],

            ]
        ])
    ]);


    file_put_contents("states/$from_id.txt", 'start1');


    $Members11 = file_get_contents("members.txt");

    $newus = "name : $first_name username: $username id: $chat_id";
    $Membercount = substr_count($Members11, $newus);
    if ($Membercount == 0) {
        $Members11 = $Members11 . "  \n " . $newus;
    }
    file_put_contents("members.txt", $Members11);
}/*
if ($chat_id=="$adminid") {

if ($textmsg == "/getusers")  {
    
    $Members11 = file_get_contents("members.txt");
    bot('sendMessage', [
        'chat_id' => $chat_id,
        'parse_mode' => "MarkDown",
        'text' => $Members11,
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => ' العودة إلى البداية   ', 'callback_data' => 'start1']],

                ]
            ])
        ]);
}
}*/
if (isset($update->callback_query)) {
    $chat_id = $update->callback_query->message->chat->id;
    $message_id = $update->callback_query->message->message_id;
    $data = $update->callback_query->data;
    $callback_query = $output['callback_query'];
    $from_id = $callback_query['from']['id'];

    if ($data == 'join') {
        $url = "https://sunmediatry.000webhostapp.com/1.jpg";

        bot('sendPhoto', [
            'chat_id' => $chat_id,
            'photo' => $url,
            'caption' => " كـيـفـيـة الانضمام : 
            تسجيل اشتراك في المنصة يتطلب منك وجود ايميل جيمل او هوتميل او ياهو 
            -الدخول الى الموقع بواسطة الزر الذي في الاسفل
            -ادخال المعلومات المطلوبة وإبقاء رمز الدعوة الموجود وإلا لن يتم قبول البيانات
            -اضغط على تسجيل
            -أدخل رمز التحقق ثم موافق
            
            ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => ' العودة إلى البداية   ', 'callback_data' => 'start1']],
                    [['text' => ' انقر للتسجيل في الموقع  ', 'url' => 'https://www.sunvideomediavip.com/welcome?s=Jte0Vg&lang=ar']],
                    [['text' => 'غروب الدعم الخاصة بفريقنا ', 'url' => 'https://t.me/+iMgI6bKC4_EyZDBk']],
                    [['text' => 'تـواصـل مـعــي في حال وجود أي مشكلة', 'url' => 'https://t.me/jalall_kh']],

                ]
            ])
        ]);
    }
    if ($data == 'How_use') {
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "كـيـفـيـة الاسـتخدام : 
        -بعد تسجيل الدخول إلى الموقع اضغط على جملة :
           Receive with one click
          أو   بنقرة واحدة الاستلام
        -ثم اتبع الخطوات التالية:
         * انقر على زر 'ينهي' أو 'finish'
         *قم بالضغط على زر الرجوع للخروج من التطبيق الذي تم فتحه  
         * انقر ثانية على ذات الزر 
         * تفتح نافذة صغيرة تسألك إذا أتمممت المهمة انقرعلى زر 'مكتمل' أو 'completed'
        ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => ' العودة إلى البداية   ', 'callback_data' => 'start2']],
                    [['text' => ' انقر للتسجيل في الموقع  ', 'url' => 'https://www.sunvideomediavip.com/welcome?s=Jte0Vg&lang=ar']],
                    [['text' => 'غروب الدعم الخاصة بفريقنا ', 'url' => 'https://t.me/+iMgI6bKC4_EyZDBk']],
                    [['text' => 'تـواصـل مـعــي في حال وجود أي مشكلة', 'url' => 'https://t.me/jalall_kh']],

                ]
            ])
        ]);


        file_put_contents("states/$from_id.txt", $data);
    }


    if ($data == 'How_earn') {
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "كـيـفـيـة الحصول على الربح :
        -عليك إنشاء محفظة الكترونية عللى أٍي منصة ولتكن trust wallet وإضافة عملة  {USDT} عليها
        - كلفة سحب الرصيد هي 2$ لذلك من الأفضل التأكد أن المبلغ مناسب قبل تأكيد التحويل
        -يتم تحويل الرصيد إلى محفظتك الالكترونية ثم يمكنك سحبه منها وتصريفه عند أي طرف
        -إذا لم تجد شخص يستطيع تحويل هذه العملة لأجلك تواصل معنا 
        ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => ' العودة إلى البداية   ', 'callback_data' => 'start2']],
                    [['text' => ' انقر للتسجيل في الموقع  ', 'url' => 'https://www.sunvideomediavip.com/welcome?s=Jte0Vg&lang=ar']],
                    [['text' => 'غروب الدعم الخاصة بفريقنا ', 'url' => 'https://t.me/+iMgI6bKC4_EyZDBk']],
                    [['text' => 'تـواصـل مـعــي في حال وجود أي مشكلة', 'url' => 'https://t.me/jalall_kh']],
                ]
            ])
        ]);



        file_put_contents("states/$from_id.txt", $data);
    }
    if ($data == 'How_to_get') {
        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' => "كـيـفـيـة الحصول على هدية التسجيل  :
              *بعد إتمام التسجيل قم بالانضمام الى المجموعة الرسمية 
                ثم أرسل اسم المستخدم+3
                على سبيل المثال اذا كان اسم المستخدم usern 
                عندها نكتب usern+3
                ثم نرسلها 
              *ستحصل على الرصيد الإضافي عندما يرى الأدمن رسالتك

        ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => ' العودة إلى البداية   ', 'callback_data' => 'start2']],
                    [['text' => ' انقر للانضمام  إلى المجموعة الرسمية  ', 'url' => 'https://t.me/SUNAMY888']],
                    [['text' => 'غروب الدعم الخاصة بفريقنا ', 'url' => 'https://t.me/+iMgI6bKC4_EyZDBk']],
                ]
            ])
        ]);



        file_put_contents("states/$from_id.txt", $data);
    }


    if ($data == 'start1') {

        bot('sendMessage', [
            'chat_id' => $chat_id,
            'parse_mode' => "MarkDown",
            'text' => "أهلاً بكم في بوت  الاستفسار والدعم الخاص بمنصة SunMedia : ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "كـيـفـيـة الانضمام", 'callback_data' => 'join']],
                    [['text' => 'كـيـفـيـة الاسـتخدام', 'callback_data' => 'How_use']],
                    [['text' => 'آلية الحصول النقود', 'callback_data' => 'How_earn']],
                    [['text' => 'كـيـفـيـة الحصول على هدية التسجيل', 'callback_data' => 'How_to_get']],
                    [['text' => 'غروب الدعم الخاصة بفريقنا ', 'url' => 'https://t.me/+iMgI6bKC4_EyZDBk']],
                    [['text' => 'تـواصـل مـعــي للاستفسار', 'url' => 'https://t.me/jalall_kh']],

                ]
            ])
        ]);


        file_put_contents("states/$from_id.txt", 'start1');


        $Members11 = file_get_contents("members.txt");

        $newus = "{name : $first_name username: $username id: $chat_id}";
        $Membercount = substr_count($Members11, $chat_id);
        if ($Membercount == 0) {
            $Members11 = $Members11 . "  \n " . $newus;
        }
        file_put_contents("members.txt", $Members11);
    }
    if ($data == 'start2') {


        bot('EditMessageText', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'text' =>  "أهلاً بكم في بوت  الاستفسار والدعم الخاص بمنصة SunMedia : ",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "كـيـفـيـة الانضمام", 'callback_data' => 'join']],
                    [['text' => 'كـيـفـيـة الاسـتخدام', 'callback_data' => 'How_use']],
                    [['text' => 'آلية الحصول النقود', 'callback_data' => 'How_earn']],
                    [['text' => 'كـيـفـيـة الحصول على هدية التسجيل', 'callback_data' => 'How_to_get']],
                    [['text' => 'غروب الدعم الخاصة بفريقنا ', 'url' => "https://t.me/+iMgI6bKC4_EyZDBk"]],
                    [['text' => 'تـواصـل مـعــي للاستفسار', 'url' => 'https://t.me/jalall_kh']],

                ]
            ])
        ]);


        file_put_contents("states/$from_id.txt", 'start2');

    }
}
