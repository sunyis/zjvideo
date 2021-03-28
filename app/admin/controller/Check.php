<?php

namespace app\admin\controller;

use think\captcha\facade\Captcha;
use app\BaseController;
use think\Request;
use think\facade\Config;
use think\facade\Session;
class Check extends BaseController
{
    //检测验证码是否输入正确
    public function checkCaptcha(Request $request)
    {
        if ($request->isPost())
        {
            $username = $request->param('username', '', 'trim');
            $password = $request->param('password', '', 'trim');
            $value = $request->param('verify', '', 'trim');
            if (!captcha_check($value)) {
                // 验证失败
                return json(['status' => 0, 'data' => '验证码输入错误']);
            } else {
                //验证成功
                return $this->checkAdmin($username,$password);
            }
        }else{
            return json(['status' => 0,'data' => '非POST提交']);
        }
    }
    //检测管理员信息是否正确
    private function checkAdmin($username,$password)
    {
        $config = Config::get('config.admin');
        if($config['username'] == $username and $config['password'] == $password)
        {
            Session::set('username',$username);
            return json(['status' => 1,'data' => '登陆成功，正在跳转']);
        }else{
            return json(['status' => 0,'data' => '登陆失败，请检查账号和密码']);
        }
    }
}
