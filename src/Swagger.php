<?php
/**
 * @desc Swagger.php
 * @author cdyun(121625706@qq.com)
 * @date 2025/9/22 17:01
 */

declare(strict_types=1);

namespace Cdyun\WebmanSwagger;

class Swagger
{

    /**
     * @param string|null $name - 名称
     * @param $default - 默认值
     * @return mixed
     * @author cdyun(121625706@qq.com)
     * @desc 获取配置config
     */
    public function getConfig(?string $name = null, $default = null): mixed
    {
        if (!is_null($name)) {
            return config('plugin.cdyun.webman-swagger.swagger.' . $name, $default);
        }
        return config('plugin.cdyun.webman-swagger.swagger');
    }

    
    /**
     * @desc 获取Swagger API文档的URL列表
     * @return array
     * @author cdyun(121625706@qq.com)
     */
    public function getUrls(): array
    {
        $groups = $this->getConfig('groups');
        $urls = [];
        foreach ($groups as $key => $vo) {
            $urls[] = ['url' => '/swagger/openapi.json?urls.primaryName=' . $vo['title'], 'name' => $vo['title']];
        }
        return $urls;
    }

    
    /**
     * @desc 获取Swagger 应用API信息
     * @param string|null $name
     * @return array
     * @author cdyun(121625706@qq.com)
     */
    public function getUrlInfo($name = null): array
    {
        $info = [];
        $groups = $this->getConfig('groups');
        if (empty($groups)) {
            return $info;
        }
        foreach ($groups as $key => $vo) {
            if ($name == null || $vo['title'] == $name) {
                $info = [
                    'title' => $vo['title'],
                    'description' => $vo['description'],
                    'name' => $key,
                ];
                break;
            }
        }
        return $info;
    }
}