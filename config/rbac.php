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
    'auth_type' => 1, //验证方式,1.验证控制器,2.验证控制器/方法
    'super_uid' => 1, //指定站长ID不需要验证
    'no_auth' => ['index', 'error', 'profile', 'api'],  //无须验证的控制器
];