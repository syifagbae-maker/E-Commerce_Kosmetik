<?php
return [
'name'=>env('APP_NAME','LuxSkin Beauty'),'env'=>env('APP_ENV','local'),'debug'=>(bool)env('APP_DEBUG',true),'url'=>env('APP_URL','http://localhost'),
'timezone'=>'Asia/Jakarta','locale'=>'id','fallback_locale'=>'en','faker_locale'=>'id_ID','key'=>env('APP_KEY'),'cipher'=>'AES-256-CBC',
'previous_keys'=>[], 'maintenance'=>['driver'=>'file','store'=>'database'],
];
