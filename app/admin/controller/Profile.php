<?php
declare(strict_types=1);
namespace app\admin\controller;
use willphp\core\Jump;
class Profile
{
    use Jump;
    protected string $middleware = 'auth';

	public function index(array $req)
	{
        $uid = session('user.id');
        $user = model('admin')->find($uid);
        if ($this->isPost()) {
            $req['id'] = $uid;
            $r = $user->save($req);
            $this->_jump(['修改成功', '修改失败'], $r, 'index');
        }
		return view()->with('vo', $user->toArray());
	}

    public function pass(array $req)
    {
        if ($this->isPost()) {
            $model = model('admin');
            $r = $model->changePassword($req);
            $this->_jump(['修改成功', $model->getError()], $r, 'index');
        }
        return view();
    }

    public function avatar()
    {
        return view();
    }
}