Webman Swagger 应用插件
=====

### 安装

```
composer require cdyun/webman-swagger
```
### - 功能介绍
##### 1、支持多应用，多插件；
##### 2、支持用户登录后，访问swagger文档；
##### 3、用户登录验证支持默认账户密码和自定义验证接口；
##### 4、用户登录自定义验证接口同时支持内链和外链验证；


### - 访问插件
##### composer安装完成后记得重启服务，根目录执行php start.php restart
```
#（插件配置了路由）访问链接
http://域名/app/swagger
```

### - （配置文件）config/app.php
```PHP
<?php

return [
    ...,
    // swagger配置
    'swagger' => [
        // swagger应用分组，支持插件和主应用，下面两个demo可删除
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
```

### - 使用注意
###### 1、每个应用的OA\Info信息，必须且只能存在一个，所以建议写在每个应用控制器继承的 BaseController.php 上；
###### 2、OA\Info中标题和描述信息会被 config/app.php 中信息替换掉；
例： 应用V1
```
<?php
namespace app\v1\controller;

use support\base\BaseController;
use OpenApi\Attributes as OA;

#[OA\Info(version: '1.0.0', title: 'V1')]
class V1BaseController extends BaseController
{
    ...其他
}
```
例： 应用V2
```
<?php
namespace app\v2\controller;

use support\base\BaseController;
use OpenApi\Attributes as OA;

#[OA\Info(version: '2.0.0', title: 'V2')]
class V2BaseController extends BaseController
{
    ...其他
}
```