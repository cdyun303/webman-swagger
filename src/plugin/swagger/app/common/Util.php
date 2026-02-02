<?php
/**
 * Util.php
 * @author cdyun(121625706@qq.com)
 * @date 2026/2/2 17:14
 */

declare (strict_types=1);

namespace plugin\swagger\app\common;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Util
{
    /**
     * 获取是否开启登录功能
     * @return bool
     * @author cdyun(121625706@qq.com)
     */
    public static function getSwaggerLogin(): bool
    {
        return self::getConfig('login.enable') === true;
    }

    /**
     * 获取配置
     * @param string|null $name - 配置名称
     * @param $default - 默认值
     * @return mixed
     * @author cdyun(121625706@qq.com)
     */
    public static function getConfig(?string $name = null, $default = null): mixed
    {
        if (!is_null($name)) {
            return config('plugin.swagger.app.swagger.' . $name, $default);
        }
        return config('plugin.swagger.app.swagger');
    }

    /**
     * 验证登录
     * @param array $data
     * @return bool
     * @author cdyun(121625706@qq.com)
     */
    public static function validateLogin(array $data): bool
    {
        $checkUrl = self::getConfig('login.check_url');
        if ($checkUrl) {
            $listen = config('process.webman.listen');
            $checkUrl = str_starts_with($checkUrl, '/') ? $listen . $checkUrl : $checkUrl;
            try {
                $http = new Client();
                $response = $http->get($checkUrl);
                $result = $response->getBody()->getContents();
                $result = json_decode($result, true);
                $successCode = getenv('SUCCESS_CODE') ? (int)getenv('SUCCESS_CODE') : 0;
                if (isset($result['code']) && $result['code'] == $successCode) {
                    return true;
                } else {
                    return false;
                }
            } catch (GuzzleException $e) {
                return false;
            }
        }
        if (self::getConfig('login.username') === $data['username'] && self::getConfig('login.password') === $data['password']) {
            return true;
        }
        return false;
    }
}