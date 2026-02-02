<?php

namespace plugin\swagger\app\controller;

use OpenApi\Generator;
use plugin\swagger\app\common\Util;
use support\Request;
use support\Response;

class IndexController
{
    /**
     * 登录路径
     */
    private string $LOGIN_PATH = '/app/swagger/login';

    /**
     * 主页路径
     */
    private string $HOME_PATH = '/app/swagger';

    /**
     * openapi.json 路径
     */
    private string $OPENAPI_PATH = '/app/swagger/openapi.json';

    /**
     * session id
     */
    private string $SESSION_ID = 'swagger_login';

    /**
     * swagger首页
     * @param Request $request
     * @return Response
     * @throws \Exception
     * @author cdyun(121625706@qq.com)
     */
    public function index(Request $request): Response
    {
        $session = $request->session();
        if (Util::getSwaggerLogin() && !$session->has($this->SESSION_ID)) {
            return redirect($this->LOGIN_PATH);
        }

        return view('index', ['urls' => json_encode($this->getUrls(), JSON_UNESCAPED_UNICODE)]);
    }

    /**
     * swagger登录
     * @param Request $request
     * @return Response
     * @throws \Exception
     * @author cdyun(121625706@qq.com)
     */
    public function login(Request $request): Response
    {
        $session = $request->session();
        if (Util::getSwaggerLogin() && !$session->has($this->SESSION_ID)) {
            if ($request->method() == 'POST') {
                $data['username'] = $request->post('username');
                $data['password'] = $request->post('password');
                if (Util::validateLogin($data)) {
                    $session->set($this->SESSION_ID, true);
                    return json(['code' => 0, 'msg' => 'ok']);
                }
                return json(['code' => -1, 'msg' => '用户名或密码错误']);
            }
            return view('login', ['title' => '登录 - Swagger']);
        } else {
            return redirect($this->HOME_PATH);
        }
    }

    /**
     * 获取Swagger JSON
     * @param Request $request
     * @return string|Response
     * @throws \Exception
     * @author cdyun(121625706@qq.com)
     */
    public function openapi(Request $request): Response|string
    {
        $session = $request->session();
        if (Util::getSwaggerLogin() && !$session->has($this->SESSION_ID)) {
            return '';
        } else {
            $name = input('urls_primaryName');
            $info = $this->getUrlInfo($name);
            $openapi = (new Generator())->generate([$info['scan_path']], null, true);
            $openapi->info->title = $info['title'];
            $openapi->info->description = $info['description'];
            header('Content-Type: application/json');
            return json($openapi);
        }
    }

    /**
     * 获取Swagger API文档的URL列表
     * @return array
     * @author cdyun(121625706@qq.com)
     */
    private function getUrls(): array
    {
        $groups = Util::getConfig('groups');
        $urls = [];
        foreach ($groups as $vo) {
            $urls[] = ['url' => $this->OPENAPI_PATH .'?urls.primaryName=' . $vo['title'], 'name' => $vo['title']];
        }
        return $urls;
    }

    /**
     * 获取Swagger 应用API信息
     * @param $name
     * @return array
     * @author cdyun(121625706@qq.com)
     */
    private function getUrlInfo($name = null): array
    {
        $info = [];
        $groups = Util::getConfig('groups');
        if (empty($groups)) {
            return $info;
        }
        foreach ($groups as $vo) {
            if ($name == null || $vo['title'] == $name) {
                $info = $vo;
                break;
            }
        }
        return $info;
    }
}
