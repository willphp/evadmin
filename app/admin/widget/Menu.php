<?php
declare(strict_types=1);
namespace app\admin\widget;
use willphp\core\Widget;
class Menu extends Widget
{
    protected string $tagName = 'auth_rule';
    protected int $expire = 0;

    public function set($id = '', array $options = [])
    {
        $root = [1 => '=根目录='];
        $menu = db('auth_rule')->field('id,pid,title,level')->where('level', 'in', '1,2')->where('status', 1)->order('sort ASC,id ASC')->select();
        $menu =  $this->orderMenu($menu);
        return $root + array_column($menu, 'title', 'id');
    }

    protected function orderMenu(array $menu, int $pid = 1): array
    {
        $tmp = [];
        foreach ($menu as $val) {
            if ($val['level'] == 2) {
                $val['title'] = '&nbsp;&nbsp;&nbsp;┗━'.$val['title'];
            }
            if ($val['pid'] == $pid) {
                $tmp[] = $val;
                $tmp = array_merge($tmp, $this->orderMenu($menu, $val['id']));
            }
        }
        return $tmp;
    }
}