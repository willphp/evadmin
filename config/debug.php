<?php
/*----------------------------------------------------------------
 | Software: [WillPHP framework]
 | Site: 113344.com
 |----------------------------------------------------------------
 | Author: 无念 <24203741@qq.com>
 | WeChat: www113344
 | Copyright (c) 2020-2023, 113344.com. All Rights Reserved.
 |---------------------------------------------------------------*/
return [
    //调试栏显示
    'level' => [
        'base' => '基本',
        'file' => '文件', //去掉则不显示文件加载
        'sql' => 'SQL',
        'debug' => '调试',
        'post' => 'POST',
        'get' => 'GET',
        'cookie' => 'COOKIE',
        'session' => 'SESSION',
        'error' => '错误',
    ],
    'is_hide' => false, //是否隐藏调试栏
    'process_log' => true, //是否把进程日志加入html注释
];