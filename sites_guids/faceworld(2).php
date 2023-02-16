<?php 

ob_start(); 

$API_KEY = 'MY_BOT_TOKEN'; 
##------------------------------## 
define('TOKEN',$API_KEY); 
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
$docu = $message->document ; 
$docuname = $docu->file_name ; 
$idbot= substr($API_KEY, 0, strpos($API_KEY, ':')); 
file_put_contents("count/$from_id",1); 
$count=file_get_contents("count/$from_id"); 
/* 
mkdir('number'); 
 
mkdir('json'); 
 
mkdir('states'); 
 
mkdir('count'); 
 
mkdir('data'); 
mkdir('join'); 
mkdir('about'); 
mkdir('How_use');*/ 
 
if($textmsg=='/start'){ 
bot('sendMessage',[ 
'chat_id'=>$chat_id, 
'parse_mode'=>"MarkDown", 
'text'=> "أهلاً بكم في بوت  الاستفسار والدعم الرسمي الخاص بمنصة faceWorld : ", 
'reply_markup'=>json_encode([  
'inline_keyboard'=>[ 
                [['text'=>"من نحن ؟ ", 'callback_data'=>'about']], 
                [['text'=>"كـيـفـيـة الانضمام", 'callback_data'=>'join']], 
                [['text'=>'كـيـفـيـة الاسـتخدام' , 'callback_data'=>'How_use']], 
                [['text'=>'تـواصـل مـعــنـا' , 'url'=>'https://face-world.net']], 
 
   ]]) 
]); 
     
 
        file_put_contents("states/$from_id.txt", "start1"); 
         
 
        $Members11=file_get_contents("members.txt"); 
        $Membercount=substr_count($Members11,$chat_id); 
            if($Membercount==0) { 
              $Members11= $Members11."  \n ".$chat_id; 
            }        
            file_put_contents("members.txt",$Members11); 
            file_put_contents("about/$from_id.txt",'yes'); 
            file_put_contents("join/$from_id.txt",'yes'); 
            file_put_contents("How_use/$from_id.txt",'yes'); 
            file_put_contents("start1/$from_id.txt",'yes'); 
            file_put_contents("create/$from_id.txt",'yes'); 
            file_put_contents("create1/$from_id.txt",'yes'); 
            file_put_contents("create2/$from_id.txt",'yes'); 
            file_put_contents("create3/$from_id.txt",'yes'); 
            file_put_contents("create4/$from_id.txt",'yes'); 
            file_put_contents("points/$from_id.txt",'yes'); 
            file_put_contents("pointsw/$from_id.txt",'yes'); 
            file_put_contents("pointsa/$from_id.txt",'yes'); 
            file_put_contents("pointsi/$from_id.txt",'yes'); 
            file_put_contents("fpro/$from_id.txt",'yes'); 
            file_put_contents("invit/$from_id.txt",'yes'); 
 
} 
if(isset($update->callback_query)){ 
    $chat_id = $update->callback_query->message->chat->id; 
    $message_id = $update->callback_query->message->message_id; 
    $data = $update->callback_query->data; 
    $callback_query = $output['callback_query']; 
    $from_id = $callback_query['from']['id']; 
 
if($data=='about'){ 
    mkdir($data);
$avail=file_get_contents("$data/$from_id.txt"); 
    file_put_contents("$data/$from_id.txt",'no'); 
$settings=file_get_contents("states/$from_id.txt"); 
    if($settings != $data and $avail == 'yes'){ 
    bot('sendMessage',[ 
'chat_id'=>$chat_id, 
'text'=> "من نحن؟ 
شبكة  تواصل اجتماعي عالمية وليست محلية  تهدف إلى تحويل المستخدم من سلعة إلى مستفيد", 
'reply_markup'=>json_encode([  
'inline_keyboard'=>[ 
        [['text'=>' العودة إلى البداية   ' , 'callback_data'=>'start1']], 
        ]  
        ]) 
    ]); 
 
    file_put_contents("states/$from_id.txt", $data); 
} 
} 
if($data=='join'){
 mkdir($data);   $url="https://deletedacc.000webhostapp.com/primg/1.jpg"; 
$avail=file_get_contents("$data/$from_id.txt"); 
    file_put_contents("$data/$from_id.txt",'no'); 
$settings=file_get_contents("states/$from_id.txt"); 
    if($settings != $data and $avail == 'yes'){ 
        bot('sendPhoto',[ 
            'chat_id'=>$chat_id, 
            'photo'=>$url, 
            'caption'=>" كـيـفـيـة الانضمام : 
            تسجيل اشتراك في المنصة يتطلب منك وجود ايميل جيمل او هوتميل او ياهو 
            -الدخول الى موقع www.face-world.net 
            -ادخال المعلومات المطلوبة ثم الموافقة على الشروط 
            -اضغط على تسجيل", 
            'reply_markup'=>json_encode([  
    'inline_keyboard'=>[ 
                    [['text'=>' العودة إلى البداية   ' , 'callback_data'=>'start1']], 
     
       ]  
       ]) 
                ]); 
 
    file_put_contents("states/$from_id.txt", "join"); 
} 
} 
 
if($data=='start1'){
    file_put_contents("states/$from_id.txt", "start1"); 
     mkdir($data);
    bot('sendMessage',[ 
        'chat_id'=>$chat_id, 
        'text'=> 'أهلاً بكم في بوت  الاستفسار والدعم الرسمي الخاص بمنصة faceWorld : ', 
        'reply_markup'=>json_encode([  
        'inline_keyboard'=>[ 
                        [['text'=>'مـن نحـن   ' , 'callback_data'=>'about']], 
                        [['text'=>'كـيـفـيـة الانضمام ' , 'callback_data'=>'join']], 
                        [['text'=>'كـيـفـيـة الاسـتخدام' , 'callback_data'=>'How_use']], 
                        [['text'=>'تـواصـل مـعــنـا' , 'url'=>'https://face-world.net']], 
         
           ]  
           ]) 
        ]); 
             
         
                file_put_contents("states/$from_id.txt", "start1"); 
                 
            file_put_contents("about/$from_id.txt",'yes'); 
            file_put_contents("join/$from_id.txt",'yes'); 
            file_put_contents("How_use/$from_id.txt",'yes'); 
            file_put_contents("start1/$from_id.txt",'yes'); 
            file_put_contents("create/$from_id.txt",'yes'); 
            file_put_contents("create1/$from_id.txt",'yes'); 
            file_put_contents("create2/$from_id.txt",'yes'); 
            file_put_contents("create3/$from_id.txt",'yes'); 
            file_put_contents("create4/$from_id.txt",'yes'); 
            file_put_contents("points/$from_id.txt",'yes'); 
            file_put_contents("pointsw/$from_id.txt",'yes'); 
            file_put_contents("pointsa/$from_id.txt",'yes'); 
            file_put_contents("pointsi/$from_id.txt",'yes'); 
            file_put_contents("fpro/$from_id.txt",'yes'); 
            file_put_contents("invit/$from_id.txt",'yes'); 
} 
 
 
if($data=='How_use'){ 
    mkdir($data); 
 
$avail=file_get_contents("$data/$from_id.txt"); 
    file_put_contents("$data/$from_id.txt",'no'); 
$settings=file_get_contents("states/$from_id.txt"); 
if($settings ='points' or $settings='create' or $settings='fpro' or $settings='invit' ){ 
    bot('EditMessageText',[
        'chat_id'=>$chat_id,
        'message_id'=>$message_id,
    'text'=> "كـيـفـيـة الاسـتخدام : ", 
'reply_markup'=>json_encode([  
'inline_keyboard'=>[ 
    [['text'=>'آلية النقاط ' , 'callback_data'=>'points']], 
    [['text'=>'إنشـاء صـفـحـة أو مـجـمـوعـة' , 'callback_data'=>'create']], 
    [['text'=>'مـيـزة الـبـرو' , 'callback_data'=>'fpro']], 
    [['text'=>'رابـط الإحـالـة' , 'callback_data'=>'invit']], 
    [['text'=>'المدزنة' , 'url'=>'https://face-world.net'],['text'=>'المتجر الالكتروني' , 'url'=>'https://face-world.net']], 
    [['text'=>' العودة إلى البداية   ' , 'callback_data'=>'start1']], 
 
        ]  
        ]) 
    ]); 
 
    file_put_contents("states/$from_id.txt", $data); 
} 
} 
 
if($data=='How_use'){ 
    mkdir($data); 
 
$avail=file_get_contents("$data/$from_id.txt"); 
    file_put_contents("$data/$from_id.txt",'no'); 
$settings=file_get_contents("states/$from_id.txt"); 
if($settings != $data and $avail == 'yes'){ 
    bot('sendMessage',[ 
'chat_id'=>$chat_id, 
'text'=> "كـيـفـيـة الاسـتخدام : ", 
'reply_markup'=>json_encode([  
'inline_keyboard'=>[ 
    [['text'=>'آلية النقاط ' , 'callback_data'=>'points']], 
    [['text'=>'إنشـاء صـفـحـة أو مـجـمـوعـة' , 'callback_data'=>'create']], 
    [['text'=>'مـيـزة الـبـرو' , 'callback_data'=>'fpro']], 
    [['text'=>'رابـط الإحـالـة' , 'callback_data'=>'invit']], 
    [['text'=>'المدزنة' , 'url'=>'https://face-world.net'],['text'=>'المتجر الالكتروني' , 'url'=>'https://face-world.net']], 
    [['text'=>' العودة إلى البداية   ' , 'callback_data'=>'start1']], 
 
        ]  
        ]) 
    ]); 
 
    file_put_contents("states/$from_id.txt", $data); 
} 
} 

if($data=='points'){ 
     mkdir($data);
 
$avail=file_get_contents("$data/$from_id.txt"); 
    file_put_contents("$data/$from_id.txt",'no'); 
$settings=file_get_contents("states/$from_id.txt"); 
file_put_contents("$settings/$from_id.txt",'yes'); 
if($settings != $data and $avail == 'yes'){ 
    bot('EditMessageText',[
        'chat_id'=>$chat_id,
        'message_id'=>$message_id,
    'text'=> "آلية النقاط  : ", 
'reply_markup'=>json_encode([  
'inline_keyboard'=>[ 
    [['text'=>'مــا هـي النقاط ؟ ' , 'callback_data'=>'pointsw']],
    [['text'=>'الية جمع النقاط  ' , 'callback_data'=>'pointsa']],
    [['text'=>'قيمة الأرباح المستحقة' , 'callback_data'=>'pointsi']],
    [['text'=>'الـعـودة إلى الـبدايـة' , 'callback_data'=>'start1']],
    [['text'=>'الـعـودة إلى الـخـلـف ' , 'callback_data'=>'How_use']],
    ]
    ])
]);
file_put_contents("states/$from_id.txt", $data); 
} 
} 

if($data=='pointsw'){ 
    mkdir($data); 
 
$avail=file_get_contents("$data/$from_id.txt"); 
    file_put_contents("$data/$from_id.txt",'no'); 
$settings=file_get_contents("states/$from_id.txt"); 
file_put_contents("$settings/$from_id.txt",'yes'); 
if($settings != $data ){ 
    bot('EditMessageText',[
        'chat_id'=>$chat_id,
        'message_id'=>$message_id,
    'text'=> "ماهي النقاط  
تهدف منصة Faceworld  إلى تغيير نظرة المستخدم حول اتجاه مواقع التواصل الاجتماعي, ونحن نطمح دائما في شبكة Faceworld إلى تحويل المستخدم من سلعة إلى مستفيد, ودورنا هنا مكافأة المستخدم على ثقته بنا عن طريق اهداءه نقاط تشجيع يمكن تحويلها إلى أرباح. ", 
'reply_markup'=>json_encode([  
'inline_keyboard'=>[ 
    [['text'=>' العودة إلى الخلف   ' , 'callback_data'=>'points']],
    [['text'=>' العودة إلى البداية   ' , 'callback_data'=>'start1']],  
    ]  
    ]) 
]); 

file_put_contents("states/$from_id.txt", $data); 
} 
} 


if($data=='pointsa'){ 
    mkdir($data); 
 
$avail=file_get_contents("$data/$from_id.txt"); 
    file_put_contents("$data/$from_id.txt",'no'); 
$settings=file_get_contents("states/$from_id.txt"); 
file_put_contents("$settings/$from_id.txt",'yes'); 
if($settings != $data ){ 
    bot('EditMessageText',[
        'chat_id'=>$chat_id,
        'message_id'=>$message_id,
    'text'=> " : الية جمع النقاط 
- تستطيع جمع النقاط عن طريق التفاعل على منشورات أصدقائك ومشاركة المنشورات في صفحتك الشخصية أو الصفحة العامة أو المجموعات.
سيتم إهداؤك: 
-  3 نقاط عن طريق الإعجاب بأي منشور. 
- نقطة واحدة عن طريق عدم الإعجاب بأي منشور. 
- نقطتان من خلال التعليق على أي منشور. 
- 4 نقاط من خلال إنشاء منشور جديد. ", 
'reply_markup'=>json_encode([  
'inline_keyboard'=>[ 
    [['text'=>' العودة إلى الخلف   ' , 'callback_data'=>'points']], 
    [['text'=>' العودة إلى البداية   ' , 'callback_data'=>'start1']], 
    ]  
    ]) 
]); 

file_put_contents("states/$from_id.txt", $data); 
} 
} 


if($data=='pointsi'){ 
    mkdir($data); 
 
$avail=file_get_contents("$data/$from_id.txt"); 
    file_put_contents("$data/$from_id.txt",'no'); 
$settings=file_get_contents("states/$from_id.txt"); 
file_put_contents("$settings/$from_id.txt",'yes'); 
if($settings != $data ){ 
    bot('EditMessageText',[
        'chat_id'=>$chat_id,
        'message_id'=>$message_id,
    'text'=> "
• ليس هناك مقدار ثابت لقيمة الأرباح المستحقة داخل المنصة وأنه من الممكن أن يتغير مع تغير سوق العملات العالمية 
• يمكن سحب الأرباح عند وصول نقاطك إلى حد معين ويجب أن يكون متساويا مع أدنى حد وهو 10$ أمريكي", 
'reply_markup'=>json_encode([  
'inline_keyboard'=>[ 
    [['text'=>' العودة إلى الخلف   ' , 'callback_data'=>'points']], 
    [['text'=>' العودة إلى البداية   ' , 'callback_data'=>'start1']], 
    ]  
    ]) 
]); 

file_put_contents("states/$from_id.txt", $data); 
} 
} 
 
if($data=='create'){ 
    mkdir($data);

$avail=file_get_contents("$data/$from_id.txt"); 
   file_put_contents("$data/$from_id.txt",'no'); 
$settings=file_get_contents("states/$from_id.txt"); 
file_put_contents("$settings/$from_id.txt",'yes'); 
if($settings != $data and $avail == 'yes'){ 
   bot('EditMessageText',[
       'chat_id'=>$chat_id,
       'message_id'=>$message_id,
   'text'=> "كيفية إنشاء صفحة أو مجموعة   : ", 
'reply_markup'=>json_encode([  
'inline_keyboard'=>[ 
    [['text'=>' انشاء صفحة عن طريق الموقع' , 'callback_data'=>'create1']], 
    [['text'=>' انشاء مجموعة عن طريق الموقع' , 'callback_data'=>'create2']], 
    [['text'=>' إنشاء مجموعة على التطبيق' , 'callback_data'=>'create3']], 
    [['text'=>' انشاء صفحة عن طريق التطبيق' , 'callback_data'=>'create4']],
    [['text'=>' العودة إلى البداية   ' , 'callback_data'=>'start1']], 
    [['text'=>' العودة إلى الخلف   ' , 'callback_data'=>'how_use']], 

    ]  
    ]) 
]); 

file_put_contents("states/$from_id.txt", $data); 
} 
} 
if($data=='create1'){ 
    mkdir($data);
$avail=file_get_contents("$data/$from_id.txt"); 
file_put_contents("$data/$from_id.txt",'no');
$settings=file_get_contents("states/$from_id.txt"); 
file_put_contents("$settings/$from_id.txt",'yes'); 
    if($settings != $data ){ 
        bot('EditMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
        'text'=> "انشاء صفحة عن طريق الموقع: 
 
-نختار من الزاوية (الثلاث خطوط |||) تظهر لدينا قائمة نختار منها صفحاتي او my pages 
 
- نضغط على صفحاتي ثم انشاء صفحة جديدة 
 
- تظهر لنا قائمة تحوي حقول: 
 
1- الحقل الاول هو اسم الصفحة المطلوب وممكن ان يكون باللغتين العربية او الانكليزية او اي لغة 
 
2- هوو اسم المستخدم الخاص بالصفحة يكون حصراا باللغة الانكليزية واحرف متصلة ببعضها بدون فواصل (  ) ابدااا 
 
3-الحقل الثالث هوو تعبئة الى ماذا تهدف صفحتك 
 
4- نوع الصفحة (سيارات - علوم- فن ...الخ) 
 
- بعدها نضغط على انشاء 
 
في حال تعذر الانشاء يرجى الانتباه على اسم المستخدم يجب ان يكون بأحد الاشكال التالية 
Faceworld1 
Faceworl_1 
Face_world 
Faceworld7890 ", 
'reply_markup'=>json_encode([  
'inline_keyboard'=>[ 
    [['text'=>' العودة إلى الخلف   ' , 'callback_data'=>'create']], 
    [['text'=>' العودة إلى البداية   ' , 'callback_data'=>'start1']], 
        ]  
        ]) 
    ]); 
 
    file_put_contents("states/$from_id.txt", $data); 
} 
} 

 
if($data=='create2'){ 
    mkdir($data);
$avail=file_get_contents("$data/$from_id.txt"); 
    file_put_contents("$data/$from_id.txt",'no'); 
$settings=file_get_contents("states/$from_id.txt"); 
file_put_contents("$settings/$from_id.txt",'yes'); 
    if($settings != $data){ 
        bot('EditMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
        'text'=> "إنشاء مجموعة على الموقع: 
اختر من الزاوية (الثلاث خطوط ≡) 
ستظهر لديك قائمة طويلة، اختر منها مجموعاتي: 
- اختر إنشاء مجموعة جديدة 
ستظهر قائمة تحتوي على عدة حقول: 
1. الحقل الأول هو اسم المجموعة المطلوب، ويمكن أن يكون بأي لغة تفضلها. 
2. الحقل الثاني هو اسم المستخدم الخاص بالمجموعة ويجب أن يكون حصرًا باللغة الإنجليزية وأحرف متصلة ببعضها. 
3. الحقل الثالث ستختار إن كنت تريد مجموعتك عامة أم خاصة. 
4. الحقل الرابع هو نوع المجموعة (سيارات، كوميديا، تسلية، أفلام .... الخ). 
بعد أن تم تعبئة جميع الحقول، اضغط على كلمة إنشاء  
*في حال تعذر إنشاء المجموعة تأكد من اسم المستخدم أن يكون بأحد الأشكال التالية: 
Faceworld1 
Faceworld_1 
Face_world 
Faceworld789 ", 
'reply_markup'=>json_encode([  
'inline_keyboard'=>[ 
    [['text'=>' العودة إلى الخلف   ' , 'callback_data'=>'create']], 
    [['text'=>' العودة إلى البداية   ' , 'callback_data'=>'start1']], 
        ]  
        ]) 
    ]); 
 
    file_put_contents("states/$from_id.txt", $data); 
} 
} 
 
if($data=='create3'){ 
    mkdir($data);
$avail=file_get_contents("$data/$from_id.txt"); 
    file_put_contents("$data/$from_id.txt",'no'); 
$settings=file_get_contents("states/$from_id.txt"); 
file_put_contents("$settings/$from_id.txt",'yes'); 
    if($settings != $data ){ 
        bot('EditMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
        'text'=> "إنشاء مجموعة على التطبيق: 
اختر من الزاوية (الثلاث خطوط ≡) 
اختر المجموعات، ثم اضغط على إنشاء 
ستظهر لديك 5 خطوات يجب اتباعها: 
1. الخطوة الأولى هي اسم المجموعة المطلوب، ويمكن أن تكون بأي لغة تفضلها. 
2. الخطوة الثانية هي اسم المستخدم الخاص بالمجموعة ويجب أن تكون حصرًا باللغة الإنجليزية وأحرف متصلة ببعضها. 
3. الخطوة الثالثة هي تعبئة إلى ماذا تهدف مجموعتك. 
4. الخطوة الرابعة هي نوع المجموعة (سيارات، كوميديا، تسلية، أفلام .... الخ). 
5. الخطوة الخامسة ستختار إن كنت تريد مجموعتك عامة أم خاصة. 
بعد أن تم تعبئة جميع الحقول، اضغط على كلمة حفظ 
*في حال تعذر إنشاء المجموعة تأكد من اسم المستخدم أن يكون بأحد الأشكال التالية: 
Faceworld1 
Faceworld_1 
Face_world 
Faceworld789", 
'reply_markup'=>json_encode([  
'inline_keyboard'=>[ 
    [['text'=>' العودة إلى الخلف   ' , 'callback_data'=>'create']], 
    [['text'=>' العودة إلى البداية   ' , 'callback_data'=>'start1']], 
        ]  
        ]) 
    ]); 
    file_put_contents("states/$from_id.txt", $data); 
} 
} 
}