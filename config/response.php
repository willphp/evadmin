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
    //全局json返回字段配置
    'json' => [
        'ret' => 'code', //状态码字段
        'msg' => 'msg', //返回信息字段
        'data' => 'data', //返回数据字段
        'status' => 'status', //状态字段：1成功(状态码<400)，0失败(状态码>=400)
    ],
    //响应消息模板
    'msgs' => [
        0 => '请求成功',
        200 => '请求成功',
        204 => '暂无记录',
        400 => '请求错误...',
        401 => '请先登录...',
        403 => '没有权限~', //设置rbac访问失败信息
        404 => '{$path} 不存在',
        405 => '{$path} 不可访问',
        406 => '{$field} 验证失败',
        412 => '表单令牌验证失败',
        416 => '{$path}：{$param} 参数不足',
        500 => '程序错误，请稍候访问...',
    ],
];