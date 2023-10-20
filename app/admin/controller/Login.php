<?php
declare(strict_types=1);
namespace app\admin\controller;
use willphp\core\Jump;
class Login
{
    use Jump;
    //登录
    public function login(array $req)
    {
        if ($this->isPost()) {
            $model = model('admin');
            $r = $model->login($req);
            $this->_jump(['登录成功', $model->getError()], $r, 'index/index');
        }
        return view();
    }
    //退出
    public function logout()
    {
        session(null);
        $this->success('退出成功', 'login/login');
    }
    //验证码
    public function captcha()
    {
        return (new \extend\captcha\Captcha())->make();
    }
}