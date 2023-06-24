<?php
declare(strict_types=1);
namespace app\admin\widget;
use willphp\core\Widget;
class Group extends Widget
{
    protected string $tagName = 'auth_group';
    protected int $expire = 0;
    public function set($id = '', array $options = [])
    {
        $list = db('auth_group')->where('status', 1)->order('id ASC')->column('name', 'id');
        if ($id == 'list') {
            return $list;
        }
        return $list[$id] ?? ['=请选择='] + $list;
    }
}