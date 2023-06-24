<?php
declare(strict_types=1);
namespace app\admin\widget;
use willphp\core\Widget;
class Auth extends Widget
{
    protected string $tagName = 'auth_rule';
    protected int $expire = 0;

    //获取用户
    public function set($id = '', array $options = [])
    {
        if (empty($id)) {
            $id = '2';
        }
        $auth = db('auth_rule')->where('id', 'in', $id)->where('type>0')->column('auth', 'id');
        return array_unique($auth);
    }
}