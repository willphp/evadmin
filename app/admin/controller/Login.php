<?php
declare(strict_types=1);
namespace app\admin\controller;
use willphp\core\Jump;
class Login
{
    use Jump;
	public function login(array $req)
	{
        if ($this->isPost()) {
            $model = model('admin');
            $r = $model->login($req);
            $this->_jump(['登录成功', $model->getError()], $r, 'index/index');
        }
		return view();
	}

    public function logout()
    {
        session(null);
        $this->success('退出成功', 'login/login');
    }

    public function captcha()
    {
        return (new \extend\captcha\Captcha())->make();
    }
}