<?php

return [
    'debug' => true,
    'controller_suffix' => 'Controller',
    'controller_reuse' => false,
    'version' => '1.0.0',
    // swagger配置
    'swagger' => [
        // swagger应用分组
        'groups' => [
            [
                // 扫描指定应用目录，每个应用的OA\Info信息，必须且只能存在一个，所以建议写在每个应用控制器继承的 BaseController.php 上
                'scan_path' => base_path('app/v1'),
                // 分组标题，会替换掉OA\Info中的title
                'title' => 'v1应用接口文档',
                // 分组描述，会替换掉OA\Info中的description
                'description' => '让开发变得更简单、更通用、更流行。',
            ],
            [
                // 分组标题
                'title' => 'admin插件接口文档',
                // 分组描述
                'description' => '让开发变得更简单、更通用、更流行。',
                // 扫描指定应用目录，每个应用的OA\Info信息，必须且只能存在一个，所以建议写在每个应用控制器继承的 BaseController.php 上
                'scan_path' => base_path('plugin/admin'),
            ],
        ],
        // 是否登录功能
        'login' => [
            // 是否开启
            'enable' => true,
            // 登录验证接口, 为空时使用默认。支持内链（/v1/core/login）和外链(http://xxx.com/v1/core/login)
            'check_url' => '',
            // 登录验证接口为空时，默认登录用户名
            'username' => 'cdyun',
            // 登录验证接口为空时，默认登录密码
            'password' => 'swagger'
        ]
    ],
];
