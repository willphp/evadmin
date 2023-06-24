<?php
declare(strict_types=1);
namespace app\admin\model;
use willphp\core\Model;
class Admin extends Model {
	protected string $table = 'admin';
	protected string $pk = 'id';
    protected array $validate = [
        ['username', 'user|unique', '账户格式错误|账户已存在', 1, 2],
        ['nickname', 'unique', '昵称已存在', 1, 1],
        ['password', '/^\w{1,12}$/', '密码格式错误(1-12位)', 4, 2],
        ['re_password', 'confirm:password', '确认密码不一致', 4, 1],
        ['email', 'email', '邮箱格式错误', 2, 1],
        ['mobile', 'mobile', '手机号格式错误', 2, 1],
        ['qq', 'qq', 'QQ号格式错误', 2, 1],
    ];
	protected array $auto = [
        ['password', 'setPassword', 'method', 2, 1],
		['status', '1', 'string', 1, 2],
	];
    protected array $filter = [
        ['username', 4, 3],
        ['password', 3, 3]
    ];

    public function setPassword($value, array $data): string
    {
        return $this->getEncryptPassword($value, $data['username']);
    }

    public function getEncryptPassword(string $password, string $salt = ''): string
    {
        return md5(md5($password).$salt);
    }

    protected function _before_update(array &$data): void
    {
        if (session('user.id') != 1) {
            $this->db = $this->db->where('id', '<>', 1);
        }
    }

    protected function _before_delete(array $data): void
    {
        $this->db = $this->db->where('id', '<>', 1);
    }

    public function login(array $req): bool
    {
        $rule = [
            ['username', 'user', '账户格式错误'],
            ['password', '/^\w{1,12}$/', '密码格式错误'],
            ['captcha', 'captcha', '验证码错误'],
        ];
        $errors = validate($rule, $req)->getError();
        if (!empty($errors)) {
            $this->errors[] = current($errors);
            return false;
        }
        $user = $this->field('id,group_id,username,nickname,password,status')->where('username', $req['username'])->find();
        if (!$user) {
            $this->errors[] = '账户不存在';
            return false;
        }
        if ($user['status'] == 0 && $user['id'] != 1) {
            $this->errors[] = '用户已停用';
            return false;
        }
        if ($user['password'] != $this->getEncryptPassword($req['password'], $user['username'])) {
            $this->errors[] = '密码错误';
            return false;
        }
        //获取权限
        $user['auth'] = db('auth_group')->where('id', $user['group_id'])->where('status', 1)->value('auth');
        if (!$user['auth']) {
            $this->errors[] = '权限不足';
            return false;
        }
        unset($user['password'], $user['status']);
        $day = isset($req['remember']) ? intval($req['remember']) : 0;
        if ($day > 0) {
            config('session.expire', 86400 * $day);
        }
        session('user', $user->toArray());
        db('admin')->where('id', $user['id'])->inc('login_count')->update(['login_time' => time(), 'login_ip' => get_ip(1)]);
        return true;
    }

    public function changePassword(array $req): bool
    {
        $rule = [
            ['old_pwd', '/^\w{1,12}$/', '旧密码1-12位'],
            ['new_pwd', '/^\w{1,12}$/', '新密码1-12位'],
            ['re_pwd', 'confirm:new_pwd', '确认密码不一致'],
        ];
        $errors = validate($rule, $req)->getError();
        if (!empty($errors)) {
            $this->errors[] = current($errors);
            return false;
        }
        $uid = session('user.id');
        $user = $this->field('username,password')->where('id', $uid)->find();
        if ($user['password'] != $this->getEncryptPassword($req['old_pwd'], $user['username'])) {
            $this->errors[] = '旧密码错误';
            return false;
        }
        $newPassword = $this->getEncryptPassword($req['new_pwd'], $user['username']);
        $ok = $this->where('id', $uid)->setField('password', $newPassword);
        if (!$ok) {
            $this->errors[] = '修改失败';
        }
        return (bool) $ok;
    }
}