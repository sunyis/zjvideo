<?php
namespace app\admin\controller;
use app\BaseController;
use think\facade\View;
use think\captcha\facade\Captcha;
class Login extends BaseController
{
    //登录页面
    public function login()
    {
        return View::fetch();
    }
    //生成验证码
    public function verify()
    {
        return Captcha::create('verify');
    }
}